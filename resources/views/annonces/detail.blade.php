@extends('layouts.welcomeLayout')

@section('content')
<div class="annonce-detail-page">
    <!-- Navigation -->
    <section class="navigation-section py-3 bg-white border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #0000FF;">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('annoncesListe.liste') }}" style="color: #0000FF;">Annonces</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $annonce->domaine }}</li>
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
                    <div class="detail-card bg-white rounded-4 shadow-sm p-4" data-aos="fade-right">
                        <!-- En-tête -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <span class="badge mb-3" style="background: #0000FF; color: white; padding: 8px 15px; border-radius: 30px;">
                                    @if($annonce->format == 'presentiel')
                                        <i class="bi bi-person-workspace"></i> Présentiel
                                    @elseif($annonce->format == 'en_ligne')
                                        <i class="bi bi-laptop"></i> En ligne
                                    @else
                                        <i class="bi bi-arrow-left-right"></i> Hybride
                                    @endif
                                </span>
                                <h1 class="fw-bold mb-2" style="color: #333; font-size: 2rem;">{{ $annonce->domaine }}</h1>
                                <p class="text-muted">
                                    <i class="bi bi-clock"></i> Publiée {{ $annonce->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="budget-box text-center p-3 rounded-3" style="background: rgba(0,0,255,0.05); min-width: 150px;">
                                <span class="d-block fw-bold" style="color: #0000FF; font-size: 2rem;">
                                    {{ number_format($annonce->budget, 0, ',', ' ') }}
                                </span>
                                <span class="text-muted">FCFA</span>
                            </div>
                        </div>

                        <!-- Description complète -->
                        <div class="description-section mb-4">
                            <h4 class="fw-bold mb-3" style="color: #333;">
                                <i class="bi bi-file-text me-2" style="color: #0000FF;"></i> Description
                            </h4>
                            <div class="p-3 rounded-3" style="background: #f8f9fa; line-height: 1.8;">
                                {{ $annonce->description }}
                            </div>
                        </div>

                        <!-- Disponibilités détaillées -->
                        <div class="disponibilite-section mb-4">
                            <h4 class="fw-bold mb-3" style="color: #333;">
                                <i class="bi bi-calendar-week me-2" style="color: #0000FF;"></i> Disponibilités
                            </h4>
                            <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                @php
                                    $disponibilites = explode("\n", $annonce->disponibilite);
                                @endphp
                                @foreach($disponibilites as $dispo)
                                    @if(!empty(trim($dispo)))
                                        <div class="dispo-item d-flex align-items-center gap-2 mb-2">
                                            <i class="bi bi-check-circle-fill" style="color: #0000FF;"></i>
                                            <span>{{ trim($dispo) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Informations sur l'étudiant -->
                        <div class="student-section">
                            <h4 class="fw-bold mb-3" style="color: #333;">
                                <i class="bi bi-person me-2" style="color: #0000FF;"></i> À propos de l'étudiant
                            </h4>
                            <div class="student-card p-3 rounded-3 d-flex align-items-center gap-3" style="background: #f8f9fa;">
                                <div class="student-avatar rounded-circle overflow-hidden d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px; background: white; border: 3px solid #0000FF;">
                                    @if($annonce->student->photo_path)
                                        <img src="{{ asset('storage/' . $annonce->student->photo_path) }}"
                                             alt="{{ $annonce->student->firstname }}"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="bi bi-person-circle" style="color: #0000FF; font-size: 3rem;"></i>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $annonce->student->firstname }} {{ $annonce->student->lastname }}</h5>
                                    @if($annonce->student->bio)
                                        <p class="text-muted mb-2">{{ Str::limit($annonce->student->bio, 100) }}</p>
                                    @endif
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-geo-alt"></i> {{ $annonce->student->city ?? 'Non précisé' }}
                                        </span>
                                        @if($annonce->student->learning_preference)
                                            <span class="badge bg-light text-dark">
                                                <i class="bi bi-laptop"></i>
                                                @if($annonce->student->learning_preference == 'online')
                                                    En ligne
                                                @elseif($annonce->student->learning_preference == 'in_person')
                                                    Présentiel
                                                @else
                                                    Hybride
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="col-lg-4">
                    <div class="sidebar-card bg-white rounded-4 shadow-sm p-4" data-aos="fade-left">
                        <!-- Actions -->
                        <div class="actions-section mb-4">
                            <h5 class="fw-bold mb-3">Actions</h5>

                            @auth
                                @if(Auth::user()->role_id == 3)
                                    <a href="{{ route('login') }}" class="btn btn-primary w-100 py-3 mb-2 rounded-pill"
                                       style="background: #0000FF; border: none;"
                                       onclick="event.preventDefault(); showPostulerMessage();">
                                        <i class="bi bi-send me-2"></i> Postuler à cette annonce
                                    </a>
                                @else
                                    <button class="btn btn-primary w-100 py-3 mb-2 rounded-pill"
                                            style="background: #0000FF; border: none;"
                                            onclick="showRoleMessage('postuler')">
                                        <i class="bi bi-send me-2"></i> Postuler à cette annonce
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-primary w-100 py-3 mb-2 rounded-pill"
                                        style="background: #0000FF; border: none;"
                                        onclick="showLoginMessage()">
                                    <i class="bi bi-send me-2"></i> Postuler à cette annonce
                                </button>
                            @endauth

                       
                        </div>

                        <!-- Résumé rapide -->
                        <div class="resume-section mb-4">
                            <h5 class="fw-bold mb-3">Résumé</h5>
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
                                    <span class="fw-bold">{{ substr_count($annonce->disponibilite, "\n") + 1 }} créneaux</span>
                                </div>
                            </div>
                        </div>

                        <!-- Partager -->
                        <div class="share-section">
                            <h5 class="fw-bold mb-3">Partager</h5>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                   target="_blank" class="share-btn d-flex align-items-center justify-content-center rounded-circle"
                                   style="width: 45px; height: 45px; background: #1877f2; color: white;">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($annonce->domaine) }}"
                                   target="_blank" class="share-btn d-flex align-items-center justify-content-center rounded-circle"
                                   style="width: 45px; height: 45px; background: #1da1f2; color: white;">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($annonce->domaine . ' ' . request()->url()) }}"
                                   target="_blank" class="share-btn d-flex align-items-center justify-content-center rounded-circle"
                                   style="width: 45px; height: 45px; background: #25d366; color: white;">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <a href="mailto:?subject={{ urlencode($annonce->domaine) }}&body={{ urlencode('Découvrez cette annonce: ' . request()->url()) }}"
                                   class="share-btn d-flex align-items-center justify-content-center rounded-circle"
                                   style="width: 45px; height: 45px; background: #333; color: white;">
                                    <i class="bi bi-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Annonces similaires -->
                    @if($annoncesSimilaires->count() > 0)
                        <div class="similaires-card bg-white rounded-4 shadow-sm p-4 mt-4">
                            <h5 class="fw-bold mb-3">Annonces similaires</h5>
                            @foreach($annoncesSimilaires as $similaire)
                                <div class="similaire-item d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="similaire-icon d-flex align-items-center justify-content-center rounded-circle"
                                         style="width: 50px; height: 50px; background: rgba(0,0,255,0.1);">
                                        <i class="bi bi-briefcase" style="color: #0000FF;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="{{ route('annoncesListe.publique.detail', $similaire->id) }}" class="text-decoration-none">
                                            <h6 class="fw-bold mb-1" style="color: #333;">{{ $similaire->domaine }}</h6>
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
    </section>

    <!-- Modals -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="modal-icon mb-4 mx-auto d-flex align-items-center justify-content-center rounded-circle"
                         style="width: 80px; height: 80px; background: #0000FF;">
                        <i class="bi bi-person-lock" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Connexion requise</h4>
                    <p class="text-muted mb-4">Pour postuler à cette annonce, vous devez être connecté en tant que tuteur.</p>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('login') }}" class="btn w-100 py-2" style="background: #0000FF; color: white;">
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
                    <a href="{{ route('home') }}" class="btn w-100 py-2" style="background: #0000FF; color: white;">
                        <i class="bi bi-house"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.annonce-detail-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.breadcrumb-item a {
    text-decoration: none;
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.detail-card, .sidebar-card, .similaires-card {
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.detail-card:hover, .sidebar-card:hover, .similaires-card:hover {
    box-shadow: 0 15px 35px rgba(0,0,255,0.1) !important;
}

.budget-box {
    transition: all 0.3s ease;
}

.budget-box:hover {
    transform: scale(1.02);
    background: rgba(0,0,255,0.1) !important;
}

.dispo-item {
    transition: all 0.3s ease;
}

.dispo-item:hover {
    transform: translateX(5px);
}

.student-card {
    transition: all 0.3s ease;
}

.student-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,255,0.1);
}

.student-avatar {
    transition: all 0.3s ease;
}

.student-card:hover .student-avatar {
    transform: scale(1.05);
    border-color: #00a36c !important;
}

.btn-outline-primary {
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #0000FF;
    color: white;
}

.share-btn {
    transition: all 0.3s ease;
    text-decoration: none;
}

.share-btn:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.similaire-item {
    transition: all 0.3s ease;
}

.similaire-item:hover {
    transform: translateX(5px);
}

.similaire-item:hover .similaire-icon {
    transform: rotate(10deg) scale(1.1);
}

.similaire-icon {
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .detail-card h1 {
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
