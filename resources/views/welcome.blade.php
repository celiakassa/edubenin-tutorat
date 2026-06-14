@extends('layouts.welcomeLayout')

@section('content')
    <!-- Hero Section -->
    <style>
        /* Hero */
        .kp-hero {
            padding-top: 44px;   /* espace sous la navbar */
            padding-bottom: 32px;   /* collé aux stats */
            background: linear-gradient(180deg, var(--kp-blue-soft), #ffffff 55%);
            overflow: hidden;
        }
        .kp-hero__grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: center;
        }
        .kp-hero__content { order: 0; }     /* texte d'abord */
        .kp-hero__media   { order: 1; }
        .kp-hero .kp-display { color: var(--kp-blue); }   /* titre « Kopiao » en bleu de marque */
        .kp-hero__subtitle {
            color: var(--kp-blue);
            font-family: var(--kp-font-title);
            font-weight: 700;
            font-size: clamp(2rem, 1.4rem + 2.8vw, 3.2rem);
            line-height: 1.1;
            margin: 0 0 1.5rem;
        }

        /* Barre de recherche : pill propre, sans bordures internes */
        .kp-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--kp-white);
            border: 2px solid var(--kp-yellow);
            border-radius: var(--kp-radius-pill);
            padding: 6px 6px 6px 18px;
            box-shadow: var(--kp-shadow-sm);
        }
        .kp-search__icon { color: var(--kp-yellow); font-size: 1.1rem; flex: 0 0 auto; }
        .kp-search__input {
            flex: 1 1 auto;
            min-width: 0;
            border: none;
            outline: none;
            background: transparent;
            font-size: 15px;
            color: var(--kp-text);
            padding: 10px 4px;
        }
        .kp-search__input::placeholder { color: var(--kp-muted); }
        .kp-search__btn { flex: 0 0 auto; }

        /* Image + badges */
        .kp-hero__image-wrap { position: relative; }
        .kp-hero__image {
            width: 100%;
            height: auto;
            border-radius: var(--kp-radius);
            box-shadow: var(--kp-shadow-lg);
            display: block;
        }
        .kp-hero__badges {
            position: absolute;
            left: 16px;
            bottom: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .kp-hero__badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--kp-white);
            border-radius: var(--kp-radius-pill);
            padding: 8px 16px 8px 8px;
            box-shadow: var(--kp-shadow);
        }
        .kp-hero__badge-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--kp-yellow);    /* cercle jaune */
            color: #1a1a1a;                  /* icône foncée */
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            flex: 0 0 auto;
        }
        .kp-hero__badge-text { display: flex; flex-direction: column; line-height: 1.15; white-space: nowrap; }
        .kp-hero__badge-text strong { color: var(--kp-ink); font-size: .95rem; font-weight: 700; }
        .kp-hero__badge-text small  { color: var(--kp-muted); font-size: .75rem; }

        /* ===== STATS — juste après la hero, informatives, sans hover ===== */
        .kp-stats { padding: 0 0 var(--kp-section-py); background: #fff; }   /* haut collé à la hero */
        .kp-stats__grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .kp-stat {
            background: var(--kp-surface);
            border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius);
            padding: 22px 16px;
            text-align: center;
        }
        .kp-stat__number {
            color: var(--kp-blue);
            font-family: var(--kp-font-title);
            font-weight: 700;
            font-size: clamp(1.4rem, 1.1rem + 1vw, 1.875rem);
            margin: 0 0 4px;
            line-height: 1;
        }
        .kp-stat__label { color: var(--kp-muted); font-size: .875rem; margin: 0; }

        /* ----- Tablette (≤991px) : une colonne, TEXTE avant image ----- */
        @media (max-width: 991px) {
            .kp-hero { padding-top: 32px; padding-bottom: 40px; }
            .kp-hero__grid { grid-template-columns: 1fr; gap: 28px; }
            .kp-hero__content { order: 0; text-align: center; }
            .kp-hero__media   { order: 1; }
            .kp-hero__search  { max-width: 560px; margin-inline: auto; }
            .kp-hero__image   { max-width: 520px; margin: 0 auto; }
        }

        /* ----- Mobile (≤575px) : sous-titre (en titre) → image → recherche ; « Kopiao » masqué ----- */
        @media (max-width: 575px) {
            .kp-hero { padding-top: 44px; }
            /* on aplatit les 2 colonnes pour ordonner librement les éléments */
            .kp-hero__content,
            .kp-hero__media { display: contents; }
            .kp-hero .kp-display { display: none; }   /* « Kopiao » masqué en mobile */
            .kp-hero__subtitle {
                order: 0;
                font-size: clamp(1.8rem, 1.3rem + 3.5vw, 2.4rem);   /* devient le titre */
                font-weight: 500;
                line-height: 1.1;
                margin: 0;
                text-align: center;
            }
            .kp-hero__image-wrap { order: 1; }
            .kp-hero__search { order: 2; }
            .kp-search { flex-wrap: wrap; border-radius: 18px; padding: 8px 8px 8px 16px; }
            .kp-search__btn { width: 100%; }
            /* badges chevauchant le bas de l'image */
            .kp-hero__badges {
                left: 50%;
                bottom: -18px;
                transform: translateX(-50%);
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
                max-width: 92%;
            }
            .kp-stats__grid { gap: 10px; }
            .kp-stat { padding: 16px 8px; }
        }
    </style>

    <section class="kp-hero">
        <div class="container">
            <div class="kp-hero__grid">
                <!-- Texte -->
                <div class="kp-hero__content">
                    <h1 class="kp-hero__subtitle">Trouvez le tuteur idéal pour réussir vos études</h1>

                    <form action="{{ route('recherche.tuteur') }}" method="GET" class="kp-hero__search">
                        <div class="kp-search">
                            <i class="bi bi-search kp-search__icon"></i>
                            <input type="text" name="search" class="kp-search__input"
                                placeholder="Rechercher un tuteur, une matière, une ville..."
                                value="{{ $searchQuery }}">
                            <button type="submit" class="kp-btn kp-btn--accent kp-search__btn">
                                <i class="bi bi-search"></i> Rechercher
                            </button>
                        </div>

                        @if ($searchQuery || $selectedSubject || $selectedCity || $selectedPreference || $selectedPriceRange)
                            <div class="mt-3 text-center text-lg-start">
                                <a href="{{ route('home') }}" class="kp-btn kp-btn--ghost kp-btn--sm">
                                    <i class="bi bi-x-circle"></i> Effacer les filtres
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Image -->
                <div class="kp-hero__media">
                    <div class="kp-hero__image-wrap">
                        <img src="{{ asset('images/image_1.webp') }}" alt="Kopiao - Trouvez votre tuteur"
                            class="kp-hero__image">
                        <div class="kp-hero__badges">
                            <div class="kp-hero__badge">
                                <span class="kp-hero__badge-icon"><i class="bi bi-person-check"></i></span>
                                <span class="kp-hero__badge-text">
                                    <strong>{{ $totalTutors }}+</strong>
                                    <small>Tuteurs actifs</small>
                                </span>
                            </div>
                            <div class="kp-hero__badge">
                                <span class="kp-hero__badge-icon"><i class="bi bi-book"></i></span>
                                <span class="kp-hero__badge-text">
                                    <strong>{{ count($allSubjects) }}+</strong>
                                    <small>Matières</small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistiques (déplacées juste après la hero — informatives, sans hover) -->
    <section class="kp-stats">
        <div class="container">
            <div class="kp-stats__grid">
                <div class="kp-stat">
                    <p class="kp-stat__number">{{ $totalTutors }}+</p>
                    <p class="kp-stat__label">Tuteurs certifiés</p>
                </div>
                <div class="kp-stat">
                    <p class="kp-stat__number">{{ count($allCities) }}+</p>
                    <p class="kp-stat__label">Villes disponibles</p>
                </div>
                <div class="kp-stat">
                    <p class="kp-stat__number">{{ count($allSubjects) }}+</p>
                    <p class="kp-stat__label">Matières enseignées</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Rejoindre (cartes d'inscription) -->
    <style>
        .kp-cards-section { padding: var(--kp-section-py) 0; background: var(--kp-blue); border-radius: 40px 40px 0 0; }
        .kp-cards-section .kp-title { color: var(--kp-white); }
        .kp-cards-section .kp-lead { color: rgba(255, 255, 255, .85); }
        .kp-section-head { text-align: center; max-width: 640px; margin: 0 auto 36px; }
        .kp-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            align-items: stretch;
        }
        .kp-rcard {
            display: flex;
            flex-direction: column;
            background: var(--kp-white);
            border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius);
            padding: 32px 28px;
            box-shadow: var(--kp-shadow-sm);
            transition: var(--kp-transition);
        }
        /* hover UNIQUE et identique pour les 3 cartes */
        .kp-rcard:hover {
            transform: translateY(-6px);
            box-shadow: var(--kp-shadow-lg);
            border-color: color-mix(in srgb, var(--kp-blue), transparent 70%);
        }
        .kp-rcard__icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: color-mix(in srgb, var(--kp-yellow), white 82%);
            color: var(--kp-yellow);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            margin-bottom: 20px;
        }
        .kp-rcard .kp-subtitle { color: #1a1a1a; }
        .kp-rcard p { flex: 1 1 auto; }          /* pousse le bouton en bas → boutons alignés */
        .kp-rcard .kp-btn { margin-top: 18px; }

        @media (max-width: 991px) {
            .kp-cards-grid { grid-template-columns: 1fr; max-width: 460px; margin: 0 auto; }
        }
    </style>

    <section class="kp-cards-section">
        <div class="container">
            <div class="kp-section-head">
                <h2 class="kp-title">Rejoignez Kopiao</h2>
                <p class="kp-lead kp-muted kp-mb-0">Tuteur ou apprenant, trouvez votre place en quelques clics.</p>
            </div>

            <div class="kp-cards-grid">
                <!-- Carte Tuteur -->
                <div class="kp-rcard">
                    <div class="kp-rcard__icon"><i class="bi bi-person-workspace"></i></div>
                    <h3 class="kp-subtitle">Devenir Tuteur</h3>
                    <p class="kp-text kp-muted">
                        Partagez votre expertise et enseignez à des apprenants du monde entier.
                        Rejoignez notre communauté de tuteurs certifiés.
                    </p>
                    <a href="{{ route('register.tuteur') }}" class="kp-btn kp-btn--primary kp-btn--block">
                        S'inscrire comme Tuteur
                    </a>
                </div>

                <!-- Carte Consulter les Tuteurs -->
                <div class="kp-rcard">
                    <div class="kp-rcard__icon"><i class="bi bi-search-heart"></i></div>
                    <h3 class="kp-subtitle">Consulter les Tuteurs</h3>
                    <p class="kp-text kp-muted">
                        Parcourez notre liste de tuteurs qualifiés et trouvez celui qui correspond à vos besoins.
                    </p>
                    <a href="{{ route('recherche.tuteur') }}" class="kp-btn kp-btn--primary kp-btn--block">
                        <i class="bi bi-eye"></i> Voir tous les tuteurs
                    </a>
                </div>

                <!-- Carte Apprenant -->
                <div class="kp-rcard">
                    <div class="kp-rcard__icon"><i class="bi bi-mortarboard"></i></div>
                    <h3 class="kp-subtitle">Devenir Apprenant</h3>
                    <p class="kp-text kp-muted">
                        Trouvez le tuteur idéal pour atteindre vos objectifs académiques.
                        Apprenez à votre rythme avec des professionnels qualifiés.
                    </p>
                    <a href="{{ route('register') }}" class="kp-btn kp-btn--primary kp-btn--block">
                        S'inscrire comme Apprenant
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Matières Section -->
    <section id="subjects" class="subjects-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="kp-title">Explorez les matières</h2>
                <p class="kp-lead kp-muted">Découvrez les {{ count($allSubjects) }} matières enseignées par nos tuteurs certifiés</p>
                <div class="divider mx-auto"></div>
            </div>

            <div class="subjects-frame">
            <!-- Conteneur des matières avec navigation -->
            <div class="subjects-carousel-container position-relative">
                <!-- Bouton précédent -->
                <button class="carousel-nav-btn prev-btn" id="prevSubjects" aria-label="Matières précédentes">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <!-- Grille des matières -->
                <div class="subjects-grid-wrapper overflow-hidden">
                    <div class="subjects-grid" id="subjectsGrid">
                        @foreach ($allSubjects as $index => $subject)
                            <div class="subject-card-wrapper" data-index="{{ $index }}">
                                <div class="subject-card">
                                    <div class="card-inner">
                                        <div class="subject-icon-wrapper">
                                            <div class="subject-icon">
                                                @php
                                                    $iconMap = [
                                                        'Math' => 'bi-calculator',
                                                        'Mathématiques' => 'bi-calculator',
                                                        'Mathematics' => 'bi-calculator',
                                                        'Français' => 'bi-chat-quote',
                                                        'French' => 'bi-chat-quote',
                                                        'Anglais' => 'bi-chat',
                                                        'English' => 'bi-chat',
                                                        'Physique' => 'bi-flask',
                                                        'Physics' => 'bi-flask',
                                                        'Chimie' => 'bi-flask',
                                                        'Chemistry' => 'bi-flask',
                                                        'Biologie' => 'bi-tree',
                                                        'Biology' => 'bi-tree',
                                                        'SVT' => 'bi-tree',
                                                        'Histoire' => 'bi-clock-history',
                                                        'History' => 'bi-clock-history',
                                                        'Géographie' => 'bi-map',
                                                        'Geography' => 'bi-map',
                                                        'Philosophie' => 'bi-pencil',
                                                        'Philosophy' => 'bi-pencil',
                                                        'Économie' => 'bi-graph-up',
                                                        'Economics' => 'bi-graph-up',
                                                        'Management' => 'bi-briefcase',
                                                        'Informatique' => 'bi-laptop',
                                                        'Computer' => 'bi-laptop',
                                                        'Programmation' => 'bi-code-slash',
                                                        'Programming' => 'bi-code-slash',
                                                        'Musique' => 'bi-music-note',
                                                        'Music' => 'bi-music-note',
                                                        'Arts' => 'bi-brush',
                                                        'Art' => 'bi-brush',
                                                        'Sport' => 'bi-trophy',
                                                        'Droit' => 'bi-bank',
                                                        'Law' => 'bi-bank',
                                                        'Médecine' => 'bi-heart-pulse',
                                                        'Medicine' => 'bi-heart-pulse',
                                                        'Comptabilité' => 'bi-calculator',
                                                        'Accounting' => 'bi-calculator',
                                                        'Marketing' => 'bi-megaphone',
                                                        'Communication' => 'bi-chat-dots',
                                                        'Langues' => 'bi-translate',
                                                        'Languages' => 'bi-translate',
                                                    ];

                                                    $icon = 'bi-book';
                                                    foreach ($iconMap as $key => $value) {
                                                        if (str_contains(strtolower($subject), strtolower($key))) {
                                                            $icon = $value;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                <i class="bi {{ $icon }}"></i>
                                            </div>
                                        </div>

                                        <h3 class="subject-title">{{ $subject }}</h3>

                                        @php
                                            // Récupérer le nombre de tuteurs pour cette matière via la table pivot
                                            $tutorCount = \App\Models\User::where('role_id', 3)
                                                ->where('is_valid', 1)
                                                ->where('is_active', 1)
                                                ->whereHas('subjects', function ($query) use ($subject) {
                                                    $query->where('nom', $subject);
                                                })
                                                ->count();
                                        @endphp

                                        <div class="subject-stats">
                                            <span class="tutor-count">{{ $tutorCount }}</span>
                                            <span class="tutor-label">tuteur(s) disponible(s)</span>
                                        </div>

                                        <a href="{{ route('recherche.tuteur', ['subject' => $subject]) }}"
                                            class="subject-link">
                                            <span>Voir les tuteurs</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>

                                        <div class="card-glow"></div>
                                        <div class="card-particles"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Bouton suivant -->
                <button class="carousel-nav-btn next-btn" id="nextSubjects" aria-label="Matières suivantes">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <!-- Lien voir toutes les matières -->
            @if (count($allSubjects) > 8)
                <div class="text-center mt-3">
                    <a href="{{ route('recherche.tuteur') }}" class="kp-btn kp-btn--cta">
                        Explorer toutes les matières
                    </a>
                </div>
            @endif
            </div>
        </div>
    </section>

    <!-- Opportunités (visible s'il y a des annonces) -->
    @if ($annonces->count() > 0)
    <section id="annonces" class="annonces-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="kp-title">Opportunités d'enseignement</h2>
                <p class="kp-lead kp-muted">Découvrez les {{ $annonces->count() }} annonces publiées par nos étudiants</p>
                <div class="divider mx-auto"></div>
            </div>
            {{-- filtres déplacés sur la page Opportunités --}}

            <!-- Carousel des annonces -->
            <div class="annonces-carousel-container position-relative">
                <button class="carousel-nav-btn prev-btn" id="prevAnnonce" aria-label="Annonce précédente"
                    style="background: white; color: var(--kp-blue); border: 2px solid var(--kp-blue);">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="annonces-carousel-wrapper overflow-hidden">
                    <div class="annonces-carousel" id="annoncesCarousel">
                        @foreach ($annonces as $annonce)
                            <div class="annonce-card-wrapper">
                                <div class="annonce-card">
                                    <!-- En-tête : domaine + budget -->
                                    <div class="annonce-head">
                                        <h3 class="annonce-domaine">{{ $annonce->domaine }}</h3>
                                        <div class="annonce-budget">
                                            <span class="annonce-budget__amount">{{ number_format($annonce->budget, 0, ',', ' ') }}</span>
                                            <span class="annonce-budget__cur">FCFA</span>
                                        </div>
                                    </div>

                                    <!-- Étudiant -->
                                    <div class="annonce-student">
                                        <div class="annonce-avatar">
                                            @if ($annonce->student->photo_path)
                                                <img src="{{ asset('storage/' . $annonce->student->photo_path) }}"
                                                    alt="{{ $annonce->student->firstname }}">
                                            @else
                                                <i class="bi bi-person-circle"></i>
                                            @endif
                                        </div>
                                        <div class="annonce-student__info">
                                            <span class="annonce-student__name">{{ $annonce->student->firstname }}</span>
                                            <span class="annonce-student__date">Publiée {{ $annonce->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <p class="annonce-desc">{{ Str::limit($annonce->description, 120) }}</p>

                                    <!-- Disponibilité -->
                                    @if ($annonce->disponibilite)
                                        <div class="annonce-tag">
                                            <i class="bi bi-calendar-check"></i>
                                            <span>{{ Str::limit($annonce->disponibilite, 50) }}</span>
                                        </div>
                                    @endif

                                    <!-- CTA -->
                                    <div class="card-footer mt-auto">
                                        <a href="{{ route('login') }}"
                                            class="kp-btn kp-btn--primary kp-btn--block"
                                            onclick="event.preventDefault(); showLoginMessage();">
                                            <i class="bi bi-send"></i>
                                            Postuler
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="carousel-nav-btn next-btn" id="nextAnnonce" aria-label="Annonce suivante"
                    style="background: white; color: var(--kp-blue); border: 2px solid var(--kp-blue);">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <div class="subjects-dots" id="annoncesDots"></div>

        </div>
    </section>
    @endif

    <!-- Top Tutors Section -->
    <!-- Tuteurs récents (visible s'il y en a) -->
    @if ($recentTutors->count() > 0)
    <section id="tutors" class="tutors-gallery section">
        <div class="container section-header text-center mb-5">
            <h2 class="kp-title">Tuteurs récemment inscrits</h2>
            <p class="kp-lead kp-muted">Découvrez les derniers professeurs à avoir rejoint Kopiao</p>
            <div class="divider mx-auto"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center g-4">
                @foreach ($recentTutors->take(6) as $tutor)
                    <div class="col-lg-4 col-md-6">
                        <div class="tutor-card">
                            <div class="tutor-card__media">
                                @if ($tutor->role_id == 3 && $tutor->is_valid == 1)
                                    <span class="tutor-card__badge"><i class="bi bi-patch-check-fill"></i> Vérifié</span>
                                @endif
                                <span class="tutor-card__avatar">
                                    <img src="{{ $tutor->photo_path ? asset('storage/' . $tutor->photo_path) : asset('images/profill_default.webp') }}"
                                        alt="{{ $tutor->firstname }}">
                                </span>
                            </div>
                            <div class="tutor-card__body">
                                <h4 class="tutor-card__name">{{ $tutor->firstname }} {{ $tutor->lastname }}</h4>
                                @php $subjects = $tutor->subjects->pluck('nom')->toArray(); @endphp
                                <p class="tutor-card__subjects">
                                    @if (!empty($subjects))
                                        {{ implode(', ', array_slice($subjects, 0, 2)) }}@if (count($subjects) > 2) <span class="tutor-card__more">+{{ count($subjects) - 2 }}</span>@endif
                                    @else
                                        Spécialité non précisée
                                    @endif
                                </p>
                                <p class="tutor-card__loc"><i class="bi bi-geo-alt"></i> {{ $tutor->city ?? 'Ville non précisée' }}</p>
                                <button class="kp-btn kp-btn--on-blue kp-btn--sm kp-btn--block tutor-card__btn"
                                    data-bs-toggle="modal" data-bs-target="#tutorModal{{ $tutor->id }}">
                                    <i class="bi bi-eye"></i> Voir le profil
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Voir plus -->
        <div class="text-center mt-4">
            <a href="{{ route('recherche.tuteur') }}" class="kp-btn kp-btn--cta">
                Voir tous les tuteurs
            </a>
        </div>
    </section>
    @endif

    <!-- Modals pour chaque tuteur -->
    @foreach ($recentTutors as $tutor)
        <div class="modal fade kp-modal" id="tutorModal{{ $tutor->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button type="button" class="kp-modal__close" data-bs-dismiss="modal" aria-label="Fermer">
                        <i class="bi bi-x-lg"></i>
                    </button>
                    <div class="modal-body p-0">
                        <div class="kp-tutor">
                            <div class="kp-tutor__top">
                                <span class="kp-tutor__avatar">
                                    <img src="{{ $tutor->photo_path ? asset('storage/' . $tutor->photo_path) : asset('images/profill_default.webp') }}"
                                        alt="{{ $tutor->firstname }}">
                                </span>
                                <div>
                                    <h3 class="kp-tutor__name">
                                        {{ $tutor->firstname }} {{ $tutor->lastname }}
                                        @if ($tutor->role_id == 3 && $tutor->is_valid == 1)
                                            <i class="bi bi-patch-check-fill kp-tutor__verified" title="Tuteur vérifié"></i>
                                        @endif
                                    </h3>
                                    <p class="kp-tutor__loc"><i class="bi bi-geo-alt"></i> {{ $tutor->city ?? 'Ville non précisée' }}</p>
                                </div>
                            </div>

                            <div class="kp-tutor__meta">
                                <span class="kp-tutor__meta-item"><i class="bi bi-cash-coin"></i> {{ $tutor->rate_per_hour ? number_format($tutor->rate_per_hour, 0, ',', ' ') . ' FCFA / h' : 'Tarif non défini' }}</span>
                                <span class="kp-tutor__meta-item"><i class="bi bi-whatsapp"></i> {{ $tutor->telephone ?? 'Non disponible' }}</span>
                            </div>

                            @php $subjects = $tutor->subjects->pluck('nom')->toArray(); @endphp
                            <div class="kp-tutor__section">
                                <h6>Spécialités</h6>
                                <div class="kp-tutor__tags">
                                    @forelse ($subjects as $subject)
                                        <span class="kp-tag">{{ $subject }}</span>
                                    @empty
                                        <span class="kp-tutor__bio">Aucune spécialité renseignée</span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="kp-tutor__section">
                                <h6>À propos</h6>
                                <p class="kp-tutor__bio">{{ $tutor->bio ?? 'Pas encore de biographie disponible.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Section CTA Annonces -->
    <section id="annonces-cta" class="annonces-cta-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="kp-title" style="color: #fff;">Trouvez un tuteur ou proposez vos compétences</h2>
                <p class="kp-lead" style="color: rgba(255, 255, 255, .8);">Rejoignez notre communauté et donnez un coup d'accélérateur à votre apprentissage</p>
                <div class="divider mx-auto"></div>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Carte Publier une annonce -->
                <div class="col-lg-6 col-md-6">
                    <div class="rs-card rs-card--blue">
                        <div class="rs-card__media">
                            <img src="{{ asset('images/image_5.webp') }}" alt="Étudiant">
                        </div>
                        <h3 class="rs-card__title">Vous cherchez un tuteur ?</h3>
                        <p class="rs-card__text">
                            Publiez une annonce gratuite et trouvez le tuteur idéal pour vos besoins spécifiques.
                        </p>
                        @auth
                            @if (Auth::user()->role_id == 2)
                                <a href="{{ route('annonces.create') }}" class="kp-btn kp-btn--on-blue">
                                    <i class="bi bi-plus-circle"></i> Publier une annonce
                                </a>
                            @else
                                <button onclick="showRoleMessage('publier')" class="kp-btn kp-btn--on-blue">
                                    <i class="bi bi-plus-circle"></i> Publier une annonce
                                </button>
                            @endif
                        @else
                            <button onclick="showLoginMessage('publier')" class="kp-btn kp-btn--on-blue">
                                <i class="bi bi-plus-circle"></i> Publier une annonce
                            </button>
                        @endauth
                    </div>
                </div>

                <!-- Carte Consulter les annonces -->
                <div class="col-lg-6 col-md-6">
                    <div class="rs-card rs-card--white">
                        <div class="rs-card__media">
                            <img src="{{ asset('images/image_6.webp') }}" alt="Tuteur">
                        </div>
                        <h3 class="rs-card__title">Vous êtes tuteur ?</h3>
                        <p class="rs-card__text">
                            Consultez les annonces publiées par les apprenants et trouvez des missions qui correspondent à vos compétences.
                        </p>
                        @auth
                            @if (Auth::user()->role_id == 3)
                                <a href="{{ route('annonces.index') }}#annonces" class="kp-btn kp-btn--primary">
                                    <i class="bi bi-eye"></i> Postuler à des annonces
                                </a>
                            @else
                                <button onclick="showRoleMessage('consulter')" class="kp-btn kp-btn--primary">
                                    <i class="bi bi-eye"></i> Postuler à des annonces
                                </button>
                            @endif
                        @else
                            <button onclick="showLoginMessage('consulter')" class="kp-btn kp-btn--primary">
                                <i class="bi bi-eye"></i> Postuler à des annonces
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="inscription" class="inscription-section">
        <div class="container">
            <div class="row align-items-center position-relative">
                <!-- Image en arrière-plan -->
                <div class="col-lg-12 position-absolute start-0 top-0 w-100 h-100 d-none d-lg-block" style="z-index: 1;">
                    <div class="background-image-wrapper overflow-hidden">
                        <img src="{{ asset('images/tuteur.jpg') }}" class="img-fluid w-100 h-100 object-fit-cover"
                            alt="Devenir tuteur">
                    </div>
                </div>

                <!-- Formulaire d'inscription simplifié -->
                <div class="col-lg-6 offset-lg-6" style="z-index: 2; position: relative;">
                    <br><br><br>
                    <div class="inscription-form rounded-4 overflow-hidden"
                        style="box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15); border: 1px solid rgba(0, 0, 0, 0.1);">
                        <!-- En-tête bleu -->
                        <div class="form-header text-white text-center py-4"
                            style="background: linear-gradient(135deg, var(--kp-blue), var(--kp-blue-dark));">
                            <h2 class="fw-bold mb-2" style="font-size: clamp(1.5rem, 1.2rem + 2vw, 2.2rem); color:white;">Devenir Tuteur</h2>
                            <p style="font-size: 1.1rem; opacity: 0.9;">Rejoignez notre communauté d'enseignants</p>
                        </div>

                        <!-- Contenu du formulaire -->
                        <div class="form-content p-4 p-lg-5" style="background: rgba(255, 255, 255, 0.95);">
                            <!-- Formulaire simplifié - Étape 1: Email -->
                            <form id="inscriptionFormStep1">
                                @csrf
                                <input type="hidden" name="role_id" value="3">

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold" style="color: var(--kp-text);">Email</label>
                                    <div class="kp-field-group">
                                        <span class="kp-field-icon"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" id="email" class="kp-field"
                                            placeholder="exemple@email.com" required>
                                    </div>
                                </div>

                                <!-- Bouton continuer -->
                                <div class="d-grid mt-4">
                                    <button type="submit" class="kp-btn kp-btn--accent kp-btn--lg kp-btn--block">
                                        <i class="bi bi-check-circle"></i> Continuer
                                    </button>
                                </div>

                                <!-- Lien connexion -->
                                <div class="text-center mt-4 pt-3" style="border-top: 1px solid var(--kp-border);">
                                    <p class="text-muted mb-0" style="font-size: 0.95rem;">
                                        Déjà inscrit ?
                                        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none"
                                            style="color: var(--kp-blue);">
                                            Se connecter
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br><br><br>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4 p-md-5">
                    <!-- Icône de succès -->
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>

                    <!-- Titre -->
                    <h3 class="fw-bold mb-3" style="color: var(--kp-blue);">Email enregistré avec succès !</h3>

                    <!-- Message -->
                    <p class="text-muted mb-4" style="font-size: 1.1rem;">
                        Nous avons bien récupéré votre email <strong id="userEmail"></strong>.
                        Cliquez sur "Finaliser l'inscription" pour compléter votre profil.
                    </p>

                    <!-- Boutons -->
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <!-- Bouton pour finaliser l'inscription -->
                        <form id="inscriptionFinalForm" method="GET" action="{{ route('register.tuteur') }}">
                            @csrf
                            <input type="hidden" name="email" id="finalEmail" value="">
                            <input type="hidden" name="role_id" value="3">
                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2 fw-bold"
                                style="background: linear-gradient(135deg, var(--kp-blue), var(--kp-blue-dark));
                                       border: none;
                                       border-radius: 50px;">
                                <i class="bi bi-person-plus me-2"></i>Finaliser l'inscription
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message de connexion pour les annonces -->
    <div class="modal fade" id="loginMessageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="modal-icon mb-4 mx-auto d-flex align-items-center justify-content-center rounded-circle"
                        style="width: 80px; height: 80px; background: var(--kp-blue);">
                        <i class="bi bi-person-lock" style="font-size: 2.5rem; color: white;"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: #333;">Connexion requise</h4>
                    <p class="text-muted mb-4">
                        Pour postuler à une annonce, vous devez être connecté en tant que tuteur.
                        Connectez-vous ou créez un compte tuteur pour continuer.
                    </p>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="{{ route('login') }}" class="btn px-4 py-2"
                            style="background: var(--kp-blue); color: white; border-radius: 8px; text-decoration: none;">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </a>
                        <a href="{{ route('register.tuteur') }}" class="btn px-4 py-2"
                            style="background: white; color: var(--kp-blue); border: 2px solid var(--kp-blue); border-radius: 8px; text-decoration: none;">
                            <i class="bi bi-person-plus me-2"></i>Devenir tuteur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal : connexion requise (ouvert par « Postuler ») -->
    <div class="modal fade kp-modal" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center px-4 pb-4 pt-0">
                    <div class="kp-modal__icon"><i class="bi bi-person-lock"></i></div>
                    <h3 class="kp-modal__title">Connexion requise</h3>
                    <p class="kp-modal__text" id="modalMessage"></p>
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                        <a href="{{ route('login') }}" class="kp-btn kp-btn--primary">Se connecter</a>
                        <a href="{{ route('register') }}" class="kp-btn kp-btn--secondary">S'inscrire</a>
                    </div>
                    <div class="kp-modal__foot">
                        Vous êtes tuteur ?
                        <a href="{{ route('register.tuteur') }}">Créer un compte tuteur</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="modal-icon mb-4 mx-auto d-flex align-items-center justify-content-center rounded-circle"
                        style="width: 90px; height: 90px; background: #FFA500;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem; color: white;"></i>
                    </div>
                    <h3 class="fw-bold mb-3" style="color: #333;">Action non autorisée</h3>
                    <p class="text-muted mb-4" id="roleModalMessage"></p>
                    <div class="d-flex flex-column gap-3">
                        @auth
                            <p class="mb-0">Vous êtes connecté en tant que
                                <strong>
                                    @if (Auth::user()->role_id == 2)
                                        Apprenant
                                    @elseif(Auth::user()->role_id == 3)
                                        Tuteur
                                    @else
                                        Administrateur
                                    @endif
                                </strong>
                            </p>
                        @endauth
                        <a href="{{ route('home') }}" class="btn px-4 py-2"
                            style="background: var(--kp-blue); color: white; border-radius: 10px; text-decoration: none; font-weight: 500;">
                            <i class="bi bi-house me-2"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('styles')
    <style>
        /* ===== VARIABLES ===== */
        :root {
            --primary: var(--kp-blue);
            --primary-dark: var(--kp-blue-dark);
            --secondary: #00a36c;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --border-light: #e9ecef;
        }

        /* ===== HERO SECTION ===== */
        .hero {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            padding: 80px 0 150px 0;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--kp-blue), #0a58ca);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: #2c3e50;
            font-weight: 500;
        }

        /* ===== BARRE DE RECHERCHE ===== */
        .search-wrapper {
            background: white;
            border-radius: 60px;
            padding: 5px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search-wrapper:hover {
            box-shadow: 0 15px 40px rgba(13, 110, 253, 0.15);
            transform: translateY(-2px);
        }

        .input-group {
            border-radius: 60px;
            overflow: hidden;
        }

        .input-group-text {
            border: none;
            background: white;
            padding-left: 25px;
        }

        .input-group-text i {
            font-size: 1.3rem;
            color: var(--kp-blue);
        }

        .form-control {
            border: none;
            padding: 15px 0;
            font-size: 1.1rem;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-primary {
            border-radius: 50px;
            padding: 12px 30px;
            background: linear-gradient(135deg, var(--kp-blue), #0a58ca);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(13, 110, 253, 0.3);
        }

        /* ===== FILTRES ===== */
        .filter-select {
            border-radius: 30px;
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            background: white;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-select:hover {
            border-color: var(--kp-blue);
            background: #f8f9fa;
        }

        .filter-select:focus {
            border-color: var(--kp-blue);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        /* ===== STATISTIQUES ===== */
        .stat-item {
            text-align: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--kp-blue);
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
            font-weight: 500;
        }

        /* ===== IMAGE ET BADGES ===== */
        .hero-image-wrapper {
            position: relative;
            padding: 20px;
        }

        .hero-image {
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            transition: all 0.5s ease;
        }

        .hero-image:hover {
            transform: scale(1.02);
        }

        .floating-badges {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .badge-item {
            position: absolute;
            display: flex;
            align-items: center;
            background: white;
            padding: 12px 20px;
            border-radius: 60px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            pointer-events: auto;
            transition: all 0.3s ease;
        }

        .badge-item:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .badge-item:nth-child(1) {
            top: 10%;
            left: -5%;
            animation: float 3s ease-in-out infinite;
        }

        .badge-item:nth-child(2) {
            bottom: 15%;
            right: -5%;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .badge-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--kp-blue), #0a58ca);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .badge-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .badge-content {
            display: flex;
            flex-direction: column;
        }

        .badge-number {
            font-weight: 800;
            color: #2c3e50;
            font-size: 1.1rem;
            line-height: 1.2;
        }

        .badge-label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* ===== CARTES D'INSCRIPTION : voir .kp-cards-section / .kp-rcard
                 (ancien CSS hors-charte supprimé) ===== */

        /* ===== MATIÈRES SECTION ===== */
        .subjects-section {
            background: linear-gradient(135deg, #fafbfc 0%, #f5f7fa 100%);
            padding: var(--kp-section-py) 0;
            position: relative;
            overflow: hidden;
        }

        .subjects-section::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.03) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            animation: float 20s ease-in-out infinite;
        }

        .subjects-section::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.02) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            animation: float 15s ease-in-out infinite reverse;
        }

        .gradient-text {
            color: var(--kp-ink);
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .divider {
            width: 64px;
            height: 3px;
            background: var(--kp-yellow);
            border-radius: 3px;
            margin-top: 16px;
        }

        @keyframes dividerPulse {

            0%,
            100% {
                width: 80px;
                opacity: 1;
            }

            50% {
                width: 120px;
                opacity: 0.8;
            }
        }

        .subjects-carousel-container {
            position: relative;
            z-index: 1;
        }
        /* chevrons retirés — on navigue au glissement (drag/swipe) */
        .subjects-carousel-container .carousel-nav-btn { display: none; }

        /* Cadre englobant le carousel + le bouton « Explorer » */
        .subjects-frame {
            position: relative;
            padding: 24px 20px;
        }
        .subjects-frame::before {
            content: "";
            position: absolute;
            inset: 0;
            border: 1.5px solid #1a1a1a;   /* les traits (noir) */
            pointer-events: none;
        }
        /* 4 petits carrés jaunes aux coins */
        .subjects-frame::after {
            content: "";
            position: absolute;
            inset: -5px;
            pointer-events: none;
            background:
                linear-gradient(#1a1a1a, #1a1a1a) left top / 10px 10px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) right top / 10px 10px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) left bottom / 10px 10px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) right bottom / 10px 10px no-repeat;
        }

        /* Indicateurs (petits traits) du carousel matières */
        .subjects-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 22px;
        }
        .subjects-dots button {
            width: 26px;
            height: 5px;
            padding: 0;
            border: none;
            border-radius: 3px;
            background: var(--kp-border);
            cursor: pointer;
            transition: var(--kp-transition);
        }
        .subjects-dots button.active {
            background: var(--kp-yellow);
            width: 40px;
        }

        .subjects-grid-wrapper {
            overflow: hidden;
            border-radius: 30px;
            padding: 20px 10px;
        }

        .subjects-grid {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            cursor: grab;
            padding-bottom: 4px;
            -ms-overflow-style: none;
            scrollbar-width: none;          /* cacher la barre de la bande (Firefox) */
        }
        .subjects-grid::-webkit-scrollbar { display: none; }   /* Chrome/Safari/Edge */
        .subjects-grid.dragging {
            cursor: grabbing;
            scroll-behavior: auto;
            scroll-snap-type: none;
        }
        .subject-card-wrapper {
            flex: 0 0 calc((100% - 48px) / 3);   /* 3 cartes visibles (2 gaps de 24px) */
            scroll-snap-align: start;
        }
        @media (max-width: 991px) {
            .subject-card-wrapper { flex: 0 0 calc((100% - 24px) / 2); }   /* 2 visibles */
        }
        @media (max-width: 600px) {
            .subject-card-wrapper { flex: 0 0 86%; }                       /* ~1 visible */
        }

        .subject-card-wrapper {
            transition: all 0.3s ease;
        }

        .subject-card {
            background: var(--kp-white);
            border-radius: var(--kp-radius);
            padding: 30px 22px;
            box-shadow: var(--kp-shadow-sm);
            transition: var(--kp-transition);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border: 1px solid var(--kp-border);
        }

        .subject-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--kp-shadow-lg);
            border-color: color-mix(in srgb, var(--kp-blue), transparent 70%);
        }

        .subject-icon {
            width: 84px;
            height: 84px;
            background: color-mix(in srgb, var(--kp-yellow), white 82%);   /* jaune doux, même opacité */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;          /* cercle parfaitement centré */
            border: none;
        }

        .subject-icon i {
            font-size: 2.4rem;
            color: var(--kp-yellow);       /* icône en jaune */
        }
        /* pas de hover sur l'icône */

        .subject-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 15px;
            transition: all 0.3s ease;
        }

        .subject-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, var(--kp-blue), transparent);
            transition: all 0.3s ease;
        }

        .subject-card:hover .subject-title::after {
            width: 60px;
            background: var(--kp-blue);
        }

        /* texte simple, pas un bouton */
        .subject-stats {
            margin-bottom: 20px;
        }

        .tutor-count {
            font-weight: 700;
            color: var(--kp-blue);
            margin-right: 4px;
        }

        .tutor-label {
            font-size: 0.9rem;
            color: var(--kp-muted);
            font-weight: 500;
        }

        .subject-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--kp-blue);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 22px;
            border-radius: var(--kp-radius-pill);
            background: var(--kp-white);
            border: 1.5px solid var(--kp-blue);
            transition: var(--kp-transition);
            margin-top: auto;
        }

        .subject-link:hover {
            background: var(--kp-blue);
            color: var(--kp-white);
        }

        .subject-link i {
            transition: transform 0.3s ease;
        }

        .subject-link:hover i {
            transform: translateX(8px);
        }

        /* Boutons de navigation */
        .carousel-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--kp-white);
            color: var(--kp-blue);
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--kp-transition);
            z-index: 10;
            box-shadow: var(--kp-shadow);
            border: 1.5px solid var(--kp-blue);
        }

        .carousel-nav-btn:hover {
            background: var(--kp-blue);
            color: var(--kp-white);
            border-color: var(--kp-blue);
        }

        .carousel-nav-btn.prev-btn {
            left: -56px;        /* chevrons dans la marge, hors des cartes */
        }

        .carousel-nav-btn.next-btn {
            right: -56px;
        }

        /* En tablette/mobile : pas de place pour les chevrons → on glisse (drag/swipe) */
        @media (max-width: 991px) {
            .carousel-nav-btn { display: none !important; }
        }

        /* Indicateurs de page */
        .pagination-indicators {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .page-indicator {
            width: 45px;
            height: 6px;
            border-radius: 3px;
            background: #e9ecef;
            border: none;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .page-indicator::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--kp-blue);
            transform: translateX(-100%);
            transition: transform 0.4s ease;
        }

        .page-indicator.active {
            width: 60px;
        }

        .page-indicator.active::before {
            transform: translateX(0);
        }

        /* Bouton voir tout */
        .btn-view-all {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            background: var(--kp-blue);
            color: var(--kp-white);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            border-radius: var(--kp-radius-pill);
            box-shadow: var(--kp-shadow-sm);
            transition: var(--kp-transition);
            border: none;
        }

        .btn-view-all:hover {
            background: var(--kp-blue-dark);
            color: var(--kp-white);          /* texte blanc au hover */
            transform: translateY(-2px);
        }

        .btn-view-all i {
            transition: transform 0.3s ease;
        }

        .btn-view-all:hover i {
            transform: translateX(8px);
        }

        /* ===== ANNONCES SECTION ===== */
        .annonces-section {
            background: white;
            padding: var(--kp-section-py) 0;
            position: relative;
        }

        .filters-container {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 15px;
        }

        .filter-label {
            color: var(--kp-blue) !important;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 12px;
            color: #333;
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--kp-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 255, 0.1);
            outline: none;
        }

        .annonces-carousel-container {
            padding: 8px 0;        /* cartes pleine largeur */
            position: relative;
        }
        .annonces-carousel-container .carousel-nav-btn { display: none; }

        .annonces-carousel-wrapper {
            overflow: hidden;
            border-radius: 15px;
        }

        .annonces-carousel {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            cursor: grab;
            padding-bottom: 4px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .annonces-carousel::-webkit-scrollbar { display: none; }
        .annonces-carousel.dragging { cursor: grabbing; scroll-behavior: auto; scroll-snap-type: none; }

        .annonce-card-wrapper {
            flex: 0 0 calc((100% - 48px) / 3);   /* 3 visibles (2 gaps de 24px) */
            scroll-snap-align: start;
        }

        .annonce-card {
            padding: 24px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: var(--kp-transition);
            border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius);
            background: var(--kp-white);
            position: relative;
        }

        /* hover identique aux autres cartes */
        .annonce-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--kp-shadow-lg);
            border-color: color-mix(in srgb, var(--kp-blue), transparent 70%);
        }

        /* ----- Contenu de la carte annonce (présentation soignée) ----- */
        .annonce-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }
        .annonce-domaine {
            font-family: var(--kp-font-title);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--kp-ink);
            margin: 0;
            line-height: 1.3;
        }
        .annonce-budget { text-align: right; white-space: nowrap; }
        .annonce-budget__amount {
            display: block;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--kp-blue);
            line-height: 1;
        }
        .annonce-budget__cur { font-size: .72rem; color: var(--kp-muted); font-weight: 600; }

        .annonce-student {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 14px;
            margin-bottom: 14px;
            border-bottom: 1px solid var(--kp-border);
        }
        .annonce-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            overflow: hidden;
            flex: 0 0 auto;
            background: var(--kp-blue-soft);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .annonce-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .annonce-avatar i { font-size: 1.5rem; color: var(--kp-blue); }
        .annonce-student__info { display: flex; flex-direction: column; line-height: 1.2; min-width: 0; }
        .annonce-student__name { font-weight: 600; font-size: .9rem; color: var(--kp-text); }
        .annonce-student__date { font-size: .78rem; color: var(--kp-muted); }

        .annonce-desc {
            color: var(--kp-text);
            font-size: .92rem;
            line-height: 1.55;
            margin: 0 0 16px;
            flex: 1 1 auto;
        }

        .annonce-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            align-self: flex-start;
            background: var(--kp-surface);
            border: 1px solid var(--kp-border);
            border-radius: 10px;
            padding: 8px 12px;
            margin-bottom: 16px;
        }
        .annonce-tag i { color: var(--kp-blue); font-size: .95rem; }
        .annonce-tag span { font-size: .85rem; color: var(--kp-muted); }

        .card-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            background: var(--kp-blue);
            color: white;
        }

        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .carousel-indicator {
            width: 40px;
            height: 4px;
            border-radius: 2px;
            background: #e0e0e0;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
        }

        .carousel-indicator.active {
            background: var(--kp-blue);
            width: 60px;
        }

        /* ===== TUTEURS SECTION ===== */
        .tutors-gallery {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: var(--kp-section-py) 0;
        }

        .tutor-card {
            background: var(--kp-white);
            border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius);
            overflow: hidden;
            box-shadow: var(--kp-shadow-sm);
            transition: var(--kp-transition);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .tutor-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--kp-shadow-lg);
            border-color: color-mix(in srgb, var(--kp-blue), transparent 70%);
        }
        .tutor-card__media { position: relative; height: 88px; background: linear-gradient(135deg, var(--kp-blue-soft), #d8e7ff); }
        .tutor-card__avatar {
            position: absolute;
            left: 50%;
            bottom: -40px;
            transform: translateX(-50%);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--kp-white);
            background: var(--kp-white);
            box-shadow: var(--kp-shadow-sm);
        }
        .tutor-card__avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.4);
            transform-origin: center 28%;
        }
        .tutor-card__badge {
            position: absolute;
            top: 12px;
            left: 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--kp-blue);
            color: var(--kp-white);
            font-size: .78rem;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: var(--kp-radius-pill);
            box-shadow: var(--kp-shadow-sm);
        }
        .tutor-card__body { padding: 50px 16px 18px; display: flex; flex-direction: column; flex: 1 1 auto; background: var(--kp-blue); text-align: center; }
        .tutor-card__name { font-family: var(--kp-font-title); font-size: 1.05rem; font-weight: 700; color: var(--kp-white); margin: 0 0 4px; }
        .tutor-card__subjects { color: rgba(255, 255, 255, .85); font-size: .9rem; margin: 0 0 8px; line-height: 1.4; }
        .tutor-card__more { background: rgba(255, 255, 255, .22); color: var(--kp-white); padding: 1px 7px; border-radius: 10px; font-size: .75rem; font-weight: 600; }
        .tutor-card__loc { color: rgba(255, 255, 255, .8); font-size: .85rem; display: flex; align-items: center; justify-content: center; gap: 5px; margin: 0 0 16px; }
        .tutor-card__loc i { color: var(--kp-white); }
        .tutor-card__btn { margin-top: auto; }

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
            color: var(--kp-blue);
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

        .verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 50px;
            background: linear-gradient(135deg, #8ca728, #20c997);
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }

        /* ===== MODALS ===== */
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
            color: var(--kp-blue);
            font-size: 1.2rem;
        }

        .subjects-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
        }

        .subject-badge {
            background: linear-gradient(135deg, var(--kp-blue) 0%, #0a58ca 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* ===== CTA SECTION ===== */
        .annonces-cta-section {
            background: #14161c;   /* fond noir */
            padding: var(--kp-section-py) 0;
            position: relative;
            overflow: hidden;
        }

        /* Grille de carrés blancs en fond, qui s'efface vers les bords */
        .annonces-cta-section::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, .06) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, .06) 1px, transparent 1px);
            background-size: 46px 46px;
            -webkit-mask-image: radial-gradient(ellipse 75% 75% at 50% 45%, #000 25%, transparent 78%);
            mask-image: radial-gradient(ellipse 75% 75% at 50% 45%, #000 25%, transparent 78%);
            pointer-events: none;
            z-index: 0;
        }
        .annonces-cta-section > .container { position: relative; z-index: 1; }

        /* Cartes « recherches » : une bleue, une jaune */
        .rs-card {
            border-radius: var(--kp-radius);
            padding: 32px 28px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: var(--kp-transition);
        }
        .rs-card:hover { transform: translateY(-6px); box-shadow: var(--kp-shadow-lg); }
        .rs-card--blue { background: var(--kp-blue); }
        .rs-card--white { background: var(--kp-white); }
        .rs-card__media {
            width: 128px;
            height: 128px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 20px;
            border: 4px solid rgba(255, 255, 255, .6);
        }
        .rs-card--white .rs-card__media { border-color: rgba(0, 0, 0, .12); }
        .rs-card__media img { width: 100%; height: 100%; object-fit: cover; }
        .rs-card__title { font-family: var(--kp-font-title); font-size: 1.3rem; font-weight: 700; margin: 0 0 10px; }
        .rs-card--blue .rs-card__title { color: var(--kp-white); }
        .rs-card--white .rs-card__title { color: #1a1a1a; }
        .rs-card__text { font-size: .95rem; line-height: 1.55; margin: 0 0 22px; max-width: 360px; }
        .rs-card--blue .rs-card__text { color: rgba(255, 255, 255, .9); }
        .rs-card--white .rs-card__text { color: var(--kp-muted); }
        .rs-card .kp-btn { margin-top: auto; }

        .cta-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .cta-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .circular-image {
            transition: all 0.4s ease;
        }

        .cta-card:hover .circular-image {
            border-color: var(--kp-blue) !important;
        }

        .icon-badge {
            transition: all 0.4s ease;
            z-index: 10;
        }

        .cta-card:hover .icon-badge {
            transform: rotate(360deg);
        }

        .btn-cta {
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-publish:hover {
            background: #0000CC !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 255, 0.2) !important;
        }

        .btn-consult:hover {
            background: #008f5c !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 150, 0, 0.2) !important;
        }

        /* ===== INSCRIPTION SECTION ===== */
        .inscription-section {
            position: relative;
            padding: var(--kp-section-py) 0 0;   /* pas de padding bas : image collée au footer */
            overflow: hidden;
            background: #f8fafc;
        }

        .background-image-wrapper { height: 100%; border-radius: 20px 20px 0 0; }   /* bas droit (collé au footer) */

        .inscription-form {
            transition: all 0.3s ease;
            margin-right: 50px;
        }

        .inscription-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2) !important;
        }

        /* ===== MODAL ICONS ===== */
        .modal-icon {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1400px) {
            .subjects-grid {
                gap: 25px;
            }
        }

        @media (max-width: 1200px) {
            .subjects-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .annonce-card-wrapper {
                flex: 0 0 calc(50% - 12.5px);
            }
        }

        @media (max-width: 992px) {
            .hero {
                padding: 60px 0 120px 0;
            }

            .hero-title {
                font-size: 2.8rem;
            }

            .badge-item {
                display: none;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .registration-card {
                flex: 0 1 300px;
                padding: 30px 25px;
                transform: translateY(30px);
            }

            .subjects-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .carousel-nav-btn {
                width: 45px;
                height: 45px;
                font-size: 1.5rem;
            }

            .tutor-modal-content {
                flex-direction: column;
                height: auto;
            }

            .tutor-modal-image {
                flex: 0 0 300px;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .btn-primary {
                padding: 10px 20px;
            }

            .filter-select {
                font-size: 0.9rem;
            }

            .registration-card {
                flex: 0 1 100%;
                max-width: 400px;
                margin: 0 auto;
            }

            .registration-card h3 {
                font-size: 1.5rem;
            }

            .card-icon-wrapper {
                width: 60px;
                height: 60px;
            }

            .card-icon-wrapper i {
                font-size: 2rem;
            }

            .btn-register {
                padding: 12px 20px;
                font-size: 1rem;
            }

            .subjects-carousel-container {
                padding: 20px 15px;
            }

            .subjects-grid {
                gap: 15px;
            }

            .subject-card {
                padding: 25px 15px 30px;
            }

            .subject-icon {
                width: 70px;
                height: 70px;
            }

            .subject-icon i {
                font-size: 2.2rem;
            }

            .subject-title {
                font-size: 1.1rem;
            }

            .carousel-nav-btn {
                display: none;
            }

            .subjects-carousel-container {
                padding: 0;
            }

            .annonce-card-wrapper {
                flex: 0 0 100%;
            }

            .annonces-carousel-container {
                padding: 20px 40px;
            }

            .carousel-nav-btn {
                width: 40px;
                height: 40px;
            }

            .circular-image {
                width: 150px !important;
                height: 150px !important;
            }

            .cta-card h3 {
                font-size: 1.5rem !important;
            }

            .tutor-modal-details {
                grid-template-columns: 1fr;
            }

            .inscription-section {
                padding: var(--kp-section-py) 0;
            }

            .col-lg-6.offset-lg-6 {
                margin-left: 0 !important;
            }

            .d-none.d-lg-block {
                display: none !important;
            }

            .inscription-form {
                background: white !important;
            }
        }

        @media (max-width: 576px) {
            .hero {
                padding: 40px 0 100px 0;
            }

            .stat-item {
                padding: 10px;
            }

            .stat-number {
                font-size: 1.2rem;
            }

            .stat-label {
                font-size: 0.8rem;
            }

            .registration-card {
                padding: 25px 20px;
                transform: translateY(20px);
            }

            .subjects-grid {
                grid-template-columns: 1fr;
            }

            .subject-card {
                max-width: 320px;
                margin: 0 auto;
            }

            .gradient-text {
                font-size: 2rem;
            }

            .btn-view-all {
                padding: 12px 25px;
                font-size: 1rem;
            }

            .annonces-carousel-container {
                padding: 20px 30px;
            }

            .circular-image {
                width: 130px !important;
                height: 130px !important;
            }

            .icon-badge {
                width: 40px !important;
                height: 40px !important;
            }

            .icon-badge i {
                font-size: 1.2rem !important;
            }

            .cta-card {
                padding: 1.5rem !important;
            }

            .inscription-form {
                padding: 1.5rem !important;
                margin: 0 1rem;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem !important;
                font-size: 1rem !important;
            }

            .modal-body {
                padding: 1.5rem !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== CAROUSEL DES MATIÈRES =====
            const grid = document.getElementById('subjectsGrid');
            const prevBtn = document.getElementById('prevSubjects');
            const nextBtn = document.getElementById('nextSubjects');
            const indicators = document.getElementById('paginationIndicators');

            // ===== Carousel infini réutilisable (drag + molette + indicateurs + auto-défilement SANS retour) =====
            function initInfiniteCarousel(track, dotsBox, cardSel, perView, interval) {
                if (!track) return;
                const base = track.querySelectorAll(cardSel).length;
                if (!base) return;

                function unit() {
                    const c = track.querySelector(cardSel);
                    if (!c) return 0;
                    const gap = parseFloat(getComputedStyle(track).columnGap || '24') || 24;
                    return c.offsetWidth + gap;
                }
                function step() { return unit() * perView || track.clientWidth; }
                function pages() { return Math.max(1, Math.ceil(base / perView)); }
                function baseWidth() { return unit() * base; }

                // Clone des cartes → la boucle continue vers l'avant (jamais de retour en arrière)
                const looping = pages() > 1;
                if (looping) {
                    Array.from(track.querySelectorAll(cardSel)).forEach(c => track.appendChild(c.cloneNode(true)));
                }

                function curPage() {
                    const s = step();
                    return s ? ((Math.round(track.scrollLeft / s) % pages()) + pages()) % pages() : 0;
                }
                function buildDots() {
                    if (!dotsBox) return;
                    dotsBox.innerHTML = '';
                    for (let i = 0; i < pages(); i++) {
                        const b = document.createElement('button');
                        b.type = 'button';
                        b.setAttribute('aria-label', 'Page ' + (i + 1));
                        b.addEventListener('click', () => track.scrollTo({ left: step() * i, behavior: 'smooth' }));
                        dotsBox.appendChild(b);
                    }
                    syncDots();
                }
                function syncDots() {
                    if (!dotsBox) return;
                    const c = curPage();
                    Array.from(dotsBox.children).forEach((b, i) => b.classList.toggle('active', i === c));
                }
                track.addEventListener('scroll', syncDots, { passive: true });

                track.addEventListener('wheel', (e) => {
                    if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) { track.scrollLeft += e.deltaY; e.preventDefault(); }
                }, { passive: false });

                let down = false, sx = 0, ss = 0, moved = 0;
                track.addEventListener('pointerdown', (e) => { down = true; moved = 0; sx = e.clientX; ss = track.scrollLeft; track.classList.add('dragging'); });
                track.addEventListener('pointermove', (e) => { if (!down) return; const dx = e.clientX - sx; moved = Math.max(moved, Math.abs(dx)); track.scrollLeft = ss - dx; });
                function up() { if (!down) return; down = false; track.classList.remove('dragging'); normalize(); }
                track.addEventListener('pointerup', up);
                track.addEventListener('pointercancel', up);
                track.addEventListener('click', (e) => { if (moved > 6) { e.preventDefault(); e.stopPropagation(); } }, true);

                function normalize() {
                    if (!looping) return;
                    const w = baseWidth();
                    if (track.scrollLeft >= w) track.scrollLeft -= w;
                    else if (track.scrollLeft < 0) track.scrollLeft += w;
                }

                let timer = null;
                function next() {
                    if (looping && track.scrollLeft >= baseWidth()) track.scrollLeft -= baseWidth();   // reset invisible (contenu identique)
                    track.scrollBy({ left: step(), behavior: 'smooth' });
                }
                function start() { if (looping) { stop(); timer = setInterval(next, interval); } }
                function stop() { if (timer) { clearInterval(timer); timer = null; } }
                track.addEventListener('pointerenter', stop);
                track.addEventListener('pointerleave', () => { up(); start(); });

                buildDots();
                start();
                window.addEventListener('resize', buildDots);
            }

            initInfiniteCarousel(grid, document.getElementById('subjectsDots'), '.subject-card-wrapper', 3, 3500);

            // ===== CAROUSEL DES ANNONCES =====
            const annonceCarousel = document.getElementById('annoncesCarousel');
            const prevAnnonce = document.getElementById('prevAnnonce');
            const nextAnnonce = document.getElementById('nextAnnonce');
            const annonceIndicators = document.getElementById('annonceIndicators');

            initInfiniteCarousel(annonceCarousel, document.getElementById('annoncesDots'), '.annonce-card-wrapper', 3, 3500);

            // ===== FORMULAIRE D'INSCRIPTION =====
            const formStep1 = document.getElementById('inscriptionFormStep1');
            if (formStep1) {
                const emailInput = document.getElementById('email');
                const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                const userEmailSpan = document.getElementById('userEmail');
                const finalEmailInput = document.getElementById('finalEmail');

                formStep1.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = emailInput.value.trim();
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (!emailPattern.test(email)) {
                        alert('Veuillez entrer un email valide');
                        return;
                    }

                    userEmailSpan.textContent = email;
                    finalEmailInput.value = email;
                    confirmationModal.show();
                    formStep1.reset();
                });
            }
        });

        // ===== FONCTIONS GLOBALES =====
        function showLoginMessage() {
            const modal = new bootstrap.Modal(document.getElementById('loginMessageModal'));
            modal.show();
        }

        function showLoginMessage(action) {
            const modal = new bootstrap.Modal(document.getElementById('loginModal'));
            const modalMessage = document.getElementById('modalMessage');

            if (action === 'publier') {
                modalMessage.textContent =
                    'Pour publier une annonce, vous devez d\'abord créer un compte apprenant ou vous connecter.';
            } else {
                modalMessage.textContent =
                    'Pour consulter les annonces et postuler, vous devez d\'abord créer un compte tuteur ou vous connecter.';
            }

            modal.show();
        }

        function showRoleMessage(action) {
            const modal = new bootstrap.Modal(document.getElementById('roleModal'));
            const modalMessage = document.getElementById('roleModalMessage');

            @auth
            if (action === 'publier') {
                modalMessage.textContent =
                    'Seuls les étudiants peuvent publier des annonces. Vous êtes connecté en tant que ' +
                    (@json(Auth::user()->role_id) == 2 ? 'étudiant' : (@json(Auth::user()->role_id) == 3 ? 'tuteur' :
                        'administrateur')) + '.';
            } else {
                modalMessage.textContent =
                    'Seuls les tuteurs peuvent consulter et postuler aux annonces. Vous êtes connecté en tant que ' +
                    (@json(Auth::user()->role_id) == 2 ? 'étudiant' : (@json(Auth::user()->role_id) == 3 ? 'tuteur' :
                        'administrateur')) + '.';
            }
        @endauth

        modal.show();
        }
    </script>
@endpush
