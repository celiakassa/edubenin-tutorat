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
        $roles = Role::where('name','!=','admin')->get();
        return view('auth.register',compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {


        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'birthdate' => ['required', 'date'],
            'photo_path'=> ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id'   => ['required'],
        ]);

        $user = User::create([
            'firstname' => $validated['firstname'],
            'lastname'  => $validated['lastname'],
            'email'     => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'birthdate' => $validated['birthdate'],
            'role_id'   => $validated['role_id'],
            'password'  => Hash::make($validated['password']),
            'photo_path'=> $request->file('photo_path') ? $request->file('photo_path')->store('photos', 'public') : null,
        ]);


        event(new Registered($user));


        // Ne pas connecter l'utilisateur immédiatement
        Auth::login($user);

        return redirect()->route('verification.notice')->with('message', 'Un email de confirmation a été envoyé. Veuillez vérifier votre boîte mail.');
    }
}
