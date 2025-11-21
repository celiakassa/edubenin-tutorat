<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Livewire\TuteursList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboard;
use App\Http\Controllers\CompleterProfilUser;
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
