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
            <a class="nav-link-item {{ request()->routeIs('faq') ? 'is-active' : '' }}" href="{{ route('faq') }}" style="margin-right: 1.75rem;">Comment ça marche ?</a>

            @auth
                <div class="nav-profile" id="navProfile">
                    <button type="button" class="nav-profile__btn" id="navProfileBtn" aria-haspopup="true" aria-expanded="false" aria-label="Mon compte">
                        <span class="nav-profile__avatar">
                            @if (auth()->user()->photo_path && Storage::disk('public')->exists(auth()->user()->photo_path))
                                <img src="{{ asset('storage/' . auth()->user()->photo_path) }}" alt="Profil">
                            @else
                                {{ strtoupper(substr(auth()->user()->firstname, 0, 1) . substr(auth()->user()->lastname, 0, 1)) }}
                            @endif
                        </span>
                    </button>
                    <div class="nav-profile__menu">
                        <a class="nav-profile__item" href="{{ route('dashboardUser') }}">
                            <i class="bi bi-grid-1x2"></i> Tableau de bord
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
            <span>Comment ça marche ?</span>
        </a>
        <a href="#" class="sidebar-link" id="contactLink">
            <i class="bi bi-envelope"></i>
            <span>Contact</span>
        </a>

        @guest
            <a href="{{ route('register.tuteur') }}" class="sidebar-link sidebar-link--cta">
                <i class="bi bi-mortarboard"></i>
                <span>Devenir tuteur</span>
            </a>
        @endguest

        @auth
            <a href="{{ route('dashboardUser') }}" class="sidebar-link">
                <i class="bi bi-grid-1x2"></i>
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

