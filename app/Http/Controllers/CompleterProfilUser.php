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
                'identity_document_path', // Nouveau champ pour tuteur
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
            if (!empty($user->$field)) {
                $filled++;
            }
        }

        $total = count($fields);
        $profileCompletion = $total > 0 ? round(($filled / $total) * 100) : 0;

        return view('CompleterProfilUser', compact('user', 'profileCompletion'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // --- Règles générales de validation ---
        $rules = [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'telephone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'custom_city' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // --- Règles spécifiques selon le rôle ---
        if ($user->role_id == 3) { // Tuteur
            $rules['qualifications'] = 'required|string|max:500';
            $rules['subjects'] = 'required|string|max:500';
            $rules['rate_per_hour'] = 'required|numeric|min:0';
            $rules['learning_preference'] = 'required|string|in:online,in_person,hybrid';
            $rules['identity_document'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240'; // 10MB max
        } elseif ($user->role_id == 2) { // Étudiant
            $rules['learning_preference'] = 'required|string|in:online,in_person,hybrid';
            $rules['learning_history'] = 'nullable|string|max:1000';
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
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'city' => $city,
            'bio' => $validated['bio'] ?? null,
        ]);

        // --- Gestion de la photo de profil ---
        if ($request->hasFile('photo')) {
            if ($user->photo_path && Storage::disk('public')->exists($user->photo_path)) {
                Storage::disk('public')->delete($user->photo_path);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->update(['photo_path' => $path]);
        }

        // --- Gestion de la pièce d'identité pour les tuteurs ---
        if ($user->role_id == 3 && $request->hasFile('identity_document')) {
            // Supprimer l'ancienne pièce si elle existe
            if ($user->identity_document_path && Storage::disk('public')->exists($user->identity_document_path)) {
                Storage::disk('public')->delete($user->identity_document_path);
            }

            // Stocker la nouvelle pièce dans le dossier 'pieceidentite'
            $path = $request->file('identity_document')->store('pieceidentite', 'public');
            $user->update([
                'identity_document_path' => $path,
                'identity_verified' => false, // Réinitialiser le statut de vérification
            ]);
        }

        // --- Mise à jour spécifique selon le rôle ---
        if ($user->role_id == 3) { // Tuteur
            $user->update([
                'qualifications' => $validated['qualifications'],
                'subjects' => $validated['subjects'],
                'rate_per_hour' => $validated['rate_per_hour'],
                'learning_preference' => $validated['learning_preference'],
            ]);

        } elseif ($user->role_id == 2) { // Étudiant
            $user->update([
                'learning_preference' => $validated['learning_preference'],
                'learning_history' => $validated['learning_history'] ?? null,
            ]);
        }

        // --- Redirection ---
        return redirect()
            ->route('CompleterProfilUser.edit')
            ->with('success', 'Profil mis à jour avec succès!');
    }

 public function show()
    {
        $user = Auth::user();

        // Charger les relations si nécessaire
        $user->load([]);

        return view('CompleterProfilUserShow', compact('user'));
    }

    // Méthode pour afficher la pièce d'identité
    public function showIdentityDocument()
    {
        $user = Auth::user();

        if (!$user->identity_document_path || !Storage::disk('public')->exists($user->identity_document_path)) {
            abort(404, 'Pièce d\'identité non trouvée');
        }

        return response()->file(storage_path('app/public/' . $user->identity_document_path));
    }

    // Méthode pour télécharger/voir la pièce d'identité
public function downloadIdentityDocument($userId)
{
    $user = User::findOrFail($userId);

    // Vérifier les permissions (admin seulement)
    if (Auth::user()->role_id != 1) {
        abort(403, 'Accès non autorisé');
    }

    if (!$user->identity_document_path) {
        abort(404, 'Pièce d\'identité non trouvée');
    }

    return Storage::disk('public')->download($user->identity_document_path);
}

// Méthode pour marquer comme vérifié
public function verifyIdentity(Request $request, $userId)
{
    $user = User::findOrFail($userId);

    // Vérifier les permissions (admin seulement)
    if (Auth::user()->role_id != 1) {
        abort(403, 'Accès non autorisé');
    }

    $user->update([
        'identity_verified' => true,
        'is_valid' => true, // Optionnel : marquer le tuteur comme valide
    ]);

    return redirect()->back()->with('success', 'Pièce d\'identité vérifiée avec succès');
}
}
