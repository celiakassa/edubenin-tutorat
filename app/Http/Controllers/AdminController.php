<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\AccountDeactivatedMail;
use App\Mail\AccountReactivatedMail;
use App\Mail\TeacherApprovedMail;
use App\Mail\TeacherRejectedMail;
use App\Models\Annonce;
use App\Models\Payment;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Log;

final class AdminController extends Controller
{
    // Méthode statique pour utilisation dans la vue
    public static function calculateProfileCompletionStatic($user): int|float
    {
        if ($user->role_id !== 3) {
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
                if (! empty($subjects)) {
                    // Vérifier si c'est une collection Eloquent
                    if ($subjects instanceof \Illuminate\Database\Eloquent\Collection) {
                        if ($subjects->count() > 0) {
                            $filled++;
                        }
                    }
                    // Vérifier si c'est une chaîne JSON
                    elseif (is_string($subjects)) {
                        $decoded = json_decode($subjects, true);
                        if (is_array($decoded) && $decoded !== []) {
                            $filled++;
                        } elseif (mb_trim($subjects) !== '') {
                            $filled++;
                        }
                    }
                    // Si c'est un tableau simple
                    elseif (is_array($subjects) && !empty($subjects)) {
                        $filled++;
                    }
                }
            } elseif (! empty($user->$field)) {
                $filled++;
            }
        }

        $total = count($fields);

        return $total > 0 ? round(($filled / $total) * 100) : 0;
    }

    // Page principale du dashboard
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // Statistiques
        $totalUsers = User::count();
        $totalStudents = User::where('role_id', 2)->count();
        $totalTeachers = User::where('role_id', 3)->count();
        $activeAccounts = User::where('is_active', 1)->count();
        $inactiveAccounts = User::where('is_active', 0)->count();

        // Statistiques pour les graphiques
        $verifiedTeachersCount = User::where('role_id', 3)->where('identity_verified', 1)->count();
        $rejectedTeachersCount = User::where('role_id', 3)->where('identity_rejected', true)->count();
        $pendingTeachersCount = User::where('role_id', 3)
            ->where('identity_rejected', false)
            ->where('identity_verified', 0)
            ->where(function ($query): void {
                $query->whereNotNull('identity_document_path')
                    ->where('identity_document_path', '!=', '');
            })
            ->count();

        $inactiveTeachersCount = User::where('role_id', 3)->where('is_active', 0)->count();

        // Professeurs avec pièce d'identité non vérifiée (en attente, hors rejetés)
        $pendingTeachers = User::where('role_id', 3)
            ->where('identity_rejected', false)
            ->where('identity_verified', 0)
            ->where(function ($query): void {
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
            ->where(function ($query): void {
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

        return view('AdminDashboard', ['totalUsers' => $totalUsers, 'totalStudents' => $totalStudents, 'totalTeachers' => $totalTeachers, 'activeAccounts' => $activeAccounts, 'inactiveAccounts' => $inactiveAccounts, 'pendingTeachers' => $pendingTeachers, 'verifiedTeachers' => $verifiedTeachers, 'teachersWithoutDoc' => $teachersWithoutDoc, 'inactiveTeachers' => $inactiveTeachers, 'verifiedTeachersCount' => $verifiedTeachersCount, 'rejectedTeachersCount' => $rejectedTeachersCount, 'pendingTeachersCount' => $pendingTeachersCount, 'inactiveTeachersCount' => $inactiveTeachersCount]);
    }

    // Voir les détails d'un professeur
    public function showTeacher($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $teacher = User::findOrFail($id);

        // Calculer le pourcentage de complétion du profil
        $profileCompletion = $this->calculateProfileCompletion($teacher);

        return view('admin.teacher-details', ['teacher' => $teacher, 'profileCompletion' => $profileCompletion]);
    }

    // Approuver un professeur
    public function approveTeacher(Request $request, $id)
    {
        $request->validate([
            'approval_reason' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $teacher = User::findOrFail($id);

            $teacher->update([
                'is_valid' => 1,
                'identity_verified' => 1,
                'identity_rejected' => false,
                'is_active' => 1,
            ]);

            // Envoyer un email au professeur
            if ($teacher->email) {
                try {
                    Mail::to($teacher->email)->send(new TeacherApprovedMail(
                        $teacher,
                        $request->approval_reason ?? 'Votre profil a été vérifié avec succès.'
                    ));
                } catch (Exception $e) {
                    Log::error('Erreur envoi email approbation: '.$e->getMessage());
                    // Continuer même si l'email échoue
                }
            }

            return back()->with('success', 'Tuteur approuvé avec succès.');
        } catch (Exception $exception) {
            Log::error('Erreur approbation professeur: '.$exception->getMessage());

            return back()->with('error', "Erreur lors de l'approbation du tuteur.");
        }
    }

    // Rejeter un professeur
    public function rejectTeacher(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        try {
            $teacher = User::findOrFail($id);

            $teacher->update([
                'is_valid' => 0,
                'identity_verified' => 0,
                'identity_rejected' => true,
            ]);

            // Envoyer un email au professeur
            if ($teacher->email) {
                try {
                    Mail::to($teacher->email)->send(new TeacherRejectedMail(
                        $teacher,
                        $request->rejection_reason
                    ));
                } catch (Exception $e) {
                    Log::error('Erreur envoi email rejet: '.$e->getMessage());
                    // Continuer même si l'email échoue
                }
            }

            return back()->with('success', 'Tuteur rejeté.');
        } catch (Exception $exception) {
            Log::error('Erreur rejet professeur: '.$exception->getMessage());

            return back()->with('error', 'Erreur lors du rejet du tuteur.');
        }
    }

    // Désactiver un compte
    public function deactivateAccount(Request $request, $id)
    {
        $request->validate([
            'deactivation_reason' => ['required', 'string', 'max:500'],
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
                } catch (Exception $e) {
                    Log::error('Erreur envoi email désactivation: '.$e->getMessage());
                    // Continuer même si l'email échoue
                }
            }

            return back()->with('success', 'Compte désactivé avec succès.');
        } catch (Exception $exception) {
            Log::error('Erreur désactivation compte: '.$exception->getMessage());

            return back()->with('error', 'Erreur lors de la désactivation.');
        }
    }

    // Réactiver un compte
    public function reactivateAccount(Request $request, $id)
    {
        $request->validate([
            'reactivation_reason' => ['nullable', 'string', 'max:500'],
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
                } catch (Exception $e) {
                    Log::error('Erreur envoi email réactivation: '.$e->getMessage());
                    // Continuer même si l'email échoue
                }
            }

            return back()->with('success', 'Compte réactivé avec succès.');
        } catch (Exception $exception) {
            Log::error('Erreur réactivation compte: '.$exception->getMessage());

            return back()->with('error', 'Erreur lors de la réactivation.');
        }
    }

    // Voir la pièce d'identité
    public function viewIdentityDocument($id)
    {
        $teacher = User::findOrFail($id);

        abort_unless($teacher->identity_document_path, 404, 'Pièce d\'identité non trouvée');

        $filePath = storage_path('app/public/'.$teacher->identity_document_path);

        abort_unless(file_exists($filePath), 404, 'Fichier non trouvé');

        return response()->file($filePath);
    }

    // ==================== MODULES SAAS ====================

    /** Liste paginée + recherche + filtres des tuteurs */
    public function teachers(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $q = $request->query('q');
        $filter = $request->query('filter', 'all');

        $query = User::where('role_id', 3);

        if ($filter === 'pending') {
            $query->where('identity_rejected', false)->where('identity_verified', 0)->whereNotNull('identity_document_path')->where('identity_document_path', '!=', '');
        } elseif ($filter === 'rejected') {
            $query->where('identity_rejected', true);
        } elseif ($filter === 'verified') {
            $query->where('identity_verified', 1);
        } elseif ($filter === 'nodoc') {
            $query->where(function ($x): void { $x->whereNull('identity_document_path')->orWhere('identity_document_path', ''); });
        } elseif ($filter === 'inactive') {
            $query->where('is_active', 0);
        }

        if ($q) {
            $query->where(function ($x) use ($q): void {
                $x->where('firstname', 'like', "%{$q}%")->orWhere('lastname', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }

        $teachers = $query->orderByDesc('created_at')->paginate(12)->withQueryString();
        foreach ($teachers as $t) {
            $t->profile_completion = $this->calculateProfileCompletion($t);
        }

        return view('admin.teachers', ['teachers' => $teachers, 'filter' => $filter, 'q' => $q]);
    }

    /** Modération des annonces */
    public function annonces(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $status = $request->query('status');
        $q = $request->query('q');

        $query = Annonce::with(['subject', 'student']);
        if ($status) {
            $query->where('status', $status);
        }
        if ($q) {
            $query->where(function ($x) use ($q): void {
                $x->where('description', 'like', "%{$q}%")
                    ->orWhereHas('subject', function ($s) use ($q): void { $s->where('nom', 'like', "%{$q}%"); })
                    ->orWhereHas('student', function ($st) use ($q): void {
                        $st->where('firstname', 'like', "%{$q}%")->orWhere('lastname', 'like', "%{$q}%");
                    });
            });
        }

        $annonces = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        $stats = [
            'total' => Annonce::count(),
            'publiees' => Annonce::where('status', 'publiée')->count(),
            'attente' => Annonce::where('status', 'en_attente')->count(),
            'budget' => Annonce::where('is_paid', true)->sum('acompte'),
        ];

        return view('admin.annonces', ['annonces' => $annonces, 'stats' => $stats, 'status' => $status, 'q' => $q]);
    }

    public function destroyAnnonce($id)
    {
        Annonce::findOrFail($id)->delete();

        return back()->with('success', 'Annonce supprimée avec succès.');
    }

    /** Finances : revenus, paiements, abonnements */
    public function finances(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $revenuAcomptes = (float) Payment::where('status', 'completed')->whereNotNull('annonce_id')->sum('amount');
        $revenuAbos = (float) Payment::where('status', 'completed')->whereNotNull('subscription_id')->sum('amount');

        $stats = [
            'total' => $revenuAcomptes + $revenuAbos,
            'acomptes' => $revenuAcomptes,
            'abonnements' => $revenuAbos,
            'abosActifs' => Subscription::where('statut', 'active')->where('date_fin', '>', now())->count(),
        ];

        $payments = Payment::with(['user', 'annonce', 'subscription'])->orderByDesc('created_at')->paginate(12);
        $subscriptions = Subscription::with('user')->orderByDesc('created_at')->paginate(12, ['*'], 'subs');

        return view('admin.finances', ['stats' => $stats, 'payments' => $payments, 'subscriptions' => $subscriptions]);
    }

    /** Gestion des matières */
    public function subjects(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $subjects = Subject::withCount(['users', 'annonces'])->orderBy('nom')->get();

        return view('admin.subjects', ['subjects' => $subjects]);
    }

    public function storeSubject(Request $request)
    {
        $data = $request->validate(['nom' => ['required', 'string', 'max:255', 'unique:subjects,nom']]);
        Subject::create(['nom' => $data['nom'], 'is_active' => true]);

        return back()->with('success', 'Matière ajoutée avec succès.');
    }

    public function updateSubject(Request $request, $id)
    {
        $data = $request->validate(['nom' => ['required', 'string', 'max:255', 'unique:subjects,nom,'.$id]]);
        Subject::findOrFail($id)->update(['nom' => $data['nom']]);

        return back()->with('success', 'Matière mise à jour.');
    }

    public function destroySubject($id)
    {
        Subject::findOrFail($id)->delete();

        return back()->with('success', 'Matière supprimée.');
    }

    // Calcul du pourcentage de complétion du profil
    private function calculateProfileCompletion($user): int|float
    {
        if ($user->role_id !== 3) {
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
                if (! empty($subjects)) {
                    // Vérifier si c'est une collection Eloquent
                    if ($subjects instanceof \Illuminate\Database\Eloquent\Collection) {
                        if ($subjects->count() > 0) {
                            $filled++;
                        }
                    }
                    // Vérifier si c'est une chaîne JSON
                    elseif (is_string($subjects)) {
                        $decoded = json_decode($subjects, true);
                        if (is_array($decoded) && $decoded !== []) {
                            $filled++;
                        } elseif (mb_trim($subjects) !== '') {
                            $filled++;
                        }
                    }
                    // Si c'est un tableau simple
                    elseif (is_array($subjects) && !empty($subjects)) {
                        $filled++;
                    }
                }
            } elseif (! empty($user->$field)) {
                $filled++;
            }
        }

        $total = count($fields);

        return $total > 0 ? round(($filled / $total) * 100) : 0;
    }
}
