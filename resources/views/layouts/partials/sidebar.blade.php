<div class="sidebar" style="background-color: #2652a3; color: white;">
    <div class="sidebar-header">
        <div class="logo" onclick="window.location.href='{{ url('/') }}'" style="cursor:pointer; color: rgb(0, 0, 0);">KP</div>
        <div class="logo-text" onclick="window.location.href='{{ url('/') }}'" style="cursor:pointer; color: white;">Kopiao</div>
    </div>

    <div class="sidebar-menu">
        <!-- Badge tuteur vérifié -->
        @if (auth()->user() && auth()->user()->isTuteur() && auth()->user()->is_valid == 1)
            <center>
                <div class="tutor-verified mb-2">
                    <span class="verified-badge" style="color: white;">
                        <i class="fas fa-check-circle" style="color: white;"></i> Tuteur vérifié
                    </span>
                </div>
            </center>
        @endif

        <br>

        <div class="menu-item {{ request()->routeIs('dashboardUser') ? 'active' : '' }}"
             onclick="window.location.href='{{ route('dashboardUser') }}'">
            <i class="fas fa-tachometer-alt" style="color: white;"></i>
            <span class="menu-text" style="color: white;">Tableau de bord</span>
        </div>

        <div class="menu-item {{ request()->routeIs('CompleterProfilUser.show') ? 'active' : '' }}"
             onclick="window.location.href='{{ route('CompleterProfilUser.show') }}'">
            <i class="fas fa-user" style="color: white;"></i>
            <span class="menu-text" style="color: white;">Mon profil</span>
        </div>

        <div class="menu-item {{ request()->routeIs('CompleterProfilUser.edit') ? 'active' : '' }}"
             onclick="window.location.href='{{ route('CompleterProfilUser.edit') }}'">
            <i class="fas fa-user-edit" style="color: white;"></i>
            <span class="menu-text" style="color: white;">Compléter mon profil</span>
        </div>

        @auth
            {{-- Étudiant --}}
            @if(auth()->user()->isEtudiant())
                <div class="menu-item {{ request()->routeIs('annonces.create') ? 'active' : '' }}"
                     onclick="window.location.href='{{ route('annonces.create') }}'">
                    <i class="fas fa-bullhorn" style="color: white;"></i>
                    <span class="menu-text" style="color: white;">Faire une annonce</span>
                </div>

                <div class="menu-item {{ request()->routeIs('annonces.index') ? 'active' : '' }}"
                     onclick="window.location.href='{{ route('annonces.index') }}'">
                    <i class="fas fa-list" style="color: white;"></i>
                    <span class="menu-text" style="color: white;">Mes annonces</span>
                </div>
            @endif

            {{-- Tuteur --}}
            @if(auth()->user()->isTuteur())
                <div class="menu-item {{ request()->routeIs('annonces') ? 'active' : '' }}"
                     onclick="window.location.href='{{ route('annonces') }}'">
                    <i class="fas fa-eye" style="color: white;"></i>
                    <span class="menu-text" style="color: white;">Voir les annonces</span>
                </div>

                <div class="menu-item {{ request()->routeIs('candidatures.index') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list" style="color: white;"></i>
                    <span class="menu-text" style="color: white;">État de mes candidatures</span>
                </div>

                <div class="menu-item {{ request()->routeIs('abonnements.user') ? 'active' : '' }}"
                     onclick="window.location.href='{{ route('abonnements.user') }}'">
                    <i class="fas fa-credit-card" style="color: white;"></i>
                    <span class="menu-text" style="color: white;">Voir mes abonnements</span>
                </div>
            @endif
        @endauth

        <div class="menu-item logout-item" style="width: 100%;">
            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                @csrf
                <button type="submit"
                    style="display: flex; align-items: center; gap: 10px; color: white; background: #e02c18;
                           padding: 13px 10px; border: none; border-radius: 6px;
                           font-weight: 500; margin-top: 5px; transition: background 0.3s;
                           width: 100%; cursor: pointer;">
                    <i class="fas fa-sign-out-alt" style="color: white;"></i>
                    <span style="font-size: 16px; color: white;">Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</div>
