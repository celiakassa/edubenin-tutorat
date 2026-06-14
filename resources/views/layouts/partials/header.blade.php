<header class="dash-header">
    <div class="d-flex align-items-center" style="gap: 14px;">
        <button class="dash-burger" id="dashBurger" aria-label="Ouvrir le menu"><i class="bi bi-list"></i></button>
        <h1 class="dash-header__title">@yield('page-title', 'Tableau de bord')</h1>
    </div>

    <div class="dash-user" id="dashUser">
        <span class="dash-user__avatar">
            @if (auth()->user()->photo_path && Storage::disk('public')->exists(auth()->user()->photo_path))
                <img src="{{ asset('storage/' . auth()->user()->photo_path) }}" alt="Profil">
            @else
                {{ strtoupper(substr(auth()->user()->firstname, 0, 1) . substr(auth()->user()->lastname, 0, 1)) }}
            @endif
        </span>

        <div class="dash-user__menu" id="dashUserMenu">
            <div class="dash-user__card">
                <span class="dash-user__card-avatar">
                    @if (auth()->user()->photo_path && Storage::disk('public')->exists(auth()->user()->photo_path))
                        <img src="{{ asset('storage/' . auth()->user()->photo_path) }}" alt="Profil">
                    @else
                        {{ strtoupper(substr(auth()->user()->firstname, 0, 1) . substr(auth()->user()->lastname, 0, 1)) }}
                    @endif
                </span>
                <div class="dash-user__card-info">
                    <span class="dash-user__card-name">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</span>
                    <span class="dash-user__card-email">{{ auth()->user()->email }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dash-user__logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</button>
            </form>
        </div>
    </div>
</header>
