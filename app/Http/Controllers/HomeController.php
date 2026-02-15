<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Annonce;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil
     */
    public function index(Request $request)
    {
        // Récupérer toutes les matières uniques de tous les tuteurs
        $allSubjects = User::where('role_id', 3)
            ->where('is_valid', 1)
            ->where('is_active', 1)
            ->whereNotNull('subjects')
            ->get()
            ->flatMap(function ($user) {
                $subjects = json_decode($user->subjects, true);
                return is_array($subjects) ? $subjects : [];
            })
            ->unique()
            ->sort()
            ->values()
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
        $annoncesQuery = Annonce::with(['student'])
            ->where('status', 'publiée')
            ->where('is_paid', true)
            ->orderBy('created_at', 'desc');

        // Appliquer les filtres aux annonces si présents
        if ($request->has('annonce_subject') && !empty($request->annonce_subject)) {
            $annoncesQuery->where('domaine', 'LIKE', '%' . $request->annonce_subject . '%');
        }

        if ($request->has('annonce_budget_min') && !empty($request->annonce_budget_min)) {
            $annoncesQuery->where('budget', '>=', $request->annonce_budget_min);
        }

        if ($request->has('annonce_budget_max') && !empty($request->annonce_budget_max)) {
            $annoncesQuery->where('budget', '<=', $request->annonce_budget_max);
        }

        if ($request->has('annonce_format') && !empty($request->annonce_format)) {
            $annoncesQuery->where('format', $request->annonce_format);
        }

        if ($request->has('annonce_disponibilite') && !empty($request->annonce_disponibilite)) {
            $searchDay = $request->annonce_disponibilite;
            $annoncesQuery->where('disponibilite', 'LIKE', '%' . $searchDay . '%');
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
        $tutors = User::where('role_id', 3)
            ->where('is_valid', 1)
            ->where('identity_verified', 1)
            ->where('is_active', 1);

        // Appliquer le filtre par matière si présent
        if ($request->has('subject') && !empty($request->subject)) {
            $tutors->where(function ($query) use ($request) {
                $query->where('subjects', 'LIKE', '%"' . $request->subject . '"%')
                      ->orWhere('subjects', 'LIKE', '%' . $request->subject . '%');
            });
        }

        // Appliquer le filtre par ville si présent
        if ($request->has('city') && !empty($request->city)) {
            $tutors->where('city', $request->city);
        }

        // Appliquer le filtre par mode d'enseignement
        if ($request->has('learning_preference') && !empty($request->learning_preference)) {
            $tutors->where('learning_preference', $request->learning_preference);
        }

        // Appliquer le filtre par tarif
        if ($request->has('price_range') && !empty($request->price_range)) {
            $priceRange = explode('-', $request->price_range);

            if (count($priceRange) == 2) {
                if ($priceRange[1] == '+') {
                    $tutors->where('rate_per_hour', '>=', $priceRange[0]);
                } else {
                    $tutors->whereBetween('rate_per_hour', [(int)$priceRange[0], (int)$priceRange[1]]);
                }
            }
        }

        // Appliquer le filtre de recherche textuelle
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $tutors->where(function ($query) use ($searchTerm) {
                $query->where('firstname', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('lastname', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('city', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('bio', 'LIKE', "%{$searchTerm}%");
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
        $tutors = $tutors->orderBy('created_at', 'desc')
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

        return view('welcome', compact(
            'allSubjects',
            'allCities',
            'tutors',
            'totalTutors',
            'selectedSubject',
            'selectedCity',
            'selectedPreference',
            'selectedPriceRange',
            'searchQuery',
            'recentTutors',
            'minPrice',
            'maxPrice',
            'annonces',
            'annoncesStats',
            'selectedAnnonceSubject',
            'selectedAnnonceBudgetMin',
            'selectedAnnonceBudgetMax',
            'selectedAnnonceFormat',
            'selectedAnnonceDisponibilite'
        ));
    }

    /**
     * Récupérer les matières populaires (API)
     */
    public function getPopularSubjects()
    {
        $matieres = User::where('role_id', 3)
            ->where('is_active', 1)
            ->whereNotNull('subjects')
            ->pluck('subjects')
            ->flatMap(function ($subjects) {
                if (is_string($subjects)) {
                    $subjects = str_replace(['[', ']', '"', "'"], '', $subjects);
                    return explode(',', $subjects);
                }
                return [];
            })
            ->map(fn($subject) => trim($subject))
            ->filter(fn($subject) => ! empty($subject) && $subject !== '')
            ->unique()
            ->take(40)
            ->values()
            ->all();

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
            ->map(function ($city) {
                if (is_string($city)) {
                    $city = str_replace(['[', ']', '"', "'"], '', $city);
                    return trim($city);
                }
                return '';
            })
            ->filter(fn($city) => ! empty($city) && $city !== '')
            ->unique()
            ->take(30)
            ->values()
            ->all();

        if (count($villes) < 15) {
            $villesDefaut = [
                'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice',
                'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille',
                'Rennes', 'Reims', 'Le Havre', 'Saint-Étienne', 'Toulon',
                'Grenoble', 'Dijon', 'Angers', 'Nîmes', 'Villeurbanne',
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
        $domaines = Annonce::where('status', 'publiée')
            ->where('is_paid', true)
            ->whereNotNull('domaine')
            ->pluck('domaine')
            ->unique()
            ->sort()
            ->values()
            ->take(30)
            ->toArray();

        return response()->json($domaines);
    }
}
