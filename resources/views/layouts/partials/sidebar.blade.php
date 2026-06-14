<aside class="dash-sidebar" id="dashSidebar">
    <div class="dash-sidebar__brand">
        <a href="{{ route('home') }}" class="dash-sidebar__name" title="Retour à l'accueil du site">Kopiao</a>
        <button type="button" class="dash-sidebar__toggle" id="dashCollapse" aria-label="Replier ou déplier le menu">
            <i class="bi bi-chevron-double-left"></i>
        </button>
    </div>

    <nav class="dash-nav">
        @auth
            @if (auth()->user()->isEtudiant())
                <a class="dash-nav__cta" href="{{ route('annonces.create') }}"
                   onclick="if(window.openCreateAnnonceModal && document.getElementById('createAnnonceModal')){if(window.kpAnnonceFormToCreate)window.kpAnnonceFormToCreate();openCreateAnnonceModal();return false;}">
                    <i class="bi bi-plus-circle"></i> <span>Publier une annonce</span>
                </a>
            @endif
        @endauth

        <a class="dash-nav__item {{ request()->routeIs('dashboardUser') || request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboardUser') }}">
            <i class="bi bi-house-door"></i> <span>Tableau de bord</span>
        </a>

        @auth
            @if (auth()->user()->isEtudiant())
                <a class="dash-nav__item {{ request()->routeIs('annonces.index') ? 'active' : '' }}" href="{{ route('annonces.index') }}">
                    <i class="bi bi-megaphone"></i> <span>Mes annonces</span>
                </a>
                <a class="dash-nav__item {{ request()->routeIs('candidatures.*') || request()->routeIs('annonces.candidatures.*') ? 'active' : '' }}" href="{{ route('candidatures.mes') }}">
                    <i class="bi bi-people"></i> <span>Candidatures</span>
                </a>
            @endif

            @if (auth()->user()->isTuteur())
                <a class="dash-nav__item {{ request()->routeIs('annonces') ? 'active' : '' }}" href="{{ route('annonces') }}">
                    <i class="bi bi-eye"></i> <span>Voir les annonces</span>
                </a>
                <a class="dash-nav__item {{ request()->routeIs('candidatures.tuteur') ? 'active' : '' }}" href="{{ route('candidatures.tuteur') }}">
                    <i class="bi bi-clipboard-check"></i> <span>Mes candidatures</span>
                </a>
                <a class="dash-nav__item {{ request()->routeIs('abonnements.user') ? 'active' : '' }}" href="{{ route('abonnements.user') }}">
                    <i class="bi bi-credit-card"></i> <span>Mes abonnements</span>
                </a>
            @endif

            @if (auth()->user()->isAdmin())
                <a class="dash-nav__item {{ request()->routeIs('apprenants.*') ? 'active' : '' }}" href="{{ route('apprenants.index') }}">
                    <i class="bi bi-mortarboard"></i> <span>Apprenants</span>
                </a>
                <a class="dash-nav__item {{ request()->routeIs('admin.teacher.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-person-workspace"></i> <span>Tuteurs</span>
                </a>
            @endif
        @endauth

        <a class="dash-nav__item {{ request()->routeIs('CompleterProfilUser.*') ? 'active' : '' }}" href="{{ route('CompleterProfilUser.show') }}">
            <i class="bi bi-person"></i> <span>Profil</span>
        </a>
    </nav>

    <div class="dash-sidebar__foot">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dash-logout">
                <i class="bi bi-box-arrow-right"></i> <span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>
