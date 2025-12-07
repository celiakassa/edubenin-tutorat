<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\TeacherApprovedMail;
use App\Mail\TeacherRejectedMail;
use App\Mail\AccountDeactivatedMail;
use App\Mail\AccountReactivatedMail;

class AdminController extends Controller
{
    // Page principale du dashboard
    public function index(Request $request)
    {
        // Statistiques
        $totalUsers = User::count();
        $totalStudents = User::where('role_id', 2)->count();
        $totalTeachers = User::where('role_id', 3)->count();
        $activeAccounts = User::where('is_active', 1)->count();
        $inactiveAccounts = User::where('is_active', 0)->count();

        // Statistiques pour les graphiques
        $verifiedTeachersCount = User::where('role_id', 3)->where('identity_verified', 1)->count();
        $rejectedTeachersCount = User::where('role_id', 3)->where('identity_verified', 0)->whereNotNull('identity_document_path')->count();
        $pendingTeachersCount = User::where('role_id', 3)
            ->where(function($query) {
                $query->where('identity_verified', 0)
                      ->orWhereNull('identity_verified');
            })
            ->where(function($query) {
                $query->whereNotNull('identity_document_path')
                      ->where('identity_document_path', '!=', '');
            })
            ->count();

        $inactiveTeachersCount = User::where('role_id', 3)->where('is_active', 0)->count();

        // Professeurs avec pièce d'identité non vérifiée (en attente)
        $pendingTeachers = User::where('role_id', 3)
            ->where(function($query) {
                $query->where('identity_verified', 0)
                      ->orWhereNull('identity_verified');
            })
            ->where(function($query) {
                $query->whereNotNull('identity_document_path')
                      ->where('identity_document_path', '!=', '');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculer le pourcentage de complétion pour chaque professeur
        foreach ($pendingTeachers as $teacher) {
            $teacher->profile_completion = $this->calculateProfileCompletion($teacher);
        }

        // Professeurs vérifiés
        $verifiedTeachers = User::where('role_id', 3)
            ->where('identity_verified', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        // Professeurs sans pièce d'identité
        $teachersWithoutDoc = User::where('role_id', 3)
            ->where(function($query) {
                $query->whereNull('identity_document_path')
                      ->orWhere('identity_document_path', '');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Professeurs désactivés
        $inactiveTeachers = User::where('role_id', 3)
            ->where('is_active', 0)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('AdminDashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalTeachers',
            'activeAccounts',
            'inactiveAccounts',
            'pendingTeachers',
            'verifiedTeachers',
            'teachersWithoutDoc',
            'inactiveTeachers',
            'verifiedTeachersCount',
            'rejectedTeachersCount',
            'pendingTeachersCount',
            'inactiveTeachersCount'
        ));
    }

    // Voir les détails d'un professeur
    public function showTeacher($id)
    {
        $teacher = User::findOrFail($id);

        // Calculer le pourcentage de complétion du profil
        $profileCompletion = $this->calculateProfileCompletion($teacher);

        return view('admin.teacher-details', compact('teacher', 'profileCompletion'));
    }

    // Approuver un professeur
    public function approveTeacher(Request $request, $id)
    {
        $request->validate([
            'approval_reason' => 'nullable|string|max:500',
        ]);

        try {
            $teacher = User::findOrFail($id);

            $teacher->update([
                'is_valid' => 1,
                'identity_verified' => 1,
                'is_active' => 1,
            ]);

            // Envoyer un email au professeur
            if ($teacher->email) {
                try {
                    Mail::to($teacher->email)->send(new TeacherApprovedMail(
                        $teacher,
                        $request->approval_reason ?? 'Votre profil a été vérifié avec succès.'
                    ));
                } catch (\Exception $e) {
                    \Log::error('Erreur envoi email approbation: ' . $e->getMessage());
                    // Continuer même si l'email échoue
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Professeur approuvé avec succès.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur approbation professeur: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'approbation: ' . $e->getMessage()
            ], 500);
        }
    }

    // Rejeter un professeur
    public function rejectTeacher(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $teacher = User::findOrFail($id);

            $teacher->update([
                'is_valid' => 0,
                'identity_verified' => 0,
            ]);

            // Envoyer un email au professeur
            if ($teacher->email) {
                try {
                    Mail::to($teacher->email)->send(new TeacherRejectedMail(
                        $teacher,
                        $request->rejection_reason
                    ));
                } catch (\Exception $e) {
                    \Log::error('Erreur envoi email rejet: ' . $e->getMessage());
                    // Continuer même si l'email échoue
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Professeur rejeté.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur rejet professeur: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du rejet: ' . $e->getMessage()
            ], 500);
        }
    }

    // Désactiver un compte
    public function deactivateAccount(Request $request, $id)
    {
        $request->validate([
            'deactivation_reason' => 'required|string|max:500',
        ]);

        try {
            $teacher = User::findOrFail($id);

            $teacher->update([
                'is_active' => 0,
            ]);

            // Envoyer un email au professeur
            if ($teacher->email) {
                try {
                    Mail::to($teacher->email)->send(new AccountDeactivatedMail(
                        $teacher,
                        $request->deactivation_reason
                    ));
                } catch (\Exception $e) {
                    \Log::error('Erreur envoi email désactivation: ' . $e->getMessage());
                    // Continuer même si l'email échoue
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Compte désactivé avec succès.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur désactivation compte: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la désactivation: ' . $e->getMessage()
            ], 500);
        }
    }

    // Réactiver un compte
    public function reactivateAccount(Request $request, $id)
    {
        $request->validate([
            'reactivation_reason' => 'nullable|string|max:500',
        ]);

        try {
            $teacher = User::findOrFail($id);

            $teacher->update([
                'is_active' => 1,
            ]);

            // Envoyer un email au professeur
            if ($teacher->email) {
                try {
                    Mail::to($teacher->email)->send(new AccountReactivatedMail(
                        $teacher,
                        $request->reactivation_reason ?? 'Votre compte a été réactivé.'
                    ));
                } catch (\Exception $e) {
                    \Log::error('Erreur envoi email réactivation: ' . $e->getMessage());
                    // Continuer même si l'email échoue
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Compte réactivé avec succès.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur réactivation compte: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la réactivation: ' . $e->getMessage()
            ], 500);
        }
    }

    // Voir la pièce d'identité
    public function viewIdentityDocument($id)
    {
        $teacher = User::findOrFail($id);

        if (!$teacher->identity_document_path) {
            abort(404, 'Pièce d\'identité non trouvée');
        }

        $filePath = storage_path('app/public/' . $teacher->identity_document_path);

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        return response()->file($filePath);
    }

    // Calcul du pourcentage de complétion du profil
    private function calculateProfileCompletion($user)
    {
        if ($user->role_id != 3) {
            return 0;
        }

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
            'identity_document_path',
            'city',
            'learning_preference',
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if ($field === 'subjects') {
                $subjects = $user->subjects;
                if (!empty($subjects)) {
                    $decoded = json_decode($subjects, true);
                    if (is_array($decoded) && !empty($decoded)) {
                        $filled++;
                    } elseif (is_string($subjects) && trim($subjects) !== '') {
                        $filled++;
                    }
                }
            } else {
                if (!empty($user->$field)) {
                    $filled++;
                }
            }
        }

        $total = count($fields);
        return $total > 0 ? round(($filled / $total) * 100) : 0;
    }

    // Méthode statique pour utilisation dans la vue
    public static function calculateProfileCompletionStatic($user)
    {
        if ($user->role_id != 3) {
            return 0;
        }

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
            'identity_document_path',
            'city',
            'learning_preference',
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if ($field === 'subjects') {
                $subjects = $user->subjects;
                if (!empty($subjects)) {
                    $decoded = json_decode($subjects, true);
                    if (is_array($decoded) && !empty($decoded)) {
                        $filled++;
                    } elseif (is_string($subjects) && trim($subjects) !== '') {
                        $filled++;
                    }
                }
            } else {
                if (!empty($user->$field)) {
                    $filled++;
                }
            }
        }

        $total = count($fields);
        return $total > 0 ? round(($filled / $total) * 100) : 0;
    }
}
