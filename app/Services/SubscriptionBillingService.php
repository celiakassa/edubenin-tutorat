<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\SubscriptionPlan;
use App\Mail\PremiumDowngradedMail;
use App\Mail\PremiumExpiringMail;
use App\Mail\StandardInvoiceMail;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

final class SubscriptionBillingService
{
    public function __construct(private readonly SubscriptionGateway $gateway) {}

    /**
     * Prépare le paiement du premium (lien de paiement Moneroo).
     *
     * @return array{id: string, checkout_url: string}
     */
    public function startPremiumCheckout(User $user): array
    {
        return $this->gateway->createCheckout(
            $user,
            SubscriptionPlan::Premium->price(),
            'Abonnement Premium Kopiao',
            route('subscriptions.premium.callback'),
            ['payment_type' => 'subscription_premium'],
        );
    }

    /**
     * Active (ou prolonge) le premium jusqu'au jour précédant le prochain renouvellement,
     * après confirmation du paiement. Idempotent sur l'identifiant de paiement.
     */
    public function activatePremium(User $user, string $paymentId, ?Carbon $from = null): Subscription
    {
        $existing = Payment::where('moneroo_payment_id', $paymentId)->first();

        if ($existing?->subscription) {
            return $existing->subscription;
        }

        $start = ($from ?? Date::today())->copy()->startOfDay();

        $current = $user->subscriptions()
            ->where('plan', SubscriptionPlan::Premium->value)
            ->where('statut', 'active')
            ->whereDate('date_fin', '>=', $start->toDateString())
            ->latest('date_fin')
            ->first();

        // Renouvellement anticipé : la nouvelle période démarre le lendemain de la fin en cours.
        if ($current) {
            $start = $current->date_fin->copy()->addDay()->startOfDay();
        }

        $renewalDay = resolve(PlanSettings::class)->renewalDay();
        $renewal = $start->day >= $renewalDay
            ? $start->copy()->startOfMonth()->addMonthNoOverflow()->day($renewalDay)
            : $start->copy()->day($renewalDay);

        if (! $current) {
            $user->subscriptions()
                ->where('plan', SubscriptionPlan::Premium->value)
                ->where('statut', 'active')
                ->update(['statut' => 'expired', 'auto_renew' => false]);
        }

        $subscription = $user->subscriptions()->create([
            'plan' => SubscriptionPlan::Premium,
            'type_abonnement' => 'mensuel',
            'date_debut' => $start,
            'date_fin' => $renewal->copy()->subDay(),
            'renouvel_at' => $renewal,
            'statut' => 'active',
            'auto_renew' => true,
        ]);

        Payment::updateOrCreate(
            ['moneroo_payment_id' => $paymentId],
            [
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'amount' => SubscriptionPlan::Premium->price(),
                'currency' => config('plans.currency'),
                'status' => 'completed',
                'payment_method' => 'moneroo',
                'paid_at' => now(),
            ],
        );

        return $subscription;
    }

    /**
     * Lien signé qui crée un paiement Moneroo neuf pour l'élève puis l'y redirige.
     * Envoyé par email : le clic suffit pour (ré)initier l'abonnement Premium.
     */
    public function renewalUrl(User $user): string
    {
        return URL::temporarySignedRoute('subscriptions.renew', now()->addDays(30), ['user' => $user->id]);
    }

    /**
     * Jour de renouvellement : les Premium non renouvelés (paiement non reçu) expirent,
     * l'élève repasse en Standard et reçoit un mail avec un lien pour se réabonner.
     *
     * @return array{renewed: int, downgraded: int}
     */
    public function renewDuePremiums(?Carbon $today = null): array
    {
        $today ??= Date::today();
        $result = ['renewed' => 0, 'downgraded' => 0];

        $due = Subscription::query()
            ->with('user')
            ->where('plan', SubscriptionPlan::Premium->value)
            ->whereHas('user', fn ($query) => $query->where('role_id', 2))
            ->where('statut', 'active')
            ->whereDate('date_fin', '<', $today->toDateString())
            ->get();

        foreach ($due as $subscription) {
            $user = $subscription->user;
            $subscription->update(['statut' => 'expired']);

            // Déjà renouvelé via le lien de l'email : rien d'autre à faire.
            if ($user->isPremium()) {
                $result['renewed']++;

                continue;
            }

            // DÉSACTIVÉ — débit automatique (Moneroo ne le permet pas, cf. SubscriptionGateway::chargeSavedMethod).
            // Pour le réactiver : décommenter ce bloc et le retour à `continue` ci-dessous.
            // if ($subscription->auto_renew && $this->gateway->chargeSavedMethod($user, SubscriptionPlan::Premium->price())) {
            //     $this->activatePremium($user, 'auto_'.$user->id.'_'.$today->format('Ym'), $today);
            //     $result['renewed']++;
            //
            //     continue;
            // }

            Mail::to($user->email)->send(new PremiumDowngradedMail($user, $this->renewalUrl($user)));
            $result['downgraded']++;
        }

        return $result;
    }

    /**
     * Envoie, avec le lien de renouvellement :
     * - un rappel N jours avant la fin du Premium ;
     * - un dernier mail le jour de la fin.
     * Chaque mail n'est envoyé qu'une fois par période, et pas si l'élève a déjà renouvelé.
     */
    public function sendExpiryReminders(?Carbon $today = null): int
    {
        $today ??= Date::today();
        $limit = $today->copy()->addDays(resolve(PlanSettings::class)->reminderDays());
        $sent = 0;

        $subscriptions = Subscription::query()
            ->with('user')
            ->where('plan', SubscriptionPlan::Premium->value)
            ->whereHas('user', fn ($query) => $query->where('role_id', 2))
            ->where('statut', 'active')
            ->whereDate('date_fin', '>=', $today->toDateString())
            ->whereDate('date_fin', '<=', $limit->toDateString())
            ->get();

        foreach ($subscriptions as $subscription) {
            $user = $subscription->user;

            $alreadyRenewed = $user->subscriptions()
                ->where('plan', SubscriptionPlan::Premium->value)
                ->where('statut', 'active')
                ->whereDate('date_fin', '>', $subscription->date_fin->toDateString())
                ->exists();

            if ($alreadyRenewed) {
                continue;
            }

            $isLastDay = $subscription->date_fin->isSameDay($today);

            if ($isLastDay && $subscription->final_notice_sent_at === null) {
                Mail::to($user->email)->send(new PremiumExpiringMail($user, $subscription, $this->renewalUrl($user), true));
                $subscription->update(['final_notice_sent_at' => now(), 'reminder_sent_at' => $subscription->reminder_sent_at ?? now()]);
                $sent++;
            } elseif (! $isLastDay && $subscription->reminder_sent_at === null) {
                Mail::to($user->email)->send(new PremiumExpiringMail($user, $subscription, $this->renewalUrl($user)));
                $subscription->update(['reminder_sent_at' => now()]);
                $sent++;
            }
        }

        return $sent;
    }

    /**
     * Fin de mois : facture les élèves standard (no-op tant que le prix standard est 0).
     */
    public function billStandardUsers(?Carbon $today = null): int
    {
        $price = SubscriptionPlan::Standard->price();

        if ($price <= 0) {
            return 0;
        }

        $today ??= Date::today();
        $billed = 0;

        User::query()->where('role_id', 2)->where('is_active', true)->each(function (User $user) use ($price, $today, &$billed): void {
            if ($user->isPremium()) {
                return;
            }

            $checkout = $this->gateway->createCheckout(
                $user,
                $price,
                'Abonnement Standard Kopiao – '.$today->translatedFormat('F Y'),
                route('subscriptions.premium.callback'),
                ['payment_type' => 'subscription_standard'],
            );

            Payment::create([
                'user_id' => $user->id,
                'moneroo_payment_id' => $checkout['id'],
                'amount' => $price,
                'currency' => config('plans.currency'),
                'status' => 'pending',
                'payment_method' => 'moneroo',
            ]);

            Mail::to($user->email)->send(new StandardInvoiceMail($user, $price, $checkout['checkout_url']));
            $billed++;
        });

        return $billed;
    }
}
