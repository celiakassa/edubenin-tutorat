<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> EduBenin</title>
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

    <!-- =======================================================
  * Template Name: Eventix
  * Template URL: https://bootstrapmade.com/eventix-bootstrap-events-website-template/
  * Updated: Sep 06 2025 with Bootstrap v5.3.8
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top shadow-sm mb-8"
    style="background: rgba(13, 110, 253, 0.95); backdrop-filter: blur(8px);">
    <div
        class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo d-flex align-items-center text-white text-decoration-none">
            <i class="bi bi-mortarboard-fill fs-3 me-2 text-warning"></i>
            <h1 class="sitename fw-bold mb-0">EduBenin Tutorat</h1>
        </a>

        <!-- Navigation -->
        <nav id="navmenu" class="navmenu">
            <ul class="d-flex align-items-center">
                <li><a href="index.html" class="active text-dark">Accueil</a></li>
                <li><a href="#about" class="text-dark">À propos</a></li>
                <li><a href="#services" class="text-dark">Nos Services</a></li>
                <li><a href="#professeurs" class="text-dark">Professeurs</a></li>
                <li><a href="#temoignages" class="text-dark">Témoignages</a></li>
                <li><a href="#contact" class="text-dark">Contact</a></li>

                <li class="dropdown"><a href="#"><span class="text-white">Plus</span> <i
                            class="bi bi-chevron-down toggle-dropdown text-white"></i></a>
                    <ul>
                        <li><a href="cours.html">Cours disponibles</a></li>
                        <li><a href="inscription.html">S’inscrire</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                        <li><a href="conditions.html">Conditions d’utilisation</a></li>
                        <li><a href="confidentialite.html">Politique de confidentialité</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Icône menu mobile -->
            <i class="mobile-nav-toggle d-xl-none bi bi-list text-white fs-3"></i>
        </nav>

        <!-- Bouton principal -->
        <a class="btn-getstarted btn btn-warning fw-semibold text-light px-4 py-2 rounded-pill"
            href="{{ route('login') }}">Se connecter</a>

    </div>
    <br> <br><br> <br><br>
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
                    <span class="sitename fw-bold fs-4">EduBenin Tutorat</span>
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
                    <li><a href="#services" class="text-white-50 text-decoration-none">Nos services</a></li>
                    <li><a href="#events" class="text-white-50 text-decoration-none">Événements</a></li>
                    <li><a href="#contact" class="text-white-50 text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- Nos Services -->
            <div class="col-lg-3 col-md-3 footer-links">
                <h4 class="text-warning fw-semibold mb-3">Nos Offres</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50 text-decoration-none">Tutorat académique</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Préparation aux examens</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Cours en ligne</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Conférences éducatives</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Accompagnement étudiant</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6 footer-newsletter">
                <h4 class="text-warning fw-semibold mb-3">Restez informé</h4>
                <p class="text-white-50">Abonnez-vous pour recevoir nos dernières actualités et offres spéciales.</p>
                <form action="#" method="post" class="d-flex mt-3">
                    <input type="email" name="email" class="form-control me-2 border-0 rounded-start"
                        placeholder="Votre e-mail" style="background-color: #f8fbff;">
                    <button type="submit" class="btn btn-warning text-dark fw-semibold px-3 rounded-end">
                        S’abonner
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Bas du footer -->
    <div class="container text-center py-3">
        <p class="mb-1 text-white-50">© <strong>EduBenin Tutorat</strong> — Tous droits réservés.</p>

    </div>

</footer>


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
          padding-top: 120px; /* correspond à la hauteur du header */
      }

  </style>

</body>

</html>
