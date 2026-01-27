<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CandidatureAcceptee;
use App\Mail\CandidatureRefusee;

class CandidatureController extends Controller
{
    /**
     * Afficher les candidatures pour une annonce (pour l'étudiant)
     */
    public function index($annonceId)
    {
        $annonce = Annonce::with(['candidatures.tuteur'])->findOrFail($annonceId);
        
        // Vérifier que l'utilisateur est l'étudiant propriétaire
        if ($annonce->student_id !== Auth::id()) {
            abort(403, 'Non autorisé. Vous n\'êtes pas le propriétaire de cette annonce.');
        }

        // Compter les candidatures par statut
        $candidatures = $annonce->candidatures;
        $stats = [
            'total' => $candidatures->count(),
            'en_attente' => $candidatures->where('statut', 'en_attente')->count(),
            'acceptees' => $candidatures->where('statut', 'acceptee')->count(),
            'refusees' => $candidatures->where('statut', 'refusee')->count(),
        ];

        // Grouper les candidatures par statut
        $candidaturesParStatut = [
            'en_attente' => $annonce->candidatures->where('statut', 'en_attente'),
            'acceptees' => $annonce->candidatures->where('statut', 'acceptee'),
            'refusees' => $annonce->candidatures->where('statut', 'refusee'),
        ];

        // Vérifier si un tuteur a déjà été accepté
        $tuteurAccepte = $annonce->tuteurAccepte;

        return view('candidatures.index', compact(
            'annonce', 
            'stats', 
            'candidaturesParStatut',
            'tuteurAccepte'
        ));
    }

    /**
     * Postuler à une annonce (pour le tuteur)
     */
    public function store(Request $request, $annonceId)
    {
        $annonce = Annonce::findOrFail($annonceId);
        
        // Vérifier que l'utilisateur est un tuteur
        if (Auth::user()->role_id !== 3) {
            return redirect()->back()->with('error', 'Seuls les tuteurs peuvent postuler.');
        }

        // Vérifier que l'annonce est publiée (avec accent)
        if ($annonce->status !== 'publiée') {
            return redirect()->back()->with('error', 'Cette annonce n\'est pas disponible.');
        }

        // Vérifier si le tuteur a déjà postulé
        $existe = Candidature::where('annonce_id', $annonceId)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette annonce.');
        }

        // Créer la candidature
        Candidature::create([
            'annonce_id' => $annonceId,
            'user_id' => Auth::id(),
            'statut' => 'en_attente',
        ]);

        return redirect()->back()->with('success', 'Votre candidature a été envoyée avec succès !');
    }

    /**
     * Accepter une candidature
     */
    public function accepter($candidatureId)
    {
        $candidature = Candidature::with(['annonce.student', 'tuteur'])->findOrFail($candidatureId);
        
        // Vérifier que l'utilisateur est l'étudiant propriétaire
        if ($candidature->annonce->student_id !== Auth::id()) {
            abort(403, 'Non autorisé. Vous n\'êtes pas le propriétaire de cette annonce.');
        }

        // Vérifier que l'annonce est encore disponible
        if ($candidature->annonce->estAttribuee()) {
            return redirect()->back()->with('error', 'Cette annonce a déjà été attribuée à un tuteur.');
        }

        // Mettre à jour le statut de cette candidature
        $candidature->update(['statut' => 'acceptee']);

        // Refuser automatiquement les autres candidatures pour cette annonce
        Candidature::where('annonce_id', $candidature->annonce_id)
            ->where('id', '!=', $candidatureId)
            ->update(['statut' => 'refusee']);

        // Mettre à jour le statut de l'annonce
        $candidature->annonce->update(['status' => 'attribuee']);

        // Envoyer un email de félicitations au tuteur accepté
        try {
            Mail::to($candidature->tuteur->email)
                ->send(new CandidatureAcceptee($candidature));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email acceptation: ' . $e->getMessage());
        }

        // Envoyer des emails de refus aux autres tuteurs
        $candidaturesRefusees = Candidature::where('annonce_id', $candidature->annonce_id)
            ->where('id', '!=', $candidatureId)
            ->with('tuteur')
            ->get();

        foreach ($candidaturesRefusees as $candidatureRefusee) {
            try {
                Mail::to($candidatureRefusee->tuteur->email)
                    ->send(new CandidatureRefusee($candidatureRefusee));
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email refus: ' . $e->getMessage());
            }
        }

        return redirect()->route('candidatures.index', $candidature->annonce_id)
            ->with('success', 'Tuteur accepté ! Les emails ont été envoyés.');
    }

    /**
     * Refuser une candidature
     */
    public function refuser($candidatureId)
    {
        $candidature = Candidature::with(['annonce.student', 'tuteur'])->findOrFail($candidatureId);
        
        // Vérifier que l'utilisateur est l'étudiant propriétaire
        if ($candidature->annonce->student_id !== Auth::id()) {
            abort(403, 'Non autorisé. Vous n\'êtes pas le propriétaire de cette annonce.');
        }

        // Ne pas permettre de refuser si déjà accepté
        if ($candidature->statut === 'acceptee') {
            return redirect()->back()->with('error', 'Cette candidature a déjà été acceptée.');
        }

        // Mettre à jour le statut
        $candidature->update(['statut' => 'refusee']);

        // Envoyer un email au tuteur
        try {
            Mail::to($candidature->tuteur->email)
                ->send(new CandidatureRefusee($candidature));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email refus: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Candidature refusée et notification envoyée.');
    }

    // ... autres méthodes ...
}