<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprenantController;
use App\Http\Controllers\CompleterProfilUser;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserDashboard;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    // Récupérer les 6 derniers tuteurs inscrits (role_id = 3) et validés
    $recentTutors = User::where('role_id', 3)
        ->where('is_valid', 1)  // Uniquement les tuteurs validés
        ->where('is_active', 1) // Uniquement les comptes actifs
        ->orderBy('created_at', 'desc')
        ->take(6)
        ->get();

    // Nombre total de tuteurs validés
    $totalTutors = User::where('role_id', 3)
        ->where('is_valid', 1)
        ->where('is_active', 1)
        ->count();

    return view('welcome', compact('recentTutors', 'totalTutors'));
});

Route::view('/tuteurs', 'teachers.tuteurs-list')->name('listProfesseur');

// Route de recherche
Route::get('/recherche-tuteurs', [RechercheController::class, 'rechercher'])
    ->name('recherche.tuteur');

// Route pour les matières populaires
// Route pour les matières populaires
Route::get('/matieres-populaires', function () {
    $matieres = \App\Models\User::where('role_id', 3)
        ->where('is_active', 1)
        ->whereNotNull('subjects')
        ->pluck('subjects')
        ->flatMap(function ($subjects) {
            // NETTOYAGE SPÉCIAL : supprime les crochets []
            if (is_string($subjects)) {
                // Supprime les crochets et guillemets
                $subjects = str_replace(['[', ']', '"', "'"], '', $subjects);

                // Divise par les virgules
                return explode(',', $subjects);
            }

            return [];
        })
        ->map(fn ($subject) => trim($subject))
        ->filter(fn ($subject) => ! empty($subject) && $subject !== '')
        ->unique()
        ->take(40)
        ->values()
        ->all();

    // Si pas assez de matières, ajouter les valeurs par défaut
    if (count($matieres) < 20) {
        $matieresDefaut = [
            'Mathématiques', 'Français', 'Anglais', 'Physique', 'Chimie',
            'SVT', 'Histoire', 'Géographie', 'Philosophie', 'Espagnol',
            'Allemand', 'Informatique', 'Économie', 'Droit', 'Marketing',
            'Comptabilité', 'Musique', 'Arts', 'Sport', 'Médecine',
            'Programmation', 'Web Design', 'Bureautique', 'Statistiques',
            'Biologie', 'Électricité', 'Mécanique', 'Architecture', 'Psychologie',
            'Sociologie', 'Communication', 'Gestion', 'Finance', 'Langues',
        ];

        $matieres = array_unique(array_merge($matieres, $matieresDefaut));
        $matieres = array_slice($matieres, 0, 40);
    }

    return response()->json($matieres);
});

// Route pour les villes populaires
Route::get('/villes-populaires', function () {
    $villes = \App\Models\User::where('role_id', 3)
        ->where('is_active', 1)
        ->whereNotNull('city')
        ->where('city', '!=', '')
        ->pluck('city')
        ->map(function ($city) {
            // NETTOYAGE : supprime les crochets [] si présents
            if (is_string($city)) {
                $city = str_replace(['[', ']', '"', "'"], '', $city);

                return trim($city);
            }

            return '';
        })
        ->filter(fn ($city) => ! empty($city) && $city !== '')
        ->unique()
        ->take(30)
        ->values()
        ->all();

    if (count($villes) < 15) {
        $villesDefaut = [
            'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice',
            'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille',
            'Rennes', 'Reims', 'Le Havre', 'Saint-Étienne', 'Toulon',
            'Grenoble', 'Dijon', 'Angers', 'Nîmes', 'Villeurbanne',
        ];

        $villes = array_unique(array_merge($villes, $villesDefaut));
        $villes = array_slice($villes, 0, 30);
    }

    return response()->json($villes);
});
// Routes pour la listes de tout les professeurs

Route::get('/professeurs', [ProfesseurController::class, 'index'])->name('professeurs.index');

// Route administrateurs

Route::middleware('auth')->group(function () {

    // Routes pour l'admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/teachers/{id}/details', [AdminController::class, 'showTeacher'])->name('teacher.details');
        Route::post('/teachers/{id}/approve', [AdminController::class, 'approveTeacher'])->name('teachers.approve');
        Route::post('/teachers/{id}/reject', [AdminController::class, 'rejectTeacher'])->name('teachers.reject');
        Route::get('/teachers/{id}/identity-document', [AdminController::class, 'viewIdentityDocument'])->name('viewIdentityDocument');
        // Dans le groupe de routes admin
        Route::post('/teachers/{id}/deactivate', [AdminController::class, 'deactivateAccount'])->name('teachers.deactivate');
        Route::post('/teachers/{id}/reactivate', [AdminController::class, 'reactivateAccount'])->name('teachers.reactivate');
    });

    // Le dashboard des utilisteurs
    Route::get('/dashboardUsers', [UserDashboard::class, 'home'])->name('dashboardUser');

    // Les routes pour completer les profils
    Route::get('/profile/edit', [CompleterProfilUser::class, 'edit'])->name('CompleterProfilUser.edit');
    Route::post('/profile/update', [CompleterProfilUser::class, 'update'])->name('CompleterProfilUser.update');
    Route::get('/profil/show', [CompleterProfilUser::class, 'show'])->name('CompleterProfilUser.show');

    // Routes pour la gestion les apprenants
    Route::resource('apprenants', ApprenantController::class);

    // Routes supplémentaires pour les actions spécifiques
    Route::put('/apprenants/{id}/validate', [ApprenantController::class, 'validateApprenant'])
        ->name('apprenants.validate');

    Route::put('/apprenants/{id}/toggle-status', [ApprenantController::class, 'toggleStatus'])
        ->name('apprenants.toggle-status');

    // Route pour afficher la liste des professeurs
    // Route::get('/list_professeur',[TeacherController::class, 'listProfesseur'])->name('listProfesseur');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/register/tuteur', [TeacherController::class, 'register'])->name('register.tuteur')->middleware('guest');

require __DIR__.'/auth.php';
