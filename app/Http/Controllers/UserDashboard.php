<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserDashboard extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $profileCompletion = $this->calculateProfileCompletion($user);

        // Récupérer les statistiques
        $stats = $this->getPlatformStatistics();

        return view('dashboardUsers', compact('user', 'profileCompletion', 'stats'));
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
                'availability',
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
            if (! empty($user->$field)) {
                $filled++;
            }
        }

        $total = count($fields);

        return $total > 0 ? round(($filled / $total) * 100) : 0;
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
