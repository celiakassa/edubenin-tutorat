<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompleterProfilUser extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $allSubjects = Subject::where('is_active', true)->orderBy('nom')->get();

        $qualificationsList = [
            'BAC'           => 'BAC (Baccalauréat)',
            'BAC+1'         => 'BAC +1',
            'BAC+2'         => 'BAC +2 (BTS, DUT, DEUG)',
            'BAC+3'         => 'BAC +3 (Licence)',
            'BAC+4'         => 'BAC +4 (Maîtrise)',
            'BAC+5'         => 'BAC +5 (Master, Ingénieur)',
            'BAC+6'         => 'BAC +6 (Master spécialisé)',
            'BAC+7'         => 'BAC +7 (Master recherche)',
            'BAC+8'         => 'BAC +8 (Doctorat)',
            'DOCTORAT'      => 'Doctorat (PhD)',
            'CAPES'         => 'CAPES',
            'AGREGATION'    => 'Agrégation',
            'CERTIFICATION' => 'Certification professionnelle',
        ];

        // Champs selon rôle
        if ($user->role_id == 3) { // Tuteur
            $fields = [
                'firstname', 'lastname', 'email', 'telephone',
                'photo_path', 'bio', 'qualifications', 'rate_per_hour',
                'identity_document_path', 'city', 'learning_preference',
            ];
            $hasSubjects = $user->subjects()->count() > 0;
        } elseif ($user->role_id == 2) { // Étudiant
            $fields = [
                'firstname', 'lastname', 'email', 'telephone',
                'photo_path', 'bio', 'learning_preference', 'city',
            ];
        } else {
            $fields = ['firstname', 'lastname', 'email', 'telephone', 'photo_path', 'bio', 'city'];
        }

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($user->$field)) {
                $filled++;
            }
        }

        if ($user->role_id == 3) {
            if ($hasSubjects) {
                $filled++;
            }
            $total = count($fields) + 1;
        } else {
            $total = count($fields);
        }

        $profileCompletion = $total > 0 ? round(($filled / $total) * 100) : 0;

        return view('CompleterProfilUser', [
            'user'              => $user,
            'profileCompletion' => $profileCompletion,
            'allSubjects'       => $allSubjects,
            'qualificationsList'=> $qualificationsList,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // ─────────────────────────────────────────────────────────────
        // La vue envoie "learning_preference" via un <input type="hidden">
        // (le champ radio a name="learning_preference_radio" et met à
        //  jour l'hidden via JS — ainsi la valeur est toujours présente)
        // ─────────────────────────────────────────────────────────────

        $rules = [
            'firstname'           => 'required|string|max:255',
            'lastname'            => 'required|string|max:255',
            'email'               => 'required|email|unique:users,email,' . $user->id,
            'telephone'           => 'required|string|max:20',
            'city'                => 'required|string|max:255',
            'custom_city'         => 'nullable|string|max:255',
            'bio'                 => 'nullable|string|max:1000',
            'photo'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'learning_preference' => 'required|string|in:online,in_person,hybrid',
        ];

        if ($user->role_id == 3) {
            $rules['qualifications']  = 'required|string|max:500';
            $rules['subjects']        = 'required|array|min:1';
            $rules['subjects.*']      = 'exists:subjects,id';
            $rules['rate_per_hour']   = 'required|numeric|min:0';

            $rules['identity_document'] = $user->identity_document_path
                ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240'
                : 'required|file|mimes:pdf,jpg,jpeg,png|max:10240';
        } elseif ($user->role_id == 2) {
            $rules['learning_history'] = 'nullable|string|max:1000';
        }

        $validated = $request->validate($rules);

        \Log::info('learning_preference sauvegardée', ['value' => $validated['learning_preference']]);

        // ── Ville ──
        $city = $validated['city'];
        if ($city === 'autre' && !empty($request->custom_city)) {
            $city = $request->custom_city;
        }

        // ── Champs de base ──
        $user->update([
            'firstname' => $validated['firstname'],
            'lastname'  => $validated['lastname'],
            'email'     => $validated['email'],
            'telephone' => $validated['telephone'],
            'city'      => $city,
            'bio'       => $validated['bio'] ?? null,
        ]);

        // ── Photo ──
        if ($request->hasFile('photo')) {
            if ($user->photo_path && Storage::disk('public')->exists($user->photo_path)) {
                Storage::disk('public')->delete($user->photo_path);
            }
            $user->update(['photo_path' => $request->file('photo')->store('profile-photos', 'public')]);
        }

        // ── Pièce d'identité (tuteur) ──
        if ($user->role_id == 3 && $request->hasFile('identity_document')) {
            if ($user->identity_document_path && Storage::disk('public')->exists($user->identity_document_path)) {
                Storage::disk('public')->delete($user->identity_document_path);
            }
            $user->update([
                'identity_document_path' => $request->file('identity_document')->store('pieceidentite', 'public'),
                'identity_verified'      => false,
            ]);
        }

        // ── Champs spécifiques tuteur ──
        if ($user->role_id == 3) {
            $user->update([
                'qualifications'      => $validated['qualifications'],
                'rate_per_hour'       => $validated['rate_per_hour'],
                'learning_preference' => $validated['learning_preference'],
            ]);
            $user->subjects()->sync($validated['subjects']);
        }

        // ── Champs spécifiques étudiant ──
        if ($user->role_id == 2) {
            $user->update([
                'learning_preference' => $validated['learning_preference'],
                'learning_history'    => $validated['learning_history'] ?? null,
            ]);
        }

        return to_route('CompleterProfilUser.edit')
            ->with('success', 'Profil mis à jour avec succès !');
    }

    public function show()
    {
        $user = Auth::user();
        $user->load('subjects');
        return view('CompleterProfilUserShow', ['user' => $user]);
    }

    public function showIdentityDocument()
    {
        $user = Auth::user();
        abort_if(
            !$user->identity_document_path || !Storage::disk('public')->exists($user->identity_document_path),
            404, 'Pièce d\'identité non trouvée'
        );
        return response()->file(storage_path('app/public/' . $user->identity_document_path));
    }

    public function downloadIdentityDocument($userId)
    {
        abort_if(Auth::user()->role_id != 1, 403, 'Accès non autorisé');
        $user = User::findOrFail($userId);
        abort_unless($user->identity_document_path, 404, 'Pièce d\'identité non trouvée');
        return Storage::disk('public')->download($user->identity_document_path);
    }

    public function verifyIdentity(Request $request, $userId)
    {
        abort_if(Auth::user()->role_id != 1, 403, 'Accès non autorisé');
        User::findOrFail($userId)->update(['identity_verified' => true, 'is_valid' => true]);
        return back()->with('success', 'Pièce d\'identité vérifiée avec succès');
    }
}
