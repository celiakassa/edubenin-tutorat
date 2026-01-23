<div class="header">
    <h1 class="page-title">@yield('page-title', 'Tableau de bord')</h1>

    <div class="user-info">
        <div class="user-avatar" id="avatar-dropdown-btn">
            @if (auth()->user()->photo_path && Storage::disk('public')->exists(auth()->user()->photo_path))
                <img src="{{ asset('storage/' . auth()->user()->photo_path) }}" alt="Photo de profil">
            @else
                {{ strtoupper(substr(auth()->user()->firstname, 0, 1) . substr(auth()->user()->lastname, 0, 1)) }}
            @endif
        </div>

        <span>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</span>

        <!-- MENU DÉROULANT -->
        <ul class="user-dropdown" id="avatar-dropdown">
            <li>
                <a href="{{ route('CompleterProfilUser.show') }}">Mon profil</a>
            </li>
            <li>
                <a href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Déconnexion
                </a>
            </li>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </ul>
    </div>
</div>

<script>
    const btn = document.getElementById("avatar-dropdown-btn");
    const menu = document.getElementById("avatar-dropdown");

    btn.addEventListener("click", () => {
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });

    // Fermer si on clique ailleurs
    document.addEventListener("click", (e) => {
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = "none";
        }
    });
</script>