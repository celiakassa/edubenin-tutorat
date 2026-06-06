@extends('layouts.welcomeLayout')

@section('content')
    <style>
        /* ===== Détail d'une annonce ===== */
        .detail-page { background: var(--kp-surface); }
        .detail-crumb { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 22px; font-size: .85rem; }
        .detail-crumb a { color: var(--kp-muted); text-decoration: none; transition: var(--kp-transition); }
        .detail-crumb a:hover { color: var(--kp-blue); }
        .detail-crumb i { color: var(--kp-muted); font-size: .66rem; opacity: .55; }
        .detail-crumb span { color: var(--kp-ink); font-weight: 600; }

        .detail-body { padding: var(--kp-section-py) 0; }

        .dcard {
            background: var(--kp-white); border: 1px solid var(--kp-border);
            border-radius: var(--kp-radius); box-shadow: var(--kp-shadow-sm); padding: 26px;
        }
        .dcard + .dcard { margin-top: 20px; }

        .detail-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--kp-blue-soft); color: var(--kp-blue);
            padding: 6px 14px; border-radius: var(--kp-radius-pill);
            font-weight: 700; font-size: .76rem; text-transform: uppercase; letter-spacing: .3px;
        }
        .detail-title { font-family: var(--kp-font-title); font-weight: 800; font-size: clamp(1.5rem, 1.1rem + 1.6vw, 2rem); color: var(--kp-ink); margin: 14px 0 0; line-height: 1.2; }
        .detail-budget {
            text-align: center; min-width: 140px; padding: 12px 16px;
            background: var(--kp-blue-soft); border-radius: var(--kp-radius-sm);
        }
        .detail-budget strong { display: block; color: var(--kp-blue); font-size: 1.7rem; font-weight: 800; line-height: 1; }
        .detail-budget small { color: var(--kp-muted); }

        .detail-info { display: flex; align-items: center; gap: 14px; margin-top: 22px; }
        .detail-info__icon {
            width: 46px; height: 46px; border-radius: var(--kp-radius-sm); flex: 0 0 auto;
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--kp-blue-soft); color: var(--kp-blue); font-size: 1.2rem;
        }
        .detail-info__label { font-size: .76rem; color: var(--kp-muted); font-weight: 600; margin: 0; }
        .detail-info__value { font-weight: 700; color: var(--kp-ink); margin: 0; }

        .detail-divider { height: 1px; background: var(--kp-border); margin: 26px 0; }
        .detail-sub { font-family: var(--kp-font-title); font-weight: 700; font-size: 1.05rem; color: var(--kp-ink); margin: 0 0 12px; display: flex; align-items: center; gap: 8px; }
        .detail-sub i { color: var(--kp-blue); }
        .detail-text { font-size: 1rem; line-height: 1.75; color: var(--kp-text); }
        .detail-dispo { display: flex; align-items: center; gap: 10px; color: var(--kp-text); margin-bottom: 8px; }
        .detail-dispo i { color: var(--kp-blue); }

        /* Sidebar */
        .detail-sidebar { position: sticky; top: 88px; }
        .detail-action { text-align: center; }
        .detail-action__label { color: var(--kp-muted); margin: 0 0 4px; font-size: .9rem; }
        .detail-action__amount { font-family: var(--kp-font-title); color: var(--kp-blue); font-size: 2.2rem; font-weight: 800; margin: 0 0 18px; }
        .detail-action__amount small { font-size: 1rem; }
        .detail-action__note { font-size: .82rem; color: var(--kp-muted); margin: 12px 0 0; }
        .detail-action__note i { color: var(--kp-blue); }

        .detail-sb-title { font-family: var(--kp-font-title); font-weight: 700; font-size: .78rem; text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); margin: 0 0 16px; }
        .detail-resume__item { display: flex; justify-content: space-between; gap: 12px; padding: 9px 0; font-size: .9rem; }
        .detail-resume__item + .detail-resume__item { border-top: 1px solid var(--kp-border); }
        .detail-resume__item .text-muted { color: var(--kp-muted); }
        .detail-resume__item strong { color: var(--kp-ink); }

        .detail-sim { display: flex; align-items: center; gap: 12px; padding: 10px 0; text-decoration: none; }
        .detail-sim + .detail-sim { border-top: 1px solid var(--kp-border); }
        .detail-sim__icon {
            width: 44px; height: 44px; border-radius: 50%; flex: 0 0 auto;
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--kp-blue-soft); color: var(--kp-blue); font-size: 1.05rem;
        }
        .detail-sim__name { font-weight: 700; color: var(--kp-ink); margin: 0; font-size: .95rem; }
        .detail-sim__budget { color: var(--kp-muted); font-size: .82rem; }
        .detail-sim:hover .detail-sim__name { color: var(--kp-blue); }

        @media (max-width: 991px) { .detail-sidebar { position: static; margin-top: 24px; } }

        /* Modals */
        .dmodal .modal-content { border: none; border-radius: var(--kp-radius); }
        .dmodal__icon {
            width: 74px; height: 74px; margin: 0 auto 18px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center; font-size: 2rem;
        }
        .dmodal__icon--blue { background: var(--kp-blue-soft); color: var(--kp-blue); }
        .dmodal__icon--warn { background: color-mix(in srgb, var(--kp-yellow), white 78%); color: var(--kp-yellow-dark); }
    </style>

    <div class="detail-page">
        <section class="detail-body">
            <div class="container">
                <nav class="detail-crumb" aria-label="Fil d'Ariane">
                    <a href="{{ route('home') }}">Accueil</a>
                    <i class="bi bi-chevron-right"></i>
                    <a href="{{ route('annoncesListe.liste') }}">Annonces</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>{{ $annonce->subject->nom ?? 'Matière non spécifiée' }}</span>
                </nav>
                <div class="row g-4">
                    <!-- Colonne principale -->
                    <div class="col-lg-8">
                        <div class="dcard">
                            <span class="detail-tag">
                                @if ($annonce->format == 'presentiel')<i class="bi bi-person-workspace"></i> Présentiel
                                @elseif($annonce->format == 'en_ligne')<i class="bi bi-laptop"></i> En ligne
                                @else<i class="bi bi-arrow-left-right"></i> Hybride @endif
                            </span>

                            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                <h1 class="detail-title">{{ $annonce->subject->nom ?? 'Matière non spécifiée' }}</h1>
                                <div class="detail-budget">
                                    <strong>{{ number_format($annonce->budget, 0, ',', ' ') }}</strong>
                                    <small>FCFA</small>
                                </div>
                            </div>

                            <div class="detail-info">
                                <span class="detail-info__icon"><i class="bi bi-calendar-event"></i></span>
                                <div>
                                    <p class="detail-info__label">Publiée le</p>
                                    <p class="detail-info__value">{{ $annonce->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <div class="detail-divider"></div>

                            <div class="mb-4">
                                <h5 class="detail-sub"><i class="bi bi-info-circle"></i> Description de la mission</h5>
                                <div class="detail-text">{{ $annonce->description }}</div>
                            </div>

                            @if ($annonce->disponibilite)
                                <div>
                                    <h5 class="detail-sub"><i class="bi bi-clock"></i> Disponibilités</h5>
                                    @foreach (explode("\n", $annonce->disponibilite) as $dispo)
                                        @if (!empty(trim($dispo)))
                                            <div class="detail-dispo"><i class="bi bi-check-circle"></i> <span>{{ trim($dispo) }}</span></div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="detail-sidebar">
                            <!-- Action -->
                            <div class="dcard detail-action">
                                <p class="detail-action__label">Rémunération totale</p>
                                <p class="detail-action__amount">{{ number_format($annonce->budget, 0, ',', ' ') }} <small>FCFA</small></p>

                                @auth
                                    @if (Auth::user()->role_id == 3)
                                        <button class="kp-btn kp-btn--accent kp-btn--block kp-btn--lg" onclick="showPostulerMessage()">
                                            <i class="bi bi-send"></i> Postuler maintenant
                                        </button>
                                    @else
                                        <button class="kp-btn kp-btn--accent kp-btn--block kp-btn--lg" onclick="showRoleMessage('postuler')">
                                            <i class="bi bi-send"></i> Postuler maintenant
                                        </button>
                                    @endif
                                @else
                                    <button class="kp-btn kp-btn--accent kp-btn--block kp-btn--lg" onclick="showLoginMessage()">
                                        <i class="bi bi-send"></i> Postuler maintenant
                                    </button>
                                @endauth

                                <p class="detail-action__note"><i class="bi bi-shield-check"></i> Paiement sécurisé via Kopiao</p>
                            </div>

                            <!-- Résumé -->
                            <div class="dcard">
                                <h5 class="detail-sb-title">Résumé</h5>
                                <div class="detail-resume__item"><span class="text-muted">Budget</span><strong>{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</strong></div>
                                <div class="detail-resume__item"><span class="text-muted">Format</span><strong>@if ($annonce->format == 'presentiel') Présentiel @elseif($annonce->format == 'en_ligne') En ligne @else Hybride @endif</strong></div>
                                <div class="detail-resume__item"><span class="text-muted">Publication</span><strong>{{ $annonce->created_at->format('d/m/Y') }}</strong></div>
                                <div class="detail-resume__item"><span class="text-muted">Disponibilités</span><strong>{{ $annonce->disponibilite ? substr_count($annonce->disponibilite, "\n") + 1 : 0 }} créneaux</strong></div>
                            </div>

                            <!-- Annonces similaires -->
                            @if (isset($annoncesSimilaires) && $annoncesSimilaires->count() > 0)
                                <div class="dcard">
                                    <h5 class="detail-sb-title">Annonces similaires</h5>
                                    @foreach ($annoncesSimilaires as $similaire)
                                        <a href="{{ route('annoncesListe.publique.detail', $similaire->id) }}" class="detail-sim">
                                            <span class="detail-sim__icon"><i class="bi bi-briefcase"></i></span>
                                            <span>
                                                <span class="detail-sim__name d-block">{{ $similaire->subject->nom ?? 'Matière' }}</span>
                                                <span class="detail-sim__budget">{{ number_format($similaire->budget, 0, ',', ' ') }} FCFA</span>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal : connexion requise -->
    <div class="modal fade dmodal" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center px-4 pb-4">
                    <div class="dmodal__icon dmodal__icon--blue"><i class="bi bi-person-lock"></i></div>
                    <h4 class="kp-subtitle mb-2">Connexion requise</h4>
                    <p class="kp-muted mb-4">Pour postuler à cette annonce, vous devez être connecté en tant que tuteur.</p>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('login') }}" class="kp-btn kp-btn--primary kp-btn--block"><i class="bi bi-box-arrow-in-right"></i> Se connecter</a>
                        <a href="{{ route('register.tuteur') }}" class="kp-btn kp-btn--secondary kp-btn--block"><i class="bi bi-person-plus"></i> Devenir tuteur</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal : action non autorisée -->
    <div class="modal fade dmodal" id="roleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center px-4 pb-4">
                    <div class="dmodal__icon dmodal__icon--warn"><i class="bi bi-exclamation-triangle"></i></div>
                    <h4 class="kp-subtitle mb-2">Action non autorisée</h4>
                    <p class="kp-muted mb-4" id="roleMessage">Seuls les tuteurs peuvent postuler aux annonces.</p>
                    <a href="{{ route('home') }}" class="kp-btn kp-btn--primary kp-btn--block"><i class="bi bi-house"></i> Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showLoginMessage() {
            new bootstrap.Modal(document.getElementById('loginModal')).show();
        }
        function showRoleMessage(action) {
            const roleMessage = document.getElementById('roleMessage');
            if (action === 'postuler') roleMessage.textContent = 'Seuls les tuteurs peuvent postuler aux annonces.';
            new bootstrap.Modal(document.getElementById('roleModal')).show();
        }
        function showPostulerMessage() {
            alert('Cette fonctionnalité sera bientôt disponible !');
        }
    </script>
@endsection
