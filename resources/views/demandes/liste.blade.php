@extends('layouts.welcomeLayout')

@section('content')
    <style>
        /* ===== Page Demandes des apprenants ===== */
        .demandes-page { background: var(--kp-surface); min-height: 100vh; }

        /* Hero avec image */
        .demandes-hero {
            position: relative;
            padding: clamp(48px, 7vw, 80px) 0;
            background:
                linear-gradient(rgba(15, 17, 22, .68), rgba(15, 17, 22, .80)),
                url('{{ asset('images/demandestout.jpg') }}') center/cover no-repeat;
            color: #fff;
            text-align: center;
            border-radius: 0 0 36px 36px;
            overflow: hidden;
        }
        .demandes-hero h1 { font-family: var(--kp-font-title); font-weight: 800; font-size: clamp(1.8rem, 1.2rem + 3vw, 2.8rem); color: #fff; margin: 0 0 10px; }
        .demandes-hero p { font-size: 1.05rem; opacity: .92; margin: 0 0 26px; color: #fff; }
        .demandes-hero .divider { width: 64px; height: 3px; background: var(--kp-yellow); border-radius: 3px; margin: 14px auto 0; }

        /* Recherche */
        .dm-search {
            max-width: 640px; margin: 0 auto 30px;
            display: flex; align-items: center; gap: 8px;
            background: var(--kp-white); border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius-pill); padding: 6px 14px 6px 18px; box-shadow: var(--kp-shadow-sm);
        }
        .dm-search i { color: var(--kp-blue); font-size: 1.1rem; }
        .dm-search input { flex: 1; border: none; outline: none; background: transparent; padding: 10px 0; font-size: 1rem; color: var(--kp-text); }
        .dm-search a { color: var(--kp-muted); text-decoration: none; }

        /* Carte filtres (sidebar) */
        .dm-filters {
            background: var(--kp-white); border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius); box-shadow: var(--kp-shadow-sm); padding: 22px; position: sticky; top: 88px;
        }
        .dm-filters h5 { font-family: var(--kp-font-title); font-size: 1.05rem; font-weight: 700; color: var(--kp-ink); margin: 0 0 18px; }
        .dm-filters h5 i { color: var(--kp-blue); }
        .dm-matieres { max-height: 380px; overflow-y: auto; padding-right: 4px; }
        .dm-check { display: flex; align-items: center; gap: 8px; padding: 6px 0; cursor: pointer; }
        .dm-check input { accent-color: var(--kp-blue); width: 16px; height: 16px; cursor: pointer; }
        .dm-check label { font-size: .9rem; color: var(--kp-text); cursor: pointer; margin: 0; }
        .dm-stats { margin-top: 18px; padding: 14px; border-radius: var(--kp-radius-sm); background: var(--kp-surface); }
        .dm-stats div { display: flex; align-items: center; gap: 8px; font-size: .88rem; color: var(--kp-text); }
        .dm-stats div + div { margin-top: 6px; }
        .dm-stats i { color: var(--kp-blue); }

        /* Cartes demandes */
        .dm-card {
            background: var(--kp-white); border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius); box-shadow: var(--kp-shadow-sm); padding: 18px;
            display: flex; gap: 16px; margin-bottom: 18px; transition: var(--kp-transition);
        }
        .dm-card:hover { transform: translateY(-4px); box-shadow: var(--kp-shadow-lg); }
        .dm-card__icon {
            width: 46px; height: 46px; border-radius: 50%; flex: 0 0 auto;
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--kp-blue-soft); color: var(--kp-blue); font-size: 1.2rem;
        }
        .dm-card__main { flex: 1; min-width: 0; }
        .dm-card__title { font-family: var(--kp-font-title); font-size: 1.15rem; font-weight: 700; color: var(--kp-ink); margin: 0 0 6px; }
        .dm-card__match { display: inline-block; background: var(--kp-yellow); color: #1a1a1a; font-size: .68rem; font-weight: 600; padding: 2px 8px; border-radius: var(--kp-radius-pill); margin-left: 6px; vertical-align: middle; }
        .dm-card__desc { color: var(--kp-muted); font-size: .9rem; line-height: 1.55; margin: 0 0 10px; }
        .dm-card__desc mark { background: var(--kp-yellow); color: #1a1a1a; padding: 1px 4px; border-radius: 4px; }
        .dm-card__date { color: var(--kp-muted); font-size: .82rem; }
        .dm-card__date i { color: var(--kp-blue); }
        .dm-card__side { flex: 0 0 auto; text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 10px; }
        .dm-card__budget { background: var(--kp-blue-soft); border-radius: var(--kp-radius-sm); padding: 6px 12px; }
        .dm-card__budget strong { color: var(--kp-blue); font-size: 1.15rem; font-weight: 800; }
        .dm-card__budget small { color: var(--kp-muted); }

        /* État vide - amélioré avec marge en bas */
        .dm-empty-wrapper {
            padding: 40px 0 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }
        .dm-empty {
            text-align: center;
            padding: 50px 40px 60px;
            background: var(--kp-white);
            border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius);
            box-shadow: var(--kp-shadow);
            max-width: 640px;
            width: 100%;
            margin: 0 auto;
        }
        .dm-empty .empty-icon {
            font-size: 4rem;
            color: var(--kp-blue);
            opacity: 0.3;
            margin-bottom: 16px;
        }
        .dm-empty .empty-icon i {
            display: block;
        }
        .dm-empty h3 {
            font-family: var(--kp-font-title);
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--kp-ink);
            margin: 0 0 8px;
        }
        .dm-empty p {
            color: var(--kp-muted);
            font-size: 0.95rem;
            margin: 0 0 24px;
            line-height: 1.7;
            max-width: 460px;
            margin-left: auto;
            margin-right: auto;
        }
        .dm-empty .empty-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .dm-empty .empty-actions .kp-btn {
            min-width: 180px;
            padding: 12px 24px;
            font-weight: 600;
        }
        .dm-empty .empty-actions .kp-btn i {
            margin-right: 8px;
        }

        @media (max-width: 575px) {
            .dm-card { flex-direction: column; }
            .dm-card__side { text-align: left; align-items: flex-start; flex-direction: row; justify-content: space-between; width: 100%; }
            .dm-empty-wrapper { padding: 30px 0 60px; min-height: 300px; }
            .dm-empty { padding: 30px 20px 40px; }
            .dm-empty .empty-actions .kp-btn { min-width: 100%; }
            .dm-empty p { font-size: 0.9rem; }
        }

        .demandes-page .pagination {
            --bs-pagination-color: var(--kp-blue);
            --bs-pagination-active-color: #1a1a1a;
            --bs-pagination-active-bg: var(--kp-yellow);
            --bs-pagination-active-border-color: var(--kp-yellow);
            --bs-pagination-hover-color: var(--kp-blue);
            --bs-pagination-hover-bg: var(--kp-blue-soft);
            gap: 4px;
        }
        .demandes-page .page-link { border-radius: var(--kp-radius-sm) !important; border: 1px solid var(--kp-border); }
    </style>

    <div class="demandes-page">
        <!-- Hero avec image -->
        <section class="demandes-hero">
            <div class="container">
                <h1>Demandes des apprenants</h1>
                <p>Trouvez la mission qui correspond à vos compétences</p>
                <div class="divider"></div>
            </div>
        </section>

        <div class="container" style="padding-top: 32px;">

            <!-- Recherche live -->
            <form action="{{ route('demandesliste.liste') }}" method="GET" id="searchForm">
                <div class="dm-search">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" id="liveSearch" placeholder="Rechercher par matière ou mot-clé…"
                        value="{{ request('search') }}" autocomplete="off">
                    @if (request('search') || request('domaine'))
                        <a href="{{ route('demandesliste.liste') }}" aria-label="Effacer"><i class="fas fa-times-circle"></i></a>
                    @endif
                    <button type="submit" class="d-none">Rechercher</button>
                </div>
            </form>

            @if (request('search'))
                <p class="text-center kp-muted mb-4">
                    Résultats pour « <strong>{{ request('search') }}</strong> » : {{ $demandes->total() }} demande(s)
                </p>
            @endif

            <div class="row g-4">
                <!-- Filtres -->
                <div class="col-lg-3">
                    <div class="dm-filters">
                        <h5><i class="fas fa-filter"></i> Filtrer par</h5>
                        <form action="{{ route('demandesliste.liste') }}" method="GET" id="filterForm">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}" id="filterSearchInput">
                            @endif
                            <label class="fw-semibold mb-2 d-block" style="color: var(--kp-text);">
                                <i class="fas fa-book" style="color: var(--kp-blue);"></i> Matière
                            </label>
                            <div class="dm-matieres">
                                <div class="dm-check">
                                    <input class="form-check-input" type="radio" name="domaine" id="matiereTous" value=""
                                        {{ !request('domaine') ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    <label for="matiereTous">Toutes les matières</label>
                                </div>
                                @if (!empty($matieres))
                                    @foreach ($matieres as $matiere)
                                        <div class="dm-check">
                                            <input class="form-check-input" type="radio" name="domaine"
                                                id="matiere{{ $loop->index }}" value="{{ $matiere }}"
                                                {{ request('domaine') == $matiere ? 'checked' : '' }}
                                                onchange="document.getElementById('filterForm').submit()">
                                            <label for="matiere{{ $loop->index }}">{{ $matiere }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            @if (request('domaine') || request('search'))
                                <a href="{{ route('demandesliste.liste') }}" class="kp-btn kp-btn--ghost kp-btn--block kp-btn--sm mt-3">
                                    <i class="fas fa-times-circle"></i> Effacer les filtres
                                </a>
                            @endif
                        </form>

                        <div class="dm-stats">
                            <div><i class="fas fa-megaphone"></i> <strong>{{ $demandes->total() }}</strong>&nbsp;demande(s)</div>
                            <div><i class="fas fa-tags"></i> {{ count($matieres ?? []) }} matière(s)</div>
                        </div>
                    </div>
                </div>

                <!-- Liste -->
                <div class="col-lg-9" id="demandesList">
                    @if ($demandes->count() > 0)
                        @foreach ($demandes as $demande)
                            <article class="dm-card">
                                <span class="dm-card__icon">
                                    @if ($demande->format == 'presentiel')<i class="fas fa-user-graduate"></i>
                                    @elseif($demande->format == 'en_ligne')<i class="fas fa-laptop"></i>
                                    @else<i class="fas fa-arrows-left-right"></i> @endif
                                </span>
                                <div class="dm-card__main">
                                    <h4 class="dm-card__title">
                                        {{ $demande->subject->nom ?? 'Matière non spécifiée' }}
                                        @if (request('search'))
                                            @php
                                                $search = request('search');
                                                $position =
                                                    stripos($demande->description, $search) !== false ||
                                                    stripos($demande->subject->nom ?? '', $search) !== false;
                                            @endphp
                                            @if ($position)
                                                <span class="dm-card__match"><i class="fas fa-search"></i> Correspondance</span>
                                            @endif
                                        @endif
                                    </h4>
                                    <p class="dm-card__desc">
                                        @if (request('search'))
                                            @php
                                                $search = request('search');
                                                $description = $demande->description;
                                                $position = stripos($description, $search);
                                                if ($position !== false) {
                                                    $start = max(0, $position - 30);
                                                    $end = min(strlen($description), $position + strlen($search) + 30);
                                                    $extract = substr($description, $start, $end - $start);
                                                    if ($start > 0) { $extract = '...' . $extract; }
                                                    if ($end < strlen($description)) { $extract .= '...'; }
                                                    $extract = preg_replace('/(' . preg_quote($search, '/') . ')/i', '<mark>$1</mark>', $extract);
                                                    echo $extract;
                                                } else {
                                                    echo Str::limit($demande->description, 150);
                                                }
                                            @endphp
                                        @else
                                            {{ Str::limit($demande->description, 150) }}
                                        @endif
                                    </p>
                                    <span class="dm-card__date"><i class="fas fa-calendar"></i> {{ $demande->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="dm-card__side">
                                    <div class="dm-card__budget">
                                        <strong>{{ number_format($demande->budget, 0, ',', ' ') }}</strong> <small>FCFA</small>
                                    </div>
                                    <a href="{{ route('annoncesListe.publique.detail', $demande->id) }}" class="kp-btn kp-btn--primary kp-btn--sm">
                                        Voir détails <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </article>
                        @endforeach

                        <div class="d-flex justify-content-center mt-5">
                            {{ $demandes->links('pagination.kopiao') }}
                        </div>
                    @else
                        <div class="dm-empty-wrapper">
                            <div class="dm-empty">
                                <div class="empty-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h3>Aucune demande disponible pour le moment</h3>
                                <p>
                                    @if (request('search') || request('domaine'))
                                        Aucun résultat ne correspond à votre recherche. Essayez avec d'autres mots-clés ou effacez les filtres.
                                    @else
                                        Les apprenants n'ont pas encore publié de demandes. Revenez un peu plus tard ou devenez tuteur pour être averti dès qu'une nouvelle demande sera publiée.
                                    @endif
                                </p>
                                <div class="empty-actions">
                                    @if (request('search') || request('domaine'))
                                        <a href="{{ route('demandesliste.liste') }}" class="kp-btn kp-btn--secondary">
                                            <i class="fas fa-undo"></i> Voir toutes les demandes
                                        </a>
                                    @endif
                                    <a href="{{ route('register.tuteur') }}" class="kp-btn kp-btn--accent">
                                        <i class="fas fa-user-plus"></i> Devenir tuteur
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('liveSearch');
            const searchForm = document.getElementById('searchForm');
            const filterSearchInput = document.getElementById('filterSearchInput');
            let timeoutId = null;

            searchInput.addEventListener('input', function () {
                if (timeoutId) clearTimeout(timeoutId);
                if (filterSearchInput) filterSearchInput.value = this.value;
                timeoutId = setTimeout(() => searchForm.submit(), 400);
            });
            searchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); searchForm.submit(); }
            });
        });
    </script>
@endsection
