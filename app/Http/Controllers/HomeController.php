<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

final class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil
     */
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // Récupérer toutes les matières depuis la nouvelle table subjects
        $allSubjects = Subject::where('is_active', true)
            ->orderBy('nom')
            ->pluck('nom')
            ->toArray();

        // Récupérer toutes les villes uniques de tous les tuteurs
        $allCities = User::where('role_id', 3)
            ->where('is_valid', 1)
            ->where('is_active', 1)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->pluck('city')
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // Récupérer les tarifs min et max pour les filtres
        $minPrice = User::where('role_id', 3)
            ->where('is_valid', 1)
            ->where('is_active', 1)
            ->whereNotNull('rate_per_hour')
            ->min('rate_per_hour') ?? 0;

        $maxPrice = User::where('role_id', 3)
            ->where('is_valid', 1)
            ->where('is_active', 1)
            ->whereNotNull('rate_per_hour')
            ->max('rate_per_hour') ?? 50000;

        // Récupérer les annonces publiées et non attribuées
        $annoncesQuery = Annonce::with(['student', 'subject']) // Ajout de la relation subject
            ->where('status', 'publiée')
            ->where('is_paid', true)->latest();

        // Appliquer les filtres aux annonces si présents
        if ($request->has('annonce_subject') && ! empty($request->annonce_subject)) {
            $subjectId = Subject::where('nom', 'LIKE', '%'.$request->annonce_subject.'%')
                ->value('id');

            if ($subjectId) {
                $annoncesQuery->where('subject_id', $subjectId);
            } else {
                // Si le nom ne correspond à aucun ID, ne retourner aucun résultat
                $annoncesQuery->where('subject_id', 0);
            }
        }

        if ($request->has('annonce_budget_min') && ! empty($request->annonce_budget_min)) {
            $annoncesQuery->where('budget', '>=', $request->annonce_budget_min);
        }

        if ($request->has('annonce_budget_max') && ! empty($request->annonce_budget_max)) {
            $annoncesQuery->where('budget', '<=', $request->annonce_budget_max);
        }

        if ($request->has('annonce_format') && ! empty($request->annonce_format)) {
            $annoncesQuery->where('format', $request->annonce_format);
        }

        if ($request->has('annonce_disponibilite') && ! empty($request->annonce_disponibilite)) {
            $searchDay = $request->annonce_disponibilite;
            $annoncesQuery->where('disponibilite', 'LIKE', '%'.$searchDay.'%');
        }

        $annonces = $annoncesQuery->take(20)->get();

        // Statistiques pour les annonces
        $annoncesStats = [
            'total' => Annonce::where('status', 'publiée')->where('is_paid', true)->count(),
            'budget_moyen' => Annonce::where('status', 'publiée')->where('is_paid', true)->avg('budget'),
            'budget_min' => Annonce::where('status', 'publiée')->where('is_paid', true)->min('budget'),
            'budget_max' => Annonce::where('status', 'publiée')->where('is_paid', true)->max('budget'),
        ];

        // Requête de base pour les tuteurs
        $tutorsQuery = User::where('role_id', 3)
            ->where('is_valid', 1)
            ->where('identity_verified', 1)
            ->where('is_active', 1);

        // Appliquer le filtre par matière si présent (avec la nouvelle relation)
        if ($request->has('subject') && ! empty($request->subject)) {
            $subjectId = Subject::where('nom', $request->subject)->value('id');
            if ($subjectId) {
                $tutorsQuery->whereHas('subjects', function ($query) use ($subjectId): void {
                    $query->where('subject_id', $subjectId);
                });
            }
        }

        // Appliquer le filtre par ville si présent
        if ($request->has('city') && ! empty($request->city)) {
            $tutorsQuery->where('city', $request->city);
        }

        // Appliquer le filtre par mode d'enseignement
        if ($request->has('learning_preference') && ! empty($request->learning_preference)) {
            $tutorsQuery->where('learning_preference', $request->learning_preference);
        }

        // Appliquer le filtre par tarif
        if ($request->has('price_range') && ! empty($request->price_range)) {
            $priceRange = explode('-', (string) $request->price_range);

            if (count($priceRange) === 2) {
                if ($priceRange[1] === '+') {
                    $tutorsQuery->where('rate_per_hour', '>=', (int) $priceRange[0]);
                } else {
                    $tutorsQuery->whereBetween('rate_per_hour', [(int) $priceRange[0], (int) $priceRange[1]]);
                }
            }
        }

        // Appliquer le filtre de recherche textuelle
        if ($request->has('search') && ! empty($request->search)) {
            $searchTerm = $request->search;
            $tutorsQuery->where(function ($query) use ($searchTerm): void {
                $query->where('firstname', 'LIKE', sprintf('%%%s%%', $searchTerm))
                    ->orWhere('lastname', 'LIKE', sprintf('%%%s%%', $searchTerm))
                    ->orWhere('city', 'LIKE', sprintf('%%%s%%', $searchTerm))
                    ->orWhere('bio', 'LIKE', sprintf('%%%s%%', $searchTerm));
            });
        }

        // Compter le nombre total de tuteurs
        $totalTutors = User::where('role_id', 3)
            ->where('is_valid', 1)
            ->where('is_active', 1)
            ->count();

        // Récupérer les tuteurs récemment inscrits
        $recentTutors = User::where('role_id', 3)
            ->where('is_valid', 1)
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Récupérer les tuteurs avec pagination
        $tutors = $tutorsQuery->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Récupérer les valeurs sélectionnées
        $selectedSubject = $request->subject ?? '';
        $selectedCity = $request->city ?? '';
        $selectedPreference = $request->learning_preference ?? '';
        $selectedPriceRange = $request->price_range ?? '';
        $searchQuery = $request->search ?? '';

        // Valeurs pour les filtres d'annonces
        $selectedAnnonceSubject = $request->annonce_subject ?? '';
        $selectedAnnonceBudgetMin = $request->annonce_budget_min ?? '';
        $selectedAnnonceBudgetMax = $request->annonce_budget_max ?? '';
        $selectedAnnonceFormat = $request->annonce_format ?? '';
        $selectedAnnonceDisponibilite = $request->annonce_disponibilite ?? '';

        return view('welcome', ['allSubjects' => $allSubjects, 'allCities' => $allCities, 'tutors' => $tutors, 'totalTutors' => $totalTutors, 'selectedSubject' => $selectedSubject, 'selectedCity' => $selectedCity, 'selectedPreference' => $selectedPreference, 'selectedPriceRange' => $selectedPriceRange, 'searchQuery' => $searchQuery, 'recentTutors' => $recentTutors, 'minPrice' => $minPrice, 'maxPrice' => $maxPrice, 'annonces' => $annonces, 'annoncesStats' => $annoncesStats, 'selectedAnnonceSubject' => $selectedAnnonceSubject, 'selectedAnnonceBudgetMin' => $selectedAnnonceBudgetMin, 'selectedAnnonceBudgetMax' => $selectedAnnonceBudgetMax, 'selectedAnnonceFormat' => $selectedAnnonceFormat, 'selectedAnnonceDisponibilite' => $selectedAnnonceDisponibilite]);
    }

    /**
     * Récupérer les matières populaires (API)
     */
    public function getPopularSubjects()
    {
        $matieres = Subject::where('is_active', true)
            ->orderBy('nom')
            ->pluck('nom')
            ->take(40)
            ->toArray();

        if (count($matieres) < 20) {
            $matieresDefaut = [
                'Mathématiques', 'Français', 'Anglais', 'Physique', 'Chimie',
                'SVT', 'Histoire', 'Géographie', 'Philosophie', 'Espagnol',
                'Allemand', 'Informatique', 'Économie', 'Droit', 'Marketing',
                'Comptabilité', 'Musique', 'Arts', 'Sport', 'Médecine',
                'Programmation', 'Web Design', 'Bureautique', 'Statistiques',
                'Biologie', 'Électricité', 'Mécanique', 'Architecture',
                'Psychologie', 'Sociologie', 'Communication', 'Gestion',
                'Finance', 'Langues',
            ];

            $matieres = array_unique(array_merge($matieres, $matieresDefaut));
            $matieres = array_slice($matieres, 0, 40);
        }

        return response()->json($matieres);
    }

    /**
     * Récupérer les villes populaires (API)
     */
    public function getPopularCities()
    {
        $villes = User::where('role_id', 3)
            ->where('is_active', 1)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->pluck('city')
            ->map(fn($city): string => mb_trim($city))
            ->filter(fn ($city): bool => ! empty($city))
            ->unique()
            ->take(30)
            ->values()
            ->all();

        if (count($villes) < 15) {
            $villesDefaut = [
                'Cotonou',
                'Porto-Novo',
                'Parakou',
                'Abomey-Calavi',
                'Djougou',
                'Bohicon',
                'Kandi',
                'Lokossa',
                'Ouidah',
                'Abomey',
                'Natitingou',
                'Savalou',
                'Comè',
                'Malanville',
                'Tchaourou',
                'Banikoara',
                'Aplahoué',
                'Allada',
                'Pobè',
                'Kétou',
            ];

            $villes = array_unique(array_merge($villes, $villesDefaut));
            $villes = array_slice($villes, 0, 30);
        }

        return response()->json($villes);
    }

    /**
     * API pour récupérer les domaines uniques des annonces
     */
    public function getAnnonceSubjects()
    {
        $subjects = Subject::whereHas('annonces', function (\Illuminate\Contracts\Database\Query\Builder $query): void {
            $query->where('status', 'publiée')
                ->where('is_paid', true);
        })
            ->pluck('nom')
            ->unique()
            ->sort()
            ->values()
            ->take(30)
            ->toArray();

        return response()->json($subjects);
    }
}
