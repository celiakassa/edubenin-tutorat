<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Services\PlanSettings;
use App\Services\SubscriptionBillingService;
use App\Services\SubscriptionGateway;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

final class SubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscriptionBillingService $billing,
        private readonly SubscriptionGateway $gateway,
    ) {}

    public function index(): View
    {
        abort_if(Auth::user()->role_id !== 2, 403, 'Accès réservé aux élèves et parents');

        $user = Auth::user();

        return view('subscriptions.index', [
            'user' => $user,
            'plan' => $user->currentPlan(),
            'subscription' => $user->subscriptions()->where('statut', 'active')->latest('date_fin')->first(),
            'plans' => resolve(PlanSettings::class)->all()['plans'],
        ]);
    }

    public function subscribePremium(): RedirectResponse
    {
        abort_if(Auth::user()->role_id !== 2, 403, 'Accès réservé aux élèves et parents');

        try {
            $checkout = $this->billing->startPremiumCheckout(Auth::user());
        } catch (Exception $exception) {
            Log::error('Erreur init abonnement premium: '.$exception->getMessage());

            return to_route('subscriptions.index')->with('error', 'Le service de paiement est momentanément indisponible.');
        }

        return redirect()->away($checkout['checkout_url']);
    }

    /**
     * Lien signé reçu par email : crée un paiement Moneroo et y redirige l'élève.
     */
    public function renew(User $user): RedirectResponse
    {
        abort_if($user->role_id !== 2, 403);

        try {
            $checkout = $this->billing->startPremiumCheckout($user);
        } catch (Exception $exception) {
            Log::error('Erreur lien de renouvellement premium: '.$exception->getMessage());

            return to_route('subscriptions.index')->with('error', 'Le service de paiement est momentanément indisponible.');
        }

        return redirect()->away($checkout['checkout_url']);
    }

    public function callback(Request $request): RedirectResponse
    {
        $paymentId = $request->query('paymentId');
        $user = Auth::user();

        if (! $paymentId) {
            return to_route('subscriptions.index')->with('error', 'Transaction invalide.');
        }

        try {
            if (! $this->gateway->isPaid((string) $paymentId)) {
                return to_route('subscriptions.index')->with('error', 'Le paiement n\'a pas été validé.');
            }

            $pendingInvoice = Payment::where('moneroo_payment_id', $paymentId)->whereNull('subscription_id')->first();

            if ($pendingInvoice) {
                $pendingInvoice->update(['status' => 'completed', 'paid_at' => now()]);

                return to_route('subscriptions.index')->with('success', 'Facture réglée, merci !');
            }

            $this->billing->activatePremium($user, (string) $paymentId);
        } catch (Exception $exception) {
            Log::error('Erreur callback abonnement: '.$exception->getMessage());

            return to_route('subscriptions.index')->with('error', 'Erreur lors de la vérification du paiement.');
        }

        return to_route('subscriptions.index')->with('success', 'Bienvenue dans l\'offre Premium !');
    }
}
