<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Kopiao</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('images/image_1.webp') }}" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Swiper Slider -->
    <link href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" rel="stylesheet">

    <!-- Glightbox -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    <!-- Kopiao Design System (Phase 0) — tokens & composants unifiés -->
    <link href="{{ asset('css/kopiao-ui.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- SweetAlert2 pour les notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireStyles
    @stack('styles')

    <style>
        /* ===================================================================
           NAVBAR KOPIAO — minimaliste, fond bleu plein, responsive.
           Toutes les couleurs viennent des variables du design system
           (kopiao-ui.css). Aucune valeur hex en dur ici.
           =================================================================== */

        /* Bandeau bleu plein, hauteur stable, sans barre grise interne */
        .header {
            background-color: var(--kp-blue);
            padding: 0;
            z-index: 997;
            box-shadow: var(--kp-shadow-sm);
            transition: none;
        }
        .header .header-container {
            background: transparent;
            border-radius: 0;
            padding-top: 0;
            padding-bottom: 0;
            margin-bottom: 0;
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        /* Logo « Kopiao » en blanc, sans pastille */
        .header .logo,
        .logo {
            background: transparent !important;
            padding: 0;
            border-radius: 0;
            display: inline-flex;
            align-items: center;
            order: 0 !important;            /* neutralise l'inversion de welcome.css */
        }
        .header .logo:hover,
        .logo:hover {
            background: transparent !important;
            transform: none;
        }
        .header .logo h1,
        .logo h1 {
            color: var(--kp-white);
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: .3px;
        }

        /* Liens de navigation (desktop) */
        .desktop-menu {
            display: flex;
            align-items: center;
            gap: .35rem;
            order: 1 !important;
        }
        .nav-link-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            color: rgba(255, 255, 255, .9);
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            border-radius: var(--kp-radius-pill);
            transition: var(--kp-transition);
        }
        .nav-link-item:hover {
            color: var(--kp-white);
            background: rgba(255, 255, 255, .14);
        }
        .nav-link-item.is-active {
            color: var(--kp-white);
            background: transparent;
            position: relative;
        }
        .nav-link-item.is-active::after {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 4px;
            width: 20px;
            height: 3px;
            background: var(--kp-yellow);
            border-radius: 3px;
        }

        /* Bouton « Se connecter » : blanc sur bleu */
        .nav-login-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            margin-left: .35rem;
            background: var(--kp-yellow);
            color: #1a1a1a;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border-radius: var(--kp-radius-pill);
            transition: var(--kp-transition);
        }
        .nav-login-btn:hover {
            background: var(--kp-white);
            color: var(--kp-blue);
        }

        /* Menu profil (utilisateur connecté) */
        .nav-profile { position: relative; margin-left: .35rem; }
        .nav-profile__btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px 5px 5px;
            background: rgba(255, 255, 255, .14);
            color: var(--kp-white);
            border: none;
            border-radius: var(--kp-radius-pill);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--kp-transition);
        }
        .nav-profile__btn:hover { background: rgba(255, 255, 255, .24); }
        .nav-profile__avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--kp-white);
            color: var(--kp-blue);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
        }
        .nav-profile__btn .bi-chevron-down { font-size: 12px; transition: var(--kp-transition); }
        .nav-profile.open .nav-profile__btn .bi-chevron-down { transform: rotate(180deg); }
        .nav-profile__menu {
            position: absolute;
            right: 0;
            top: calc(100% + 12px);
            min-width: 220px;
            background: var(--kp-white);
            border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius-sm);
            box-shadow: var(--kp-shadow-lg);
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: var(--kp-transition);
            z-index: 1000;
        }
        .nav-profile.open .nav-profile__menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .nav-profile__item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--kp-text);
            background: none;
            border: none;
            font-size: 14px;
            font-weight: 500;
            text-align: left;
            text-decoration: none;
            cursor: pointer;
            transition: var(--kp-transition);
        }
        .nav-profile__item i { font-size: 1rem; width: 18px; color: var(--kp-muted); }
        .nav-profile__item:hover { background: var(--kp-blue-soft); color: var(--kp-blue-dark); }
        .nav-profile__item:hover i { color: var(--kp-blue); }
        .nav-profile__sep { margin: 6px 4px; border: 0; border-top: 1px solid var(--kp-border); }
        .nav-profile__item--danger { color: #dc3545; }
        .nav-profile__item--danger i { color: #dc3545; }
        .nav-profile__item--danger:hover { background: #fdecec; color: #b02a37; }
        .nav-profile__item--danger:hover i { color: #b02a37; }

        /* ===== Burger (mobile / tablette) — blanc sur bleu, soigné ===== */
        .burger-menu {
            display: none;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            padding: 0;
            background: none;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            z-index: 1001;
            order: 1 !important;
            transition: var(--kp-transition);
        }
        .burger-menu:hover { background: rgba(255, 255, 255, .14); }
        .burger-icon,
        .burger-icon::before,
        .burger-icon::after {
            width: 24px;
            height: 2.5px;
            background-color: var(--kp-white);
            border-radius: 2px;
            transition: all .3s ease;
        }
        .burger-icon { position: relative; display: block; }
        .burger-icon::before,
        .burger-icon::after { content: ''; position: absolute; left: 0; }
        .burger-icon::before { top: -7px; }
        .burger-icon::after { top: 7px; }
        .burger-menu.active .burger-icon { background-color: transparent; }
        .burger-menu.active .burger-icon::before { transform: rotate(45deg); top: 0; }
        .burger-menu.active .burger-icon::after { transform: rotate(-45deg); top: 0; }

        /* ===== Drawer mobile : glisse depuis la DROITE, sous la navbar ===== */
        .sidebar-menu {
            position: fixed;
            top: 64px;
            right: -340px;
            width: 300px;
            max-width: 86vw;
            height: calc(100% - 64px);
            background: var(--kp-blue);
            z-index: 1002;
            transition: right .32s ease;
            box-shadow: -8px 0 28px rgba(0, 0, 0, .18);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .sidebar-menu.active { right: 0; }
        .sidebar-header { display: none; }   /* le drawer démarre déjà sous la navbar */
        .sidebar-links { padding: 14px; display: flex; flex-direction: column; gap: 4px; }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            color: var(--kp-white);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            border-left: none;
            transition: var(--kp-transition);
        }
        .sidebar-link i { font-size: 1.15rem; width: 22px; text-align: center; }
        .sidebar-link span { font-size: 1rem; font-weight: 500; }
        .sidebar-link:hover,
        .sidebar-link.is-active { background: rgba(255, 255, 255, .14); }
        .logout-btn {
            background: none;
            width: 100%;
            text-align: left;
            border: none;
            cursor: pointer;
        }

        /* Overlay : démarre aussi sous la navbar */
        .menu-overlay {
            position: fixed;
            top: 64px;
            left: 0;
            width: 100%;
            height: calc(100% - 64px);
            background: rgba(0, 0, 0, .45);
            z-index: 1001;
            display: none;
        }
        .menu-overlay.active { display: block; }
        body.menu-open { overflow: hidden; }

        /* ===== Breakpoints ===== */
        @media (max-width: 991px) {
            .header .header-container { min-height: 58px; }
            .sidebar-menu { top: 58px; height: calc(100% - 58px); }
            .menu-overlay { top: 58px; height: calc(100% - 58px); }
            .burger-menu { display: inline-flex; }
            .desktop-menu { display: none !important; }
        }
        @media (min-width: 992px) {
            .burger-menu { display: none !important; }
            .desktop-menu { display: flex; }
        }

        /* Animation des liens footer */
        .footer-links ul li a {
            transition: all 0.3s ease;
            display: inline-block;
        }
        .footer-links ul li a:hover {
            color: var(--kp-yellow) !important;
            transform: translateX(5px);
        }

        /* Animation réseaux sociaux */
        .footer .social-links a {
            width: auto;
            height: auto;
            border: none;
            border-radius: 0;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .footer .social-links a:hover {
            transform: translateY(-3px);
            color: var(--kp-yellow) !important;
            border-color: transparent;
        }
    </style>
</head>

<body>

<header id="header" class="header fixed-top">
    <div class="header-container container-fluid container-xl">

        <!-- Logo « Kopiao » en blanc, à gauche -->
        <a href="{{ url('/') }}" class="logo text-decoration-none">
            <h1 class="sitename mb-0">Kopiao</h1>
        </a>

        <!-- Menu principal desktop : liens à droite -->
        <nav class="desktop-menu">
            <a class="nav-link-item {{ request()->routeIs('annoncesListe.*') ? 'is-active' : '' }}" href="{{ route('annoncesListe.liste') }}">Annonces</a>
            <a class="nav-link-item {{ request()->routeIs('demandesliste.*') ? 'is-active' : '' }}" href="{{ route('demandesliste.liste') }}">Demandes</a>
            <a class="nav-link-item {{ request()->routeIs('faq') ? 'is-active' : '' }}" href="{{ route('faq') }}" style="margin-right: 1.75rem;">FAQ</a>

            @auth
                <div class="nav-profile" id="navProfile">
                    <button type="button" class="nav-profile__btn" id="navProfileBtn" aria-haspopup="true" aria-expanded="false">
                        <span class="nav-profile__avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                        <span class="d-none d-xl-inline">{{ auth()->user()->name ?? 'Mon compte' }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <div class="nav-profile__menu">
                        <a class="nav-profile__item" href="{{ route('dashboardUser') }}">
                            <i class="bi bi-grid-1x2"></i> Tableau de bord
                        </a>
                        <a class="nav-profile__item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person"></i> Mon profil
                        </a>
                        <hr class="nav-profile__sep">
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="nav-profile__item nav-profile__item--danger">
                                <i class="bi bi-box-arrow-right"></i> Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a class="nav-login-btn" href="{{ route('login') }}">
                    Se connecter
                </a>
            @endauth
        </nav>

        <!-- Burger (mobile / tablette) -->
        <button class="burger-menu" id="burgerBtn" aria-label="Ouvrir le menu">
            <span class="burger-icon"></span>
        </button>
    </div>
</header>

<!-- Drawer Mobile (glisse depuis la droite, sous la navbar) -->
<div class="sidebar-menu" id="sidebarMenu">
    <div class="sidebar-header">
        <h3>Menu</h3>
        <button class="close-btn" id="closeMenuBtn">×</button>
    </div>
    <div class="sidebar-links">
        <a href="{{ url('/') }}" class="sidebar-link">
            <i class="bi bi-house"></i>
            <span>Accueil</span>
        </a>
        <a href="{{ route('annoncesListe.liste') }}" class="sidebar-link">
            <i class="bi bi-megaphone"></i>
            <span>Annonces</span>
        </a>
        <a href="{{ route('demandesliste.liste') }}" class="sidebar-link">
            <i class="bi bi-chat-dots"></i>
            <span>Demandes</span>
        </a>
        <a href="{{ route('faq') }}" class="sidebar-link">
            <i class="bi bi-question-circle"></i>
            <span>FAQ</span>
        </a>
        <a href="#" class="sidebar-link" id="contactLink">
            <i class="bi bi-envelope"></i>
            <span>Contact</span>
        </a>

        @auth
            <a href="{{ route('dashboardUser') }}" class="sidebar-link">
                <i class="bi bi-grid-1x2"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link">
                <i class="bi bi-person"></i>
                <span>Mon profil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="sidebar-link logout-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Se déconnecter</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="sidebar-link">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Se connecter</span>
            </a>
        @endauth
    </div>
</div>

<!-- Overlay -->
<div class="menu-overlay" id="menuOverlay"></div>

<main class="main">
    @yield('content')
</main>

<footer id="footer" class="footer position-relative text-white"
    style="background: linear-gradient(135deg, var(--kp-blue), var(--kp-blue-dark)); padding-top: 60px;">

    <div class="container footer-top pb-5 border-bottom border-light">
        <div class="row gy-4">

            <!-- Bloc logo et contact -->
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center mb-3 text-white text-decoration-none">
                    <span class="sitename fw-bold fs-4 text-light">Kopiao</span>
                </a>
                <p class="text-white-50 mt-3">Votre plateforme de mise en relation pour les cours particuliers et le soutien scolaire.</p>

                <div class="social-links d-flex mt-4">
                    <a href="https://www.facebook.com/share/1EEgM4RwCR/" target="_blank" class="me-3 text-white fs-4" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/kopiaoofficiel?igsh=MW1weGNhcW91ZzRzZg==" target="_blank" class="me-3 text-white fs-4" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/kopiao/" target="_blank" class="me-3 text-white fs-4" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="https://x.com/kopiaoofficiel?t=zD2MHk2cCpuwQ2m6fQl3Pg&s=09" target="_blank" class="text-white fs-4" title="Twitter">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                </div>
            </div>

            <!-- Liens rapides - Augmentés -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4 class="footer-title">Liens utiles</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Accueil
                    </a></li>
                    <li class="mb-2"><a href="{{ route('annoncesListe.liste') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Annonces
                    </a></li>
                    <li class="mb-2"><a href="{{ route('demandesliste.liste') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Demandes
                    </a></li>
                    <li class="mb-2"><a href="#" id="contactFooterLink" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Contact
                    </a></li>
                    <li class="mb-2"><a href="{{ route('faq') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> FAQ
                    </a></li>
                    @auth
                    <li class="mb-2"><a href="{{ route('dashboardUser') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Tableau de bord
                    </a></li>
                    @endauth
                </ul>
            </div>

            <!-- Nos Services -->
            <div class="col-lg-3 col-md-3 footer-links">
                <h4 class="footer-title">Nos Services</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Cours particuliers
                    </a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Soutien scolaire
                    </a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Préparation examens
                    </a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Cours en ligne
                    </a></li>
                </ul>
            </div>

            <!-- Newsletter - Version mailto simple -->
            <div class="col-lg-3 col-md-6 footer-newsletter">
                <h4 class="footer-title">Restez informé</h4>
                <p class="text-white-50">Abonnez-vous pour recevoir nos dernières actualités et offres spéciales.</p>

                <form id="newsletterForm" class="mt-3">
                    <div class="footer-newsletter-group">
                        <input type="email" id="newsletterEmail" name="email" class="kp-field"
                            placeholder="Votre e-mail" required>
                        <button type="submit" class="kp-btn kp-btn--accent">S'abonner</button>
                    </div>
                    <div id="newsletterMessage" class="mt-2 small"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bas du footer -->
    <div class="container py-3">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center gap-2 text-center text-md-start">
            <p class="mb-0 text-white-50">© <strong>Kopiao</strong> — Tous droits réservés.</p>
            <p class="mb-0 small text-white-50">
                <a href="#" class="text-white-50 text-decoration-none">Mentions légales</a> |
                <a href="#" class="text-white-50 text-decoration-none">Politique de confidentialité</a> |
                <a href="#" class="text-white-50 text-decoration-none">CGU</a>
            </p>
        </div>
    </div>
</footer>

<!-- Modal Contact - Version corrigée -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #0B69F1; color: white;">
                <h5 class="modal-title text-white" id="contactModalLabel">
                    <i class="bi bi-envelope me-2"></i> Nous contacter
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contactForm">
                    <div class="mb-3">
                        <label for="contactName" class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="contactName" placeholder="Votre nom et prénom" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactEmail" class="form-label">Votre email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="contactEmail" placeholder="exemple@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactMessage" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="contactMessage" rows="4" placeholder="Votre message..." required></textarea>
                    </div>
                    <div id="contactFormMessage" class="mt-2"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Fermer
                </button>
                <button type="button" class="btn btn-primary" id="sendContactBtn" style="background: #0B69F1;">
                    <i class="bi bi-send me-2"></i>Envoyer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS (nécessaire pour le modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Initialiser AOS
    AOS.init({
        duration: 800,
        once: false
    });

    // Menu Burger JavaScript avec TOGGLE
    const burgerBtn = document.getElementById('burgerBtn');
    const sidebarMenu = document.getElementById('sidebarMenu');
    const closeMenuBtn = document.getElementById('closeMenuBtn');
    const menuOverlay = document.getElementById('menuOverlay');

    function toggleMenu() {
        sidebarMenu.classList.toggle('active');
        menuOverlay.classList.toggle('active');
        document.body.classList.toggle('menu-open');
        burgerBtn.classList.toggle('active');
    }

    function closeMenu() {
        sidebarMenu.classList.remove('active');
        menuOverlay.classList.remove('active');
        document.body.classList.remove('menu-open');
        burgerBtn.classList.remove('active');
    }

    burgerBtn.addEventListener('click', toggleMenu);
    closeMenuBtn.addEventListener('click', closeMenu);
    menuOverlay.addEventListener('click', closeMenu);

    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', closeMenu);
    });

    // Menu profil (dropdown) — ouverture/fermeture
    const navProfile = document.getElementById('navProfile');
    const navProfileBtn = document.getElementById('navProfileBtn');
    if (navProfile && navProfileBtn) {
        navProfileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const open = navProfile.classList.toggle('open');
            navProfileBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('click', function (e) {
            if (!navProfile.contains(e.target)) {
                navProfile.classList.remove('open');
                navProfileBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // Initialisation du Modal Bootstrap
    let contactModal = null;

    // Attendre que le DOM soit chargé
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser le modal
        const modalElement = document.getElementById('contactModal');
        if (modalElement) {
            contactModal = new bootstrap.Modal(modalElement);
        }
    });

    // Ouvrir le modal depuis le lien Contact
    document.getElementById('contactLink')?.addEventListener('click', function(e) {
        e.preventDefault();
        if (contactModal) {
            contactModal.show();
        } else {
            // Fallback si le modal n'est pas initialisé
            const modalElement = document.getElementById('contactModal');
            if (modalElement) {
                contactModal = new bootstrap.Modal(modalElement);
                contactModal.show();
            }
        }
    });

    // Ouvrir le modal depuis le footer
    document.getElementById('contactFooterLink')?.addEventListener('click', function(e) {
        e.preventDefault();
        if (contactModal) {
            contactModal.show();
        } else {
            const modalElement = document.getElementById('contactModal');
            if (modalElement) {
                contactModal = new bootstrap.Modal(modalElement);
                contactModal.show();
            }
        }
    });

    // Bouton d'envoi du formulaire de contact
    document.getElementById('sendContactBtn')?.addEventListener('click', function() {
        const name = document.getElementById('contactName').value.trim();
        const email = document.getElementById('contactEmail').value.trim();
        const message = document.getElementById('contactMessage').value.trim();
        const messageDiv = document.getElementById('contactFormMessage');

        // Validation
        if (!name) {
            messageDiv.innerHTML = '<span class="text-danger">Veuillez entrer votre nom complet</span>';
            setTimeout(() => { messageDiv.innerHTML = ''; }, 3000);
            return;
        }

        if (!email) {
            messageDiv.innerHTML = '<span class="text-danger">Veuillez entrer votre email</span>';
            setTimeout(() => { messageDiv.innerHTML = ''; }, 3000);
            return;
        }

        if (!email.includes('@') || !email.includes('.')) {
            messageDiv.innerHTML = '<span class="text-danger">Veuillez entrer un email valide</span>';
            setTimeout(() => { messageDiv.innerHTML = ''; }, 3000);
            return;
        }

        if (!message) {
            messageDiv.innerHTML = '<span class="text-danger">Veuillez écrire votre message</span>';
            setTimeout(() => { messageDiv.innerHTML = ''; }, 3000);
            return;
        }

        if (message.length < 10) {
            messageDiv.innerHTML = '<span class="text-danger">Votre message est trop court (minimum 10 caractères)</span>';
            setTimeout(() => { messageDiv.innerHTML = ''; }, 3000);
            return;
        }

        // Ouvrir le client email par défaut
        const subject = encodeURIComponent(`Message de contact - ${name}`);
        const body = encodeURIComponent(`Nom : ${name}\nEmail : ${email}\n\nMessage :\n${message}\n\n---\nMessage envoyé depuis le site Kopiao`);
        window.location.href = `mailto:contact@kopiao.com?subject=${subject}&body=${body}`;

        // Afficher le message de succès
        Swal.fire({
            icon: 'success',
            title: 'Message préparé !',
            text: 'Votre client email va s\'ouvrir. Il ne vous reste plus qu\'à envoyer le message.',
            timer: 3000,
            showConfirmButton: false
        });

        // Réinitialiser le formulaire
        document.getElementById('contactName').value = '';
        document.getElementById('contactEmail').value = '';
        document.getElementById('contactMessage').value = '';
        messageDiv.innerHTML = '';

        // Fermer le modal
        if (contactModal) {
            contactModal.hide();
        }
    });

    // Newsletter simple avec mailto
    document.getElementById('newsletterForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const email = document.getElementById('newsletterEmail').value;
        const messageDiv = document.getElementById('newsletterMessage');

        if (!email || !email.includes('@')) {
            messageDiv.innerHTML = '<span class="text-danger">Veuillez entrer un email valide</span>';
            setTimeout(() => { messageDiv.innerHTML = ''; }, 3000);
            return;
        }

        // Ouvrir le client email par défaut
        const subject = encodeURIComponent('Abonnement Newsletter - Kopiao');
        const body = encodeURIComponent(`Bonjour,\n\nJe souhaite m'abonner à la newsletter Kopiao avec l'adresse email suivante :\n\n${email}\n\nMerci.`);
        window.location.href = `mailto:contact@kopiao.com?subject=${subject}&body=${body}`;

        messageDiv.innerHTML = '<span class="text-success">✓ Ouverture de votre messagerie !</span>';
        document.getElementById('newsletterEmail').value = '';

        setTimeout(() => { messageDiv.innerHTML = ''; }, 3000);
    });
</script>

@stack('scripts')

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Autres scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="{{ asset('js/welcome.js') }}"></script>

<style>
    body .main {
        padding-top: 64px;   /* = hauteur navbar desktop → le contenu démarre pile sous la navbar */
    }

    @media (max-width: 991px) {
        body .main {
            padding-top: 58px;   /* = hauteur navbar tablette/mobile */
        }
    }

    .footer-links ul li a i {
        transition: transform 0.3s ease;
    }

    .footer-links ul li a:hover i {
        transform: translateX(3px);
    }

    /* Style pour les champs requis */
    .text-danger {
        font-size: 0.9rem;
    }

    .form-control:focus {
        border-color: #0B69F1;
        box-shadow: 0 0 0 0.2rem rgba(11, 105, 241, 0.25);
    }

    /* Style pour le bouton tableau de bord */
    .btn-success {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }

    .btn-success:hover {
        background-color: #218838 !important;
        border-color: #1e7e34 !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
</style>

@livewireStyles
</body>

</html>
