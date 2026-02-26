<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Carbon\Carbon;

class AnnonceController extends Controller
{
    public function __construct()
    {
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.environment', 'sandbox'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        abort_if(Auth::user()->role_id != 2, 403, 'Accès réservé aux étudiants');
        
        $user = Auth::user();
        return view('annonces.create', ['user' => $user]);
    }

    // Enregistrer l'annonce
    public function store(Request $request)
    {
        abort_if(Auth::user()->role_id != 2, 403, 'Accès réservé aux étudiants');

        $request->validate([
            'domaine' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'budget' => ['required', 'numeric', 'min:1000', 'max:1000000000'],
            'disponibilite' => ['required', 'date', 'after:now'],
            'format' => ['required', 'in:presentiel,en_ligne,hybrid']
        ]);

        $annonce = new Annonce();
        $annonce->student_id = Auth::id();
        $annonce->domaine = $request->domaine;
        $annonce->description = $request->description;
        $annonce->budget = (float) $request->budget;
        $annonce->disponibilite = $request->disponibilite;
        $annonce->format = $request->format;

        // Calcul acompte
        $percentage = rand(20, 30) / 100;
        $annonce->acompte = round($annonce->budget * $percentage, 2);

        // Statut initial
        $annonce->status = 'en_attente';
        $annonce->is_paid = false;

        $annonce->save();

        return to_route('annonces.payment', $annonce->id)
            ->with('success', 'Annonce créée. Veuillez payer l\'acompte pour la publier.');
    }

    // Afficher la page de paiement
    public function payment($id)
    {
        $annonce = Annonce::findOrFail($id);
        $user = Auth::user();
        
        abort_if($annonce->student_id != Auth::id(), 403, 'Accès non autorisé');

        if ($annonce->is_paid) {
            return to_route('annonces.show', $annonce->id)
                ->with('info', 'Cette annonce est déjà payée.');
        }

        return view('annonces.payment', ['annonce' => $annonce, 'user' => $user]);
    }

    // Callback de paiement - CORRIGÉ
    public function handlePayment(Request $request)
    {
        $user = Auth::user();
        $transactionId = $request->input('id');
        $annonceId = $request->input('annonce_id');

        if (!$transactionId || !$annonceId) {
            return back()->with('error', 'Transaction invalide.');
        }

        try {
            // Récupérer la transaction FedaPay
            $transaction = Transaction::retrieve($transactionId);

            // Vérifier le statut
            if ($transaction->status !== 'approved') {
                return to_route('annonces.payment', $annonceId)
                    ->with('error', 'Le paiement n\'est pas encore confirmé.');
            }

            // Éviter les doublons
            $existingPayment = Payment::where('fedapay_transaction_id', $transaction->id)->first();
            if ($existingPayment) {
                return to_route('annonces.show', $annonceId)
                    ->with('info', 'Ce paiement a déjà été traité.');
            }

            // Récupérer l'annonce
            $annonce = Annonce::findOrFail($annonceId);
            
            // Vérifier que l'utilisateur est propriétaire de l'annonce
            abort_if($annonce->student_id != $user->id, 403, 'Accès non autorisé');

            // IMPORTANT: FedaPay retourne le montant en FCFA (entier)
            $amountPaid = (float) $transaction->amount; // Conversion en float pour notre DB

            // Créer le paiement
            Payment::create([
                'annonce_id' => $annonce->id,
                'user_id' => $user->id,
                'fedapay_transaction_id' => $transaction->id,
                'amount' => $amountPaid,
                'currency' => 'XOF',
                'status' => $transaction->status,
                'payment_method' => $transaction->mode ?? 'mobile_money',
                'payment_details' => json_encode($transaction->toArray()),
                'paid_at' => \Illuminate\Support\Facades\Date::now(),
            ]);

            // Mettre à jour l'annonce
            $annonce->update([
                'status' => 'publiée',
                'is_paid' => true,
                'published_at' => \Illuminate\Support\Facades\Date::now()
            ]);

            return to_route('annonces.show', $annonce->id)
                ->with('success', 'Paiement effectué avec succès ! Votre annonce est maintenant publiée.');

        } catch (\FedaPay\Error\ApiConnection $e) {
            Log::error('Erreur connexion FedaPay: ' . $e->getMessage());
            return to_route('annonces.payment', $annonceId)
                ->with('error', 'Impossible de vérifier le paiement.');
        } catch (\FedaPay\Error\InvalidRequest $e) {
            Log::error('Erreur requête FedaPay: ' . $e->getMessage());
            return to_route('annonces.payment', $annonceId)
                ->with('error', 'Erreur lors de la vérification du paiement.');
        } catch (\Exception $e) {
            Log::error('Erreur paiement annonce: ' . $e->getMessage());
            return to_route('annonces.payment', $annonceId)
                ->with('error', 'Une erreur est survenue lors du traitement du paiement.');
        }
    }

    // Afficher les annonces de l'étudiant
    public function index()
    {
        abort_if(Auth::user()->role_id != 2, 403, 'Accès réservé aux étudiants');

        $user = Auth::user();
        $annonces = Annonce::where('student_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('annonces.index', ['annonces' => $annonces, 'user' => $user]);
    }

    // Afficher une annonce spécifique
    public function show($id)
    {
        $annonce = Annonce::with(['student', 'payments'])->findOrFail($id);
        $user = Auth::user();
        
        abort_if($annonce->student_id != Auth::id() && Auth::user()->role_id != 1, 403, 'Accès non autorisé');

        return view('annonces.show', ['annonce' => $annonce, 'user' => $user]);
    }

    // Afficher le formulaire d'édition
    public function edit($id)
    {
        $annonce = Annonce::findOrFail($id);
        $user = Auth::user();
        
        abort_if($annonce->student_id != Auth::id(), 403, 'Accès non autorisé');

        if ($annonce->status != 'en_attente') {
            return to_route('annonces.show', $annonce->id)
                ->with('error', 'Cette annonce ne peut plus être modifiée.');
        }

        return view('annonces.edit', ['annonce' => $annonce, 'user' => $user]);
    }

    // Mettre à jour l'annonce
    public function update(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        
        abort_if($annonce->student_id != Auth::id(), 403, 'Accès non autorisé');

        if ($annonce->status != 'en_attente') {
            return to_route('annonces.show', $annonce->id)
                ->with('error', 'Cette annonce ne peut plus être modifiée.');
        }

        $request->validate([
            'domaine' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'budget' => ['required', 'numeric', 'min:1000'],
            'disponibilite' => ['required', 'date', 'after:now'],
            'format' => ['required', 'in:presentiel,en_ligne,hybrid']
        ]);

        $annonce->domaine = $request->domaine;
        $annonce->description = $request->description;
        $annonce->budget = $request->budget;
        $annonce->disponibilite = $request->disponibilite;
        $annonce->format = $request->format;
        
        // Recalculer l'acompte si le budget a changé
        if ($annonce->isDirty('budget')) {
            $percentage = rand(20, 30) / 100;
            $annonce->acompte = $request->budget * $percentage;
        }
        
        $annonce->save();

        return to_route('annonces.show', $annonce->id)
            ->with('success', 'Annonce mise à jour avec succès.');
    }

    // Supprimer une annonce
    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);
        
        abort_if($annonce->student_id != Auth::id(), 403, 'Accès non autorisé');

        if ($annonce->status === 'attribuee') {
            return back()
                ->with('error', 'Impossible de supprimer une annonce déjà attribuée.');
        }

        $annonce->delete();

        return to_route('annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}