@extends('layouts.welcomeLayout')

@section('content')
<div class="professeurs-page">

    <!-- Background vidéo -->
    <div class="video-background">
        <video autoplay muted loop playsinline class="background-video">
            <source src="https://assets.mixkit.co/videos/preview/mixkit-stars-in-space-1610-large.mp4" type="video/mp4">
            <!-- Video de backup si MP4 ne charge pas -->
            <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        </video>
        <div class="video-overlay"></div>
    </div>

    <!-- Titre principal avec effet glitch -->
    <div class="container title-container" data-aos="fade-down">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="main-title glitch" data-text="Nos Tuteurs d'Excellence">
                    <span class="gradient-text">Nos Tuteurs</span> d'<span class="highlight-text">Excellence</span>
                </h1>
                <p class="subtitle animate__animated animate__fadeInUp">
                    Découvrez l'élite des éducateurs, sélectionnés pour leur expertise et leur passion
                </p>

                <!-- Stats animées -->
                <div class="stats-container">
                    <div class="stat-item" data-aos="zoom-in" data-aos-delay="100">
                        <div class="stat-number" data-count="{{ $professeurs->total() }}">0</div>
                        <div class="stat-label">Tuteurs Experts</div>
                    </div>
                    <div class="stat-item" data-aos="zoom-in" data-aos-delay="200">
                        <div class="stat-number" data-count="98">0</div>
                        <div class="stat-label">% de Satisfaction</div>
                    </div>
                    <div class="stat-item" data-aos="zoom-in" data-aos-delay="300">
                        <div class="stat-number" data-count="24">0</div>
                        <div class="stat-label">Heures / Jour</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Container principal des professeurs -->
    <div class="container-fluid professors-main-container">
        <div class="row g-0">

            <!-- Sidebar avec filtres -->
            <div class="col-lg-3 d-none d-lg-block sidebar-container">
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="bi bi-funnel-fill me-2"></i>Filtres
                    </h3>

                    <div class="filter-section">
                        <h4 class="filter-title">Matières</h4>
                        <div class="filter-tags">
                            <span class="filter-tag active">Toutes</span>
                            <span class="filter-tag">Mathématiques</span>
                            <span class="filter-tag">Physique</span>
                            <span class="filter-tag">Informatique</span>
                            <span class="filter-tag">Anglais</span>
                            <span class="filter-tag">Français</span>
                        </div>
                    </div>

                    <div class="filter-section">
                        <h4 class="filter-title">Disponibilité</h4>
                        <div class="filter-options">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="onlineCheck" checked>
                                <label class="form-check-label" for="onlineCheck">
                                    <i class="bi bi-wifi text-success me-2"></i>En ligne
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inPersonCheck" checked>
                                <label class="form-check-label" for="inPersonCheck">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>En présentiel
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="filter-section">
                        <h4 class="filter-title">Note minimum</h4>
                        <div class="rating-filter">
                            <div class="stars-filter">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $i == 3 ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" title="{{ $i }} étoiles">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <button class="btn-apply-filters">
                        <i class="bi bi-arrow-clockwise me-2"></i>Appliquer les filtres
                    </button>
                </div>

                <!-- CTA Card -->
                <div class="cta-card mt-4">
                    <h4>Devenez Tuteur</h4>
                    <p>Rejoignez notre équipe d'experts</p>
                    <a href="{{ route('login') }}" class="btn-cta">
                        Postuler maintenant
                    </a>
                </div>
            </div>

            <!-- Section principale des professeurs -->
            <div class="col-lg-9">
                <!-- Grille des professeurs -->
                <div class="professors-grid" id="professorsGrid">
                    @foreach($professeurs as $professeur)
                    <div class="professor-card-container" data-aos="zoom-in-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="professor-card">
                            <!-- Photo de fond avec overlay -->
                            <div class="professor-bg-image">
                                @if($professeur->photo_path)
                                    <img src="{{ asset('storage/' . $professeur->photo_path) }}"
                                         alt="{{ $professeur->firstname }} {{ $professeur->lastname }}"
                                         class="bg-img">
                                @else
                                    <div class="default-bg">
                                        <div class="initials">{{ substr($professeur->firstname, 0, 1) }}{{ substr($professeur->lastname, 0, 1) }}</div>
                                    </div>
                                @endif
                                <div class="bg-overlay"></div>

                                <!-- Badge en ligne -->
                                <div class="online-status {{ $professeur->learning_preference == 'online' ? 'online' : 'offline' }}">
                                    <i class="bi bi-wifi"></i>
                                </div>

                                <!-- Note flottante -->
                                @if($professeur->satisfaction_score)
                                <div class="floating-rating">
                                    <span class="rating-number">{{ $professeur->satisfaction_score }}</span>
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $professeur->satisfaction_score)
                                                <i class="bi bi-star-fill"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Contenu de la carte -->
                            <div class="professor-content">
                                <!-- Nom avec effet néon -->
                                <h3 class="professor-name">
                                    <span class="neon-text">{{ $professeur->firstname }}</span>
                                    <span class="neon-text">{{ $professeur->lastname }}</span>
                                </h3>

                                <!-- Matières avec animation -->
                                <div class="professor-subjects">
                                    @if($professeur->subjects)
                                        @php
                                            $subjects = json_decode($professeur->subjects, true);
                                        @endphp
                                        @if(is_array($subjects))
                                            <div class="subjects-scroll">
                                                @foreach($subjects as $subject)
                                                <span class="subject-chip">{{ $subject }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>

                                <!-- Localisation -->
                                <div class="professor-location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>{{ $professeur->city ?? 'Non spécifié' }}</span>
                                </div>

                                <!-- Tarif -->
                                @if($professeur->rate_per_hour)
                                <div class="professor-rate">
                                    <div class="rate-badge">
                                        <span class="currency">₣</span>
                                        <span class="amount">{{ number_format($professeur->rate_per_hour, 0, ',', ' ') }}</span>
                                        <span class="unit">/h</span>
                                    </div>
                                </div>
                                @endif

                                <!-- Actions -->
                                <div class="professor-actions">
                                    <!-- Téléphone -->
                                    @if($professeur->telephone)
                                    <a href="tel:{{ $professeur->telephone }}" class="action-btn phone-btn"
                                       data-bs-toggle="tooltip" data-bs-title="Appeler">
                                        <i class="bi bi-telephone-fill"></i>
                                    </a>
                                    @endif

                                    <!-- Message -->
                                    <button class="action-btn message-btn contact-professor"
                                            data-prof-id="{{ $professeur->id }}"
                                            data-prof-name="{{ $professeur->firstname }}">
                                        <i class="bi bi-chat-left-text-fill"></i>
                                        <span class="btn-text">Contacter</span>
                                    </button>

                                    <!-- Voir profil -->
                                    <a href="#" class="action-btn profile-btn"
                                       data-bs-toggle="tooltip" data-bs-title="Voir profil">
                                        <i class="bi bi-person-badge-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination avec animation -->
                <div class="pagination-container" data-aos="fade-up">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            {{ $professeurs->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating action button -->
    <button class="fab" id="scrollTopBtn">
        <i class="bi bi-chevron-up"></i>
    </button>

    <!-- Modal de contact -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal content will be loaded via JS -->
            </div>
        </div>
    </div>

</div>

<style>
/* ===== STYLES PRINCIPAUX ===== */
.professeurs-page {
    position: relative;
    min-height: 100vh;
    overflow-x: hidden;
}

/* Background vidéo */
.video-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -2;
}

.background-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg,
        rgba(0, 0, 255, 0.9) 0%,
        rgba(0, 0, 128, 0.85) 50%,
        rgba(0, 0, 64, 0.95) 100%);
    mix-blend-mode: multiply;
}

/* Titre principal */
.title-container {
    padding-top: 80px;
    margin-bottom: 60px;
}

.main-title {
    font-size: 4.5rem;
    font-weight: 900;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
    position: relative;
}

.gradient-text {
    background: linear-gradient(90deg, #00ffff, #0080ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.highlight-text {
    color: #ffcc00;
    text-shadow: 0 0 10px rgba(255, 204, 0, 0.5);
}

.glitch {
    position: relative;
    animation: glitch 3s infinite;
}

@keyframes glitch {
    0% { transform: translate(0); }
    2% { transform: translate(-2px, 2px); }
    4% { transform: translate(-2px, -2px); }
    6% { transform: translate(2px, 2px); }
    8% { transform: translate(2px, -2px); }
    10% { transform: translate(0); }
    100% { transform: translate(0); }
}

.subtitle {
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 40px;
}

/* Stats animées */
.stats-container {
    display: flex;
    justify-content: center;
    gap: 50px;
    margin-top: 40px;
}

.stat-item {
    text-align: center;
    padding: 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    min-width: 150px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.15);
}

.stat-number {
    font-size: 3rem;
    font-weight: 900;
    color: #00ffff;
    text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
}

.stat-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Sidebar */
.sidebar-container {
    padding: 30px 20px;
}

.sidebar-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    padding: 30px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.sidebar-title {
    color: white;
    font-size: 1.5rem;
    margin-bottom: 30px;
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    padding-bottom: 15px;
}

.filter-section {
    margin-bottom: 30px;
}

.filter-title {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.filter-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.filter-tag {
    padding: 8px 16px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-tag:hover,
.filter-tag.active {
    background: linear-gradient(90deg, #00ffff, #0080ff);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
}

.filter-options .form-check {
    margin-bottom: 10px;
}

.filter-options .form-check-label {
    color: rgba(255, 255, 255, 0.9);
    cursor: pointer;
}

/* Stars filter */
.rating-filter {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.stars-filter {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
}

.stars-filter input {
    display: none;
}

.stars-filter label {
    color: #ddd;
    font-size: 1.5rem;
    padding: 5px;
    cursor: pointer;
    transition: color 0.3s;
}

.stars-filter label:hover,
.stars-filter label:hover ~ label,
.stars-filter input:checked ~ label {
    color: #ffcc00;
}

.btn-apply-filters {
    width: 100%;
    padding: 15px;
    background: linear-gradient(90deg, #00ffff, #0080ff);
    border: none;
    border-radius: 15px;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-apply-filters:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 255, 255, 0.3);
}

.cta-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 25px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.cta-card h4 {
    color: white;
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.cta-card p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 20px;
}

.btn-cta {
    display: inline-block;
    padding: 12px 30px;
    background: white;
    color: #667eea;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
}

/* Grille des professeurs */
.professors-main-container {
    padding: 0 30px;
}

.professors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    padding: 20px;
}

.professor-card-container {
    perspective: 1000px;
}

.professor-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(15px);
    border-radius: 25px;
    overflow: hidden;
    position: relative;
    height: 500px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    transform-style: preserve-3d;
}

.professor-card:hover {
    transform: translateY(-20px) rotateX(5deg);
    box-shadow:
        0 30px 60px rgba(0, 0, 0, 0.5),
        0 0 50px rgba(0, 255, 255, 0.3);
    border-color: rgba(0, 255, 255, 0.3);
}

.professor-bg-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.bg-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.professor-card:hover .bg-img {
    transform: scale(1.1);
}

.default-bg {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.initials {
    font-size: 4rem;
    font-weight: 900;
    color: white;
    opacity: 0.5;
}

.bg-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        to bottom,
        transparent 0%,
        rgba(0, 0, 0, 0.1) 30%,
        rgba(0, 0, 0, 0.3) 50%,
        rgba(0, 0, 0, 0.7) 80%,
        rgba(0, 0, 0, 0.9) 100%
    );
}

.online-status {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    z-index: 2;
    transition: all 0.3s ease;
}

.online-status.online {
    background: rgba(16, 185, 129, 0.9);
    color: white;
    animation: pulseOnline 2s infinite;
}

.online-status.offline {
    background: rgba(107, 114, 128, 0.9);
    color: white;
}

@keyframes pulseOnline {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.floating-rating {
    position: absolute;
    top: 20px;
    left: 20px;
    background: rgba(0, 0, 0, 0.8);
    padding: 10px 15px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    z-index: 2;
    backdrop-filter: blur(10px);
}

.rating-number {
    color: #ffcc00;
    font-size: 1.2rem;
    font-weight: 700;
}

.rating-stars {
    color: #ffcc00;
    font-size: 0.9rem;
}

/* Contenu de la carte */
.professor-content {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 30px;
    z-index: 3;
}

.professor-name {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.neon-text {
    font-size: 1.8rem;
    font-weight: 800;
    color: white;
    text-shadow:
        0 0 5px #fff,
        0 0 10px #fff,
        0 0 20px #00ffff,
        0 0 30px #00ffff;
    animation: neonGlow 2s ease-in-out infinite alternate;
}

@keyframes neonGlow {
    from {
        text-shadow:
            0 0 5px #fff,
            0 0 10px #fff,
            0 0 20px #00ffff,
            0 0 30px #00ffff;
    }
    to {
        text-shadow:
            0 0 10px #fff,
            0 0 20px #00ffff,
            0 0 30px #00ffff,
            0 0 40px #00ffff;
    }
}

.professor-subjects {
    margin-bottom: 15px;
    overflow: hidden;
}

.subjects-scroll {
    display: flex;
    gap: 8px;
    animation: scrollSubjects 20s linear infinite;
    padding-left: 100%;
}

@keyframes scrollSubjects {
    0% { transform: translateX(0); }
    100% { transform: translateX(-100%); }
}

.subject-chip {
    background: rgba(0, 255, 255, 0.2);
    border: 1px solid rgba(0, 255, 255, 0.5);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    white-space: nowrap;
    backdrop-filter: blur(5px);
}

.professor-location {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
}

.professor-location i {
    color: #00ffff;
}

.professor-rate {
    margin-bottom: 20px;
}

.rate-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(90deg, rgba(255, 204, 0, 0.2), rgba(255, 204, 0, 0.1));
    border: 1px solid rgba(255, 204, 0, 0.3);
    padding: 8px 20px;
    border-radius: 20px;
    backdrop-filter: blur(10px);
}

.currency {
    color: #ffcc00;
    font-weight: 700;
    font-size: 1.2rem;
}

.amount {
    color: white;
    font-size: 1.5rem;
    font-weight: 800;
    margin: 0 5px;
}

.unit {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.professor-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.phone-btn {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.phone-btn:hover {
    background: #10b981;
    color: white;
    transform: scale(1.1);
}

.message-btn {
    flex: 1;
    border-radius: 25px;
    background: linear-gradient(90deg, #00ffff, #0080ff);
    color: white;
    border: none;
    display: flex;
    gap: 10px;
    padding: 0 25px;
    width: auto;
}

.message-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 255, 255, 0.3);
}

.profile-btn {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.profile-btn:hover {
    background: white;
    color: #0080ff;
    transform: scale(1.1);
}

.btn-text {
    font-size: 0.9rem;
    font-weight: 600;
}

/* Pagination */
.pagination-container {
    padding: 40px 0;
}

.pagination {
    --bs-pagination-color: white;
    --bs-pagination-bg: transparent;
    --bs-pagination-border-color: rgba(255, 255, 255, 0.2);
    --bs-pagination-hover-color: white;
    --bs-pagination-hover-bg: rgba(0, 255, 255, 0.2);
    --bs-pagination-hover-border-color: #00ffff;
    --bs-pagination-focus-color: white;
    --bs-pagination-focus-bg: rgba(0, 255, 255, 0.3);
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(0, 255, 255, 0.25);
    --bs-pagination-active-color: #000;
    --bs-pagination-active-bg: #00ffff;
    --bs-pagination-active-border-color: #00ffff;
}

.page-link {
    border-radius: 10px !important;
    margin: 0 5px;
    border: none !important;
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(10px);
}

/* Floating action button */
.fab {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00ffff, #0080ff);
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(0, 255, 255, 0.3);
}

.fab:hover {
    transform: scale(1.1) rotate(180deg);
    box-shadow: 0 15px 30px rgba(0, 255, 255, 0.5);
}

/* Responsive */
@media (max-width: 992px) {
    .sidebar-container {
        display: none;
    }

    .professors-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        padding: 10px;
    }

    .main-title {
        font-size: 3rem;
    }

    .stats-container {
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .stat-item {
        width: 80%;
    }
}

@media (max-width: 768px) {
    .professors-grid {
        grid-template-columns: 1fr;
        padding: 20px;
    }

    .main-title {
        font-size: 2.5rem;
    }

    .title-container {
        padding-top: 40px;
        margin-bottom: 30px;
    }

    .professor-card {
        height: 450px;
    }
}

@media (max-width: 576px) {
    .neon-text {
        font-size: 1.5rem;
    }

    .professor-content {
        padding: 20px;
    }

    .rate-badge {
        padding: 6px 15px;
    }

    .amount {
        font-size: 1.2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Compter les stats
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const target = parseInt(stat.getAttribute('data-count'));
        const increment = target / 50;
        let current = 0;

        const updateCounter = () => {
            if (current < target) {
                current += increment;
                stat.textContent = Math.floor(current);
                setTimeout(updateCounter, 20);
            } else {
                stat.textContent = target;
            }
        };

        setTimeout(updateCounter, 500);
    });

    // Animation de scroll des matières
    const subjectContainers = document.querySelectorAll('.subjects-scroll');
    subjectContainers.forEach(container => {
        const containerWidth = container.scrollWidth;
        const parentWidth = container.parentElement.offsetWidth;

        if (containerWidth > parentWidth) {
            const duration = (containerWidth / 50) * 1000; // Vitesse basée sur la longueur
            container.style.animationDuration = duration + 'ms';
        }
    });

    // Effet parallaxe sur les cartes
    const cards = document.querySelectorAll('.professor-card');
    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateY = (x - centerX) / 25;
            const rotateX = (centerY - y) / 25;

            card.style.transform = `
                translateY(-20px)
                rotateX(${rotateX}deg)
                rotateY(${rotateY}deg)
            `;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) rotateX(0) rotateY(0)';
            setTimeout(() => {
                card.style.transform = '';
            }, 300);
        });
    });

    // Bouton de retour en haut
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollTopBtn.style.opacity = '1';
            scrollTopBtn.style.transform = 'translateY(0)';
        } else {
            scrollTopBtn.style.opacity = '0';
            scrollTopBtn.style.transform = 'translateY(20px)';
        }
    });

    scrollTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Gestion du contact des professeurs
    const contactButtons = document.querySelectorAll('.contact-professor');
    contactButtons.forEach(button => {
        button.addEventListener('click', function() {
            const profId = this.getAttribute('data-prof-id');
            const profName = this.getAttribute('data-prof-name');

            // Animation du bouton
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
            this.classList.add('sent');

            // Rétablir après 2 secondes
            setTimeout(() => {
                this.innerHTML = originalHTML;
                this.classList.remove('sent');
            }, 2000);

            // Simuler l'ouverture d'un modal (à implémenter)
            console.log(`Contacter ${profName} (ID: ${profId})`);
        });
    });

    // Filtres interactifs
    const filterTags = document.querySelectorAll('.filter-tag');
    filterTags.forEach(tag => {
        tag.addEventListener('click', function() {
            filterTags.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Animation de feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Effet de particules (optionnel)
    createParticles();
});

function createParticles() {
    const container = document.querySelector('.professeurs-page');
    const particleCount = 30;

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.cssText = `
            position: fixed;
            width: ${Math.random() * 3 + 1}px;
            height: ${Math.random() * 3 + 1}px;
            background: rgba(0, 255, 255, ${Math.random() * 0.5 + 0.2});
            border-radius: 50%;
            top: ${Math.random() * 100}vh;
            left: ${Math.random() * 100}vw;
            z-index: -1;
            pointer-events: none;
        `;
        container.appendChild(particle);

        // Animation des particules
        animateParticle(particle);
    }
}

function animateParticle(particle) {
    let x = parseFloat(particle.style.left);
    let y = parseFloat(particle.style.top);
    let speedX = (Math.random() - 0.5) * 0.5;
    let speedY = (Math.random() - 0.5) * 0.5;

    function move() {
        x += speedX;
        y += speedY;

        // Rebond sur les bords
        if (x <= 0 || x >= 100) speedX *= -1;
        if (y <= 0 || y >= 100) speedY *= -1;

        particle.style.left = x + 'vw';
        particle.style.top = y + 'vh';

        requestAnimationFrame(move);
    }

    move();
}
</script>
@endsection
