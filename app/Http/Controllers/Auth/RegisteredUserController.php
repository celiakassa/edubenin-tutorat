<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /**
     * Traiter l'inscription (tuteur ou étudiant)
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'integer', 'in:2,3'], // 2 = étudiant, 3 = tuteur
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'role_id' => $validated['role_id'],
            'password' => Hash::make($validated['password']),
        ]);

        // Déclencher l'événement d'inscription
        event(new Registered($user));

        // Connecter l'utilisateur
        Auth::login($user);

        // Message personnalisé selon le rôle
        $roleMessage = $validated['role_id'] == 3
            ? 'Bienvenue parmi nos tuteurs !'
            : 'Bienvenue sur EduConnect !';

        return redirect()->route('verification.notice')
            ->with('message', "Un email de confirmation a été envoyé à {$user->email}. Veuillez vérifier votre boîte mail.  {$roleMessage}");
    }

}
