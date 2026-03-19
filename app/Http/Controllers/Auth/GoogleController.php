<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirige l'utilisateur vers Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Gère le callback de Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Vérifier si l'utilisateur existe déjà avec cet email
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                // Séparer le nom complet en prénom et nom
                $nameParts = explode(' ', $googleUser->name);
                $firstName = $nameParts[0] ?? '';
                $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

                // Créer un utilisateur temporaire (sans rôle défini)
                $user = User::create([
                    'firstname' => $googleUser->user['given_name'] ?? $firstName,
                    'lastname' => $googleUser->user['family_name'] ?? $lastName,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => null,
                    'telephone' => null,
                    'photo_path' => $googleUser->avatar,
                    'role_id' => null, // Pas de rôle pour l'instant
                    'registration_completed' => false, // Inscription non terminée
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]);

                // Connecter l'utilisateur
                Auth::login($user, true);

                // Rediriger vers la page de choix du rôle
                return redirect()->route('choose.role');

            } else {
                // L'utilisateur existe déjà
                Auth::login($user, true);

                // Vérifier si l'inscription est complète
                if (!$user->registration_completed || !$user->role_id) {
                    return redirect()->route('choose.role');
                }

                // Mise à jour de la date de dernière connexion
                $user->update(['last_login' => now()]);

                // Redirection selon le rôle
                return $this->redirectBasedOnRole($user);
            }

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Erreur de connexion Google: ' . $e->getMessage());
        }
    }

    /**
     * Affiche la page de choix du rôle
     */
    public function showRoleChoice()
    {
        $user = Auth::user();

        // Si l'utilisateur a déjà un rôle, rediriger directement
        if ($user->role_id && $user->registration_completed) {
            return $this->redirectBasedOnRole($user);
        }

        return view('auth.choose-role');
    }

    /**
     * Enregistre le choix du rôle
     */
    public function storeRoleChoice(Request $request)
    {
        $request->validate([
            'role' => 'required|in:etudiant,tuteur'
        ]);

        $user = Auth::user();

        // Récupérer l'ID du rôle
        $role = Role::where('name', $request->role)->first();

        if (!$role) {
            return back()->with('error', 'Rôle invalide');
        }

        // Mettre à jour l'utilisateur
        $user->update([
            'role_id' => $role->id,
            'registration_completed' => true,
            'last_login' => now()
        ]);

        // Redirection selon le rôle choisi
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirige l'utilisateur en fonction de son rôle
     */
/**
 * Redirige l'utilisateur en fonction de son rôle
 */
private function redirectBasedOnRole($user)
{
    if ($user->role_id == 1) {
        return redirect()->route('admin.dashboard');
    }

  
    return redirect()->route('dashboardUser');
}
}
