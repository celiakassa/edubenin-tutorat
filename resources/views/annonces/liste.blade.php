@extends('layouts.welcomeLayout')

@section('content')
    <style>
        /* ===== Page Liste des annonces ===== */
        .annonces-page { background: var(--kp-surface); }

        .annonces-hero {
            position: relative;
            padding: clamp(48px, 7vw, 80px) 0;
            background:
                linear-gradient(rgba(15, 17, 22, .68), rgba(15, 17, 22, .80)),
                url('{{ asset('images/1.webp') }}') center/cover no-repeat;
            color: #fff;
            text-align: center;
            border-radius: 0 0 36px 36px;
            overflow: hidden;
        }
        .annonces-hero h1 { color: #fff; }
        .annonces-hero h1 { font-family: var(--kp-font-title); font-weight: 800; font-size: clamp(1.8rem, 1.2rem + 3vw, 2.8rem); margin: 0 0 10px; }
        .annonces-hero p { font-size: 1.05rem; opacity: .92; margin: 0 0 26px; }
        .annonces-search {
            max-width: 580px; margin: 0 auto;
            display: flex; align-items: center; gap: 6px;
            background: #fff; border-radius: var(--kp-radius-pill); padding: 6px 6px 6px 20px;
            box-shadow: var(--kp-shadow);
        }
        .annonces-search input { flex: 1; border: none; outline: none; background: transparent; font-size: 1rem; color: var(--kp-text); padding: 8px 0; }
        .annonces-search .kp-btn { flex: 0 0 auto; }
        .annonces-search__active { margin-top: 12px; font-size: .85rem; }
        .annonces-search__active a { color: #fff; text-decoration: underline; }

        .annonces-body { padding: var(--kp-section-py) 0; }

        /* Stats */
        .annonces-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; }
        @media (max-width: 767px) { .annonces-stats { grid-template-columns: 1fr; } }
        .astat {
            display: flex; align-items: center; gap: 14px;
            background: var(--kp-white); border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius); box-shadow: var(--kp-shadow-sm); padding: 16px 18px;
        }
        .astat__icon {
            width: 48px; height: 48px; border-radius: 50%; flex: 0 0 auto;
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--kp-blue-soft); color: var(--kp-blue); font-size: 1.4rem;
        }
        .astat__value { font-family: var(--kp-font-title); font-weight: 700; font-size: 1.3rem; color: var(--kp-ink); display: block; line-height: 1.1; }
        .astat__label { color: var(--kp-muted); font-size: .85rem; }

        /* Filtres */
        .filters-card {
            background: var(--kp-white); border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius); box-shadow: var(--kp-shadow-sm);
            padding: 22px; margin-bottom: 36px;
        }
        .filters-card label { font-size: .82rem; font-weight: 600; color: var(--kp-text); margin-bottom: 6px; display: block; }
        .filters-card label i { color: var(--kp-blue); }

        /* Grille annonces */
        .annonces-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        @media (max-width: 991px) { .annonces-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 575px) { .annonces-grid { grid-template-columns: 1fr; } }

        .acard {
            background: var(--kp-white); border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius); overflow: hidden; box-shadow: var(--kp-shadow-sm);
            display: flex; flex-direction: column; height: 100%; transition: var(--kp-transition);
        }
        .acard:hover { transform: translateY(-6px); box-shadow: var(--kp-shadow-lg); }
        .acard__top {
            display: flex; align-items: center; justify-content: space-between;
            padding: 13px 18px; background: var(--kp-blue); color: #fff;
        }
        .acard__format {
            display: inline-flex; align-items: center; gap: 5px;
            background: #fff; color: var(--kp-blue);
            padding: 4px 11px; border-radius: var(--kp-radius-pill); font-size: .76rem; font-weight: 600;
        }
        .acard__budget { font-weight: 700; font-size: 1rem; }
        .acard__body { padding: 18px; display: flex; flex-direction: column; flex: 1; }
        .acard__subject { font-family: var(--kp-font-title); font-size: 1.15rem; font-weight: 700; color: var(--kp-ink); margin: 0 0 8px; }
        .acard__desc { color: var(--kp-muted); font-size: .9rem; line-height: 1.55; margin: 0 0 14px; }
        .acard__student { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
        .acard__avatar { width: 38px; height: 38px; border-radius: 50%; overflow: hidden; flex: 0 0 auto; background: var(--kp-blue-soft); display: inline-flex; align-items: center; justify-content: center; }
        .acard__avatar img { width: 100%; height: 100%; object-fit: cover; }
        .acard__avatar i { color: var(--kp-blue); font-size: 1.4rem; }
        .acard__time { color: var(--kp-muted); font-size: .82rem; }
        .acard__dispo {
            display: flex; align-items: center; gap: 8px;
            background: var(--kp-surface); border-radius: var(--kp-radius-sm);
            padding: 9px 12px; margin-bottom: 16px; color: var(--kp-text); font-size: .82rem;
        }
        .acard__dispo i { color: var(--kp-blue); }
        .acard .kp-btn { margin-top: auto; }

        /* État vide */
        .annonces-empty {
            max-width: 560px; margin: 30px auto; text-align: center;
            background: var(--kp-white); border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius); box-shadow: var(--kp-shadow); padding: 48px 28px;
        }
        .annonces-empty i { font-size: 3rem; color: var(--kp-blue); opacity: .35; }

        .annonces-body .pagination {
            --bs-pagination-color: var(--kp-blue);
            --bs-pagination-active-color: #1a1a1a;
            --bs-pagination-active-bg: var(--kp-yellow);
            --bs-pagination-active-border-color: var(--kp-yellow);
            --bs-pagination-hover-color: var(--kp-blue);
            --bs-pagination-hover-bg: var(--kp-blue-soft);
            gap: 4px;
        }
        .annonces-body .page-link { border-radius: var(--kp-radius-sm) !important; border: 1px solid var(--kp-border); }
    </style>

    <div class="annonces-page">
        <!-- Hero -->
        <section class="annonces-hero">
            <div class="container">
                <h1>Toutes les annonces</h1>
                <p>Découvrez les {{ $stats['total'] }} missions disponibles et trouvez celle qui vous correspond</p>

                <form action="{{ route('annoncesListe.liste') }}" method="GET">
                    <div class="annonces-search">
                        <input type="text" name="search" placeholder="Rechercher par matière ou mot-clé…" value="{{ request('search') }}">
                        <button type="submit" class="kp-btn kp-btn--accent"><i class="bi bi-search"></i></button>
                    </div>
                    @if (request('search'))
                        <div class="annonces-search__active">
                            Recherche : « {{ request('search') }} »
                            <a href="{{ route('annoncesListe.liste') }}">effacer</a>
                        </div>
                    @endif
                </form>
            </div>
        </section>

        <section class="annonces-body">
            <div class="container">

                <!-- Stats -->
                <div class="annonces-stats">
                    <div class="astat">
                        <span class="astat__icon"><i class="bi bi-megaphone"></i></span>
                        <div><span class="astat__value">{{ $stats['total'] ?? 0 }}</span><span class="astat__label">Annonces actives</span></div>
                    </div>
                    <div class="astat">
                        <span class="astat__icon"><i class="bi bi-cash-stack"></i></span>
                        <div><span class="astat__value">{{ number_format($stats['budget_moyen'] ?? 0, 0, ',', ' ') }} F</span><span class="astat__label">Budget moyen</span></div>
                    </div>
                    <div class="astat">
                        <span class="astat__icon"><i class="bi bi-bar-chart"></i></span>
                        <div><span class="astat__value">{{ number_format($stats['budget_max'] ?? 0, 0, ',', ' ') }} F</span><span class="astat__label">Budget max</span></div>
                    </div>
                </div>

                <!-- Filtres -->
                <div class="filters-card">
                    <form action="{{ route('annoncesListe.liste') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <label><i class="bi bi-book"></i> Matière</label>
                                <select name="domaine" class="kp-select">
                                    <option value="">Toutes les matières</option>
                                    @if (!empty($matieres))
                                        @foreach ($matieres as $matiere)
                                            <option value="{{ $matiere }}" {{ request('domaine') == $matiere ? 'selected' : '' }}>{{ $matiere }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label><i class="bi bi-coin"></i> Budget min</label>
                                <input type="number" name="budget_min" class="kp-field" placeholder="Min (FCFA)" value="{{ request('budget_min') }}" min="0">
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label><i class="bi bi-coin"></i> Budget max</label>
                                <input type="number" name="budget_max" class="kp-field" placeholder="Max (FCFA)" value="{{ request('budget_max') }}" min="0">
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label><i class="bi bi-laptop"></i> Format</label>
                                <select name="format" class="kp-select">
                                    <option value="">Tous</option>
                                    <option value="presentiel" {{ request('format') == 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                                    <option value="en_ligne" {{ request('format') == 'en_ligne' ? 'selected' : '' }}>En ligne</option>
                                    <option value="hybrid" {{ request('format') == 'hybrid' ? 'selected' : '' }}>Hybride</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label><i class="bi bi-calendar"></i> Disponible le</label>
                                <select name="jour" class="kp-select">
                                    <option value="">Tous les jours</option>
                                    @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $j)
                                        <option value="{{ $j }}" {{ request('jour') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end mt-3">
                            <a href="{{ route('annoncesListe.liste') }}" class="kp-btn kp-btn--ghost"><i class="bi bi-x-circle"></i> Effacer</a>
                            <button type="submit" class="kp-btn kp-btn--primary"><i class="bi bi-funnel"></i> Appliquer</button>
                        </div>
                    </form>
                </div>

                <!-- Grille -->
                @if (isset($annonces) && $annonces->count() > 0)
                    <div class="annonces-grid">
                        @foreach ($annonces as $annonce)
                            <article class="acard">
                                <div class="acard__top">
                                    <span class="acard__format">
                                        @if ($annonce->format == 'presentiel')<i class="bi bi-person-workspace"></i> Présentiel
                                        @elseif($annonce->format == 'en_ligne')<i class="bi bi-laptop"></i> En ligne
                                        @else<i class="bi bi-arrow-left-right"></i> Hybride @endif
                                    </span>
                                    <span class="acard__budget">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="acard__body">
                                    <h3 class="acard__subject">{{ $annonce->subject->nom ?? 'Matière non spécifiée' }}</h3>
                                    <p class="acard__desc">{{ Str::limit($annonce->description, 120) }}</p>

                                    <div class="acard__student">
                                        <span class="acard__avatar">
                                            @if ($annonce->student && $annonce->student->photo_path)
                                                <img src="{{ asset('storage/' . $annonce->student->photo_path) }}" alt="{{ $annonce->student->firstname }}">
                                            @else
                                                <i class="bi bi-person-circle"></i>
                                            @endif
                                        </span>
                                        <span class="acard__time"><i class="bi bi-clock"></i> {{ $annonce->created_at->diffForHumans() }}</span>
                                    </div>

                                    <div class="acard__dispo">
                                        <i class="bi bi-calendar-check"></i>
                                        <span>{{ Str::limit($annonce->disponibilite ?? 'Non spécifié', 50) }}</span>
                                    </div>

                                    <a href="{{ route('annoncesListe.publique.detail', $annonce->id) }}" class="kp-btn kp-btn--primary kp-btn--block">
                                        <i class="bi bi-eye"></i> Voir les détails
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        {{ $annonces->links('pagination.kopiao') }}
                    </div>
                @else
                    <div class="annonces-empty">
                        <i class="bi bi-inbox"></i>
                        <h3 class="kp-subtitle mt-3 mb-2">Aucune annonce trouvée</h3>
                        <p class="kp-muted mb-4">Essayez de modifier vos filtres ou revenez plus tard.</p>
                        <a href="{{ route('annoncesListe.liste') }}" class="kp-btn kp-btn--secondary">
                            <i class="bi bi-arrow-repeat"></i> Réinitialiser les filtres
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
