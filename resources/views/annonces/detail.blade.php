@extends('layouts.welcomeLayout')

@section('content')
<div class="annonce-detail-page">
    <!-- Navigation -->
    <section class="navigation-section py-3 bg-white border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #0B69F1;">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('annoncesListe.liste') }}" style="color: #0B69F1;">Annonces</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $annonce->subject->nom ?? 'Matière non spécifiée' }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Détail de l'annonce -->
    <section class="detail-section py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Colonne principale -->
                <div class="col-lg-8">
                    <div class="main-card bg-white rounded-4 shadow-sm p-4" data-aos="fade-right">
                        <!-- En-tête -->
                        <div class="mb-4">
                            <span class="category-tag mb-3">
                                @if($annonce->format == 'presentiel')
                                    <i class="fas fa-user-graduate mr-2"></i>Présentiel
                                @elseif($annonce->format == 'en_ligne')
                                    <i class="fas fa-video mr-2"></i>En ligne
                                @else
                                    <i class="fas fa-sync-alt mr-2"></i>Hybride
                                @endif
                            </span>

                            <div class="d-flex justify-content-between align-items-start">
                                <h1 class="display-title mb-0">{{ $annonce->subject->nom ?? 'Matière non spécifiée' }}</h1>
                                <div class="budget-box text-center p-3 rounded-3" style="background: rgba(11, 105, 241, 0.05); min-width: 150px;">
                                    <span class="d-block fw-bold" style="color: #0B69F1; font-size: 2rem;">
                                        {{ number_format($annonce->budget, 0, ',', ' ') }}
                                    </span>
                                    <span class="text-muted">FCFA</span>
                                </div>
                            </div>

                            <!-- Quick info grid -->
                            <div class="quick-info-grid mt-4">
                                <div class="info-item">
                                    <div class="icon-box">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <p class="label">Publiée le</p>
                                        <p class="value">{{ $annonce->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                               
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="custom-divider my-5"></div>

                        <!-- Description complète -->
                        <div class="description-section mb-5">
                            <h5 class="section-subtitle mb-3">
                                <i class="fas fa-info-circle mr-2" style="color: #0B69F1;"></i>Description de la mission
                            </h5>
                            <div class="content-text">
                                {{ $annonce->description }}
                            </div>
                        </div>

                        <!-- Disponibilités détaillées -->
                        @if($annonce->disponibilite)
                            <div class="description-section mb-5">
                                <h5 class="section-subtitle mb-3">
                                    <i class="fas fa-clock mr-2" style="color: #0B69F1;"></i>Disponibilités détaillées
                                </h5>
                                <div class="content-text">
                                    @php
                                        $disponibilites = explode("\n", $annonce->disponibilite);
                                    @endphp
                                    @foreach($disponibilites as $dispo)
                                        @if(!empty(trim($dispo)))
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-check-circle mr-3" style="color: #0B69F1;"></i>
                                                <span>{{ trim($dispo) }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Footer finance -->
                        <div class="finance-footer-card p-4 mt-4">
                            <div class="row align-items-center text-center text-md-left">
                                <div class="col-md-6 border-md-right">
                                    <p class="label-muted text-uppercase small mb-1">Budget total</p>
                                    <p class="h4 font-weight-bold mb-0" style="color: #333;">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</p>
                                </div>
                                <div class="col-md-6 pl-md-4 mt-3 mt-md-0">
                                    <p class="label-muted text-uppercase small mb-1">Format</p>
                                    <p class="h6 font-weight-bold mb-0 text-capitalize" style="color: #333;">
                                        @if($annonce->format == 'presentiel')
                                            Présentiel
                                        @elseif($annonce->format == 'en_ligne')
                                            En ligne
                                        @else
                                            Hybride
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="col-lg-4">
                    <div class="sticky-sidebar">
                        <!-- Carte action bleue -->
                        <div class="action-card-blue bg-white rounded-4 shadow-sm p-4 mb-4" data-aos="fade-left">
                            <div class="text-center">
                                <p class="text-muted mb-1">Rémunération Totale</p>
                                <h2 class="budget-display mb-4" style="color: #0B69F1; font-size: 2.5rem;">
                                    {{ number_format($annonce->budget, 0, ',', ' ') }} <small style="font-size: 1rem;">FCFA</small>
                                </h2>

                                @auth
                                    @if(Auth::user()->role_id == 3)
                                        <button class="btn btn-primary w-100 py-3 mb-3 rounded-pill"
                                                style="background: #0B69F1; border: none;"
                                                onclick="showPostulerMessage()">
                                            <i class="fas fa-paper-plane mr-2"></i>Postuler maintenant
                                        </button>
                                    @else
                                        <button class="btn btn-primary w-100 py-3 mb-3 rounded-pill"
                                                style="background: #0B69F1; border: none;"
                                                onclick="showRoleMessage('postuler')">
                                            <i class="fas fa-paper-plane mr-2"></i>Postuler maintenant
                                        </button>
                                    @endif
                                @else
                                    <button class="btn btn-primary w-100 py-3 mb-3 rounded-pill"
                                            style="background: #0B69F1; border: none;"
                                            onclick="showLoginMessage()">
                                        <i class="fas fa-paper-plane mr-2"></i>Postuler maintenant
                                    </button>
                                @endauth
                                <p class="small text-muted mb-0">
                                    <i class="fas fa-shield-alt mr-1" style="color: #0B69F1;"></i> Paiement sécurisé via Kopiao
                                </p>
                            </div>
                        </div>

                        <!-- Résumé rapide -->
                        <div class="resume-card bg-white rounded-4 shadow-sm p-4 mb-4">
                            <h5 class="sidebar-title mb-4">Résumé</h5>
                            <div class="resume-items">
                                <div class="resume-item d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Budget</span>
                                    <span class="fw-bold">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="resume-item d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Format</span>
                                    <span class="fw-bold">
                                        @if($annonce->format == 'presentiel')
                                            Présentiel
                                        @elseif($annonce->format == 'en_ligne')
                                            En ligne
                                        @else
                                            Hybride
                                        @endif
                                    </span>
                                </div>
                                <div class="resume-item d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Date de publication</span>
                                    <span class="fw-bold">{{ $annonce->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="resume-item d-flex justify-content-between py-2">
                                    <span class="text-muted">Disponibilités</span>
                                    <span class="fw-bold">{{ $annonce->disponibilite ? substr_count($annonce->disponibilite, "\n") + 1 : 0 }} créneaux</span>
                                </div>
                            </div>
                        </div>

                        <!-- Annonces similaires -->
                        @if(isset($annoncesSimilaires) && $annoncesSimilaires->count() > 0)
                            <div class="similaires-card bg-white rounded-4 shadow-sm p-4">
                                <h5 class="sidebar-title mb-4">Annonces similaires</h5>
                                @foreach($annoncesSimilaires as $similaire)
                                    <div class="d-flex align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="avatar-box mr-3">
                                            <div class="avatar-letter" style="background: #eef5ff; color: #0B69F1;">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="{{ route('annoncesListe.publique.detail', $similaire->id) }}" class="text-decoration-none">
                                                <h6 class="mb-0 fw-bold" style="color: #333;">{{ $similaire->subject->nom ?? 'Matière' }}</h6>
                                                <small class="text-muted">{{ number_format($similaire->budget, 0, ',', ' ') }} FCFA</small>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals (inchangés) -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="modal-icon mb-4 mx-auto d-flex align-items-center justify-content-center rounded-circle"
                         style="width: 80px; height: 80px; background: #0B69F1;">
                        <i class="bi bi-person-lock" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Connexion requise</h4>
                    <p class="text-muted mb-4">Pour postuler à cette annonce, vous devez être connecté en tant que tuteur.</p>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('login') }}" class="btn w-100 py-2" style="background: #0B69F1; color: white;">
                            <i class="bi bi-box-arrow-in-right"></i> Se connecter
                        </a>
                        <a href="{{ route('register.tuteur') }}" class="btn w-100 py-2" style="background: #00a36c; color: white;">
                            <i class="bi bi-person-plus"></i> Devenir tuteur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="modal-icon mb-4 mx-auto d-flex align-items-center justify-content-center rounded-circle"
                         style="width: 80px; height: 80px; background: #FFA500;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Action non autorisée</h4>
                    <p class="text-muted mb-4" id="roleMessage">Seuls les tuteurs peuvent postuler aux annonces.</p>
                    <a href="{{ route('home') }}" class="btn w-100 py-2" style="background: #0B69F1; color: white;">
                        <i class="bi bi-house"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Font */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

.annonce-detail-page {
    background: #f8f9fa;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* Breadcrumb */
.breadcrumb-item a {
    text-decoration: none;
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

/* Category Tag */
.category-tag {
    display: inline-block;
    background: #eef5ff;
    color: #0B69F1;
    padding: 6px 18px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
}

/* Display Title */
.display-title {
    font-weight: 800;
    font-size: 2rem;
    letter-spacing: -1px;
    line-height: 1.2;
    color: #333;
}

/* Quick Info Grid */
.quick-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.info-item {
    display: flex;
    align-items: center;
}

.icon-box {
    width: 48px;
    height: 48px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: #0B69F1;
    box-shadow: 0 4px 10px rgba(0,0,0,0.03);
}

.info-item .label {
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 0;
    font-weight: 600;
}

.info-item .value {
    font-weight: 700;
    margin-bottom: 0;
    color: #333;
}

/* Divider */
.custom-divider {
    height: 1px;
    background: linear-gradient(to right, #e2e8f0, transparent);
}

/* Section Subtitle */
.section-subtitle {
    font-weight: 700;
    color: #333;
}

/* Content Text */
.content-text {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #64748b;
}

/* Finance Footer */
.finance-footer-card {
    background: #f8fafc;
    border-radius: 18px;
    border: 1px solid #edf2f7;
}

.label-muted {
    color: #64748b;
    font-weight: 600;
}

/* Border MD */
@media (min-width: 768px) {
    .border-md-right {
        border-right: 1px solid #e2e8f0;
    }
}

/* Budget Box */
.budget-box {
    transition: all 0.3s ease;
}

.budget-box:hover {
    transform: scale(1.02);
    background: rgba(11, 105, 241, 0.1) !important;
}

/* Sidebar Title */
.sidebar-title {
    font-weight: 800;
    color: #64748b;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 1px;
}

/* Avatar Box */
.avatar-box {
    width: 50px;
    height: 50px;
}

.avatar-letter {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.2rem;
}

/* Share Buttons */
.share-btn {
    transition: all 0.3s ease;
    text-decoration: none;
}

.share-btn:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Sticky Sidebar */
.sticky-sidebar {
    position: sticky;
    top: 20px;
}

/* Cards */
.main-card, .action-card-blue, .resume-card, .similaires-card, .share-card {
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.main-card:hover, .action-card-blue:hover, .resume-card:hover, .similaires-card:hover, .share-card:hover {
    box-shadow: 0 15px 35px rgba(11, 105, 241, 0.1) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .display-title {
        font-size: 1.5rem !important;
    }

    .budget-box {
        min-width: 100px !important;
        padding: 0.5rem !important;
    }

    .budget-box span:first-child {
        font-size: 1.2rem !important;
    }
}
</style>

<script>
function showLoginMessage() {
    const modal = new bootstrap.Modal(document.getElementById('loginModal'));
    modal.show();
}

function showRoleMessage(action) {
    const modal = new bootstrap.Modal(document.getElementById('roleModal'));
    const roleMessage = document.getElementById('roleMessage');

    if (action === 'postuler') {
        roleMessage.textContent = 'Seuls les tuteurs peuvent postuler aux annonces.';
    }

    modal.show();
}

function showPostulerMessage() {
    alert('Cette fonctionnalité sera bientôt disponible !');
}
</script>
@endsection
