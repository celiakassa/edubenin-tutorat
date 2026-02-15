<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\User;
use Illuminate\Http\Request;

class ListeAnnonceController extends Controller
{
    /**
     * Afficher la liste de toutes les annonces avec filtres
     */
    public function index(Request $request)
    {
        // Requête de base avec relations
        $annonces = Annonce::with(['student'])
            ->where('status', 'publiée')
            ->where('is_paid', true);

        // Filtre par recherche textuelle (domaine ou description)
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $annonces->where(function($query) use ($searchTerm) {
                $query->where('domaine', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtre par domaine spécifique
        if ($request->has('domaine') && !empty($request->domaine)) {
            $annonces->where('domaine', 'LIKE', "%{$request->domaine}%");
        }

        // Filtre par budget minimum
        if ($request->has('budget_min') && !empty($request->budget_min)) {
            $annonces->where('budget', '>=', $request->budget_min);
        }

        // Filtre par budget maximum
        if ($request->has('budget_max') && !empty($request->budget_max)) {
            $annonces->where('budget', '<=', $request->budget_max);
        }

        // Filtre par format
        if ($request->has('format') && !empty($request->format)) {
            $annonces->where('format', $request->format);
        }

        // Filtre par disponibilité (jour de la semaine)
        if ($request->has('jour') && !empty($request->jour)) {
            $jour = $request->jour;
            $annonces->where('disponibilite', 'LIKE', "%{$jour}%");
        }

        // Récupérer tous les domaines uniques pour le filtre
        $domaines = Annonce::where('status', 'publiée')
            ->where('is_paid', true)
            ->whereNotNull('domaine')
            ->pluck('domaine')
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // Statistiques
        $stats = [
            'total' => Annonce::where('status', 'publiée')->where('is_paid', true)->count(),
            'budget_moyen' => Annonce::where('status', 'publiée')->where('is_paid', true)->avg('budget'),
            'budget_min' => Annonce::where('status', 'publiée')->where('is_paid', true)->min('budget'),
            'budget_max' => Annonce::where('status', 'publiée')->where('is_paid', true)->max('budget'),
        ];

        // Pagination
        $annonces = $annonces->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('annonces.liste', compact('annonces', 'domaines', 'stats'));
    }

    /**
     * Afficher le détail d'une annonce
     */
    public function show($id)
    {
        $annonce = Annonce::with(['student', 'payments'])
            ->where('status', 'publiée')
            ->where('is_paid', true)
            ->findOrFail($id);

        // Annonces similaires (même domaine)
        $annoncesSimilaires = Annonce::with(['student'])
            ->where('status', 'publiée')
            ->where('is_paid', true)
            ->where('id', '!=', $id)
            ->where('domaine', 'LIKE', "%{$annonce->domaine}%")
            ->limit(3)
            ->get();

        return view('annonces.detail', compact('annonce', 'annoncesSimilaires'));
    }

    /**
     * API pour les filtres dynamiques
     */
    public function getFiltres()
    {
        $domaines = Annonce::where('status', 'publiée')
            ->where('is_paid', true)
            ->whereNotNull('domaine')
            ->pluck('domaine')
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $budgetMin = Annonce::where('status', 'publiée')
            ->where('is_paid', true)
            ->min('budget') ?? 0;

        $budgetMax = Annonce::where('status', 'publiée')
            ->where('is_paid', true)
            ->max('budget') ?? 1000000;

        return response()->json([
            'domaines' => $domaines,
            'budget_min' => $budgetMin,
            'budget_max' => $budgetMax
        ]);
    }


    /**
 * Afficher la liste des demandes (annonces) avec filtre par domaine
 */
/**
 * Afficher la liste des demandes (annonces) avec filtre par domaine et recherche
 */
public function demandesListe(Request $request)
{
    // Requête de base
    $demandes = Annonce::with(['student'])
        ->where('status', 'publiée')
        ->where('is_paid', true);

    // RECHERCHE PAR TEXTE (domaine OU description)
    if ($request->has('search') && !empty($request->search)) {
        $searchTerm = $request->search;
        $demandes->where(function($query) use ($searchTerm) {
            $query->where('domaine', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
        });
    }

    // Filtre par domaine (indépendant de la recherche)
    if ($request->has('domaine') && !empty($request->domaine)) {
        $demandes->where('domaine', 'LIKE', "%{$request->domaine}%");
    }

    // Récupérer tous les domaines uniques pour le filtre
    $domaines = Annonce::where('status', 'publiée')
        ->where('is_paid', true)
        ->whereNotNull('domaine')
        ->pluck('domaine')
        ->unique()
        ->sort()
        ->values()
        ->toArray();

    // Pagination (6 par page)
    $demandes = $demandes->orderBy('created_at', 'desc')->paginate(6)->withQueryString();

    return view('demandes.liste', compact('demandes', 'domaines'));
}
}
