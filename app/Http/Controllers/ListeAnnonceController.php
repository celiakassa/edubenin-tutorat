<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Subject;
use Illuminate\Http\Request;

class ListeAnnonceController extends Controller
{
    /**
     * Afficher la liste de toutes les annonces avec filtres
     */
    public function index(Request $request)
    {
        // Requête de base avec relations
        $annonces = Annonce::with(['student', 'subject'])
            ->where('status', 'publiée')
            ->where('is_paid', true);

        // Filtre par recherche textuelle (nom de la matière ou description)
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $annonces->where(function(\Illuminate\Contracts\Database\Query\Builder $query) use ($searchTerm) {
                $query->whereHas('subject', function(\Illuminate\Contracts\Database\Query\Builder $q) use ($searchTerm) {
                        $q->where('nom', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtre par matière spécifique (via le nom de la matière)
        if ($request->has('domaine') && !empty($request->domaine)) {
            $annonces->whereHas('subject', function(\Illuminate\Contracts\Database\Query\Builder $q) use ($request) {
                $q->where('nom', 'LIKE', "%{$request->domaine}%");
            });
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
        if ($request->has('format') && !in_array($request->format, [null, '', '0'], true)) {
            $annonces->where('format', $request->format);
        }

        // Filtre par disponibilité (jour de la semaine)
        if ($request->has('jour') && !empty($request->jour)) {
            $jour = $request->jour;
            $annonces->where('disponibilite', 'LIKE', "%{$jour}%");
        }

        // Récupérer toutes les matières uniques pour le filtre
        $matieres = Subject::whereHas('annonces', function(\Illuminate\Contracts\Database\Query\Builder $q) {
                $q->where('status', 'publiée')->where('is_paid', true);
            })
            ->pluck('nom')
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
        $annonces = $annonces->latest()->paginate(12)->withQueryString();

        // Passer 'matieres' à la vue au lieu de 'domaines'
        return view('annonces.liste', ['annonces' => $annonces, 'matieres' => $matieres, 'stats' => $stats]);
    }

    /**
     * Afficher le détail d'une annonce
     */
    public function show($id)
    {
        $annonce = Annonce::with(['student', 'payments', 'subject'])
            ->where('status', 'publiée')
            ->where('is_paid', true)
            ->findOrFail($id);

        // Annonces similaires (même matière)
        $annoncesSimilaires = Annonce::with(['student', 'subject'])
            ->where('status', 'publiée')
            ->where('is_paid', true)
            ->where('id', '!=', $id)
            ->where('subject_id', $annonce->subject_id)
            ->limit(3)
            ->get();

        return view('annonces.detail', ['annonce' => $annonce, 'annoncesSimilaires' => $annoncesSimilaires]);
    }

    /**
     * API pour les filtres dynamiques
     */
    public function getFiltres()
    {
        $matieres = Subject::whereHas('annonces', function(\Illuminate\Contracts\Database\Query\Builder $q) {
                $q->where('status', 'publiée')->where('is_paid', true);
            })
            ->pluck('nom')
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
            'domaines' => $matieres, // Garder le nom 'domaines' pour la compatibilité JS
            'budget_min' => $budgetMin,
            'budget_max' => $budgetMax
        ]);
    }

    /**
     * Afficher la liste des demandes (annonces) avec filtre par matière et recherche
     */
    public function demandesListe(Request $request)
    {
        // Requête de base
        $demandes = Annonce::with(['student', 'subject'])
            ->where('status', 'publiée')
            ->where('is_paid', true);

        // RECHERCHE PAR TEXTE (nom de la matière OU description)
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $demandes->where(function(\Illuminate\Contracts\Database\Query\Builder $query) use ($searchTerm) {
                $query->whereHas('subject', function(\Illuminate\Contracts\Database\Query\Builder $q) use ($searchTerm) {
                        $q->where('nom', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtre par matière (indépendant de la recherche)
        if ($request->has('domaine') && !empty($request->domaine)) {
            $demandes->whereHas('subject', function(\Illuminate\Contracts\Database\Query\Builder $q) use ($request) {
                $q->where('nom', 'LIKE', "%{$request->domaine}%");
            });
        }

        // Récupérer toutes les matières uniques pour le filtre
        $matieres = Subject::whereHas('annonces', function(\Illuminate\Contracts\Database\Query\Builder $q) {
                $q->where('status', 'publiée')->where('is_paid', true);
            })
            ->pluck('nom')
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // Pagination (6 par page)
        $demandes = $demandes->latest()->paginate(6)->withQueryString();

        // Passer 'matieres' à la vue
        return view('demandes.liste', ['demandes' => $demandes, 'matieres' => $matieres]);
    }
}
