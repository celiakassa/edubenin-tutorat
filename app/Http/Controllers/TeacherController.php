<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\StatutCandidat;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Payment;
use App\Models\Subscription;
use App\Traits\HasHashid;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Moneroo\Laravel\Payment as MonerooPayment;

final class TeacherController extends Controller
{
    /**
     * Initialiser le paiement d'abonnement
     */
    use HasHashid;

    public function register(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('teachers.register');
    }

    public function initSubscriptionPayment(Request $request)
    {
        $user = auth()->user();

        try {
            $paymentData = [
                'amount' => 6500,
                'currency' => 'XOF',
                'description' => 'Abonnement Tuteur - 1 mois',
                'return_url' => route('paiement.success'),
                'customer' => [
                    'email' => $user->email,
                    'first_name' => $user->firstname,
                    'last_name' => $user->lastname,
                    'phone' => $user->telephone ?? '',
                ],
                'metadata' => [
                    'user_id' => (string) $user->id,
                    'subscription_type' => 'mensuel',
                ],
            ];

            $monerooPayment = new MonerooPayment();
            $payment = $monerooPayment->init($paymentData);

            Log::info('Paiement initialisé', [
                'transaction_id' => $payment->id,
                'user_id' => $user->id,
                'checkout_url' => $payment->checkout_url,
            ]);

            return response()->json([
                'success' => true,
                'checkout_url' => $payment->checkout_url,
                'transaction_id' => $payment->id,
            ]);

        } catch (Exception $exception) {
            Log::error('Erreur init paiement Moneroo: '.$exception->getMessage(), [
                'user_id' => $user->id ?? null,
                'trace' => $exception->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur: '.$exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Page de succès du paiement
     */
    public function paymentSuccess(Request $request)
    {
        $transactionId = $request->query('paymentId');

        Log::info('Payment success callback', [
            'transaction_id' => $transactionId,
            'all_params' => $request->all(),
        ]);

        if (! $transactionId) {
            return to_route('subscription.user')
                ->with('error', 'Transaction invalide.');
        }

        try {
            $monerooPayment = new MonerooPayment();

            Log::info('Attempting to get payment details', ['transaction_id' => $transactionId]);

            $payment = $monerooPayment->get($transactionId);

            Log::info('Payment retrieved successfully', [
                'transaction_id' => $transactionId,
                'status' => $payment->status ?? 'N/A',
            ]);

            // Vérifier si déjà traité
            if (isset($payment->is_processed) && $payment->is_processed === true) {
                Log::info('Payment already processed by Moneroo');

                return to_route('annonces')
                    ->with('info', 'Ce paiement a déjà été traité.');
            }

            // Vérifier le statut
            $status = $payment->status ?? 'unknown';

            if (mb_strtolower($status) === 'success') {
                Log::info('Starting subscription processing');

                $this->processSubscription($payment, $transactionId);

                // Marquer comme traité
                try {
                    $monerooPayment->markAsProcessed($transactionId);
                    Log::info('Payment marked as processed');
                } catch (Exception $e) {
                    Log::warning('Could not mark as processed: '.$e->getMessage());
                }

                return to_route('annonces')
                    ->with('success', 'Abonnement activé avec succès !');
            }

            Log::warning('Payment not successful', ['status' => $status]);

            return to_route('subscription.user')
                ->with('error', 'Le paiement n\'a pas été validé. Statut: '.$status);

        } catch (Exception $exception) {
            Log::error('Erreur verification paiement', [
                'transaction_id' => $transactionId,
                'error_message' => $exception->getMessage(),
                'error_line' => $exception->getLine(),
            ]);

            return to_route('subscription.user')
                ->with('error', 'Erreur lors de la vérification du paiement.');
        }
    }

    /**
     * Afficher les annonces correspondant aux matières du tuteur
     */
    public function ShowAnnonces(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $tuteur = auth()->user();

        abort_if(! $tuteur || ! $tuteur->isTuteur(), 403, 'Accès interdit');

        // Récupère les IDs des matières du tuteur
        $subjectIds = $tuteur->subjects()->pluck('subjects.id');

        $annonces = Annonce::query()
            ->whereIn('subject_id', $subjectIds) // filtre par ID
            ->publiees()
            ->latest()
            ->paginate(6);

        return view('teachers.annonce', ['annonces' => $annonces]);
    }

    /**
     * Afficher la page d'abonnement
     */
    public function showSubscription(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('teachers.subscription-teacher');
    }

    /**
     * Afficher l'historique des abonnements du tuteur
     */
    public function showSubscriptionHistory(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur est un tuteur
        abort_unless($user->isTuteur(), 403, 'Accès interdit. Cette page est réservée aux tuteurs.');

        // Récupérer tous les abonnements avec pagination
        $subscriptions = Subscription::where('user_id', $user->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Récupérer tous les paiements liés aux abonnements avec pagination
        $payments = Payment::where('user_id', $user->id)
            ->whereNotNull('subscription_id')
            ->orderBy('paid_at', 'desc')
            ->paginate(15);

        // Abonnement actif
        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('statut', 'active')
            ->where('date_fin', '>', now())
            ->first();

        return view('teachers.subscription-history', [
            'subscriptions' => $subscriptions,
            'payments' => $payments,
            'activeSubscription' => $activeSubscription,
        ]);
    }

    /**
     * Afficher le détail d'une annonce
     */
    public function showAnnonceDetail($hash): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $annonce = Annonce::findByHashidOrFail($hash);

        // On récupère l'étudiant qui a créé l'annonce (en supposant que la relation s'appelle 'user')
        $student = $annonce->student;

        $hasApplied = false;
        if (auth()->check() && auth()->user()->isTuteur()) {
            $hasApplied = Candidature::where('annonce_id', $annonce->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        $candidature = Candidature::where('annonce_id', $annonce->id)
            ->where('user_id', auth()->id())
            ->first();

        // On vérifie si la candidature est validée
        $teacher_validate = Candidature::where([
            ['annonce_id', '=', $annonce->id],
            ['user_id', '=', auth()->id()],
            ['statut', '=', StatutCandidat::VALIDE],
        ])->exists(); // Utiliser exists() est plus simple ici pour un booléen

        return view('teachers.annonce-detail', [
            'annonce' => $annonce,
            'hasApplied' => $hasApplied,
            'teacher_validate' => $teacher_validate,
            'student' => $student, // On envoie l'objet student à la vue
            'candidature' => $candidature,
        ]);
    }

    /**
     * Postuler à une annonce
     */
    public function postuler($id)
    {
        $user = auth()->user();

        $existing = Candidature::where('annonce_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return back()->with('info', 'Vous avez déjà postulé à cette annonce.');
        }

        Candidature::create([
            'annonce_id' => $id,
            'user_id' => $user->id,
            'statut' => 'en_attente',
        ]);

        return back()->with('success', 'Votre candidature a été envoyée avec succès !');
    }

    /**
     * Traiter l'abonnement après paiement réussi
     */
    private function processSubscription($payment, $transactionId): void
    {
        try {
            Log::info('Processing subscription started');

            // Vérifier si le paiement n'a pas déjà été traité dans notre DB
            $existingPayment = Payment::where('moneroo_payment_id', $transactionId)->first();

            if ($existingPayment) {
                Log::info('Payment already processed in database');

                return;
            }

            // Convertir l'objet Moneroo en array PHP
            $paymentData = json_decode(json_encode($payment), true);

            throw_unless(is_array($paymentData), Exception::class, 'Impossible de convertir les données de paiement');

            // Récupérer l'user_id depuis metadata
            $userId = null;
            if (isset($paymentData['metadata']) && is_array($paymentData['metadata'])) {
                $userId = $paymentData['metadata']['user_id'] ?? null;
            }

            throw_unless($userId, Exception::class, 'User ID manquant dans les metadata');

            DB::beginTransaction();

            $user = \App\Models\User::findOrFail($userId);

            // Gérer l'abonnement
            $existingSubscription = $user->subscriptions()
                ->where('statut', 'active')
                ->lockForUpdate()
                ->first();

            $startDate = now();
            $isExtending = false;

            if ($existingSubscription && $existingSubscription->date_fin->isFuture()) {
                $startDate = $existingSubscription->date_fin;
                $isExtending = true;
            }

            $endDate = $startDate->copy()->addMonth();

            if ($isExtending) {
                $existingSubscription->update([
                    'date_fin' => $endDate,
                    'statut' => 'active',
                    'type_abonnement' => 'mensuel',
                ]);
                $subscription = $existingSubscription;
            } else {
                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'date_debut' => $startDate,
                    'date_fin' => $endDate,
                    'statut' => 'active',
                    'type_abonnement' => 'mensuel',
                ]);
            }

            // ✅ Extraire amount (simple number)
            $amount = (float) ($paymentData['amount'] ?? 6500);

            // ✅ Extraire currency CODE (c'est un objet !)
            $currency = 'XOF'; // Valeur par défaut
            if (isset($paymentData['currency']) && is_array($paymentData['currency'])) {
                $currency = $paymentData['currency']['code'] ?? 'XOF';
            }

            // ✅ Extraire la méthode de paiement depuis capture->method
            $methodCode = 'moneroo';
            $methodName = 'Moneroo';

            if (isset($paymentData['capture']) && is_array($paymentData['capture']) && (isset($paymentData['capture']['method']) && is_array($paymentData['capture']['method']))) {
                $methodCode = $paymentData['capture']['method']['short_code'] ?? 'moneroo';
                $methodName = $paymentData['capture']['method']['name'] ?? 'Moneroo';
            }

            Log::info('Payment details extracted', [
                'amount' => $amount,
                'currency' => $currency,
                'method_code' => $methodCode,
            ]);

            // ✅ Préparer payment_details avec toutes les infos
            $paymentDetailsArray = [
                'id' => $paymentData['id'] ?? $transactionId,
                'status' => $paymentData['status'] ?? 'success',
                'amount' => $amount,
                'currency_code' => $currency,
                'currency_full' => $paymentData['currency'] ?? null,
                'amount_formatted' => $paymentData['amount_formatted'] ?? null,
                'description' => $paymentData['description'] ?? null,
                'method' => [
                    'code' => $methodCode,
                    'name' => $methodName,
                ],
                'customer' => $paymentData['customer'] ?? null,
                'capture' => $paymentData['capture'] ?? null,
                'metadata' => $paymentData['metadata'] ?? null,
                'initiated_at' => $paymentData['initiated_at'] ?? null,
            ];

            // Date de paiement
            $paidAt = isset($paymentData['initiated_at'])
                ? \Illuminate\Support\Facades\Date::parse($paymentData['initiated_at'])
                : now();

            // ✅ Créer l'enregistrement de paiement
            Log::info('Creating payment record');

            $paymentRecord = Payment::create([
                'moneroo_payment_id' => $transactionId,
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'completed',
                'payment_method' => $methodCode,
                'payment_details' => $paymentDetailsArray,
                'paid_at' => $paidAt,
            ]);

            Log::info('Payment record created successfully', [
                'payment_id' => $paymentRecord->id,
            ]);

            DB::commit();

            Log::info('Subscription processed successfully');

        } catch (Exception $exception) {
            DB::rollBack();

            Log::error('Error in processSubscription', [
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);

            throw $exception;
        }
    }
}
