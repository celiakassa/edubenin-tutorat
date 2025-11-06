<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompleterProfilUser extends Controller
{
public function edit()
{
    $user = Auth::user();

    // Définir les champs à vérifier selon le rôle
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
    } else { // autres rôles
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

    // Calcul du pourcentage complété
    $filled = 0;
    foreach ($fields as $field) {
        if (!empty($user->$field)) {
            $filled++;
        }
    }

    $total = count($fields);
    $profileCompletion = round(($filled / $total) * 100);

    return view('CompleterProfilUser', compact('user', 'profileCompletion'));
}

public function update(Request $request)
{
    $user = Auth::user();

    // --- Règles générales de validation ---
    $rules = [
        'firstname' => 'required|string|max:255',
        'lastname'  => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email,' . $user->id,
        'telephone' => 'required|string|max:20',
        'birthdate' => 'required|date',
        'city'      => 'required|string|max:255',
        'custom_city' => 'nullable|string|max:255', 
        'bio'       => 'nullable|string|max:1000',
        'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    // --- Règles spécifiques selon le rôle ---
    if ($user->role_id == 3) { // Tuteur
        $rules['qualifications'] = 'required|string|max:500';
        $rules['subjects']       = 'required|string|max:500';
        $rules['rate_per_hour']  = 'required|numeric|min:0';
        $rules['availability']   = 'nullable|array';
    } elseif ($user->role_id == 2) { // Étudiant
        $rules['learning_preference'] = 'required|string|in:En_ligne,présentiel,hybrid';
        $rules['learning_history']    = 'nullable|string|max:1000';
    }

    // --- Validation ---
    $validated = $request->validate($rules);

    // --- Gestion de la ville ---
    $city = $validated['city'];
    if ($city === 'autre' && !empty($request->custom_city)) {
        $city = $request->custom_city;
    }

    // --- Mise à jour des champs de base ---
    $user->update([
        'firstname' => $validated['firstname'],
        'lastname'  => $validated['lastname'],
        'email'     => $validated['email'],
        'telephone' => $validated['telephone'],
        'birthdate' => $validated['birthdate'],
        'city'      => $city,
        'bio'       => $validated['bio'] ?? null,
    ]);

    // --- Gestion de la photo de profil ---
    if ($request->hasFile('photo')) {
        if ($user->photo_path && Storage::disk('public')->exists($user->photo_path)) {
            Storage::disk('public')->delete($user->photo_path);
        }
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->update(['photo_path' => $path]);
    }

    // --- Mise à jour spécifique selon le rôle ---
    if ($user->role_id == 3) {
        // --- Formatage des disponibilités ---
        $availabilityData = [];

        if ($request->has('availability')) {
            foreach ($request->availability as $day => $info) {
                if (isset($info['enabled'])) {
                    $availabilityData[$day] = [
                        'start' => $info['start'] ?? null,
                        'end'   => $info['end'] ?? null,
                    ];
                }
            }
        }

        // --- Mise à jour des champs du tuteur ---
        $user->update([
            'qualifications' => $validated['qualifications'],
            'subjects'       => $validated['subjects'],
            'rate_per_hour'  => $validated['rate_per_hour'],
            'availability'   => json_encode($availabilityData),
        ]);
    } elseif ($user->role_id == 2) {
        // --- Mise à jour des champs de l'étudiant ---
        $user->update([
            'learning_preference' => $validated['learning_preference'],
            'learning_history'    => $validated['learning_history'] ?? null,
        ]);
    }

    // --- Redirection ---
    return redirect()
        ->route('CompleterProfilUser.edit')
        ->with('success', 'Profil mis à jour avec succès!');
}


  }
