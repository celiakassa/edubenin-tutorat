<?php

namespace App\Http\Controllers;

use App\Enums\StatutCandidat;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use FedaPay\FedaPay;
use FedaPay\Transaction;

class TeacherController extends Controller
{


    public function __construct()
    {
        // Configurer FedaPay
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.environment', 'sandbox'));
    }


    public function listProfesseur()
    {
        // ...
    }

    /**
     * Affiche toutes les annonces paginées dans la vue teachers.annonce
     */
    public function ShowAnnonces()
    {
        $annonces = \App\Models\Annonce::orderBy('created_at', 'desc')->paginate(10);
        return view('teachers.annonce', compact('annonces'));
    }
    public function register()
    {
        return view('teachers.register');
    }

    /**
     * Affiche les détails d'une annonce spécifique
     */
    public function showAnnonceDetail($hash)
    {
        $annonce = Annonce::findByHashidOrFail($hash);

        $hasApplied = false;


        if (auth()->check() && auth()->user()->isTuteur()) {
            $hasApplied = Candidature::where('annonce_id', $annonce->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        // Récupérer la candidature du teacher (peu importe le statut)
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
    public function showSubscription()
    {
        return view('teachers.subscription-teacher');
    }

    public function handleSubscription(Request $request)
    {
        $user = $request->user();
        $transactionId = $request->input('id'); // ID FedaPay envoyé par callback

        if (!$transactionId) {
            return redirect()->back()->with('error', 'Transaction invalide.');
        }

        try {
            // 🔹 Récupérer la transaction via le SDK FedaPay
            $transaction = Transaction::retrieve($transactionId);

            // 🔹 Vérifier le statut
            if ($transaction->status !== 'approved') {
                return redirect()->back()->with('error', 'Le paiement n\'est pas encore confirmé.');
            }

            // 🔹 Éviter les doublons
            $existingPayment = Payment::where('fedapay_transaction_id', $transaction->id)->first();
            if ($existingPayment) {
                return redirect()->route('subscription-user')
                    ->with('info', 'Ce paiement a déjà été traité.');
            }

            DB::transaction(function () use ($transaction, $user) {

                // 🔹 1. Gérer l’abonnement
                $existingSubscription = $user->subscription;
                $startDate = Carbon::now();

                if ($existingSubscription && Carbon::parse($existingSubscription->date_fin)->isFuture()) {
                    // Abonnement actif → prolonger
                    $startDate = Carbon::parse($existingSubscription->date_fin);
                }

                $endDate = $startDate->copy()->addMonth(); // 1 mois

                if ($existingSubscription && Carbon::parse($existingSubscription->date_fin)->isFuture()) {
                    $existingSubscription->update([
                        'date_debut' => $startDate,
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

                // 🔹 2. Enregistrer le paiement avec subscription_id
                Payment::create([
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id, // ✅ lien paiement → abonnement
                    'fedapay_transaction_id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'currency' => $transaction->currency ?? 'XOF', // valeur par défaut
                    'status' => $transaction->status,
                    'payment_method' => $transaction->mode ?? 'mobile_money',
                    'payment_details' => $transaction,
                ]);
            });

            return redirect()->route('annonces')
                ->with('success', 'Abonnement activé avec succès !');
        } catch (\FedaPay\Error\ApiConnection $e) {
            return redirect()->back()->with('error', 'Impossible de vérifier le paiement.');
        } catch (\FedaPay\Error\InvalidRequest $e) {
            return redirect()->back()->with('error', 'Erreur lors de la vérification du paiement.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors du traitement du paiement.');
        }
    }

    public function postuler($id)
    {
        $user = auth()->user();

        // Vérifier si l'utilisateur a déjà postulé
        $existing = \App\Models\Candidature::where('annonce_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('info', 'Vous avez déjà postulé à cette annonce.');
        }

        // Enregistrer la candidature
        \App\Models\Candidature::create([
            'annonce_id' => $id,
            'user_id' => $user->id,
            'statut' => 'en_attente', // statut par défaut
        ]);

        // Redirection avec message succès
        return redirect()->back()->with('success', 'Votre candidature a été envoyée avec succès !');
    }
}
