<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    // Afficher le formulaire de création
    public function create()
    {
        // Vérifier que seul l'étudiant (role_id = 2) peut accéder
        if (Auth::user()->role_id != 2) {
            abort(403, 'Accès réservé aux étudiants');
        }
        
        $user = Auth::user();
        return view('annonces.create', compact('user'));
    }

    // Enregistrer l'annonce
    public function store(Request $request)
    {
        if (Auth::user()->role_id != 2) {
            abort(403, 'Accès réservé aux étudiants');
        }

        $request->validate([
            'domaine' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'budget' => 'required|numeric|min:0',
            'disponibilite' => 'required|date|after:now',
            'format' => 'required|in:presentiel,en_ligne,hybrid'
        ]);

        $annonce = new Annonce();
        $annonce->student_id = Auth::id();
        $annonce->domaine = $request->domaine;
        $annonce->description = $request->description;
        $annonce->budget = $request->budget;
        $annonce->disponibilite = $request->disponibilite;
        $annonce->format = $request->format;
        
        // Calculer l'acompte (20-30%)
        $percentage = rand(20, 30) / 100;
        $annonce->acompte = $request->budget * $percentage;
        
        // Statut initial
        $annonce->status = 'en_attente';
        $annonce->is_paid = false;
        
        $annonce->save();

        return redirect()->route('annonces.payment', $annonce->id)
            ->with('success', 'Annonce créée. Veuillez payer l\'acompte pour la publier.');
    }

    // Afficher la page de paiement
    public function payment($id)
    {
        $annonce = Annonce::findOrFail($id);
        $user = Auth::user();
        
        if ($annonce->student_id != Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        return view('annonces.payment', compact('annonce', 'user'));
    }

    // Traiter le paiement (simulé)
    public function processPayment(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        
        if ($annonce->student_id != Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        // Ici, vous intégrerez votre système de paiement (Stripe, PayPal, etc.)
        // Pour l'exemple, on simule un paiement réussi
        
        $annonce->is_paid = true;
        $annonce->status = 'publiee';
        $annonce->published_at = now();
        $annonce->save();

        return redirect()->route('annonces.show', $annonce->id)
            ->with('success', 'Paiement effectué. Votre annonce est maintenant publiée.');
    }

    // Afficher les annonces de l'étudiant
    public function index()
    {
        if (Auth::user()->role_id != 2) {
            abort(403, 'Accès réservé aux étudiants');
        }

        $user = Auth::user();
        $annonces = Annonce::where('student_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('annonces.index', compact('annonces', 'user'));
    }

    // Afficher une annonce spécifique
    public function show($id)
    {
        $annonce = Annonce::with('student')->findOrFail($id);
        $user = Auth::user();
        
        // Vérifier que l'utilisateur a le droit de voir l'annonce
        if ($annonce->student_id != Auth::id() && Auth::user()->role_id != 1) {
            abort(403, 'Accès non autorisé');
        }

        return view('annonces.show', compact('annonce', 'user'));
    }

    // Supprimer une annonce
    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);
        
        if ($annonce->student_id != Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier si l'annonce n'a pas encore été attribuée
        if ($annonce->status === 'attribuee') {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer une annonce déjà attribuée.');
        }

        $annonce->delete();

        return redirect()->route('annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}