<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\ApprenantController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\CompleterProfilUser;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListeAnnonceController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Routes d'authentification Google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

// ===== ROUTE POUR LE CHOIX DU RÔLE APRÈS CONNEXION GOOGLE =====
Route::middleware(['auth'])->group(function () {
    Route::get('/choose-role', [GoogleController::class, 'showRoleChoice'])->name('choose.role');
    Route::post('/choose-role', [GoogleController::class, 'storeRoleChoice'])->name('store.role');
});


// ==================== ROUTES PUBLIQUES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/matieres-populaires', [HomeController::class, 'getPopularSubjects'])->name('matieres.populaires');
Route::get('/villes-populaires', [HomeController::class, 'getPopularCities'])->name('villes.populaires');

Route::view('/tuteurs', 'teachers.tuteurs-list')->name('listProfesseur');

// Route pour le callback de paiement d'abonnement tuteur (webhook - sans auth)
Route::post('/paiement/callback', [TeacherController::class, 'HandleSubscription'])->name('paiement.callback');
Route::post('/paiement/init-subscription', [TeacherController::class, 'initSubscriptionPayment'])->name('paiement.init');

// Route de recherche (publique)
Route::get('/recherche-tuteurs', [RechercheController::class, 'rechercher'])->name('recherche.tuteur');

// Routes pour la liste de tous les professeurs (publique)
Route::get('/professeurs', [ProfesseurController::class, 'index'])->name('professeurs.index');

// Routes pour les annonces publiques (sans auth)
Route::get('/annoncesliste', [ListeAnnonceController::class, 'index'])->name('annoncesListe.liste');
Route::get('/annonceliste/{id}', [ListeAnnonceController::class, 'show'])->name('annoncesListe.publique.detail');
Route::get('/api/annoncesliste/filtres', [ListeAnnonceController::class, 'getFiltres'])->name('annoncesListe.filtres');
Route::get('/demandesliste', [ListeAnnonceController::class, 'demandesListe'])->name('demandesliste.liste');

// FAQ (publique)
Route::view('/faq', 'faq.index')->name('faq');

// Route d'enregistrement tuteur (sans auth)
Route::get('/register/tuteur', [TeacherController::class, 'register'])->name('register.tuteur')->middleware('guest');

// ==================== ROUTES PROTÉGÉES PAR AUTH ====================
Route::middleware(['auth'])->group(function () {

    // ===== ROUTES ADMINISTRATEUR =====
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/teachers/{id}/details', [AdminController::class, 'showTeacher'])->name('teacher.details');
        Route::post('/teachers/{id}/approve', [AdminController::class, 'approveTeacher'])->name('teachers.approve');
        Route::post('/teachers/{id}/reject', [AdminController::class, 'rejectTeacher'])->name('teachers.reject');
        Route::get('/teachers/{id}/identity-document', [AdminController::class, 'viewIdentityDocument'])->name('viewIdentityDocument');
        Route::post('/teachers/{id}/deactivate', [AdminController::class, 'deactivateAccount'])->name('teachers.deactivate');
        Route::post('/teachers/{id}/reactivate', [AdminController::class, 'reactivateAccount'])->name('teachers.reactivate');
    });

    // ===== ROUTES TUTEUR (ABONNEMENT) =====
    Route::get('/subscription-user', [TeacherController::class, 'showSubscription'])->name('subscription.user');
    Route::get('/abonnements-historique', [TeacherController::class, 'showSubscriptionHistory'])->name('abonnements.user');
    Route::get('/paiement/success', [TeacherController::class, 'paymentSuccess'])->name('paiement.success');

    // ===== ROUTES DASHBOARD UTILISATEUR =====
    Route::prefix('dashboardUsers')->group(function () {
        Route::get('/', [UserDashboard::class, 'home'])->name('dashboardUser');
        Route::get('/annonces', [TeacherController::class, 'ShowAnnonces'])->name('annonces');
        Route::get('/annonces/{hash}', [TeacherController::class, 'showAnnonceDetail'])->name('annonces.dashboard.detail');

        // Route d'abonnement tuteur avec vérification d'abonnement
        Route::post('/annonces/{id}/postuler', [TeacherController::class, 'postuler'])
            ->name('annonce.postuler')
            ->middleware(['check.subscription']);

        // Routes pour compléter les profils
        Route::get('/profile/edit', [CompleterProfilUser::class, 'edit'])->name('CompleterProfilUser.edit');
        Route::post('/profile/update', [CompleterProfilUser::class, 'update'])->name('CompleterProfilUser.update');
        Route::get('/profil/show', [CompleterProfilUser::class, 'show'])->name('CompleterProfilUser.show');

        // Routes pour la gestion des apprenants
        Route::resource('apprenants', ApprenantController::class);

        // Routes supplémentaires pour les actions spécifiques
        Route::put('/apprenants/{id}/validate', [ApprenantController::class, 'validateApprenant'])->name('apprenants.validate');
        Route::put('/apprenants/{id}/toggle-status', [ApprenantController::class, 'toggleStatus'])->name('apprenants.toggle-status');
    });

    // ===== ROUTES PROFIL =====
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/identity-document/show', [CompleterProfilUser::class, 'showIdentityDocument'])
        ->name('identity.document.show');

    // ===== ROUTES ANNONCES (CRUD COMPLET) =====
    Route::prefix('annonces')->name('annonces.')->group(function () {
        // Routes principales (toutes protégées)
        Route::get('/', [AnnonceController::class, 'index'])->name('index');
        Route::get('/create', [AnnonceController::class, 'create'])->name('create');
        Route::post('/', [AnnonceController::class, 'store'])->name('store');
        Route::get('/{id}', [AnnonceController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AnnonceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AnnonceController::class, 'update'])->name('update');
        Route::delete('/{id}', [AnnonceController::class, 'destroy'])->name('destroy');

        // Routes de paiement FedaPay
        Route::get('/{id}/payment', [AnnonceController::class, 'payment'])->name('payment');
        Route::post('/{id}/init-payment', [AnnonceController::class, 'initPayment'])->name('init-payment');
        Route::get('/{id}/check-payment', [AnnonceController::class, 'checkPaymentStatus'])->name('check-payment');

        // Routes de paiement Moneroo
        Route::post('/{id}/init-payment-moneroo', [AnnonceController::class, 'initPaymentMoneroo'])->name('init-payment.moneroo');
        Route::get('/payment/callback-moneroo', [AnnonceController::class, 'handlePaymentMoneroo'])->name('payment.callback.moneroo');

        // Routes pour les candidatures
        Route::get('/{annonce}/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
        Route::post('/{annonce}/candidatures', [CandidatureController::class, 'store'])->name('candidatures.store');
        Route::post('/candidatures/{candidature}/accepter', [CandidatureController::class, 'accepter'])->name('candidatures.accepter');
        Route::post('/candidatures/{candidature}/refuser', [CandidatureController::class, 'refuser'])->name('candidatures.refuser');
        Route::get('/candidatures/{candidature}/profil', [CandidatureController::class, 'voirProfilTuteur'])->name('candidatures.profil');
        Route::get('/{annonce}/candidatures/stats', [CandidatureController::class, 'stats'])->name('candidatures.stats');
    });
});

// ==================== ROUTES PUBLIC POUR CALLBACKS ET WEBHOOKS (SANS CSRF) ====================
Route::post('/annonces/payment/callback', [AnnonceController::class, 'handlePayment'])
    ->name('annonces.payment.callback')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::post('/annonces/webhook/moneroo', [AnnonceController::class, 'webhookMoneroo'])
    ->name('annonces.webhook.moneroo')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::post('/annonces/webhook/fedapay', [AnnonceController::class, 'webhook'])
    ->name('annonces.webhook.fedapay')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

require __DIR__.'/auth.php';
