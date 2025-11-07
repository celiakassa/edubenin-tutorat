<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserDashboard extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $profileCompletion = $this->calculateProfileCompletion($user);

        return view('dashboardUsers', compact('user', 'profileCompletion'));
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
}
