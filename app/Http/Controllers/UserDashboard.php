<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

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
                'rate_per_hour',
                'identity_document_path',
                'city',
                'learning_preference',
            ];

            // Vérification spéciale pour les matières (relation)
            $hasSubjects = $user->subjects()->count() > 0;
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
            if (!empty($user->$field)) {
                $filled++;
            }
        }

        // Ajouter la vérification des matières pour les tuteurs
        if ($user->role_id == 3 && $hasSubjects) {
            $filled++;
        }

        $total = count($fields) + ($user->role_id == 3 ? 1 : 0);

        return $total > 0 ? round(($filled / $total) * 100) : 0;
    }

    /**
     * Statistiques spécifiques pour les tuteurs
     */
    private function getTutorStatistics($user)
    {
        // IDs des matières du tuteur
        $tutorSubjectIds = $user->subjects->pluck('id')->toArray();

        // Nombre d'annonces dans ses matières
        $annoncesInDomain = 0;
        if (!empty($tutorSubjectIds)) {
            $annoncesInDomain = Annonce::where('status', 'publiée')
                ->whereIn('subject_id', $tutorSubjectIds)
                ->count();
        }

        // Nombre de candidatures validées
        $candidaturesValidees = Candidature::where('user_id', $user->id)
            ->where('statut', 'acceptee')
            ->count();

        // Nombre total de candidatures
        $totalCandidatures = Candidature::where('user_id', $user->id)->count();

        // Candidatures en attente
        $candidaturesEnAttente = Candidature::where('user_id', $user->id)
            ->where('statut', 'en_attente')
            ->count();

        // Acompte total pour les annonces validées
        $acompteTotal = Annonce::whereHas('candidatures', function (\Illuminate\Contracts\Database\Query\Builder $query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('statut', 'acceptee');
        })->sum('acompte');

        // Récentes annonces dans ses matières
        $recentAnnonces = collect();
        if (!empty($tutorSubjectIds)) {
            $recentAnnonces = Annonce::where('status', 'publiée')
                ->whereIn('subject_id', $tutorSubjectIds)
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Dernières candidatures du tuteur (5 dernières)
        $dernieresCandidatures = Candidature::where('user_id', $user->id)
            ->with(['annonce'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'annoncesInDomain' => $annoncesInDomain,
            'candidaturesValidees' => $candidaturesValidees,
            'totalCandidatures' => $totalCandidatures,
            'candidaturesEnAttente' => $candidaturesEnAttente,
            'acompteTotal' => $acompteTotal,
            'recentAnnonces' => $recentAnnonces,
            'dernieresCandidatures' => $dernieresCandidatures,
            'tutorSubjects' => $user->subjects->pluck('nom')->toArray(), // noms des matières
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
            ->with('subject')
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
