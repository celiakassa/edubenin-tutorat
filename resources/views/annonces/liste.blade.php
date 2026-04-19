@extends('layouts.welcomeLayout')

@section('content')
<div class="annonces-liste-page">
    <!-- Hero Section avec image de fond -->
    <section class="hero-section py-5 position-relative" style="background: linear-gradient(135deg, rgba(35, 36, 36, 0.493) 0%, rgba(36, 36, 36, 0.568) 100%), url('{{ asset('images/1.webp') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="text-center text-white py-4">
                <h1 class="display-4 fw-bold mb-3">Toutes les annonces</h1>
                <p class="lead mb-4">Découvrez les {{ $stats['total'] }} missions disponibles et trouvez celle qui vous correspond</p>

                <!-- Barre de recherche rapide corrigée -->
                <form action="{{ route('annoncesListe.liste') }}" method="GET" class="search-form mx-auto" style="max-width: 600px;">
                    @csrf
                    <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                        <input type="text" name="search" class="form-control form-control-lg border-0 py-3"
                               placeholder="Rechercher par matière ou mot-clé..." value="{{ request('search') }}" style="outline: none; box-shadow: none;">
                        <button class="btn btn-light btn-lg px-4" type="submit" style="background: white; border-left: 1px solid #e0e0e0;">
                            <i class="bi bi-search" style="color: #0B69F1;"></i>
                        </button>
                    </div>
                    <!-- Affichage du terme de recherche actif -->
                    @if(request('search'))
                        <div class="mt-2">
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-search me-1"></i> Recherche : "{{ request('search') }}"
                                <a href="{{ route('annoncesListe.liste') }}" class="text-decoration-none ms-2">&times;</a>
                            </span>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </section>

    <!-- Section Filtres et Annonces -->
    <section class="filters-section py-5">
        <div class="container">
            <!-- Filtres -->
            <div class="filters-container bg-white rounded-4 shadow-sm p-4 mb-5" data-aos="fade-up">
                <form action="{{ route('annoncesListe.liste') }}" method="GET" class="filters-form">
                    <div class="row g-3">
                        <!-- Domaine (Matière) -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold" style="color: #0B69F1;">
                                <i class="bi bi-book me-1" style="color: #0B69F1;"></i> Matière
                            </label>
                            <select name="domaine" class="form-select">
                                <option value="">Toutes les matières</option>
                                @if(!empty($matieres))
                                    @foreach($matieres as $matiere)
                                        <option value="{{ $matiere }}" {{ request('domaine') == $matiere ? 'selected' : '' }}>
                                            {{ $matiere }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Budget min -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold" style="color: #0B69F1;">
                                <i class="bi bi-coin me-1" style="color: #0B69F1;"></i> Budget min
                            </label>
                            <input type="number" name="budget_min" class="form-control"
                                   placeholder="Min (FCFA)" value="{{ request('budget_min') }}" min="0">
                        </div>

                        <!-- Budget max -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold" style="color: #0B69F1;">
                                <i class="bi bi-coin me-1" style="color: #0B69F1;"></i> Budget max
                            </label>
                            <input type="number" name="budget_max" class="form-control"
                                   placeholder="Max (FCFA)" value="{{ request('budget_max') }}" min="0">
                        </div>

                        <!-- Format -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold" style="color: #0B69F1;">
                                <i class="bi bi-laptop me-1" style="color: #0B69F1;"></i> Format
                            </label>
                            <select name="format" class="form-select">
                                <option value="">Tous</option>
                                <option value="presentiel" {{ request('format') == 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                                <option value="en_ligne" {{ request('format') == 'en_ligne' ? 'selected' : '' }}>En ligne</option>
                                <option value="hybrid" {{ request('format') == 'hybrid' ? 'selected' : '' }}>Hybride</option>
                            </select>
                        </div>

                        <!-- Jour de disponibilité -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold" style="color: #0B69F1;">
                                <i class="bi bi-calendar me-1" style="color: #0B69F1;"></i> Disponible le
                            </label>
                            <select name="jour" class="form-select">
                                <option value="">Tous les jours</option>
                                <option value="Lundi" {{ request('jour') == 'Lundi' ? 'selected' : '' }}>Lundi</option>
                                <option value="Mardi" {{ request('jour') == 'Mardi' ? 'selected' : '' }}>Mardi</option>
                                <option value="Mercredi" {{ request('jour') == 'Mercredi' ? 'selected' : '' }}>Mercredi</option>
                                <option value="Jeudi" {{ request('jour') == 'Jeudi' ? 'selected' : '' }}>Jeudi</option>
                                <option value="Vendredi" {{ request('jour') == 'Vendredi' ? 'selected' : '' }}>Vendredi</option>
                                <option value="Samedi" {{ request('jour') == 'Samedi' ? 'selected' : '' }}>Samedi</option>
                                <option value="Dimanche" {{ request('jour') == 'Dimanche' ? 'selected' : '' }}>Dimanche</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 d-flex gap-2 justify-content-end">
                            <a href="{{ route('annoncesListe.liste') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Effacer les filtres
                            </a>
                            <button type="submit" class="btn btn-primary" style="background: #0B69F1; border: none;">
                                <i class="bi bi-funnel"></i> Appliquer les filtres
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistiques rapides -->
            <div class="stats-rapid row g-3 mb-5">
                <div class="col-md-4">
                    <div class="stat-card bg-white p-3 rounded-3 shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 50px; height: 50px; background: rgba(11, 105, 241, 0.1);">
                                <i class="bi bi-megaphone" style="color: #0B69F1; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <span class="stat-value d-block fw-bold" style="color: #0B69F1; font-size: 1.5rem;">
                                    {{ $stats['total'] ?? 0 }}
                                </span>
                                <span class="stat-label text-muted">Annonces actives</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-white p-3 rounded-3 shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 50px; height: 50px; background: rgba(11, 105, 241, 0.1);">
                                <i class="bi bi-cash-stack" style="color: #0B69F1; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <span class="stat-value d-block fw-bold" style="color: #0B69F1; font-size: 1.5rem;">
                                    {{ number_format($stats['budget_moyen'] ?? 0, 0, ',', ' ') }} F
                                </span>
                                <span class="stat-label text-muted">Budget moyen</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card bg-white p-3 rounded-3 shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 50px; height: 50px; background: rgba(11, 105, 241, 0.1);">
                                <i class="bi bi-bar-chart" style="color: #0B69F1; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <span class="stat-value d-block fw-bold" style="color: #0B69F1; font-size: 1.5rem;">
                                    {{ number_format($stats['budget_max'] ?? 0, 0, ',', ' ') }} F
                                </span>
                                <span class="stat-label text-muted">Budget max</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grille des annonces -->
            @if(isset($annonces) && $annonces->count() > 0)
                <div class="annonces-grid">
                    @foreach($annonces as $annonce)
                        <div class="annonce-card bg-white rounded-4 shadow-sm overflow-hidden" data-aos="fade-up">
                            <div class="card-header p-3" style="background: #0B69F1;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-white text-primary px-3 py-2 rounded-pill" style="color: #0B69F1 !important;">
                                        @if($annonce->format == 'presentiel')
                                            <i class="bi bi-person-workspace"></i> Présentiel
                                        @elseif($annonce->format == 'en_ligne')
                                            <i class="bi bi-laptop"></i> En ligne
                                        @else
                                            <i class="bi bi-arrow-left-right"></i> Hybride
                                        @endif
                                    </span>
                                    <span class="text-white fw-bold">
                                        {{ number_format($annonce->budget, 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <h3 class="fw-bold mb-3" style="color: #333; font-size: 1.3rem;">
                                    {{ $annonce->subject->nom ?? 'Matière non spécifiée' }}
                                </h3>

                                <p class="text-muted mb-3" style="line-height: 1.6;">
                                    {{ Str::limit($annonce->description, 120) }}
                                </p>

                                <div class="student-info d-flex align-items-center gap-2 mb-3">
                                    <div class="student-avatar rounded-circle overflow-hidden d-flex align-items-center justify-content-center"
                                         style="width: 40px; height: 40px; background: #f0f0f0;">
                                        @if($annonce->student && $annonce->student->photo_path)
                                            <img src="{{ asset('storage/' . $annonce->student->photo_path) }}"
                                                 alt="{{ $annonce->student->firstname }}"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-person-circle" style="color: #0B69F1; font-size: 1.5rem;"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> {{ $annonce->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>

                                <div class="disponibilite mb-3 p-2 rounded" style="background: #f8f9fa;">
                                    <i class="bi bi-calendar-check me-2" style="color: #0B69F1;"></i>
                                    <small>{{ Str::limit($annonce->disponibilite ?? 'Non spécifié', 50) }}</small>
                                </div>

                                <a href="{{ route('annoncesListe.publique.detail', $annonce->id) }}" class="btn w-100 py-2 rounded-pill"
                                   style="background: #0B69F1; color: white; border: none;">
                                    <i class="bi bi-eye me-2"></i> Voir les détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $annonces->links() }}
                </div>
            @else
                <div class="no-results text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                    <h3 class="mt-3" style="color: #333;">Aucune annonce trouvée</h3>
                    <p class="text-muted">Essayez de modifier vos filtres ou revenez plus tard.</p>
                    <a href="{{ route('annoncesListe.liste') }}" class="btn btn-primary mt-3" style="background: #0B69F1; border: none;">
                        <i class="bi bi-arrow-repeat"></i> Réinitialiser les filtres
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>

<style>
.annonces-liste-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 15s ease-in-out infinite;
}

.hero-section::after {
    content: '';
    position: absolute;
    bottom: -50%;
    left: -20%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 20s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    25% { transform: translate(2%, 2%) rotate(2deg); }
    75% { transform: translate(-2%, -2%) rotate(-2deg); }
}

.search-form .input-group {
    border-radius: 50px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.search-form .input-group:focus-within {
    box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
}

.search-form input {
    padding: 15px 25px;
    font-size: 1.1rem;
    border: none;
}

.search-form input:focus {
    outline: none;
    box-shadow: none;
}

.search-form button {
    background: white;
    border: none;
    transition: all 0.3s ease;
}

.search-form button:hover {
    background: #f8f9fa;
}

.search-form button:hover i {
    transform: scale(1.1);
}

.search-form button i {
    transition: transform 0.3s ease;
}

.filters-container {
    border: 1px solid rgba(11, 105, 241, 0.1);
}

.filters-container .form-control,
.filters-container .form-select {
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 10px 12px;
    transition: all 0.3s ease;
}

.filters-container .form-control:focus,
.filters-container .form-select:focus {
    border-color: #0B69F1;
    box-shadow: 0 0 0 0.2rem rgba(11, 105, 241, 0.1);
    outline: none;
}

.btn-primary {
    background: #0B69F1 !important;
    border: none !important;
    padding: 10px 25px;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #0855c4 !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(11, 105, 241, 0.3);
}

.btn-outline-secondary {
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
}

.annonces-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.annonce-card {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.annonce-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(11, 105, 241, 0.1) !important;
    border-color: rgba(11, 105, 241, 0.2);
}

.card-header {
    border-bottom: none;
}

.annonce-card .btn {
    transition: all 0.3s ease;
}

.annonce-card .btn:hover {
    background: #0855c4 !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(11, 105, 241, 0.3);
}

.stat-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
    cursor: default;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(11, 105, 241, 0.1) !important;
}

/* Pagination */
.pagination {
    gap: 5px;
}

.pagination .page-link {
    border: none;
    border-radius: 10px;
    color: #333;
    padding: 10px 15px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: #0B69F1;
    color: white;
    transform: translateY(-2px);
}

.pagination .active .page-link {
    background: #0B69F1;
    color: white;
}

.badge.bg-white.text-primary {
    color: #0B69F1 !important;
}

/* Responsive */
@media (max-width: 992px) {
    .annonces-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .annonces-grid {
        grid-template-columns: 1fr;
        max-width: 500px;
        margin: 0 auto;
    }

    .hero-section h1 {
        font-size: 2rem;
    }

    .search-form {
        padding: 0 15px;
    }
}
</style>
@endsection
