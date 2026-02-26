<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\ApprenantController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\CompleterProfilUser;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListeAnnonceController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserDashboard;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/matieres-populaires', [HomeController::class, 'getPopularSubjects'])->name('matieres.populaires');
Route::get('/villes-populaires', [HomeController::class, 'getPopularCities'])->name('villes.populaires');

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

    return view('welcome', ['recentTutors' => $recentTutors, 'totalTutors' => $totalTutors]);
});

Route::view('/tuteurs', 'teachers.tuteurs-list')->name('listProfesseur');

// Route pour le callback de paiement d'abonnement tuteur
Route::post('/paiement/callback', [TeacherController::class, 'HandleSubscription'])->name('paiement.callback');
Route::post('/paiement/init-subscription', [TeacherController::class, 'initSubscriptionPayment'])->name('paiement.init');
Route::post('/paiement/callback', [TeacherController::class, 'handleSubscription'])->name('paiement.callback');
Route::get('/paiement/success', [TeacherController::class,'paymentSuccess'])->name('paiement.success');


// Route de recherche
Route::get('/recherche-tuteurs', [RechercheController::class, 'rechercher'])->name('recherche.tuteur');

// Routes pour la listes de tout les professeurs
Route::get('/professeurs', [ProfesseurController::class, 'index'])->name('professeurs.index');


// Routes pour les annonces publiques
Route::get('/annoncesliste', [ListeAnnonceController::class, 'index'])->name('annoncesListe.liste');
Route::get('/annonceliste/{id}', [ListeAnnonceController::class, 'show'])->name('annoncesListe.publique.detail');
Route::get('/api/annoncesliste/filtres', [ListeAnnonceController::class, 'getFiltres'])->name('annoncesListe.filtres');

// À ajouter avec les autres routes publiques
Route::get('/demandesliste', [ListeAnnonceController::class, 'demandesListe'])->name('demandesliste.liste');


// Route pour la FAQ
Route::view('/faq', 'faq.index')->name('faq');


// Route administrateurs
Route::middleware('auth')->group(function () {

    // Routes pour l'admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/teachers/{id}/details', [AdminController::class, 'showTeacher'])->name('teacher.details');
        Route::post('/teachers/{id}/approve', [AdminController::class, 'approveTeacher'])->name('teachers.approve');
        Route::post('/teachers/{id}/reject', [AdminController::class, 'rejectTeacher'])->name('teachers.reject');
        Route::get('/teachers/{id}/identity-document', [AdminController::class, 'viewIdentityDocument'])->name('viewIdentityDocument');
        Route::post('/teachers/{id}/deactivate', [AdminController::class, 'deactivateAccount'])->name('teachers.deactivate');
        Route::post('/teachers/{id}/reactivate', [AdminController::class, 'reactivateAccount'])->name('teachers.reactivate');
    });

    // Route d'abonnement tuteur
    Route::get('/subscription-user', [TeacherController::class, 'showSubscription'])->name('subscription.user');
    Route::get('/abonnements-historique', [TeacherController::class, 'showSubscriptionHistory'])->name('abonnements.user');
});

// Groupe pour le dashboard des utilisateurs
Route::prefix('dashboardUsers')->group(function () {
    Route::get('/', [UserDashboard::class, 'home'])->name('dashboardUser');
    Route::get('/annonces', [TeacherController::class, 'ShowAnnonces'])->name('annonces');
    Route::get('/annonces/{hash}', [TeacherController::class, 'showAnnonceDetail'])->name('annonces.dashboard.detail');

    // Route d'abonnement tuteur hors dashboardUse
    Route::post('/annonces/{id}/postuler', [TeacherController::class, 'postuler'])
        ->name('annonce.postuler')
        ->middleware(['auth', 'check.subscription']);

    // Les routes pour completer les profils
    Route::get('/profile/edit', [CompleterProfilUser::class, 'edit'])->name('CompleterProfilUser.edit');
    Route::post('/profile/update', [CompleterProfilUser::class, 'update'])->name('CompleterProfilUser.update');
    Route::get('/profil/show', [CompleterProfilUser::class, 'show'])->name('CompleterProfilUser.show');

    // Routes pour la gestion les apprenants
    Route::resource('apprenants', ApprenantController::class);

    // Routes supplémentaires pour les actions spécifiques
    Route::put('/apprenants/{id}/validate', [ApprenantController::class, 'validateApprenant'])->name('apprenants.validate');
    Route::put('/apprenants/{id}/toggle-status', [ApprenantController::class, 'toggleStatus'])->name('apprenants.toggle-status');
});

// Route pour cree les annonces
Route::prefix('annonces')->group(function () {
    // Routes principales
    Route::get('/', [AnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/create', [AnnonceController::class, 'create'])->name('annonces.create');
    Route::post('/', [AnnonceController::class, 'store'])->name('annonces.store');
    Route::get('/{id}', [AnnonceController::class, 'show'])->name('annonces.show');
    Route::get('/{id}/edit', [AnnonceController::class, 'edit'])->name('annonces.edit');
    Route::put('/{id}', [AnnonceController::class, 'update'])->name('annonces.update');
    Route::delete('/{id}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');

    // Routes de paiement (FedaPay - existantes)
    Route::get('/{id}/payment', [AnnonceController::class, 'payment'])->name('annonces.payment');
    Route::post('/{id}/init-payment', [AnnonceController::class, 'initPayment'])->name('annonces.init-payment');
    Route::get('/{id}/check-payment', [AnnonceController::class, 'checkPaymentStatus'])->name('annonces.check-payment');

    // Route POST pour le callback de paiement FedaPay (existante)
    Route::post('/payment/callback', [AnnonceController::class, 'handlePayment'])->name('annonces.payment.callback');

    // Routes de paiement (Moneroo - NOUVELLES)
    Route::post('/{id}/init-payment-moneroo', [AnnonceController::class, 'initPaymentMoneroo'])->name('annonces.init-payment.moneroo');
    Route::get('/payment/callback-moneroo', [AnnonceController::class, 'handlePaymentMoneroo'])->name('annonces.payment.callback.moneroo');
    Route::post('/webhook/moneroo', [AnnonceController::class, 'webhookMoneroo'])
        ->name('annonces.webhook.moneroo')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    // Pour les étudiants (gérer les candidatures)
    Route::get('/{annonce}/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');

    // Pour les tuteurs (postuler)
    Route::post('/{annonce}/candidatures', [CandidatureController::class, 'store'])->name('candidatures.store');

    // Accepter une candidature
    Route::post('/candidatures/{candidature}/accepter', [CandidatureController::class, 'accepter'])->name('candidatures.accepter');

    // Refuser une candidature
    Route::post('/candidatures/{candidature}/refuser', [CandidatureController::class, 'refuser'])->name('candidatures.refuser');

    // Voir le profil d'un tuteur
    Route::get('/candidatures/{candidature}/profil', [CandidatureController::class, 'voirProfilTuteur'])->name('candidatures.profil');

    // API pour les statistiques (graphiques)
    Route::get('/{annonce}/candidatures/stats', [CandidatureController::class, 'stats'])->name('candidatures.stats');

    // Webhook FedaPay (existant)
    Route::post('/webhook/fedapay', [AnnonceController::class, 'webhook'])->name('annonces.webhook.fedapay');
});

// Routes de profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/register/tuteur', [TeacherController::class, 'register'])->name('register.tuteur')->middleware('guest');

require __DIR__.'/auth.php';
