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
        /* Menu Burger Styles */
        .burger-menu {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            padding: 10px;
            z-index: 1001;
        }

        .burger-icon {
            width: 30px;
            height: 3px;
            background-color: white;
            position: relative;
            transition: all 0.3s ease;
        }

        .burger-icon::before,
        .burger-icon::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 3px;
            background-color: white;
            transition: all 0.3s ease;
        }

        .burger-icon::before {
            top: -8px;
        }

        .burger-icon::after {
            bottom: -8px;
        }

        /* Animation du burger quand le menu est ouvert */
        .burger-menu.active .burger-icon {
            background-color: transparent;
        }

        .burger-menu.active .burger-icon::before {
            transform: rotate(45deg);
            top: 0;
        }

        .burger-menu.active .burger-icon::after {
            transform: rotate(-45deg);
            bottom: 0;
        }

        /* Sidebar Menu */
        .sidebar-menu {
            position: fixed;
            top: 0;
            left: -300px;
            width: 280px;
            height: 100%;
            background: linear-gradient(135deg, #0B69F1, #004aad);
            z-index: 1002;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        }

        .sidebar-menu.active {
            left: 0;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-header h3 {
            margin: 0;
            color: white;
            font-weight: bold;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .close-btn:hover {
            background: rgba(255,255,255,0.2);
        }

        .sidebar-links {
            padding: 20px 0;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,0.1);
            border-left-color: #ffc107;
        }

        .sidebar-link i {
            margin-right: 12px;
            font-size: 1.2rem;
            width: 24px;
        }

        .sidebar-link span {
            font-size: 1rem;
            font-weight: 500;
        }

        .logout-btn {
            background: none;
            width: 100%;
            text-align: left;
            border: none;
            cursor: pointer;
        }

        /* Overlay */
        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1001;
            display: none;
        }

        .menu-overlay.active {
            display: block;
        }

        body.menu-open {
            overflow: hidden;
        }

        /* Style du logo Kopiao en bleu #0B69F1 */
        .logo {
            background-color: #0B69F1 !important;
            padding: 8px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: inline-flex;
        }

        .logo:hover {
            background-color: #0056b3 !important;
            transform: scale(1.05);
        }

        .logo h1 {
            color: white;
            margin: 0;
            font-size: 1.5rem;
        }

        /* Header container - logo à gauche, burger à droite */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        /* Desktop menu - visible sur grand écran */
        .desktop-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Styles pour mobile */
        @media (max-width: 991px) {
            .burger-menu {
                display: block;
            }

            .desktop-menu {
                display: none !important;
            }

            .logo {
                order: 0;
            }

            .burger-menu {
                order: 1;
            }
        }

        @media (min-width: 992px) {
            .burger-menu {
                display: none !important;
            }
        }

        /* Animation des liens footer */
        .footer-links ul li a {
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links ul li a:hover {
            color: #ffc107 !important;
            transform: translateX(5px);
        }

        /* Animation réseaux sociaux */
        .social-links a {
            transition: all 0.3s ease;
            display: inline-block;
        }

        .social-links a:hover {
            transform: translateY(-3px);
            color: #ffc107 !important;
        }
    </style>
</head>

<body>

<header id="header" class="header d-flex align-items-center fixed-top" style="background-color: #0B69F1;">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between"
        style="margin-bottom: 35px;">

        <!-- Logo à gauche avec couleur bleue #0B69F1 -->
        <a href="{{ url('/') }}" class="logo d-flex align-items-center text-white text-decoration-none">
            <h1 class="sitename fw-bold mb-0">Kopiao</h1>
        </a>

        <!-- Menu principal desktop -->
        <nav class="desktop-menu d-flex align-items-center gap-2">
            <ul class="d-flex list-unstyled mb-0 align-items-center gap-2">
                <li>
                    <a class="btn btn-primary fw-semibold text-light px-4 py-2 rounded-pill text-decoration-none"
                        href="{{ route('annoncesListe.liste') }}">
                        Annonces
                    </a>
                </li>

                <li>
                    <a class="btn btn-primary fw-semibold text-light px-4 py-2 rounded-pill text-decoration-none"
                        href="{{ route('demandesliste.liste') }}">
                        Demandes
                    </a>
                </li>

                <li>
                    <a class="btn btn-primary fw-semibold text-light px-4 py-2 rounded-pill text-decoration-none"
                        href="{{ route('faq') }}">
                        FAQ
                    </a>
                </li>
            </ul>

            @auth
                <div class="d-flex gap-2">
                    <!-- Bouton Tableau de bord pour utilisateur connecté -->
                    <a class="btn btn-success fw-semibold text-light px-4 py-2 rounded-pill text-decoration-none"
                        href="{{ route('dashboardUser') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Tableau de bord
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger fw-semibold px-4 py-2 rounded-pill">
                            <i class="bi bi-box-arrow-right me-2"></i> Se déconnecter
                        </button>
                    </form>
                </div>
            @else
                <a class="btn btn-warning bg-light fw-semibold text-dark px-4 py-2 rounded-pill" href="{{ route('login') }}">
                    Se connecter
                </a>
            @endauth
        </nav>

        <!-- Burger Menu Button à droite -->
        <button class="burger-menu" id="burgerBtn">
            <div class="burger-icon"></div>
        </button>
    </div>
</header>

<!-- Sidebar Menu Mobile -->
<div class="sidebar-menu" id="sidebarMenu">
    <div class="sidebar-header">
        <h3>Kopiao</h3>
        <button class="close-btn" id="closeMenuBtn">×</button>
    </div>
    <div class="sidebar-links">
        <br><br>
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
            <!-- Bouton Tableau de bord dans le sidebar -->
            <a href="{{ route('dashboardUser') }}" class="sidebar-link" style="border-left-color: #ffc107; background: rgba(255,255,255,0.05);">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
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
    style="background: linear-gradient(135deg, #0d6efd, #004aad); padding-top: 60px;">

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
                <h4 class="text-warning fw-semibold mb-3">Liens utiles</h4>
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
                <h4 class="text-warning fw-semibold mb-3">Nos Services</h4>
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
                <h4 class="text-warning fw-semibold mb-3">Restez informé</h4>
                <p class="text-white-50">Abonnez-vous pour recevoir nos dernières actualités et offres spéciales.</p>

                <form id="newsletterForm" class="mt-3">
                    <div class="d-flex">
                        <input type="email" id="newsletterEmail" name="email" class="form-control me-2 border-0 rounded-start"
                            placeholder="Votre e-mail" style="background-color: #f8fbff;" required>
                        <button type="submit" class="btn btn-warning text-white fw-semibold px-3 rounded-end">
                            S'abonner
                        </button>
                    </div>
                    <div id="newsletterMessage" class="mt-2 small"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bas du footer -->
    <div class="container text-center py-3">
        <p class="mb-1 text-white-50">© <strong>Kopiao</strong> — Tous droits réservés.</p>
        <p class="mb-0 small text-white-50">
            <a href="#" class="text-white-50 text-decoration-none">Mentions légales</a> |
            <a href="#" class="text-white-50 text-decoration-none">Politique de confidentialité</a> |
            <a href="#" class="text-white-50 text-decoration-none">CGU</a>
        </p>
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
        padding-top: 120px;
    }

    @media (max-width: 768px) {
        body .main {
            padding-top: 100px;
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
