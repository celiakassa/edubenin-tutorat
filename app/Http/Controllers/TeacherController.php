<?php

namespace App\Http\Controllers;

use App\Enums\StatutCandidat;
use App\Jobs\HandleSubscriptionJob;
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
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.mode'));
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
        $transactionId = $request->input('id');

        if (!$transactionId) {
            return back()->with('error', 'Transaction invalide.');
        }

        try {
            // ⚡ OPTIMISATION 1: Vérifier si le paiement existe déjà (éviter doublon)
            $existingPayment = Payment::where('fedapay_transaction_id', $transactionId)->first();

            if ($existingPayment) {
                return redirect()->route('annonces')
                    ->with('success', 'Abonnement déjà activé !');
            }

            // ⚡ OPTIMISATION 2: Vérifier le paiement FedaPay
            $transaction = Transaction::retrieve($transactionId);

            if ($transaction->status !== 'approved') {
                return back()->with('error', 'Le paiement n\'a pas été validé.');
            }

            $user = $request->user();

            DB::beginTransaction();

            try {
                // ⚡ OPTIMISATION 3: Charger l'abonnement existant en UNE seule requête
                $existingSubscription = $user->subscription()->lockForUpdate()->first();

                $startDate = Carbon::now();
                $isExtending = false;

                if ($existingSubscription && Carbon::parse($existingSubscription->date_fin)->isFuture()) {
                    $startDate = Carbon::parse($existingSubscription->date_fin);
                    $isExtending = true;
                }

                $endDate = $startDate->copy()->addMonth();

                // ⚡ OPTIMISATION 4: Update OU Create en une seule opération
                if ($isExtending) {
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

                // ⚡ OPTIMISATION 5: Create direct (pas de firstOrCreate car déjà vérifié)
                Payment::create([
                    'fedapay_transaction_id' => $transactionId,
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'amount' => $transaction->amount,
                    'currency' => $transaction->currency ?? 'XOF',
                    'status' => $transaction->status,
                    'payment_method' => $transaction->mode ?? 'mobile_money',
                    'payment_details' => json_encode($transaction),
                ]);

                DB::commit();

                return redirect()->route('annonces')
                    ->with('success', 'Abonnement activé avec succès ! 🎉');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Erreur activation abonnement: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
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
