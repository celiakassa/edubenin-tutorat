@extends('layouts.welcomeLayout')

@section('content')
    <style>
        /* ===== Page Recherche de tuteurs ===== */
        .search-page { background: var(--kp-surface); padding: var(--kp-section-py) 0; }
        .search-head { text-align: center; max-width: 640px; margin: 0 auto 18px; }

        .search-form {
            background: var(--kp-white);
            border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius);
            box-shadow: var(--kp-shadow-sm);
            padding: 14px 16px;
        }
        .search-form label { font-size: .76rem; font-weight: 600; color: var(--kp-muted); margin-bottom: 4px; display: block; }

        /* Barre de résultats */
        .results-bar {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px; margin: 36px 0 22px;
        }
        .results-bar__title {
            font-family: var(--kp-font-title); font-size: 1.4rem; font-weight: 700; color: var(--kp-ink); margin: 0;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .results-bar__title .count {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 30px; height: 26px; padding: 0 9px;
            background: var(--kp-blue); color: #fff; border-radius: var(--kp-radius-pill);
            font-size: .85rem; font-weight: 700;
        }
        .filter-chips { display: flex; flex-wrap: wrap; gap: 8px; }
        .filter-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--kp-blue-soft); color: var(--kp-blue);
            padding: 5px 6px 5px 12px; border-radius: var(--kp-radius-pill);
            font-size: .82rem; font-weight: 600;
        }
        .filter-chip a {
            display: inline-flex; width: 18px; height: 18px; border-radius: 50%;
            align-items: center; justify-content: center; color: var(--kp-blue);
            background: rgba(11, 105, 241, .12); text-decoration: none; transition: var(--kp-transition);
        }
        .filter-chip a:hover { background: var(--kp-blue); color: #fff; }

        /* Grille */
        .res-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
        @media (max-width: 1199px) { .res-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 991px)  { .res-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 575px)  { .res-grid { grid-template-columns: 1fr; } }

        /* Carte tuteur */
        .res-card {
            background: var(--kp-white);
            border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius);
            overflow: hidden;
            box-shadow: var(--kp-shadow-sm);
            display: flex; flex-direction: column; height: 100%;
            transition: var(--kp-transition);
        }
        .res-card:hover { transform: translateY(-6px); box-shadow: var(--kp-shadow-lg); }
        .res-card__media { position: relative; height: 148px; overflow: hidden; background: var(--kp-blue-soft); }
        .res-card__media img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
        .res-card:hover .res-card__media img { transform: scale(1.06); }
        .res-card__mode {
            position: absolute; top: 12px; right: 12px;
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(255, 255, 255, .95); color: var(--kp-ink);
            padding: 5px 11px; border-radius: var(--kp-radius-pill);
            font-size: .76rem; font-weight: 600; box-shadow: var(--kp-shadow-sm);
        }
        .res-card__body { padding: 14px 16px; display: flex; flex-direction: column; flex: 1; }
        .res-card__name {
            font-family: var(--kp-font-title); font-size: 1.02rem; font-weight: 700;
            color: var(--kp-ink); margin: 0 0 1px; display: flex; align-items: center; gap: 6px;
        }
        .res-card__name .bi-patch-check-fill { color: var(--kp-blue); font-size: .85rem; }
        .res-card__role { color: var(--kp-muted); font-size: .82rem; margin: 0 0 9px; }
        .res-card__tags { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 10px; }
        .res-card__tag {
            background: var(--kp-surface); border: 1px solid var(--kp-border); color: var(--kp-text);
            padding: 2px 9px; border-radius: var(--kp-radius-pill); font-size: .73rem; font-weight: 600;
        }
        .res-card__meta { display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px; }
        .res-card__meta div { display: flex; align-items: center; gap: 8px; color: var(--kp-text); font-size: .82rem; }
        .res-card__meta i { color: var(--kp-blue); }
        .res-card .kp-btn { margin-top: auto; }

        /* État vide */
        .search-empty {
            max-width: 560px; margin: 40px auto; text-align: center;
            background: var(--kp-white); border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius); box-shadow: var(--kp-shadow); padding: 48px 28px;
        }
        .search-empty i { font-size: 3rem; color: var(--kp-blue); opacity: .35; }

        /* Pagination */
        .search-page .pagination {
            --bs-pagination-color: var(--kp-blue);
            --bs-pagination-active-color: #1a1a1a;
            --bs-pagination-active-bg: var(--kp-yellow);
            --bs-pagination-active-border-color: var(--kp-yellow);
            --bs-pagination-hover-color: var(--kp-blue);
            --bs-pagination-hover-bg: var(--kp-blue-soft);
            gap: 4px;
        }
        .search-page .page-link { border-radius: var(--kp-radius-sm) !important; border: 1px solid var(--kp-border); }

        /* Modal profil tuteur */
        .tutor-modal .modal-dialog { max-width: 396px; }
        .tutor-modal .modal-content { border: none; border-radius: var(--kp-radius); overflow: hidden; }
        .tm-close {
            position: absolute; top: 14px; right: 14px; z-index: 3;
            width: 34px; height: 34px; border-radius: 50%; border: none;
            background: rgba(255, 255, 255, .9); color: var(--kp-ink);
            display: inline-flex; align-items: center; justify-content: center; cursor: pointer;
            transition: var(--kp-transition);
        }
        .tm-close:hover { background: var(--kp-white); }
        .tm-head { text-align: center; padding: 24px 20px 12px; }
        .tm-avatar {
            width: 76px; height: 76px; border-radius: 50%; overflow: hidden; margin: 0 auto 12px;
            border: 3px solid var(--kp-blue-soft); background: var(--kp-blue-soft);
        }
        .tm-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .tm-name { font-family: var(--kp-font-title); font-size: 1.15rem; font-weight: 700; color: var(--kp-ink); margin: 0 0 2px; }
        .tm-name .bi-patch-check-fill { color: var(--kp-blue); font-size: .9rem; }
        .tm-role { color: var(--kp-muted); font-size: .85rem; margin: 0; }
        .tm-rating { color: var(--kp-yellow); font-size: .9rem; margin-top: 5px; }
        .tm-body { padding: 0 20px 20px; }
        .tm-row { display: flex; align-items: center; gap: 10px; color: var(--kp-text); font-size: .88rem; padding: 5px 0; }
        .tm-row i { color: var(--kp-blue); width: 18px; }
        .tm-tags { display: flex; flex-wrap: wrap; gap: 6px; margin: 12px 0; }
        .tm-bio { color: var(--kp-muted); font-size: .9rem; line-height: 1.6; margin: 10px 0 18px; }
    </style>

    <div class="search-page">
        <div class="container">

            <div class="search-head">
                <h1 class="kp-title">Nos tuteurs</h1>
                <p class="kp-lead kp-muted">Affinez votre recherche ou lancez-en une nouvelle</p>
            </div>

            <!-- Formulaire de recherche -->
            <form action="{{ route('recherche.tuteur') }}" method="GET" class="search-form">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="subject">Matière</label>
                        <input type="text" name="subject" id="subject" class="kp-field"
                            placeholder="Ex : Mathématiques, Anglais…" value="{{ request('subject') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" class="kp-field"
                            placeholder="Entrez une ville" value="{{ request('city') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="learning_preference">Mode d'apprentissage</label>
                        <select name="learning_preference" id="learning_preference" class="kp-select">
                            <option value="">Tous les modes</option>
                            <option value="online" {{ request('learning_preference') == 'online' ? 'selected' : '' }}>En ligne</option>
                            <option value="in_person" {{ request('learning_preference') == 'in_person' ? 'selected' : '' }}>Présentiel</option>
                            <option value="both" {{ request('learning_preference') == 'both' ? 'selected' : '' }}>Les deux</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="kp-btn kp-btn--primary kp-btn--block">
                            <i class="bi bi-search"></i> Rechercher
                        </button>
                    </div>
                </div>
            </form>

            <!-- Barre de résultats + filtres actifs -->
            <div class="results-bar">
                <h2 class="results-bar__title">
                    <span class="count">{{ $tuteurs->total() }}</span>
                    tuteur{{ $tuteurs->total() > 1 ? 's' : '' }} trouvé{{ $tuteurs->total() > 1 ? 's' : '' }}
                </h2>
                <div class="filter-chips">
                    @if (request('subject'))
                        <span class="filter-chip">
                            <i class="bi bi-book"></i> {{ request('subject') }}
                            <a href="{{ request()->fullUrlWithoutQuery('subject') }}" aria-label="Retirer"><i class="bi bi-x"></i></a>
                        </span>
                    @endif
                    @if (request('city'))
                        <span class="filter-chip">
                            <i class="bi bi-geo-alt"></i> {{ request('city') }}
                            <a href="{{ request()->fullUrlWithoutQuery('city') }}" aria-label="Retirer"><i class="bi bi-x"></i></a>
                        </span>
                    @endif
                    @if (request('learning_preference'))
                        <span class="filter-chip">
                            <i class="bi bi-laptop"></i>
                            @if (request('learning_preference') == 'online') En ligne
                            @elseif(request('learning_preference') == 'in_person') Présentiel
                            @else Les deux @endif
                            <a href="{{ request()->fullUrlWithoutQuery('learning_preference') }}" aria-label="Retirer"><i class="bi bi-x"></i></a>
                        </span>
                    @endif
                </div>
            </div>

            @if ($tuteurs->count() == 0)
                <!-- Aucun résultat -->
                <div class="search-empty">
                    <i class="bi bi-search"></i>
                    <h3 class="kp-subtitle mt-3 mb-2">Aucun tuteur trouvé</h3>
                    <p class="kp-muted mb-4">Essayez d'élargir vos critères de recherche.</p>
                    <a href="{{ request()->fullUrlWithoutQuery(['subject', 'city', 'learning_preference']) }}"
                        class="kp-btn kp-btn--secondary">
                        <i class="bi bi-arrow-counterclockwise"></i> Réinitialiser
                    </a>
                </div>
            @else
                <!-- Grille des tuteurs -->
                <div class="res-grid">
                    @foreach ($tuteurs as $tuteur)
                        @php
                            $subjects = $tuteur->subjects->pluck('nom')->toArray();
                            $mode = $tuteur->learning_preference;
                            $modeLabel = $mode == 'online' ? 'En ligne' : ($mode == 'in_person' ? 'Présentiel' : 'Flexible');
                            $modeIcon = $mode == 'online' ? 'bi-wifi' : ($mode == 'in_person' ? 'bi-geo-alt' : 'bi-check2-circle');
                            $photo = $tuteur->photo_path ? Storage::url($tuteur->photo_path) : asset('images/profill_default.webp');
                            $rate = $tuteur->rate_per_hour ? number_format($tuteur->rate_per_hour, 0, ',', ' ') . ' FCFA/h' : 'Non renseigné';
                        @endphp
                        <article class="res-card">
                            <div class="res-card__media">
                                <img src="{{ $photo }}" alt="{{ $tuteur->firstname }} {{ $tuteur->lastname }}"
                                    onerror="this.src='{{ asset('images/profill_default.webp') }}'">
                                <span class="res-card__mode"><i class="bi {{ $modeIcon }}"></i> {{ $modeLabel }}</span>
                            </div>
                            <div class="res-card__body">
                                <h3 class="res-card__name">
                                    {{ $tuteur->firstname }} {{ $tuteur->lastname }}
                                    @if ($tuteur->is_valid == 1)<i class="bi bi-patch-check-fill" title="Tuteur vérifié"></i>@endif
                                </h3>
                                <p class="res-card__role">Professeur de {{ $subjects[0] ?? 'matières' }}</p>

                                @if (count($subjects))
                                    <div class="res-card__tags">
                                        @foreach (array_slice($subjects, 0, 3) as $s)
                                            <span class="res-card__tag">{{ $s }}</span>
                                        @endforeach
                                        @if (count($subjects) > 3)
                                            <span class="res-card__tag">+{{ count($subjects) - 3 }}</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="res-card__meta">
                                    <div><i class="bi bi-geo-alt"></i> {{ $tuteur->city ?? 'Non spécifiée' }}</div>
                                    <div><i class="bi bi-cash-coin"></i> {{ $rate }}</div>
                                </div>

                                <button type="button" class="kp-btn kp-btn--primary kp-btn--block js-tutor"
                                    data-name="{{ $tuteur->firstname }} {{ $tuteur->lastname }}"
                                    data-role="Professeur de {{ $subjects[0] ?? 'matières' }}"
                                    data-photo="{{ $photo }}"
                                    data-city="{{ $tuteur->city ?? 'Non spécifiée' }}"
                                    data-rate="{{ $rate }}"
                                    data-mode="{{ $modeLabel }}"
                                    data-tags="{{ implode('|', $subjects) }}"
                                    data-bio="{{ $tuteur->bio ?? '' }}"
                                    data-tel="{{ $tuteur->telephone ?? '' }}"
                                    data-verified="{{ $tuteur->is_valid == 1 ? '1' : '0' }}"
                                    data-rating="{{ $tuteur->satisfaction_score ?? 0 }}">
                                    Voir le profil
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($tuteurs->hasPages())
                    <div class="mt-5">
                        <nav aria-label="Pagination" class="d-flex justify-content-center">
                            {{ $tuteurs->links('pagination.kopiao') }}
                        </nav>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Modal profil tuteur -->
    <div class="modal fade tutor-modal" id="tutorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative">
                <button type="button" class="tm-close" data-bs-dismiss="modal" aria-label="Fermer"><i class="bi bi-x-lg"></i></button>
                <div class="tm-head">
                    <div class="tm-avatar"><img id="tmPhoto" src="" alt=""></div>
                    <h3 class="tm-name"><span id="tmName"></span> <i class="bi bi-patch-check-fill" id="tmVerified"></i></h3>
                    <p class="tm-role" id="tmRole"></p>
                    <div class="tm-rating" id="tmRating"></div>
                </div>
                <div class="tm-body">
                    <div class="tm-tags" id="tmTags"></div>
                    <div class="tm-row"><i class="bi bi-geo-alt"></i> <span id="tmCity"></span></div>
                    <div class="tm-row"><i class="bi bi-cash-coin"></i> <span id="tmRate"></span></div>
                    <div class="tm-row"><i class="bi bi-laptop"></i> <span id="tmMode"></span></div>
                    <p class="tm-bio" id="tmBio"></p>
                    <a href="#" id="tmContact" class="kp-btn kp-btn--accent kp-btn--block"><i class="bi bi-telephone"></i> Contacter</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalEl = document.getElementById('tutorModal');
            const modal = new bootstrap.Modal(modalEl);

            document.querySelectorAll('.js-tutor').forEach(btn => {
                btn.addEventListener('click', function () {
                    const d = this.dataset;
                    document.getElementById('tmPhoto').src = d.photo;
                    document.getElementById('tmName').textContent = d.name;
                    document.getElementById('tmRole').textContent = d.role;
                    document.getElementById('tmCity').textContent = d.city;
                    document.getElementById('tmRate').textContent = d.rate;
                    document.getElementById('tmMode').textContent = d.mode;
                    document.getElementById('tmBio').textContent = d.bio || 'Aucune description fournie.';
                    document.getElementById('tmVerified').style.display = d.verified === '1' ? '' : 'none';

                    // Étoiles
                    const r = Math.round(parseFloat(d.rating) || 0);
                    document.getElementById('tmRating').innerHTML = r > 0
                        ? '★'.repeat(Math.min(r, 5)) + '☆'.repeat(Math.max(0, 5 - r))
                        : '';

                    // Tags
                    const tags = (d.tags || '').split('|').filter(Boolean);
                    document.getElementById('tmTags').innerHTML = tags
                        .map(t => `<span class="res-card__tag">${t}</span>`).join('');

                    // Contact
                    const contact = document.getElementById('tmContact');
                    if (d.tel) {
                        contact.href = 'tel:' + d.tel;
                        contact.style.display = '';
                    } else {
                        contact.style.display = 'none';
                    }

                    modal.show();
                });
            });
        });
    </script>
@endsection
