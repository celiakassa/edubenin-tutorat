<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inscription') — Kopiao</title>
    <link href="{{ asset('favicon.svg') }}" rel="icon" type="image/svg+xml">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Rubik:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/kopiao-ui.css') }}" rel="stylesheet">

    @include('partials.landing-styles')

    <style>
        html, body { height: 100%; margin: 0; overflow: hidden; scrollbar-gutter: auto !important; }
        body { background: var(--kp-white); }

        .auth-split { display: flex; height: 100%; flex-direction: row-reverse; overflow: hidden; }

        /* Gauche : formulaire (blanc) */
        .auth-split__form {
            flex: 1 1 58%;
            display: flex; overflow-y: auto;
            padding: 44px 24px; background: var(--kp-white);
            border-radius: 48px 0 0 48px;
            margin-left: -48px;
            position: relative; z-index: 2;
        }
        .auth-split__form-inner { width: 100%; max-width: 520px; margin: auto; }
        .auth-split__logo {
            display: none; font-family: var(--kp-font-title); font-weight: 800;
            font-size: 1.5rem; color: var(--kp-blue); text-decoration: none; margin-bottom: 22px;
        }

        /* Droite : branding (bleu) */
        .auth-split__brand {
            flex: 0 0 42%; position: relative; overflow: hidden;
            background: linear-gradient(150deg, var(--kp-blue), var(--kp-blue-darker));
            color: #fff; display: flex; align-items: center; justify-content: center; padding: 48px;
        }
        .auth-split__brand > div { position: relative; z-index: 1; }
        .auth-back {
            position: absolute; top: 24px; left: 24px; z-index: 2;
            width: 44px; height: 44px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, .14); color: #fff; font-size: 1.2rem;
            text-decoration: none; transition: var(--kp-transition);
        }
        .auth-back:hover { background: rgba(255, 255, 255, .26); color: #fff; transform: translateX(-2px); }
        .auth-split__brand-name {
            font-family: var(--kp-font-title); font-weight: 700; font-size: clamp(2.9rem, 1.8rem + 3.6vw, 4.6rem);
            margin: 0; line-height: 1; letter-spacing: .3px; color: #fff;
            animation: brandFadeUp .9s cubic-bezier(.2, .7, .2, 1) both;
        }
        .auth-split__brand-textwrap {
            display: grid; grid-template-rows: 0fr;
            animation: brandTextGrow .85s ease .6s forwards;
        }
        .auth-split__brand-text {
            overflow: hidden; min-height: 0; margin: 0; padding-top: 18px;
            font-size: 1.1rem; opacity: .92; max-width: 380px; line-height: 1.65;
        }
        @keyframes brandFadeUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes brandTextGrow {
            from { grid-template-rows: 0fr; opacity: 0; }
            to { grid-template-rows: 1fr; opacity: 1; }
        }
        .auth-split__brand::before { content: ''; position: absolute; width: 420px; height: 420px; border-radius: 50%; background: rgba(255, 255, 255, .06); top: -130px; right: -120px; }
        .auth-split__brand::after { content: ''; position: absolute; width: 300px; height: 300px; border-radius: 50%; background: rgba(255, 193, 7, .10); bottom: -100px; left: -80px; }

        /* Navbar/footer du site : masqués en desktop (le design scindé reste), visibles en mobile */
        @media (min-width: 992px) {
            #header, #footer, #sidebarMenu, #menuOverlay { display: none !important; }
        }
        @media (max-width: 991px) {
            html, body { height: auto; overflow: auto; }
            .auth-split { display: block; height: auto; overflow: visible; }
            .auth-split__brand { display: none; }
            .auth-split__form { min-height: 100dvh; overflow: visible; padding: 88px 20px 40px; border-radius: 0; margin-left: 0; }
        }
    </style>
    @stack('head')
</head>

<body>
    @include('partials.landing-navbar')

    <div class="auth-split">
        <main class="auth-split__form">
            <div class="auth-split__form-inner">
                <a href="{{ url('/') }}" class="auth-split__logo">Kopiao</a>
                @yield('content')
            </div>
        </main>

        <aside class="auth-split__brand">
            <a href="{{ url()->previous() }}" class="auth-back" aria-label="Retour">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="auth-split__brand-name">Kopiao</h1>
                <div class="auth-split__brand-textwrap">
                    <p class="auth-split__brand-text">@yield('brand_text', 'Kopiao connecte les apprenants aux meilleurs tuteurs du Bénin. Trouvez un tuteur, publiez une annonce et progressez à votre rythme, en ligne comme en présentiel.')</p>
                </div>
            </div>
        </aside>
    </div>

    @include('partials.landing-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/newsletter.js') }}"></script>

    <script>
        (function () {
            const burgerBtn = document.getElementById('burgerBtn');
            const sidebarMenu = document.getElementById('sidebarMenu');
            const closeMenuBtn = document.getElementById('closeMenuBtn');
            const menuOverlay = document.getElementById('menuOverlay');
            if (burgerBtn && sidebarMenu) {
                const toggle = () => {
                    sidebarMenu.classList.toggle('active');
                    if (menuOverlay) menuOverlay.classList.toggle('active');
                    document.body.classList.toggle('menu-open');
                    burgerBtn.classList.toggle('active');
                };
                const close = () => {
                    sidebarMenu.classList.remove('active');
                    if (menuOverlay) menuOverlay.classList.remove('active');
                    document.body.classList.remove('menu-open');
                    burgerBtn.classList.remove('active');
                };
                burgerBtn.addEventListener('click', toggle);
                if (closeMenuBtn) closeMenuBtn.addEventListener('click', close);
                if (menuOverlay) menuOverlay.addEventListener('click', close);
                document.querySelectorAll('.sidebar-link').forEach(l => l.addEventListener('click', close));
            }
            const navProfile = document.getElementById('navProfile');
            const navProfileBtn = document.getElementById('navProfileBtn');
            if (navProfile && navProfileBtn) {
                navProfileBtn.addEventListener('click', function (e) { e.stopPropagation(); navProfile.classList.toggle('open'); });
                document.addEventListener('click', function (e) { if (!navProfile.contains(e.target)) navProfile.classList.remove('open'); });
            }
        })();
    </script>
    @stack('scripts')
</body>

</html>
