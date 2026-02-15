<?php

namespace App\Http\Controllers;

use App\Enums\StatutCandidat;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Moneroo\Laravel\Payment as MonerooPayment;

class TeacherController extends Controller
{
    /**
     * Initialiser le paiement d'abonnement
     */
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
                    'user_id' => (string)$user->id,
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

        } catch (\Exception $e) {
            Log::error('Erreur init paiement Moneroo: ' . $e->getMessage(), [
                'user_id' => $user->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage(),
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
            'all_params' => $request->all()
        ]);

        if (!$transactionId) {
            return redirect()->route('subscription.user')
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

                return redirect()->route('annonces')
                    ->with('info', 'Ce paiement a déjà été traité.');
            }

            // Vérifier le statut
            $status = $payment->status ?? 'unknown';

            if (strtolower($status) === 'success') {
                Log::info('Starting subscription processing');

                $this->processSubscription($payment, $transactionId);

                // Marquer comme traité
                try {
                    $monerooPayment->markAsProcessed($transactionId);
                    Log::info('Payment marked as processed');
                } catch (\Exception $e) {
                    Log::warning('Could not mark as processed: ' . $e->getMessage());
                }

                return redirect()->route('annonces')
                    ->with('success', 'Abonnement activé avec succès !');
            } else {
                Log::warning('Payment not successful', ['status' => $status]);

                return redirect()->route('subscription.user')
                    ->with('error', 'Le paiement n\'a pas été validé. Statut: ' . $status);
            }

        } catch (\Exception $e) {
            Log::error('Erreur verification paiement', [
                'transaction_id' => $transactionId,
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
            ]);

            return redirect()->route('subscription.user')
                ->with('error', 'Erreur lors de la vérification du paiement.');
        }
    }

    /**
     * Traiter l'abonnement après paiement réussi
     */
    private function processSubscription($payment, $transactionId)
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

            if (!is_array($paymentData)) {
                throw new \Exception('Impossible de convertir les données de paiement');
            }

            // Récupérer l'user_id depuis metadata
            $userId = null;
            if (isset($paymentData['metadata']) && is_array($paymentData['metadata'])) {
                $userId = $paymentData['metadata']['user_id'] ?? null;
            }

            if (!$userId) {
                throw new \Exception('User ID manquant dans les metadata');
            }

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

            if (isset($paymentData['capture']) && is_array($paymentData['capture'])) {
                if (isset($paymentData['capture']['method']) && is_array($paymentData['capture']['method'])) {
                    $methodCode = $paymentData['capture']['method']['short_code'] ?? 'moneroo';
                    $methodName = $paymentData['capture']['method']['name'] ?? 'Moneroo';
                }
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
                ? Carbon::parse($paymentData['initiated_at'])
                : now();

            // ✅ Créer l'enregistrement de paiement
            Log::info('Creating payment record');

            $paymentRecord = Payment::create([
                'moneroo_payment_id' => $transactionId,
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'amount' => $amount,
                'currency' => $currency, // Maintenant c'est bien une string "XOF"
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

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error in processSubscription', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            throw $e;
        }
    }

    public function ShowAnnonces()
    {
        $tuteur = auth()->user();

        if (!$tuteur || !$tuteur->isTuteur()) {
            abort(403, 'Accès interdit');
        }

        $subjects = json_decode($tuteur->subjects, true) ?? [];

        $annonces = \App\Models\Annonce::whereIn('domaine', $subjects)
            ->where('status', 'publiée')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('teachers.annonce', compact('annonces'));
    }

    public function showSubscription()
    {
        return view('teachers.subscription-teacher');
    }

    /**
     * Afficher l'historique des abonnements du tuteur
     */
    public function showSubscriptionHistory()
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur est un tuteur
        if (!$user->isTuteur()) {
            abort(403, 'Accès interdit. Cette page est réservée aux tuteurs.');
        }

        // Récupérer tous les abonnements avec pagination
        $subscriptions = Subscription::where('user_id', $user->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15); // 15 abonnements par page

        // Récupérer tous les paiements liés aux abonnements avec pagination
        $payments = Payment::where('user_id', $user->id)
            ->whereNotNull('subscription_id')
            ->orderBy('paid_at', 'desc')
            ->paginate(15); // 15 paiements par page

        // Abonnement actif
        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('statut', 'active')
            ->where('date_fin', '>', now())
            ->first();

        return view('teachers.subscription-history', compact('subscriptions', 'payments', 'activeSubscription'));
    }

    public function showAnnonceDetail($hash)
    {
        $annonce = Annonce::findByHashidOrFail($hash);
        $hasApplied = false;

        if (auth()->check() && auth()->user()->isTuteur()) {
            $hasApplied = Candidature::where('annonce_id', $annonce->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        $candidature = Candidature::where('annonce_id', $annonce->id)
            ->where('user_id', auth()->id())
            ->first();

        $teacher_validate = Candidature::where([
            ['annonce_id', '=', $annonce->id],
            ['user_id', '=', auth()->id()],
            ['statut', '=', StatutCandidat::VALIDE],
        ])->first();

        $student = $annonce->student ?? null;

        return view('teachers.annonce-detail', compact('annonce', 'hasApplied', 'teacher_validate', 'student', 'candidature'));
    }

    public function postuler($id)
    {
        $user = auth()->user();

        $existing = \App\Models\Candidature::where('annonce_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('info', 'Vous avez déjà postulé à cette annonce.');
        }

        \App\Models\Candidature::create([
            'annonce_id' => $id,
            'user_id' => $user->id,
            'statut' => 'en_attente',
        ]);

        return redirect()->back()->with('success', 'Votre candidature a été envoyée avec succès !');
    }
}
