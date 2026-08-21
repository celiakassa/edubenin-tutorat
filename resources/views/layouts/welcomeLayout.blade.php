<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Kopiao</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('favicon.svg') }}" rel="icon" type="image/svg+xml">
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

    @include("partials.landing-styles")
</head>

<body>

@include("partials.landing-navbar")

<main class="main">
    @yield('content')
</main>

@include("partials.landing-footer")


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


</script>
<script src="{{ asset('js/newsletter.js') }}"></script>

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
