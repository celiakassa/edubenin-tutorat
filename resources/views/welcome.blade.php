@extends('layouts.welcomeLayout')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">
                <!-- Texte principal -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                    <h1 class="hero-title">EduConnect</h1>

                    <p class="hero-subtitle">Apprendre. Enseigner. Réussir partout dans le monde.</p>
                    <p class="hero-description">
                        EduConnect est une plateforme internationale qui met en relation les apprenants et des tuteurs
                        qualifiés
                        pour des cours particuliers en ligne ou en présentiel. Accédez à une éducation de qualité, adaptée à
                        vos besoins,
                        votre niveau et votre rythme, où que vous soyez dans le monde.
                    </p>

                    <div class="platform-details mb-4">
                        <div class="detail-item" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-geo-alt"></i>
                            <span>Disponible dans plusieurs pays et régions du monde</span>
                        </div>
                        <div class="detail-item" data-aos="fade-up" data-aos-delay="350">
                            <i class="bi bi-people"></i>
                            <span>+1000 tuteurs certifiés à l'international</span>
                        </div>
                        <div class="detail-item" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-cash-stack"></i>
                            <span>Paiements faciles et sécurisés</span>
                        </div>
                    </div>

                    <div class="hero-actions" data-aos="fade-up" data-aos-delay="450">
                        <a href="{{route('register')}}" class="btn btn-primary btn-lg me-3">Trouver un Tuteur</a>
                        <a href="{{ route('register.tuteur') }}" class="btn btn-outline-primary btn-lg">Devenir Tuteur</a>
                    </div>

                </div>

                <!-- Image principale -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="hero-image-wrapper">
                        <img src="{{ asset('images/image_1.webp') }}" alt="EduConnect Global" class="img-fluid hero-image">

                        <div class="floating-badges">
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="600">
                                <i class="bi bi-person-check"></i>
                                <span>Tuteurs Certifiés</span>
                            </div>
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="650">
                                <i class="bi bi-laptop"></i>
                                <span>Cours en Ligne & Présentiel</span>
                            </div>
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="700">
                                <i class="bi bi-shield-lock"></i>
                                <span>Paiement Sécurisé</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /Hero Section -->



    <!-- About Section -->
    <section id="about" class="about section" style="margin-top: 0px;">

        {{--
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">
                <!-- Colonne gauche : cartes d'informations -->
                <div class="col-lg-6 mb-4 mb-lg-0">

                    <div class="features-grid">
                        <div class="row g-4">
                            <!-- Carte 1 : Inscription -->
                            <div class="col-lg-6 col-md-7" data-aos="fade-up" data-aos-delay="200">
                                <a href="{{ route('register') }}" class="text-decoration-none text-dark">
                                    <div class="feature-card h-100">
                                        <div class="feature-icon">
                                            <i class="bi bi-person-plus"></i>
                                        </div>
                                        <h4>Inscription Simple</h4>
                                        <p>
                                            Créez votre compte en quelques clics via votre email, numéro de téléphone ou
                                            réseaux
                                            sociaux. Rejoignez une communauté d’apprenants et de tuteurs au Bénin.
                                        </p>
                                        <p class="fw-semibold mt-2 text-primary">Cliquez ici pour vous inscrire</p>
                                    </div>
                                </a>
                            </div>

                            <!-- Carte 2 : Connexion -->
                            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
                                <a href="{{ route('login') }}" class="text-decoration-none text-dark">
                                    <div class="feature-card h-100">
                                        <div class="feature-icon">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                        </div>
                                        <h4>Connexion Rapide</h4>
                                        <p>
                                            Accédez à votre espace personnel pour suivre vos cours, gérer vos réservations
                                            et échanger directement avec vos tuteurs ou apprenants.
                                        </p>
                                        <p class="fw-semibold mt-2 text-primary">Cliquez ici pour vous connecter</p>
                                    </div>
                                </a>
                            </div>



                        </div>
                    </div>
                </div>

                <!-- Colonne droite : image -->
                <div class="col-lg-6">
                    <div class="image-wrapper" data-aos="zoom-in" data-aos-delay="300">
                        <img src="{{ asset('images/image_2.webp') }}" alt="EduBenin Tutorat showcase" class="img-fluid">
                        <div class="floating-card" data-aos="fade-up" data-aos-delay="600">
                            <div class="card-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="card-content">
                                <h4>Communauté Active</h4>
                                <p>Des centaines d’apprenants et de tuteurs déjà connectés au Bénin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

         --}}

        <!-- Appel à l’action -->
<div class="cta-section py-5" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color:#0d6efd;">Trouver un Tuteur Qualifié</h2>
            <p class="text-muted">Recherchez parmi nos meilleurs professeurs particuliers</p>
        </div>

        <form action="{{ route('recherche.tuteur') }}" method="GET"
            class="search-bar p-4 p-lg-5 rounded-4 shadow-lg"
            style="background: linear-gradient(135deg, #e8f1ff 0%, #f0f7ff 100%); border-left: 6px solid #0d6efd;">

            <div class="row g-3 align-items-end">
                <!-- Matière -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="color:#0d6efd;">Cours</label>
                    <input type="text" name="subject" class="form-control form-control-lg border-primary-subtle"
                        placeholder="Ex : Mathématiques, Anglais..." id="subjectInput" value="{{ old('subject', request('subject')) }}">
                </div>

                <!-- Ville -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="color:#0d6efd;">Ville</label>
                    <input type="text" name="city" class="form-control form-control-lg border-primary-subtle"
                        placeholder="Entrez une ville" id="cityInput" value="{{ old('city', request('city')) }}">
                </div>

                <!-- Préférence d'apprentissage -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="color:#0d6efd;">Mode d'apprentissage</label>
                    <select name="learning_preference" class="form-control form-control-lg border-primary-subtle">
                        <option value="">Tous les modes</option>
                        <option value="online" {{ request('learning_preference') == 'online' ? 'selected' : '' }}>En Ligne</option>
                        <option value="in_person" {{ request('learning_preference') == 'in_person' ? 'selected' : '' }}>Présentiel</option>
                        <option value="both" {{ request('learning_preference') == 'both' ? 'selected' : '' }}>Les deux</option>
                    </select>
                </div>

                <!-- Bouton Rechercher -->
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary btn-lg px-4" style="height: 56px;">
                        <i class="bi bi-search me-2"></i>Rechercher
                    </button>
                </div>
            </div>
        </form>

        <!-- Matières populaires défilantes -->
        <div class="mt-5">
            <h5 class="text-center mb-4 fw-semibold" style="color:#0d6efd;">
                <i class="bi bi-lightning-charge-fill me-2"></i>Cours populaires
            </h5>
            <div class="matieres-container position-relative overflow-hidden">
                <div class="navigation-buttons left">
                    <button class="btn-scroll-prev btn btn-sm btn-outline-primary">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                </div>
                <div class="matieres-scroll d-flex gap-3">
                    <!-- Les matières seront chargées dynamiquement -->
                </div>
                <div class="navigation-buttons right">
                    <button class="btn-scroll-next btn btn-sm btn-outline-primary">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <div class="scroll-shadow left"></div>
                <div class="scroll-shadow right"></div>
            </div>
        </div>

        <!-- Villes populaires défilantes (sens inverse) -->
        <div class="mt-4">
            <h5 class="text-center mb-4 fw-semibold" style="color:#dc3545;">
                <i class="bi bi-geo-alt-fill me-2"></i>Villes populaires
            </h5>
            <div class="villes-container position-relative overflow-hidden">
                <div class="navigation-buttons left">
                    <button class="btn-scroll-prev-villes btn btn-sm btn-outline-danger">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                </div>
                <div class="villes-scroll d-flex gap-3">
                    <!-- Les villes seront chargées dynamiquement -->
                </div>
                <div class="navigation-buttons right">
                    <button class="btn-scroll-next-villes btn btn-sm btn-outline-danger">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <div class="scroll-shadow left"></div>
                <div class="scroll-shadow right"></div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour le défilement des matières et villes -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales pour le contrôle du défilement
    let scrollPositionMatiere = 0;
    let scrollPositionVille = 0;
    let autoScrollMatiere = true;
    let autoScrollVille = true;
    let scrollSpeedMatiere = 0.8;
    let scrollSpeedVille = -0.8; // Sens inverse

    // Récupérer les matières populaires
    fetch('/matieres-populaires')
        .then(response => response.json())
        .then(matieres => {
            const container = document.querySelector('.matieres-scroll');

            // Créer les badges de matière
            matieres.forEach(matiere => {
                const badge = createMatiereBadge(matiere);
                container.appendChild(badge);
            });

            // Dupliquer pour effet infini
            matieres.forEach(matiere => {
                const badge = createMatiereBadge(matiere);
                container.appendChild(badge);
            });

            startAutoScrollMatiere();
            setupScrollControlsMatiere();
        })
        .catch(error => {
            console.error('Erreur lors du chargement des matières:', error);
            loadDefaultMatieres();
        });

    // Récupérer les villes populaires
    fetch('/villes-populaires')
        .then(response => response.json())
        .then(villes => {
            const container = document.querySelector('.villes-scroll');

            // Créer les badges de ville
            villes.forEach(ville => {
                const badge = createVilleBadge(ville);
                container.appendChild(badge);
            });

            // Dupliquer pour effet infini
            villes.forEach(ville => {
                const badge = createVilleBadge(ville);
                container.appendChild(badge);
            });

            startAutoScrollVille();
            setupScrollControlsVille();
        })
        .catch(error => {
            console.error('Erreur lors du chargement des villes:', error);
            loadDefaultVilles();
        });

    // Fonctions de création des badges
    function createMatiereBadge(matiere) {
        const badge = document.createElement('button');
        badge.className = 'matiere-badge btn btn-outline-primary rounded-pill px-4 py-2';
        badge.type = 'button';
        badge.style.whiteSpace = 'nowrap';
        badge.innerHTML = `<i class="bi bi-book me-1"></i>${matiere}`;
        badge.onclick = function() {
            document.getElementById('subjectInput').value = matiere;
            // Soumettre automatiquement si l'utilisateur le souhaite
            // document.querySelector('form').submit();
        };
        return badge;
    }

    function createVilleBadge(ville) {
        const badge = document.createElement('button');
        badge.className = 'ville-badge btn btn-outline-danger rounded-pill px-4 py-2';
        badge.type = 'button';
        badge.style.whiteSpace = 'nowrap';
        badge.innerHTML = `<i class="bi bi-geo-alt me-1"></i>${ville}`;
        badge.onclick = function() {
            document.getElementById('cityInput').value = ville;
            // Soumettre automatiquement si l'utilisateur le souhaite
            // document.querySelector('form').submit();
        };
        return badge;
    }

    // Défilement automatique pour les matières
    function startAutoScrollMatiere() {
        const container = document.querySelector('.matieres-scroll');

        function animate() {
            if (autoScrollMatiere) {
                scrollPositionMatiere -= scrollSpeedMatiere;

                if (Math.abs(scrollPositionMatiere) >= container.scrollWidth / 2) {
                    scrollPositionMatiere = 0;
                }

                container.style.transform = `translateX(${scrollPositionMatiere}px)`;
            }
            requestAnimationFrame(animate);
        }

        animate();
    }

    // Défilement automatique pour les villes (sens inverse)
    function startAutoScrollVille() {
        const container = document.querySelector('.villes-scroll');

        function animate() {
            if (autoScrollVille) {
                scrollPositionVille -= scrollSpeedVille;

                if (Math.abs(scrollPositionVille) >= container.scrollWidth / 2) {
                    scrollPositionVille = 0;
                }

                container.style.transform = `translateX(${scrollPositionVille}px)`;
            }
            requestAnimationFrame(animate);
        }

        animate();
    }

    // Contrôles manuels pour les matières
    function setupScrollControlsMatiere() {
        const container = document.querySelector('.matieres-scroll');
        const btnPrev = document.querySelector('.btn-scroll-prev');
        const btnNext = document.querySelector('.btn-scroll-next');

        btnPrev.addEventListener('click', function() {
            autoScrollMatiere = false;
            scrollPositionMatiere += 200;
            container.style.transform = `translateX(${scrollPositionMatiere}px)`;

            // Réactiver le défilement automatique après 5 secondes
            setTimeout(() => autoScrollMatiere = true, 5000);
        });

        btnNext.addEventListener('click', function() {
            autoScrollMatiere = false;
            scrollPositionMatiere -= 200;
            container.style.transform = `translateX(${scrollPositionMatiere}px)`;

            // Réactiver le défilement automatique après 5 secondes
            setTimeout(() => autoScrollMatiere = true, 5000);
        });

        // Pause au survol
        container.parentElement.addEventListener('mouseenter', () => autoScrollMatiere = false);
        container.parentElement.addEventListener('mouseleave', () => autoScrollMatiere = true);
    }

    // Contrôles manuels pour les villes
    function setupScrollControlsVille() {
        const container = document.querySelector('.villes-scroll');
        const btnPrev = document.querySelector('.btn-scroll-prev-villes');
        const btnNext = document.querySelector('.btn-scroll-next-villes');

        btnPrev.addEventListener('click', function() {
            autoScrollVille = false;
            scrollPositionVille += 200;
            container.style.transform = `translateX(${scrollPositionVille}px)`;

            // Réactiver le défilement automatique après 5 secondes
            setTimeout(() => autoScrollVille = true, 5000);
        });

        btnNext.addEventListener('click', function() {
            autoScrollVille = false;
            scrollPositionVille -= 200;
            container.style.transform = `translateX(${scrollPositionVille}px)`;

            // Réactiver le défilement automatique après 5 secondes
            setTimeout(() => autoScrollVille = true, 5000);
        });

        // Pause au survol
        container.parentElement.addEventListener('mouseenter', () => autoScrollVille = false);
        container.parentElement.addEventListener('mouseleave', () => autoScrollVille = true);
    }

    // Fonctions de secours
    function loadDefaultMatieres() {
        const matieresParDefaut = [
            'Mathématiques', 'Français', 'Anglais', 'Physique', 'Chimie',
            'SVT', 'Histoire', 'Géographie', 'Philosophie', 'Espagnol',
            'Allemand', 'Informatique', 'Économie', 'Droit', 'Marketing',
            'Comptabilité', 'Musique', 'Arts', 'Sport', 'Médecine'
        ];

        const container = document.querySelector('.matieres-scroll');
        matieresParDefaut.forEach(matiere => {
            const badge = createMatiereBadge(matiere);
            container.appendChild(badge);
        });

        matieresParDefaut.forEach(matiere => {
            const badge = createMatiereBadge(matiere);
            container.appendChild(badge);
        });

        startAutoScrollMatiere();
        setupScrollControlsMatiere();
    }

    function loadDefaultVilles() {
        const villesParDefaut = [
            'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice',
            'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille',
            'Rennes', 'Reims', 'Le Havre', 'Saint-Étienne', 'Toulon'
        ];

        const container = document.querySelector('.villes-scroll');
        villesParDefaut.forEach(ville => {
            const badge = createVilleBadge(ville);
            container.appendChild(badge);
        });

        villesParDefaut.forEach(ville => {
            const badge = createVilleBadge(ville);
            container.appendChild(badge);
        });

        startAutoScrollVille();
        setupScrollControlsVille();
    }
});
</script>

<style>
/* Styles pour les badges de matière et ville */
.matiere-badge, .ville-badge {
    transition: all 0.3s ease;
    border-width: 2px;
    flex-shrink: 0;
}

.matiere-badge:hover {
    background-color: #0d6efd !important;
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
}

.ville-badge:hover {
    background-color: #dc3545 !important;
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
}

.matiere-badge:active, .ville-badge:active {
    transform: translateY(0);
}

.matiere-badge i, .ville-badge i {
    margin-right: 5px;
}

/* Containers de défilement */
.matières-container, .villes-container {
    height: 70px;
    overflow: hidden;
    position: relative;
    padding: 0 40px;
}

.matières-scroll, .villes-scroll {
    display: flex;
    position: absolute;
    left: 0;
    top: 0;
    transition: transform 0.5s ease;
}

/* Boutons de navigation */
.navigation-buttons {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 3;
    background: rgba(255, 255, 255, 0.9);
    padding: 5px;
    border-radius: 8px;
}

.navigation-buttons.left {
    left: 10px;
}

.navigation-buttons.right {
    right: 10px;
}

.btn-scroll-prev, .btn-scroll-next,
.btn-scroll-prev-villes, .btn-scroll-next-villes {
    padding: 5px 10px;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Ombres de dégradé */
.scroll-shadow {
    position: absolute;
    top: 0;
    width: 50px;
    height: 100%;
    pointer-events: none;
    z-index: 2;
}

.scroll-shadow.left {
    left: 0;
    background: linear-gradient(to right, white, transparent);
}

.scroll-shadow.right {
    right: 0;
    background: linear-gradient(to left, white, transparent);
}

/* Styles du formulaire */
.search-bar {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.search-bar:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(13, 110, 253, 0.15) !important;
}

.form-control-lg {
    height: 56px;
    border-radius: 12px;
}

.form-control-lg:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn-primary {
    border-radius: 12px;
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .cta-section {
        padding: 2rem 0 !important;
    }

    .search-bar {
        padding: 1.5rem !important;
    }

    .matières-container, .villes-container {
        height: 60px;
        padding: 0 35px;
    }

    .matiere-badge, .ville-badge {
        padding: 0.5rem 1rem !important;
        font-size: 0.9rem;
    }

    .navigation-buttons {
        display: none;
    }
}

@media (max-width: 576px) {
    .matières-container, .villes-container {
        height: 50px;
    }

    .matiere-badge, .ville-badge {
        padding: 0.4rem 0.8rem !important;
        font-size: 0.85rem;
    }
}
</style>

    </section><!-- /About Section -->




    <!-- Top Tutors Section -->
<section id="tutors" class="tutors-gallery section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Tuteurs récemment inscrits</h2>
        <p>Découvrez les derniers professeurs à avoir rejoint EduBenin Tutorat</p>
    </div>

    <div class="container" data-aos="fade-up">
        <!-- Première rangée (3 tuteurs) -->
        <div class="row justify-content-center mb-4">
            @foreach ($recentTutors->take(3) as $index => $tutor)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="tutor-card" data-tutor-id="{{ $tutor->id }}">
                        <div class="tutor-image-wrapper">
                            <img src="{{ $tutor->photo_path ? asset('storage/' . $tutor->photo_path) : asset('images/profill_default.webp') }}"
                                alt="{{ $tutor->firstname }}"
                                class="tutor-img">
                            <div class="tutor-overlay">
                                <button class="btn-view-profile" data-bs-toggle="modal" data-bs-target="#tutorModal{{ $tutor->id }}">
                                    <i class="bi bi-eye"></i> Voir le profil
                                </button>
                            </div>
                        </div>
                        <div class="tutor-info">

                            <h4 class="tutor-name">{{ $tutor->firstname }} {{ $tutor->lastname }}</h4>

                            @php
                                // Gestion des matières
                                $subjects = [];
                                if (!empty($tutor->subjects)) {
                                    $decoded = json_decode($tutor->subjects, true);
                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                        $subjects = $decoded;
                                    } else {
                                        $subjects = array_map('trim', explode(',', $tutor->subjects));
                                    }
                                }
                                $subjects = array_filter($subjects);
                            @endphp

                            <p class="tutor-subjects">
                                @if(!empty($subjects))
                                    {{ implode(', ', array_slice($subjects, 0, 2)) }}
                                    @if(count($subjects) > 2)
                                        <span class="more-subjects">+{{ count($subjects) - 2 }}</span>
                                    @endif
                                @else
                                    Spécialité non précisée
                                @endif
                            </p>
                            <p class="tutor-location">
                                <i class="bi bi-geo-alt"></i> {{ $tutor->city ?? 'Ville non précisée' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Deuxième rangée (3 tuteurs) avec effet de superposition -->
        @if($recentTutors->count() > 3)
            <div class="row justify-content-center mt-5">
                @foreach ($recentTutors->slice(3, 3) as $index => $tutor)
                    @php
                        $zIndex = 30 - ($index * 10);
                        $marginLeft = $index * -20;
                    @endphp
                    <div class="col-lg-4 col-md-6">
                        <div class="tutor-card stacked"
                             style="z-index: {{ $zIndex }}; margin-left: {{ $marginLeft }}px;"
                             data-tutor-id="{{ $tutor->id }}">
                            <div class="tutor-image-wrapper">
                                <img src="{{ $tutor->photo_path ? asset('storage/' . $tutor->photo_path) : asset('images/profill_default.webp') }}"
                                    alt="{{ $tutor->firstname }}"
                                    class="tutor-img">
                                <div class="tutor-overlay">
                                    <button class="btn-view-profile" data-bs-toggle="modal" data-bs-target="#tutorModal{{ $tutor->id }}">
                                        <i class="bi bi-eye"></i> Voir le profil
                                    </button>
                                </div>
                            </div>
                            <div class="tutor-info">

                                <h4 class="tutor-name">{{ $tutor->firstname }} {{ $tutor->lastname }}</h4>

                                @php
                                    $subjects = [];
                                    if (!empty($tutor->subjects)) {
                                        $decoded = json_decode($tutor->subjects, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $subjects = $decoded;
                                        } else {
                                            $subjects = array_map('trim', explode(',', $tutor->subjects));
                                        }
                                    }
                                    $subjects = array_filter($subjects);
                                @endphp

                                <p class="tutor-subjects">
                                    @if(!empty($subjects))
                                        {{ implode(', ', array_slice($subjects, 0, 2)) }}
                                        @if(count($subjects) > 2)
                                            <span class="more-subjects">+{{ count($subjects) - 2 }}</span>
                                        @endif
                                    @else
                                        Spécialité non précisée
                                    @endif
                                </p>
                                <p class="tutor-location">
                                    <i class="bi bi-geo-alt"></i> {{ $tutor->city ?? 'Ville non précisée' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Bouton Voir plus -->
    @if($recentTutors->count() > 6)
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('recherche.tuteur') }}" class="btn btn-primary btn-lg">
                Voir tous les tuteurs <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    @endif
</section>

<!-- Modals pour chaque tuteur -->
@foreach ($recentTutors as $tutor)
    <div class="modal fade" id="tutorModal{{ $tutor->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 position-relative">
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="tutor-modal-content">
                        <div class="tutor-modal-image">
                            <img src="{{ $tutor->photo_path ? asset('storage/' . $tutor->photo_path) : asset('images/profill_default.webp') }}"
                                alt="{{ $tutor->firstname }}">
                        </div>
                        <div class="tutor-modal-info">
                            <div class="tutor-modal-header">
                                <h3>{{ $tutor->firstname }} {{ $tutor->lastname }}</h3>

                            </div>

                            <div class="tutor-modal-details">
                                <div class="detail-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>{{ $tutor->city ?? 'Ville non précisée' }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-cash-coin"></i>
                                    <span>{{ $tutor->rate_per_hour ? number_format($tutor->rate_per_hour, 0, ',', ' ') . ' FCFA / h' : 'Tarif non défini' }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-whatsapp"></i>
                                    <span>{{ $tutor->telephone ?? 'Non disponible' }}</span>
                                </div>
                            </div>

                            <div class="tutor-modal-subjects">
                                <h6>Spécialités :</h6>
                                @php
                                    $subjects = [];
                                    if (!empty($tutor->subjects)) {
                                        $decoded = json_decode($tutor->subjects, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $subjects = $decoded;
                                        } else {
                                            $subjects = array_map('trim', explode(',', $tutor->subjects));
                                        }
                                    }
                                    $subjects = array_filter($subjects);
                                @endphp

                                <div class="subjects-list">
                                    @foreach($subjects as $subject)
                                        <span class="subject-badge">{{ $subject }}</span>
                                    @endforeach
                                    @if(empty($subjects))
                                        <span class="text-muted">Aucune spécialité renseignée</span>
                                    @endif
                                </div>
                            </div>

                            <div class="tutor-modal-bio">
                                <h6>À propos :</h6>
                                <p>{{ $tutor->bio ?? 'Pas encore de biographie disponible.' }}</p>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
.tutors-gallery {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 80px 0;
}

.tutor-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    height: 100%;
}

.tutor-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    z-index: 50 !important;
}

.tutor-card.stacked {
    position: relative;
    transition: all 0.4s ease;
}

.tutor-card.stacked:hover {
    margin-left: 0 !important;
    z-index: 100 !important;
}

.tutor-image-wrapper {
    position: relative;
    height: 280px;
    overflow: hidden;
}

.tutor-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.tutor-card:hover .tutor-img {
    transform: scale(1.1);
}

.tutor-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.4s ease;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 20px;
}

.tutor-card:hover .tutor-overlay {
    opacity: 1;
}

.btn-view-profile {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    padding: 12px 24px;
    border-radius: 50px;
    color: #0d6efd;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-view-profile:hover {
    background: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.tutor-info {
    padding: 25px;
}

.tutor-rating {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #ffc107;
    font-weight: 600;
    margin-bottom: 10px;
}

.tutor-name {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 8px;
    font-size: 1.3rem;
}

.tutor-subjects {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 12px;
    line-height: 1.4;
}

.more-subjects {
    background: #e9ecef;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.8rem;
    margin-left: 5px;
}

.tutor-location {
    color: #495057;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Modal Styles */
.modal-content {
    border-radius: 25px;
    overflow: hidden;
    border: none;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
}

.close-modal {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #666;
    transition: all 0.3s ease;
    z-index: 1000;
    border: 2px solid #eee;
}

.close-modal:hover {
    background: #f8f9fa;
    color: #333;
    transform: rotate(90deg);
}

.tutor-modal-content {
    display: flex;
    height: 600px;
}

.tutor-modal-image {
    flex: 0 0 40%;
    overflow: hidden;
}

.tutor-modal-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.tutor-modal-info {
    flex: 0 0 60%;
    padding: 40px;
    overflow-y: auto;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.tutor-modal-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e9ecef;
}

.tutor-modal-header h3 {
    color: #2c3e50;
    font-weight: 800;
    margin-bottom: 10px;
}

.tutor-modal-rating {
    display: flex;
    align-items: center;
    gap: 15px;
}

.stars {
    color: #ddd;
    font-size: 1.2rem;
}

.stars .active {
    color: #ffc107;
}

.rating-text {
    font-weight: 600;
    color: #6c757d;
}

.tutor-modal-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 30px;
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #495057;
}

.detail-item i {
    color: #0d6efd;
    font-size: 1.2rem;
}

.tutor-modal-subjects h6,
.tutor-modal-bio h6 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.subjects-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 25px;
}

.subject-badge {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
}

.tutor-modal-bio p {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 30px;
}

.tutor-modal-actions {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.tutor-modal-actions .btn {
    flex: 1;
    padding: 12px 20px;
    border-radius: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.tutor-modal-actions .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Responsive */
@media (max-width: 992px) {
    .tutor-modal-content {
        flex-direction: column;
        height: auto;
    }

    .tutor-modal-image {
        flex: 0 0 300px;
    }

    .tutor-modal-info {
        flex: 1;
    }

    .tutor-card.stacked {
        margin-left: 0 !important;
        margin-top: -50px;
        z-index: 10;
    }
}

@media (max-width: 768px) {
    .tutor-modal-details {
        grid-template-columns: 1fr;
    }

    .tutor-modal-actions {
        flex-direction: column;
    }

    .tutor-image-wrapper {
        height: 250px;
    }
}

@media (max-width: 576px) {
    .tutor-card {
        margin-bottom: 30px;
    }

    .tutor-card.stacked {
        margin-top: -30px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser AOS
    AOS.init({
        duration: 800,
        once: true
    });

    // Animation des cartes empilées
    const stackedCards = document.querySelectorAll('.tutor-card.stacked');

    stackedCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            // Remettre toutes les cartes en position initiale
            stackedCards.forEach(c => {
                c.style.transform = 'translateY(0)';
                c.style.marginLeft = c.style.marginLeft;
            });

            // Animer la carte survolée
            this.style.transform = 'translateY(-20px)';
            this.style.marginLeft = '0px';

            // Déplacer les autres cartes
            const index = Array.from(stackedCards).indexOf(this);
            stackedCards.forEach((c, i) => {
                if (i < index) {
                    c.style.marginLeft = '-40px';
                } else if (i > index) {
                    c.style.marginLeft = '40px';
                }
            });
        });

        card.addEventListener('mouseleave', function() {
            // Revenir à la position initiale
            stackedCards.forEach((c, i) => {
                c.style.transform = 'translateY(0)';
                c.style.marginLeft = (i * -20) + 'px';
            });
        });
    });

    // Animation d'ouverture des modals
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-bs-target');
            const modal = document.querySelector(modalId);

            // Animation d'entrée
            modal.querySelector('.modal-content').style.transform = 'scale(0.9)';
            modal.querySelector('.modal-content').style.opacity = '0';

            setTimeout(() => {
                modal.querySelector('.modal-content').style.transition = 'all 0.4s ease';
                modal.querySelector('.modal-content').style.transform = 'scale(1)';
                modal.querySelector('.modal-content').style.opacity = '1';
            }, 10);
        });
    });

    // Animation de fermeture des modals
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');

            // Animation de sortie
            modal.querySelector('.modal-content').style.transform = 'scale(0.9)';
            modal.querySelector('.modal-content').style.opacity = '0';

            setTimeout(() => {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            }, 300);
        });
    });

    // Reset modal animation quand elle se ferme
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function() {
            this.querySelector('.modal-content').style.transform = '';
            this.querySelector('.modal-content').style.opacity = '';
            this.querySelector('.modal-content').style.transition = '';
        });
    });
});
</script>


{{--
    <!-- Paid Services Section -->
    <section id="services-paid" class="tickets section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Services Payants</h2>
            <p>Découvrez les options premium pour améliorer votre expérience sur EduBenin Tutorat</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">

                <!-- Service 1 : Abonnement Étudiant -->
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-icon">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <h4 class="ticket-title">Abonnement Étudiant</h4>
                            <p class="ticket-subtitle">Accédez à plus de tuteurs et réservez sans limite</p>
                        </div>
                        <div class="ticket-body">
                            <ul class="benefits-list">
                                <li><i class="bi bi-check2"></i> Réservations illimitées</li>
                                <li><i class="bi bi-check2"></i> Accès prioritaire aux tuteurs notés 5★</li>
                                <li><i class="bi bi-check2"></i> Rappels SMS gratuits</li>
                                <li><i class="bi bi-check2"></i> Historique de paiements détaillé</li>
                            </ul>
                            <a href="#" class="ticket-btn">Souscrire</a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

                <!-- Service 2 : Pack Tuteur Premium -->
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="ticket-card premium">
                        <div class="ticket-header">
                            <div class="ticket-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <h4 class="ticket-title">Pack Tuteur Premium</h4>
                            <p class="ticket-subtitle">Boostez votre visibilité et vos revenus</p>
                        </div>
                        <div class="ticket-body">
                            <ul class="benefits-list">
                                <li><i class="bi bi-check2"></i> Profil mis en avant sur la plateforme</li>
                                <li><i class="bi bi-check2"></i> Accès à la messagerie prioritaire</li>
                                <li><i class="bi bi-check2"></i> Statistiques avancées sur les élèves</li>
                                <li><i class="bi bi-check2"></i> Badge “Tuteur Premium”</li>
                            </ul>
                            <a href="#" class="ticket-btn">Activer</a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

                <!-- Service 3 : Cours Enregistrés -->
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-icon">
                                <i class="bi bi-play-circle"></i>
                            </div>
                            <h4 class="ticket-title">Cours Enregistrés</h4>
                            <p class="ticket-subtitle">Apprenez à votre rythme, où que vous soyez</p>
                        </div>
                        <div class="ticket-body">
                            <ul class="benefits-list">
                                <li><i class="bi bi-check2"></i> Accès illimité aux vidéos des tuteurs</li>
                                <li><i class="bi bi-check2"></i> Téléchargement possible (offline)</li>
                                <li><i class="bi bi-check2"></i> Suivi de progression personnalisé</li>
                                <li><i class="bi bi-check2"></i> Évaluations automatiques intégrées</li>
                            </ul>
                            <a href="#" class="ticket-btn">Découvrir</a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

                <!-- Service 4 : Coaching & Suivi Personnalisé -->
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-icon">
                                <i class="bi bi-person-lines-fill"></i>
                            </div>
                            <h4 class="ticket-title">Coaching Personnalisé</h4>
                            <p class="ticket-subtitle">Un accompagnement dédié selon vos objectifs</p>
                        </div>
                        <div class="ticket-body">
                            <ul class="benefits-list">
                                <li><i class="bi bi-check2"></i> Plan d’apprentissage sur mesure</li>
                                <li><i class="bi bi-check2"></i> Séances individuelles de coaching</li>
                                <li><i class="bi bi-check2"></i> Suivi des progrès avec le tuteur</li>
                                <li><i class="bi bi-check2"></i> Rapport mensuel d’évolution</li>
                            </ul>
                            <a href="#" class="ticket-btn">Demander un devis</a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

            </div>
        </div>

    </section><!-- /Paid Services Section -->

 --}}

    {{--    <!-- Témoignages Section -->
    <section id="testimonials" class="testimonials section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Témoignages</h2>
            <p>Ce que nos utilisateurs disent de leur expérience sur EduBenin Tutorat</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="testimonials-slider swiper init-swiper">
                <script type="application/json" class="swiper-config">
            {
              "slidesPerView": 1,
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              }
            }
            </script>

                <div class="swiper-wrapper">

                    <!-- Témoignage 1 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Une plateforme qui m’a vraiment aidée à progresser !</h2>
                                    <p>
                                        Grâce à EduBenin Tutorat, j’ai pu trouver un tuteur disponible et patient pour
                                        m’aider à mieux comprendre les mathématiques.
                                        En quelques semaines, mes notes ont nettement augmenté.
                                    </p>
                                    <p>
                                        Le système de réservation est très simple à utiliser, et j’apprécie surtout la
                                        possibilité de noter les tuteurs après chaque séance.
                                        C’est une expérience très positive que je recommande à tous les étudiants.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('images/person-f-10.webp') }}" class="profile-img"
                                            alt="">
                                        <div class="profile-info">
                                            <h3>Saul Goodman</h3>
                                            <span>Étudiante en 3e</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('images/person-f-10.webp') }}" class="featured-img"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Testimonial Item -->

                    <!-- Témoignage 2 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Un excellent outil pour les tuteurs comme moi</h2>
                                    <p>
                                        EduBenin Tutorat m’a permis de rencontrer de nombreux élèves motivés sans avoir à
                                        chercher moi-même des cours.
                                        Tout est automatisé, du paiement à la planification des séances.
                                    </p>
                                    <p>
                                        J’apprécie particulièrement la transparence du système et les retours des étudiants,
                                        qui m’aident à m’améliorer constamment.
                                        Je recommande vivement la plateforme à tous les enseignants indépendants.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('images/person-m-6.webp') }}" class="profile-img"
                                            alt="">
                                        <div class="profile-info">
                                            <h3>Sara Wilsson</h3>
                                            <span>Tutrice en Physique-Chimie</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('images/person-m-6.webp') }}" class="featured-img"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Testimonial Item -->

                    <!-- Témoignage 3 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Un accompagnement personnalisé et efficace</h2>
                                    <p>
                                        Ce que j’aime avec EduBenin Tutorat, c’est la possibilité de choisir un tuteur en
                                        fonction de mon emploi du temps et de mon niveau.
                                        Mon tuteur a adapté chaque séance à mes besoins spécifiques.
                                    </p>
                                    <p>
                                        En peu de temps, j’ai repris confiance en moi et j’ai compris des notions que je
                                        croyais impossibles à maîtriser.
                                        Merci à toute l’équipe pour cette belle initiative.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('images/person-f-8.webp') }}" class="profile-img"
                                            alt="">
                                        <div class="profile-info">
                                            <h3>Matt Brandon</h3>
                                            <span>Étudiant en Terminale</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('images/person-f-8.webp') }}" class="featured-img"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Testimonial Item -->

                    <!-- Témoignage 4 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Une expérience fluide et motivante</h2>
                                    <p>
                                        La plateforme est simple à utiliser, même pour quelqu’un qui n’est pas très à l’aise
                                        avec la technologie.
                                        J’ai pu m’inscrire, trouver un tuteur et commencer mes cours en moins de dix
                                        minutes.
                                    </p>
                                    <p>
                                        Le suivi des progrès est un vrai plus ! Je peux voir mes résultats s’améliorer au
                                        fil des semaines.
                                        EduBenin Tutorat a totalement changé ma façon d’apprendre.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('images/person-f-8.webp') }}" class="profile-img"
                                            alt="">
                                        <div class="profile-info">
                                            <h3>Jena Karlis</h3>
                                            <span>Parent d’élève</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('images/person-f-8.webp') }}" class="featured-img"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Testimonial Item -->

                </div>

                <div class="swiper-navigation w-100 d-flex align-items-center justify-content-center">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>

            </div>

        </div>

    </section><!-- /Témoignages Section -->

     --}}


    <!-- Contact Section -->
    <section id="inscription" class="inscription-section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center position-relative">

            <!-- Image en arrière-plan avec effet flou -->
            <div class="col-lg-12 position-absolute start-0 top-0 w-100 h-100 d-none d-lg-block"
                 style="z-index: 1;">
                <div class="background-image-wrapper rounded-4 overflow-hidden">
                    <img src="{{ asset('images/image_3.webp') }}"
                         class="img-fluid w-100 h-100 object-fit-cover"
                         alt="Devenir tuteur EduBenin"
                        >
                </div>
            </div>

            <!-- Formulaire d'inscription à droite avec transparence -->
            <div class="col-lg-6 offset-lg-6" data-aos="fade-left" data-aos-delay="300"
                 style="z-index: 2; position: relative;">
                 <br><br><br>
                <div class="inscription-form p-4 p-lg-5 rounded-4"
                     style="background: linear-gradient(135deg, rgba(227, 242, 253, 0.7), rgba(255, 255, 255, 0.8));
                            box-shadow: 0 8px 24px rgba(0, 123, 255, 0.15);
                            border: 1px solid rgba(0, 123, 255, 0.2);
                            backdrop-filter: blur(5px);">

                    <div class="section-title mb-4 text-primary">
                        <h2 class="fw-bold" style="color: #0f0f0f;">Devenir un tuteur</h2>
                        <p style="color: #0d47a1;">Rejoignez notre équipe de tuteurs passionnés et partagez votre savoir avec les étudiants de <strong>EduBenin Tutorat</strong>.</p>
                    </div>

                    <form id="inscriptionForm">
                        <div class="row gy-3">

                            <div class="col-md-6">
                                <label for="nom" class="form-label text-dark fw-semibold">Nom</label>
                                <input type="text" name="nom" id="nom"
                                       class="form-control border-0 shadow-sm" style="background-color: rgba(248, 251, 255, 0.8);"
                                       placeholder="Votre nom" required>
                            </div>

                            <div class="col-md-6">
                                <label for="prenom" class="form-label text-dark fw-semibold">Prénom</label>
                                <input type="text" name="prenom" id="prenom"
                                       class="form-control border-0 shadow-sm" style="background-color: rgba(248, 251, 255, 0.8);"
                                       placeholder="Votre prénom" required>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label text-dark fw-semibold">Adresse e-mail</label>
                                <input type="email" name="email" id="email"
                                       class="form-control border-0 shadow-sm" style="background-color: rgba(248, 251, 255, 0.8);"
                                       placeholder="votremail@example.com" required>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label text-dark fw-semibold">Mot de passe</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                           class="form-control border-0 shadow-sm" style="background-color: rgba(248, 251, 255, 0.8);"
                                           placeholder="Créez un mot de passe" required>
                                    <button type="button" class="btn btn-outline-secondary border-0" onclick="togglePassword('password')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="confirmPassword" class="form-label text-dark fw-semibold">Confirmer le mot de passe</label>
                                <div class="input-group">
                                    <input type="password" name="confirmPassword" id="confirmPassword"
                                           class="form-control border-0 shadow-sm" style="background-color: rgba(248, 251, 255, 0.8);"
                                           placeholder="Confirmez votre mot de passe" required>
                                    <button type="button" class="btn btn-outline-secondary border-0" onclick="togglePassword('confirmPassword')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="conditions" required>
                                    <label class="form-check-label text-dark" for="conditions">
                                        J'accepte les <a href="#" style="color: #0d6efd; text-decoration: none;">conditions d'utilisation</a> et la <a href="#" style="color: #0d6efd; text-decoration: none;">politique de confidentialité</a>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary mt-3 px-4 py-2"
                                        style="background: linear-gradient(135deg, #2196f3, #0d6efd);
                                               border: none;
                                               box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
                                               transition: 0.3s;">
                                    <i class="bi bi-person-plus me-2"></i>S'inscrire comme tuteur
                                </button>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <p class="text-muted small">Vous avez déjà un compte ? <a href="#" style="color: #0d6efd; text-decoration: none;">Connectez-vous</a></p>
                            </div>

                        </div>

                    </form>

                    <script>
                        function togglePassword(inputId) {
                            const input = document.getElementById(inputId);
                            const button = input.nextElementSibling.querySelector('i');

                            if (input.type === 'password') {
                                input.type = 'text';
                                button.classList.remove('bi-eye');
                                button.classList.add('bi-eye-slash');
                            } else {
                                input.type = 'password';
                                button.classList.remove('bi-eye-slash');
                                button.classList.add('bi-eye');
                            }
                        }

                        function validateForm(event) {
                            event.preventDefault();

                            const password = document.getElementById('password').value;
                            const confirmPassword = document.getElementById('confirmPassword').value;

                            if (password !== confirmPassword) {
                                alert('Les mots de passe ne correspondent pas.');
                                return false;
                            }

                            if (password.length < 8) {
                                alert('Le mot de passe doit contenir au moins 8 caractères.');
                                return false;
                            }

                            // Ici, vous pouvez ajouter l'envoi des données à votre backend
                            alert('Formulaire soumis avec succès!');
                            // document.getElementById('inscriptionForm').submit();
                        }

                        // Attacher la fonction de validation au formulaire
                        document.getElementById('inscriptionForm').addEventListener('submit', validateForm);
                    </script>

                </div>
                <br><br><br>
            </div>

        </div>


    </div>

</section>


<style>
.inscription-section {
    position: relative;
    padding: 5rem 0;
    overflow: hidden;
    background: #f8fafc;
}

.background-image-wrapper {
    width: 100%;
    height: 100%;
}

.object-fit-cover {
    object-fit: cover;
}

/* Effets de transparence et flou */
.inscription-form {
    transition: all 0.3s ease;
}

.inscription-form:hover {
    backdrop-filter: blur(8px);
    box-shadow: 0 12px 32px rgba(0, 123, 255, 0.2) !important;
}

/* Styles pour les inputs */
.form-control {
    transition: all 0.3s ease;
}

.form-control:focus {
    background-color: rgba(255, 255, 255, 0.9) !important;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.2) !important;
}

/* Responsive design */
@media (max-width: 991.98px) {
    .inscription-section {
        padding: 3rem 0;
    }

    /* Sur mobile, le formulaire prend toute la largeur */
    .col-lg-6.offset-lg-6 {
        margin-left: 0 !important;
    }

    /* L'image n'apparaît pas sur mobile */
    .d-none.d-lg-block {
        display: none !important;
    }

    /* Supprimer le flou sur mobile pour meilleure lisibilité */
    .inscription-form {
        backdrop-filter: none !important;
        background: linear-gradient(135deg, rgba(227, 242, 253, 0.9), rgba(255, 255, 255, 0.95)) !important;
    }
}

@media (max-width: 767.98px) {
    .inscription-form {
        padding: 2rem !important;
        margin: 0 1rem;
    }
}

/* Animation pour le bouton */
.btn-primary {
    transition: all 0.3s ease !important;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(13, 110, 253, 0.4) !important;
}
</style>
@endsection
