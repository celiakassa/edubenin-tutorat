<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> EduConnect</title>
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




    <!-- =======================================================
  * Template Name: Eventix
  * Template URL: https://bootstrapmade.com/eventix-bootstrap-events-website-template/
  * Updated: Sep 06 2025 with Bootstrap v5.3.8
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    @livewireStyles
    @stack('styles')
</head>




<header id="header" class="header d-flex align-items-center fixed-top" style="background-color: blue;">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between"
        style=" margin-bottom: 35px;">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center text-white text-decoration-none">

            <h1 class="sitename fw-bold mb-0">EduConnect</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}" class="active">Accueil</a></li>
                <li><a href="#about">À propos</a></li>
                <li><a href="#services">Nos Services</a></li>
                <li><a href="{{ route('professeurs.index') }}">Professeurs</a></li>

                <li><a href="#contact">Contact</a></li>



            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>




        @auth
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger fw-semibold px-4 py-2 rounded-pill">
                    <i class="bi bi-box-arrow-right me-2"></i>Se déconnecter
                </button>
            </form>
        @else
        <div style="margin: 0px; padding: 0px;">
          <a class="btn-getstarted btn btn-warning bg-light fw-semibold text-dark px-4 py-2 rounded-pill" style="margin-right: 0px; padding-right:0px; border:solid 3px #0d6efd;"
                href="{{ route('register.tuteur') }}">
                Devenir tuteur
            </a>

            <a class="btn-getstarted btn btn-warning fw-semibold text-light px-4 py-2 rounded-pill"
                href="{{ route('login') }}">
                Se connecter
            </a>

            </div>
        @endauth

        <style>
            /* ================================
   CACHER LE BOUTON CONNEXION SUR MOBILE
=================================== */
            @media (max-width: 991px) {
                .btn-getstarted {
                    display: none !important;
                }
            }
        </style>

    </div>
</header>



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
                    <i class="bi bi-mortarboard-fill fs-3 me-2 text-warning"></i>
                    <span class="sitename fw-bold fs-4 text-light">EduConnect</span>
                </a>
                <div class="footer-contact pt-2">
                    <p>Campus Universitaire d’Abomey-Calavi</p>
                    <p>Cotonou, Bénin</p>
                    <p class="mt-3"><strong>Téléphone :</strong> <span>+229 91 45 67 89</span></p>
                    <p><strong>Email :</strong> <span>contact@edubenin.bj</span></p>
                </div>
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
                    <li><a href="#about" class="text-white-50 text-decoration-none">À propos</a></li>

                    <li><a href="#contact" class="text-white-50 text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- Nos Services -->
            <div class="col-lg-3 col-md-3 footer-links">
                <h4 class="text-warning fw-semibold mb-3">Nos Offres</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50 text-decoration-none">Tutorat académique</a></li>


                    <li><a href="#" class="text-white-50 text-decoration-none">Accompagnement étudiant</a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6 footer-newsletter">
                <h4 class="text-warning fw-semibold mb-3">Restez informé</h4>
                <p class="text-white-50">Abonnez-vous pour recevoir nos dernières actualités et offres spéciales.
                </p>
                <div class="d-flex mt-3">
                    <input type="email" id="emailInput" class="form-control me-2 border-0 rounded-start"
                        placeholder="Votre e-mail" style="background-color: #f8fbff;" required>

                    <button onclick="sendMail()" class="btn btn-warning text-dark fw-semibold px-3 rounded-end">
                        S’abonner
                    </button>
                </div>

                <script>
                    function sendMail() {
                        const emailField = document.getElementById("emailInput");
                        const email = emailField.value;

                        // Vérifie automatiquement au format email (HTML5)
                        if (!emailField.checkValidity()) {
                            alert("Veuillez entrer une adresse e-mail valide.");
                            return;
                        }

                        // Ouvre l'application email
                        window.location.href = `mailto:${email}?subject=Abonnement&body=Je souhaite m'abonner.`;
                    }
                </script>

            </div>

        </div>
    </div>

    <!-- Bas du footer -->
    <div class="container text-center py-3">
        <p class="mb-1 text-white-50">© <strong>EduBenin Tutorat</strong> — Tous droits réservés.</p>

    </div>

</footer>

<script>
    AOS.init({
        duration: 800,
        once: false
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
    /* Dans welcome.css ou dans une section <style> */
    body .main {
        padding-top: 120px;
        /* correspond à la hauteur du header */
    }
</style>
@livewireStyles
</body>

</html>
