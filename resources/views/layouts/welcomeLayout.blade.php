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
    <!-- Bootstrap 5 -->
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

            /* Le logo reste à gauche automatiquement avec flex */
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
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger fw-semibold px-4 py-2 rounded-pill">
                        <i class="bi bi-box-arrow-right me-2"></i> Se déconnecter
                    </button>
                </form>
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

        @auth
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
                <a href="index.html" class="logo d-flex align-items-center mb-3 text-white text-decoration-none">
                    <span class="sitename fw-bold fs-4 text-light">Kopiao</span>
                </a>

                <div class="social-links d-flex mt-4">
                    <a href="#" class="me-3 text-white fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="me-3 text-white fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="me-3 text-white fs-5"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>

            <!-- Liens rapides -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4 class="text-warning fw-semibold mb-3">Liens utiles</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50 text-decoration-none">Accueil</a></li>
                </ul>
            </div>

            <!-- Nos Services -->
            <div class="col-lg-3 col-md-3 footer-links">
                <h4 class="text-warning fw-semibold mb-3">Nos Offres</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50 text-decoration-none">Accompagnement</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6 footer-newsletter">
                <h4 class="text-warning fw-semibold mb-3">Restez informé</h4>
                <p class="text-white-50">Abonnez-vous pour recevoir nos dernières actualités et offres spéciales.</p>
                <div class="d-flex mt-3">
                    <input type="email" id="emailInput" class="form-control me-2 border-0 rounded-start"
                        placeholder="Votre e-mail" style="background-color: #f8fbff;" required>
                    <button onclick="sendMail()" class="btn btn-warning text-dark fw-semibold px-3 rounded-end">
                        S'abonner
                    </button>
                </div>

                <script>
                    function sendMail() {
                        const emailField = document.getElementById("emailInput");
                        const email = emailField.value;

                        if (!emailField.checkValidity()) {
                            alert("Veuillez entrer une adresse e-mail valide.");
                            return;
                        }

                        window.location.href = `mailto:${email}?subject=Abonnement&body=Je souhaite m'abonner.`;
                    }
                </script>
            </div>
        </div>
    </div>

    <!-- Bas du footer -->
    <div class="container text-center py-3">
        <p class="mb-1 text-white-50">© <strong>Kopiao</strong> — Tous droits réservés.</p>
    </div>
</footer>

<script>
    AOS.init({
        duration: 800,
        once: false
    });

    // Menu Burger JavaScript avec TOGGLE (ouvre et ferme avec le même bouton)
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

    // Un seul bouton pour ouvrir et fermer (toggle)
    burgerBtn.addEventListener('click', toggleMenu);
    closeMenuBtn.addEventListener('click', closeMenu);
    menuOverlay.addEventListener('click', closeMenu);

    // Fermer le menu quand on clique sur un lien
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
</script>

@stack('scripts')

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- PHP Email Form Validation (ce script est souvent local, pas sur CDN) -->
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- AOS (Animate On Scroll) -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- PureCounter -->
<script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>

<!-- imagesLoaded -->
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>

<!-- Isotope Layout -->
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<!-- Glightbox -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<!-- Main JS File -->
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
</style>

@livewireStyles
</body>

</html>
