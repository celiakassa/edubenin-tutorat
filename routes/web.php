<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Livewire\TuteursList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboard;
use App\Http\Controllers\CompleterProfilUser;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\ProfesseurController;
use App\Models\User;

Route::get('/', function () {
    // Récupérer les 6 derniers tuteurs inscrits (role_id = 3 et actifs)
    $recentTutors = User::where('role_id', 3)
        ->orderBy('created_at', 'desc')
        ->take(6)
        ->get();

    return view('welcome', compact('recentTutors'));
});


Route::view('/tuteurs','teachers.tuteurs-list')->name('listProfesseur');

// Route de recherche
Route::get('/recherche-tuteurs', [RechercheController::class, 'rechercher'])
    ->name('recherche.tuteur');

// Route pour les matières populaires
Route::get('/matieres-populaires', function() {
    $matieres = \App\Models\User::where('role_id', 3)
        ->where('is_active', 1)
        ->whereNotNull('subjects')
        ->pluck('subjects')
        ->flatMap(function ($subjects) {
            return explode(',', $subjects);
        })
        ->map(fn($subject) => trim($subject))
        ->filter()
        ->unique()
        ->take(40)
        ->values()
        ->all();

    if (count($matieres) < 20) {
        $matieresDefaut = [
            'Mathématiques', 'Français', 'Anglais', 'Physique', 'Chimie',
            'SVT', 'Histoire', 'Géographie', 'Philosophie', 'Espagnol',
            'Allemand', 'Informatique', 'Économie', 'Droit', 'Marketing',
            'Comptabilité', 'Musique', 'Arts', 'Sport', 'Médecine',
            'Programmation', 'Web Design', 'Bureautique', 'Statistiques',
            'Biologie', 'Électricité', 'Mécanique', 'Architecture', 'Psychologie',
            'Sociologie', 'Communication', 'Gestion', 'Finance', 'Langues'
        ];

        $matieres = array_unique(array_merge($matieres, $matieresDefaut));
        $matieres = array_slice($matieres, 0, 40);
    }

    return response()->json($matieres);
});

// Route pour les villes populaires
Route::get('/villes-populaires', function() {
    $villes = \App\Models\User::where('role_id', 3)
        ->where('is_active', 1)
        ->whereNotNull('city')
        ->where('city', '!=', '')
        ->pluck('city')
        ->map(fn($city) => trim($city))
        ->filter()
        ->unique()
        ->take(30)
        ->values()
        ->all();

    if (count($villes) < 15) {
        $villesDefaut = [
            'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice',
            'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille',
            'Rennes', 'Reims', 'Le Havre', 'Saint-Étienne', 'Toulon',
            'Grenoble', 'Dijon', 'Angers', 'Nîmes', 'Villeurbanne'
        ];

        $villes = array_unique(array_merge($villes, $villesDefaut));
        $villes = array_slice($villes, 0, 30);
    }

    return response()->json($villes);
});

//Routes pour la listes de tout les professeurs

Route::get('/professeurs', [ProfesseurController::class, 'index'])->name('professeurs.index');

Route::middleware('auth')->group(function () {

    //Le dashboard des utilisteurs
    Route::get('/dashboardUsers', [UserDashboard::class, 'home'])->name('dashboardUser');


    //Les routes pour completer les profils
     Route::get('/profile/edit', [CompleterProfilUser::class, 'edit'])->name('CompleterProfilUser.edit');
    Route::post('/profile/update', [CompleterProfilUser::class, 'update'])->name('CompleterProfilUser.update');
    Route::get('/profil/show', [CompleterProfilUser::class, 'show'])->name('CompleterProfilUser.show');

    //Route pour afficher la liste des professeurs
     //Route::get('/list_professeur',[TeacherController::class, 'listProfesseur'])->name('listProfesseur');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
