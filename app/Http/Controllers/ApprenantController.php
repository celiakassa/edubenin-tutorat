<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentDeactivatedMail;
use App\Mail\StudentReactivatedMail;
use App\Mail\StudentValidatedMail;

class ApprenantController extends Controller
{
    /**
     * Afficher la liste des apprenants avec statistiques
     */
    public function index()
    {
        $apprenants = User::where('role_id', 2)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistiques pour les diagrammes
        $stats = $this->getApprenantsStats();

        // Calculer le pourcentage de complétion pour chaque apprenant
        $apprenants->transform(function ($apprenant) {
            $apprenant->profile_completion = $this->calculateProfileCompletion($apprenant);

            return $apprenant;
        });

        return view('apprenants.index', compact('apprenants', 'stats'));
    }

    /**
     * Obtenir les statistiques des apprenants
     */
    private function getApprenantsStats()
    {
        $totalApprenants = User::where('role_id', 2)->count();

        // Calcul du pourcentage de profil complet
        $apprenantsWithCompleteProfile = 0;
        $allApprenants = User::where('role_id', 2)->get();

        foreach ($allApprenants as $apprenant) {
            if ($this->calculateProfileCompletion($apprenant) == 100) {
                $apprenantsWithCompleteProfile++;
            }
        }

        $profileCompletionPercentage = $totalApprenants > 0
            ? round(($apprenantsWithCompleteProfile / $totalApprenants) * 100, 2)
            : 0;

        // Statistiques par ville
        $villeStats = User::where('role_id', 2)
            ->select('city', \DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->pluck('total', 'city')
            ->toArray();

        // Inscriptions par mois (derniers 6 mois)
        $inscriptionsParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('M Y');

            $count = User::where('role_id', 2)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $inscriptionsParMois[$monthYear] = $count;
        }

        // Statut des apprenants
        $actifs = User::where('role_id', 2)->where('is_active', true)->count();
        $inactifs = User::where('role_id', 2)->where('is_active', false)->count();
        $valides = User::where('role_id', 2)->where('is_valid', true)->count();
        $nonValides = User::where('role_id', 2)->where('is_valid', false)->count();

        return [
            'total' => $totalApprenants,
            'avecProfilComplet' => $apprenantsWithCompleteProfile,
            'pourcentageProfilComplet' => $profileCompletionPercentage,
            'parVille' => $villeStats,
            'inscriptionsParMois' => $inscriptionsParMois,
            'actifs' => $actifs,
            'inactifs' => $inactifs,
            'valides' => $valides,
            'nonValides' => $nonValides,
        ];
    }

    /**
     * Calculer le pourcentage de complétion du profil
     */
    private function calculateProfileCompletion($user)
    {
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

        $filled = 0;
        foreach ($fields as $field) {
            if (! empty($user->$field)) {
                $filled++;
            }
        }

        $total = count($fields);

        return $total > 0 ? round(($filled / $total) * 100) : 0;
    }

    /**
     * Afficher les détails d'un apprenant
     */
    public function show($id)
    {
        $apprenant = User::where('id', $id)
            ->where('role_id', 2)
            ->firstOrFail();

        // Calcul du pourcentage de complétion du profil
        $profileCompletion = $this->calculateProfileCompletion($apprenant);

        return view('apprenants.show', compact('apprenant', 'profileCompletion'));
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit($id)
    {
        $apprenant = User::where('id', $id)
            ->where('role_id', 2)
            ->firstOrFail();

        return view('apprenants.edit', compact('apprenant'));
    }

    /**
     * Mettre à jour un apprenant
     */
    public function update(Request $request, $id)
    {
        $apprenant = User::where('id', $id)
            ->where('role_id', 2)
            ->firstOrFail();

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'telephone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'city' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'learning_preference' => 'nullable|in:online,in_person,hybrid',
            'learning_history' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'is_valid' => 'boolean',
        ]);

        // Mise à jour des données
        $apprenant->firstname = $validated['firstname'];
        $apprenant->lastname = $validated['lastname'];
        $apprenant->email = $validated['email'];
        $apprenant->telephone = $validated['telephone'] ?? null;
        $apprenant->city = $validated['city'];
        $apprenant->bio = $validated['bio'] ?? null;
        $apprenant->learning_preference = $validated['learning_preference'] ?? 'online';
        $apprenant->learning_history = $validated['learning_history'] ?? null;
        $apprenant->is_active = $validated['is_active'] ?? true;
        $apprenant->is_valid = $validated['is_valid'] ?? false;

        // Mise à jour du mot de passe si fourni
        if (! empty($validated['password'])) {
            $apprenant->password = Hash::make($validated['password']);
        }

        // Gestion de la photo de profil
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($apprenant->photo_path && Storage::disk('public')->exists($apprenant->photo_path)) {
                Storage::disk('public')->delete($apprenant->photo_path);
            }

            $photoPath = $request->file('photo')->store('profile-photos', 'public');
            $apprenant->photo_path = $photoPath;
        }

        $apprenant->save();

        return redirect()->route('apprenants.index')
            ->with('success', 'Apprenant mis à jour avec succès!');
    }

    /**
     * Supprimer un apprenant
     */
    public function destroy($id)
    {
        $apprenant = User::where('id', $id)
            ->where('role_id', 2)
            ->firstOrFail();

        // Supprimer la photo de profil si elle existe
        if ($apprenant->photo_path && Storage::disk('public')->exists($apprenant->photo_path)) {
            Storage::disk('public')->delete($apprenant->photo_path);
        }

        $apprenant->delete();

        return redirect()->route('apprenants.index')
            ->with('success', 'Apprenant supprimé avec succès!');
    }

    /**
     * Valider un apprenant (avec email)
     */
    public function validateApprenant(Request $request, $id)
    {
        $request->validate([
            'validation_reason' => 'nullable|string|max:500',
        ]);

        $apprenant = User::where('id', $id)
            ->where('role_id', 2)
            ->firstOrFail();

        $apprenant->is_valid = true;
        $apprenant->save();

        // Envoyer un email de validation
        if ($apprenant->email) {
            try {
                Mail::to($apprenant->email)->send(new StudentValidatedMail(
                    $apprenant,
                    $request->validation_reason ?? 'Votre compte a été validé avec succès.'
                ));
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email validation étudiant: ' . $e->getMessage());
            }
        }

        return redirect()->back()
            ->with('success', 'Apprenant validé avec succès!');
    }

    /**
     * Désactiver un compte étudiant (avec email)
     */
    public function deactivateAccount(Request $request, $id)
    {
        $request->validate([
            'deactivation_reason' => 'required|string|max:500',
        ]);

        $apprenant = User::where('id', $id)
            ->where('role_id', 2)
            ->firstOrFail();

        $apprenant->is_active = false;
        $apprenant->save();

        // Envoyer un email de désactivation
        if ($apprenant->email) {
            try {
                Mail::to($apprenant->email)->send(new StudentDeactivatedMail(
                    $apprenant,
                    $request->deactivation_reason
                ));
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email désactivation étudiant: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Compte étudiant désactivé avec succès.'
        ]);
    }

    /**
     * Réactiver un compte étudiant (avec email)
     */
    public function reactivateAccount(Request $request, $id)
    {
        $request->validate([
            'reactivation_reason' => 'nullable|string|max:500',
        ]);

        $apprenant = User::where('id', $id)
            ->where('role_id', 2)
            ->firstOrFail();

        $apprenant->is_active = true;
        $apprenant->save();

        // Envoyer un email de réactivation
        if ($apprenant->email) {
            try {
                Mail::to($apprenant->email)->send(new StudentReactivatedMail(
                    $apprenant,
                    $request->reactivation_reason ?? 'Votre compte a été réactivé.'
                ));
            } catch (\Exception $e) {
                \Log::error('Erreur envoi email réactivation étudiant: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Compte étudiant réactivé avec succès.'
        ]);
    }

    /**
     * Activer/désactiver un apprenant (version simple sans email)
     */
    public function toggleStatus($id)
    {
        $apprenant = User::where('id', $id)
            ->where('role_id', 2)
            ->firstOrFail();

        $apprenant->is_active = ! $apprenant->is_active;
        $apprenant->save();

        $status = $apprenant->is_active ? 'activé' : 'désactivé';

        return redirect()->back()
            ->with('success', "Apprenant $status avec succès!");
    }
}
