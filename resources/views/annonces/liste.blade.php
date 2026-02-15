@extends('layouts.welcomeLayout')

@section('content')
<div class="annonces-liste-page">
    <!-- Hero Section -->
    <section class="hero-section py-5" style="background: linear-gradient(135deg, #0000FF 0%, #6f42c1 100%);">
        <div class="container">
            <div class="text-center text-white py-4">
                <h1 class="display-4 fw-bold mb-3">Toutes les annonces</h1>
                <p class="lead mb-4">Découvrez les {{ $stats['total'] }} missions disponibles et trouvez celle qui vous correspond</p>

                <!-- Barre de recherche rapide -->
                <form action="{{ route('annoncesListe.liste') }}" method="GET" class="search-form mx-auto" style="max-width: 600px;">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control-lg border-0"
                               placeholder="Rechercher par matière ou mot-clé..." value="{{ request('search') }}">
                        <button class="btn btn-light btn-lg" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
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
                        <!-- Domaine -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold" style="color: #0000FF;">
                                <i class="bi bi-book me-1"></i> Domaine
                            </label>
                            <select name="domaine" class="form-select">
                                <option value="">Tous les domaines</option>
                                @foreach($domaines as $domaine)
                                    <option value="{{ $domaine }}" {{ request('domaine') == $domaine ? 'selected' : '' }}>
                                        {{ $domaine }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Budget min -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold" style="color: #0000FF;">
                                <i class="bi bi-coin me-1"></i> Budget min
                            </label>
                            <input type="number" name="budget_min" class="form-control"
                                   placeholder="Min (FCFA)" value="{{ request('budget_min') }}">
                        </div>

                        <!-- Budget max -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold" style="color: #0000FF;">
                                <i class="bi bi-coin me-1"></i> Budget max
                            </label>
                            <input type="number" name="budget_max" class="form-control"
                                   placeholder="Max (FCFA)" value="{{ request('budget_max') }}">
                        </div>

                        <!-- Format -->
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold" style="color: #0000FF;">
                                <i class="bi bi-laptop me-1"></i> Format
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
                            <label class="form-label fw-semibold" style="color: #0000FF;">
                                <i class="bi bi-calendar me-1"></i> Disponible le
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
                            <button type="submit" class="btn btn-primary" style="background: #0000FF; border: none;">
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
                                 style="width: 50px; height: 50px; background: rgba(0,0,255,0.1);">
                                <i class="bi bi-megaphone" style="color: #0000FF; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <span class="stat-value d-block fw-bold" style="color: #0000FF; font-size: 1.5rem;">
                                    {{ $stats['total'] }}
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
                                 style="width: 50px; height: 50px; background: rgba(0,0,255,0.1);">
                                <i class="bi bi-cash-stack" style="color: #0000FF; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <span class="stat-value d-block fw-bold" style="color: #0000FF; font-size: 1.5rem;">
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
                                 style="width: 50px; height: 50px; background: rgba(0,0,255,0.1);">
                                <i class="bi bi-bar-chart" style="color: #0000FF; font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <span class="stat-value d-block fw-bold" style="color: #0000FF; font-size: 1.5rem;">
                                    {{ number_format($stats['budget_max'] ?? 0, 0, ',', ' ') }} F
                                </span>
                                <span class="stat-label text-muted">Budget max</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grille des annonces -->
            @if($annonces->count() > 0)
                <div class="annonces-grid">
                    @foreach($annonces as $annonce)
                        <div class="annonce-card bg-white rounded-4 shadow-sm overflow-hidden" data-aos="fade-up">
                            <div class="card-header p-3" style="background: #0000FF;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-white text-primary px-3 py-2 rounded-pill">
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
                                    {{ $annonce->domaine }}
                                </h3>

                                <p class="text-muted mb-3" style="line-height: 1.6;">
                                    {{ Str::limit($annonce->description, 120) }}
                                </p>

                                <div class="student-info d-flex align-items-center gap-2 mb-3">
                                    <div class="student-avatar rounded-circle overflow-hidden d-flex align-items-center justify-content-center"
                                         style="width: 40px; height: 40px; background: #f0f0f0;">
                                        @if($annonce->student->photo_path)
                                            <img src="{{ asset('storage/' . $annonce->student->photo_path) }}"
                                                 alt="{{ $annonce->student->firstname }}"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-person-circle" style="color: #0000FF; font-size: 1.5rem;"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="d-block fw-semibold" style="color: #333;">
                                            {{ $annonce->student->firstname }} {{ $annonce->student->lastname }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> {{ $annonce->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>

                                <div class="disponibilite mb-3 p-2 rounded" style="background: #f8f9fa;">
                                    <i class="bi bi-calendar-check me-2" style="color: #0000FF;"></i>
                                    <small>{{ Str::limit($annonce->disponibilite, 50) }}</small>
                                </div>

                                <a href="{{ route('annoncesListe.publique.detail', $annonce->id) }}" class="btn w-100 py-2 rounded-pill"
                                   style="background: #0000FF; color: white; border: none;">
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
                    <a href="{{ route('annoncesListe.liste') }}" class="btn btn-primary mt-3" style="background: #0000FF; border: none;">
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
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
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
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 20s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    25% { transform: translate(2%, 2%) rotate(2deg); }
    75% { transform: translate(-2%, -2%) rotate(-2deg); }
}

.search-form .input-group {
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    border-radius: 50px;
    overflow: hidden;
}

.search-form input {
    padding: 15px 25px;
    font-size: 1.1rem;
}

.search-form button {
    padding: 15px 30px;
    background: white;
    color: #0000FF;
    border: none;
}

.search-form button:hover {
    background: #f8f9fa;
    color: #0000CC;
}

.filters-container {
    border: 1px solid rgba(0,0,255,0.1);
}

.filters-container .form-control,
.filters-container .form-select {
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 10px 12px;
}

.filters-container .form-control:focus,
.filters-container .form-select:focus {
    border-color: #0000FF;
    box-shadow: 0 0 0 0.2rem rgba(0,0,255,0.1);
}

.btn-primary {
    background: #0000FF;
    border: none;
    padding: 10px 25px;
    border-radius: 10px;
    font-weight: 500;
}

.btn-primary:hover {
    background: #0000CC;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,255,0.3);
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
    box-shadow: 0 20px 40px rgba(0,0,255,0.1) !important;
    border-color: rgba(0,0,255,0.2);
}

.card-header {
    border-bottom: none;
}

.annonce-card .btn {
    transition: all 0.3s ease;
}

.annonce-card .btn:hover {
    background: #0000CC !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,255,0.3);
}

.stat-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,255,0.1) !important;
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
    background: #0000FF;
    color: white;
    transform: translateY(-2px);
}

.pagination .active .page-link {
    background: #0000FF;
    color: white;
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
}
</style>
@endsection
