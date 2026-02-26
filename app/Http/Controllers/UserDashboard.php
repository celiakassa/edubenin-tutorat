<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Candidature;

class UserDashboard extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $profileCompletion = $this->calculateProfileCompletion($user);

        // Vérifier le rôle et rediriger vers la bonne vue
        if ($user->isAdmin()) {
            // Statistiques pour admin
            $stats = $this->getPlatformStatistics();
            return view('dashboardUsers', ['user' => $user, 'profileCompletion' => $profileCompletion, 'stats' => $stats]);
        } elseif ($user->isTuteur()) {
            // Statistiques pour tuteur
            $stats = $this->getTutorStatistics($user);
            return view('DashboardTeacher', ['user' => $user, 'profileCompletion' => $profileCompletion, 'stats' => $stats]);
        } else {
            // Statistiques pour étudiant
            $stats = $this->getStudentStatistics($user);
            return view('dashboardUsers', ['user' => $user, 'profileCompletion' => $profileCompletion, 'stats' => $stats]);
        }
    }

    private function calculateProfileCompletion($user)
    {
        // --- Définir les champs à vérifier selon le rôle ---
        if ($user->role_id == 3) { // Tuteur
            $fields = [
                'firstname',
                'lastname',
                'email',
                'telephone',
                'photo_path',
                'bio',
                'qualifications',
                'subjects',
                'rate_per_hour',
                'identity_document_path',
                'city',
                'learning_preference',
            ];
        } elseif ($user->role_id == 2) { // Étudiant
            $fields = [
                'firstname',
                'lastname',
                'email',
                'telephone',
                'photo_path',
                'bio',
                'learning_history',
                'learning_preference',
                'city',
            ];
        } else { // Autres rôles
            $fields = [
                'firstname',
                'lastname',
                'email',
                'telephone',
                'photo_path',
                'bio',
                'city',
            ];
        }

        // --- Calcul du pourcentage complété ---
        $filled = 0;
        foreach ($fields as $field) {
            // Vérification spéciale pour certains champs
            if ($field === 'subjects' && $user->role_id == 3) {
                // Pour les sujets, vérifier que ce n'est pas un tableau vide
                $subjects = $user->subjects;
                if (!empty($subjects)) {
                    $decoded = json_decode($subjects, true);
                    if (is_array($decoded) && $decoded !== []) {
                        $filled++;
                    } elseif (is_string($subjects) && trim($subjects) !== '') {
                        $filled++;
                    }
                }
            } elseif (!empty($user->$field)) {
                // Vérification standard pour les autres champs
                $filled++;
            }
        }

        $total = count($fields);

        return $total > 0 ? round(($filled / $total) * 100) : 0;
    }

    /**
     * Statistiques spécifiques pour les tuteurs
     */
    private function getTutorStatistics($user)
    {
        // Récupérer les subjects du tuteur
        $tutorSubjects = json_decode($user->subjects, true);
        if (!is_array($tutorSubjects)) {
            $tutorSubjects = [];
        }

        // Nombre d'annonces dans son domaine (subjects)
        $annoncesInDomain = 0;
        if ($tutorSubjects !== []) {
            $annoncesInDomain = Annonce::where('status', 'publiée')
                ->where(function($query) use ($tutorSubjects) {
                    foreach ($tutorSubjects as $subject) {
                        $query->orWhere('domaine', 'LIKE', '%' . $subject . '%');
                    }
                })
                ->count();
        }

        // Nombre de candidatures validées (acceptées)
        $candidaturesValidees = Candidature::where('user_id', $user->id)
            ->where('statut', 'acceptee')
            ->count();

        // Nombre total de candidatures
        $totalCandidatures = Candidature::where('user_id', $user->id)->count();

        // Candidatures en attente
        $candidaturesEnAttente = Candidature::where('user_id', $user->id)
            ->where('statut', 'en_attente')
            ->count();

        // Acompte total (somme des acomptes des annonces avec candidature acceptée)
        $acompteTotal = Annonce::whereHas('candidatures', function(\Illuminate\Contracts\Database\Query\Builder $query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('statut', 'acceptee');
        })->sum('acompte');

        // Pour le moment, on utilise une valeur statique si demandé
        $acompteStatique = 0; // Tu peux mettre une valeur par défaut ici

        // Récentes annonces dans son domaine (5 dernières)
        $recentAnnonces = collect();
        if ($tutorSubjects !== []) {
            $recentAnnonces = Annonce::where('status', 'publiée')
                ->where(function($query) use ($tutorSubjects) {
                    foreach ($tutorSubjects as $subject) {
                        $query->orWhere('domaine', 'LIKE', '%' . $subject . '%');
                    }
                })
                ->with('student')
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Dernières candidatures
        $dernieresCandidatures = Candidature::where('user_id', $user->id)
            ->with(['annonce', 'annonce.student'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'annoncesInDomain' => $annoncesInDomain,
            'candidaturesValidees' => $candidaturesValidees,
            'totalCandidatures' => $totalCandidatures,
            'candidaturesEnAttente' => $candidaturesEnAttente,
            'acompteTotal' => $acompteTotal,
            'acompteStatique' => $acompteStatique,
            'recentAnnonces' => $recentAnnonces,
            'dernieresCandidatures' => $dernieresCandidatures,
            'tutorSubjects' => $tutorSubjects,
        ];
    }

    /**
     * Statistiques pour les étudiants
     */
    private function getStudentStatistics($user)
    {
        // Nombre d'annonces publiées
        $annoncesPubliees = Annonce::where('student_id', $user->id)
            ->where('status', 'publiée')
            ->count();

        // Nombre d'annonces avec candidatures
        $annoncesAvecCandidatures = Annonce::where('student_id', $user->id)
            ->has('candidatures')
            ->count();

        // Annonces récentes
        $recentAnnonces = Annonce::where('student_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'annoncesPubliees' => $annoncesPubliees,
            'annoncesAvecCandidatures' => $annoncesAvecCandidatures,
            'recentAnnonces' => $recentAnnonces,
        ];
    }

    private function getPlatformStatistics()
    {
        // Statistiques des rôles
        $totalUsers = User::where('is_active', true)->count();
        $tutorsCount = User::where('role_id', 3)->where('is_active', true)->count();
        $studentsCount = User::where('role_id', 2)->where('is_active', true)->count();

        // Pourcentages
        $tutorsPercentage = $totalUsers > 0 ? round(($tutorsCount / $totalUsers) * 100, 1) : 0;
        $studentsPercentage = $totalUsers > 0 ? round(($studentsCount / $totalUsers) * 100, 1) : 0;

        // Statistiques des préférences d'apprentissage pour les tuteurs
        $onlineTutors = User::where('role_id', 3)
            ->where('learning_preference', 'online')
            ->where('is_active', true)
            ->count();

        $inPersonTutors = User::where('role_id', 3)
            ->where('learning_preference', 'in_person')
            ->where('is_active', true)
            ->count();

        $hybridTutors = User::where('role_id', 3)
            ->where('learning_preference', 'hybrid')
            ->where('is_active', true)
            ->count();

        // Statistiques des préférences d'apprentissage pour les étudiants
        $onlineStudents = User::where('role_id', 2)
            ->where('learning_preference', 'online')
            ->where('is_active', true)
            ->count();

        $inPersonStudents = User::where('role_id', 2)
            ->where('learning_preference', 'in_person')
            ->where('is_active', true)
            ->count();

        $hybridStudents = User::where('role_id', 2)
            ->where('learning_preference', 'hybrid')
            ->where('is_active', true)
            ->count();

        // Top villes des utilisateurs
        $topCities = User::where('is_active', true)
            ->whereNotNull('city')
            ->selectRaw('city, COUNT(*) as count')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return [
            'totalUsers' => $totalUsers,
            'tutorsCount' => $tutorsCount,
            'studentsCount' => $studentsCount,
            'tutorsPercentage' => $tutorsPercentage,
            'studentsPercentage' => $studentsPercentage,
            'onlineTutors' => $onlineTutors,
            'inPersonTutors' => $inPersonTutors,
            'hybridTutors' => $hybridTutors,
            'onlineStudents' => $onlineStudents,
            'inPersonStudents' => $inPersonStudents,
            'hybridStudents' => $hybridStudents,
            'topCities' => $topCities,
        ];
    }
}
