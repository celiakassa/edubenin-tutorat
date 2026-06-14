@extends('layouts.dashboard')

@section('title', 'Kopiao - Dashboard Tuteur')
@section('page-title', 'Tableau de bord')

@push('styles')
    <style>
        /* ===== Tableau de bord tuteur — aligné design system ===== */
        .td-greet { margin-bottom: 22px; }
        .td-greet__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .td-greet__sub { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .td-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin: 8px 0 24px; }
        .td-stat { background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; transition: border-color .2s, transform .2s; }
        .td-stat:hover { border-color: var(--kp-blue); transform: translateY(-1px); }
        .td-stat__icon { width: 44px; height: 44px; border-radius: 11px; display: flex; align-items: center; justify-content: center; background: rgba(26, 26, 26, .06); color: #1a1a1a; font-size: var(--kp-fs-md); flex-shrink: 0; }
        .td-stat__info { display: flex; align-items: baseline; gap: 7px; min-width: 0; flex-wrap: wrap; }
        .td-stat__val { font-size: var(--kp-fs-xl); font-weight: 700; color: #1a1a1a; margin: 0; }
        .td-stat__lbl { font-size: var(--kp-fs-xs); color: var(--kp-muted); margin: 0; }

        .td-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .td-card { background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; }
        .td-card__head { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 15px 18px; border-bottom: 1px solid var(--kp-border); }
        .td-card__head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-md); font-weight: 700; color: var(--kp-ink); margin: 0; display: flex; align-items: center; gap: 8px; }
        .td-card__head h2 i { color: var(--kp-blue); }
        .td-count { background: var(--kp-blue-soft); color: var(--kp-blue); font-size: var(--kp-fs-2xs); font-weight: 700; padding: 3px 11px; border-radius: 20px; white-space: nowrap; }
        .td-list { flex: 1; }
        .td-item { padding: 14px 18px; border-bottom: 1px solid var(--kp-border); }
        .td-item:last-child { border-bottom: none; }
        .td-item__head { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 5px; }
        .td-item__title { font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-base); margin: 0; }
        .td-item__desc { color: var(--kp-muted); font-size: var(--kp-fs-sm); margin: 0 0 9px; line-height: 1.45; }
        .td-item__foot { display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
        .td-item__meta { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; color: var(--kp-muted); font-size: var(--kp-fs-xs); }
        .td-item__meta i { color: var(--kp-blue); margin-right: 3px; }
        .td-price { font-weight: 800; color: var(--kp-blue); font-size: var(--kp-fs-base); }
        .td-badge { font-size: var(--kp-fs-2xs); font-weight: 700; padding: 3px 10px; border-radius: 20px; white-space: nowrap; display: inline-flex; align-items: center; gap: 4px; }
        .td-badge--success { background: #d1fae5; color: #065f46; }
        .td-badge--warning { background: #fef3c7; color: #92400e; }
        .td-badge--danger { background: #fee2e2; color: #991b1b; }
        .td-badge--soft { background: var(--kp-surface); color: var(--kp-ink); }
        .td-btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 15px; border-radius: 20px; background: var(--kp-blue); color: #fff; text-decoration: none; font-size: var(--kp-fs-xs); font-weight: 600; transition: background .2s; white-space: nowrap; }
        .td-btn:hover { background: #1a1a1a; color: #fff; }
        .td-btn--ghost { background: #fff; border: 1.5px solid var(--kp-border); color: var(--kp-ink); }
        .td-btn--ghost:hover { background: var(--kp-blue); color: #fff; border-color: var(--kp-blue); }
        .td-card__foot { padding: 12px; text-align: center; border-top: 1px solid var(--kp-border); }
        .td-card__foot a { color: var(--kp-blue); font-weight: 600; font-size: var(--kp-fs-sm); text-decoration: none; }
        .td-card__foot a:hover { text-decoration: underline; }
        .td-empty { text-align: center; padding: 42px 20px; }
        .td-empty i { font-size: 46px; color: var(--kp-border); margin-bottom: 12px; display: block; }
        .td-empty strong { display: block; color: var(--kp-ink); font-size: var(--kp-fs-base); margin-bottom: 4px; }
        .td-empty p { color: var(--kp-muted); margin: 0; font-size: var(--kp-fs-sm); }

        .td-expertise { background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; padding: 18px; margin-top: 18px; }
        .td-expertise h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-md); font-weight: 700; color: var(--kp-ink); margin: 0 0 12px; display: flex; align-items: center; gap: 8px; }
        .td-expertise h2 i { color: var(--kp-blue); }
        .td-tags { display: flex; flex-wrap: wrap; gap: 8px; }
        .td-tag { background: var(--kp-blue-soft); color: var(--kp-blue); padding: 6px 14px; border-radius: 20px; font-size: var(--kp-fs-sm); font-weight: 600; }

        @media (max-width: 860px) { .td-grid { grid-template-columns: 1fr; } }
        @media (max-width: 640px) { .td-stats { grid-template-columns: repeat(2, 1fr); gap: 10px; } }
        @media (max-width: 360px) { .td-stats { grid-template-columns: 1fr; } }
    </style>
@endpush

@section('content')
    @php $heure = (int) now()->format('H'); $salut = $heure < 18 ? 'Bonjour' : 'Bonsoir'; @endphp
    <div class="td-greet">
        <h1 class="td-greet__title">{{ $salut }}, {{ auth()->user()->firstname }} 👋</h1>
        <p class="td-greet__sub">Voici un aperçu de votre activité de tuteur.</p>
    </div>

    {{-- Bandeau « Complétez votre profil » --}}
    @include('dashboard.partials.profile-banner')

    {{-- Statistiques --}}
    <div class="td-stats">
        <div class="td-stat">
            <div class="td-stat__icon"><i class="bi bi-file-earmark-text"></i></div>
            <div class="td-stat__info">
                <h3 class="td-stat__val">{{ $stats['annoncesInDomain'] }}</h3>
                <p class="td-stat__lbl">Annonces dispo</p>
            </div>
        </div>
        <div class="td-stat">
            <div class="td-stat__icon"><i class="bi bi-check-circle"></i></div>
            <div class="td-stat__info">
                <h3 class="td-stat__val">{{ $stats['candidaturesValidees'] }}</h3>
                <p class="td-stat__lbl">Validées</p>
            </div>
        </div>
        <div class="td-stat">
            <div class="td-stat__icon"><i class="bi bi-clock-history"></i></div>
            <div class="td-stat__info">
                <h3 class="td-stat__val">{{ $stats['candidaturesEnAttente'] }}</h3>
                <p class="td-stat__lbl">En attente</p>
            </div>
        </div>
        <div class="td-stat">
            <div class="td-stat__icon"><i class="bi bi-cash-coin"></i></div>
            <div class="td-stat__info">
                <h3 class="td-stat__val">{{ number_format($stats['acompteTotal'], 0, ',', ' ') }}</h3>
                <p class="td-stat__lbl">FCFA d'acomptes</p>
            </div>
        </div>
    </div>

    <div class="td-grid">
        {{-- Annonces récentes pour vous --}}
        <div class="td-card">
            <div class="td-card__head">
                <h2><i class="bi bi-megaphone"></i> Annonces récentes pour vous</h2>
                <span class="td-count">{{ count($stats['recentAnnonces']) }} dispo</span>
            </div>
            <div class="td-list">
                @forelse(collect($stats['recentAnnonces'])->take(2) as $annonce)
                    <div class="td-item">
                        <div class="td-item__head">
                            <h3 class="td-item__title">{{ $annonce->domaine }}</h3>
                            @if($annonce->format == 'online')
                                <span class="td-badge td-badge--soft"><i class="bi bi-globe"></i> En ligne</span>
                            @elseif($annonce->format == 'in_person')
                                <span class="td-badge td-badge--soft"><i class="bi bi-people"></i> Présentiel</span>
                            @elseif($annonce->format)
                                <span class="td-badge td-badge--soft"><i class="bi bi-arrows-collapse"></i> Hybride</span>
                            @endif
                        </div>
                        <p class="td-item__desc">{{ Str::limit($annonce->description, 90) }}</p>
                        <div class="td-item__foot">
                            <div class="td-item__meta">
                                <span><i class="bi bi-person"></i>{{ $annonce->student->firstname }}</span>
                                <span><i class="bi bi-geo-alt"></i>{{ $annonce->student->city ?? 'Non spécifié' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="td-price">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span>
                                <a href="{{ route('annonces.dashboard.detail', $annonce->hashid) }}" class="td-btn">Voir <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="td-empty">
                        <i class="bi bi-file-earmark-x"></i>
                        <strong>Aucune annonce disponible</strong>
                        <p>Les nouvelles annonces dans votre domaine apparaîtront ici.</p>
                    </div>
                @endforelse
            </div>
            @if(count($stats['recentAnnonces']) > 2)
                <div class="td-card__foot">
                    <a href="{{ route('annonces') }}">Voir plus <i class="bi bi-arrow-right"></i></a>
                </div>
            @endif
        </div>

        {{-- Mes candidatures récentes --}}
        <div class="td-card">
            <div class="td-card__head">
                <h2><i class="bi bi-clipboard-check"></i> Mes candidatures récentes</h2>
                <span class="td-count">{{ count($stats['dernieresCandidatures']) }}</span>
            </div>
            <div class="td-list">
                @forelse(collect($stats['dernieresCandidatures'])->take(2) as $candidature)
                    <div class="td-item">
                        <div class="td-item__head">
                            <h3 class="td-item__title">{{ $candidature->annonce->domaine }}</h3>
                            @if($candidature->statut == 'acceptee')
                                <span class="td-badge td-badge--success"><i class="bi bi-check-circle"></i> Acceptée</span>
                            @elseif($candidature->statut == 'en_attente')
                                <span class="td-badge td-badge--warning"><i class="bi bi-clock"></i> En attente</span>
                            @else
                                <span class="td-badge td-badge--danger"><i class="bi bi-x-circle"></i> Refusée</span>
                            @endif
                        </div>
                        <p class="td-item__desc">Envoyée le {{ $candidature->created_at->format('d/m/Y à H:i') }}</p>
                        <div class="td-item__foot">
                            <div class="td-item__meta">
                                <span><i class="bi bi-person"></i>{{ $candidature->annonce->student->firstname }}</span>
                                @if($candidature->statut == 'acceptee')
                                    <span style="color: #065f46; font-weight: 700;"><i class="bi bi-cash-coin" style="color:#065f46;"></i>{{ number_format($candidature->annonce->acompte, 0, ',', ' ') }} FCFA</span>
                                @endif
                            </div>
                            <a href="{{ route('annonces.dashboard.detail', $candidature->annonce->hashid) }}" class="td-btn td-btn--ghost">Détails <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                @empty
                    <div class="td-empty">
                        <i class="bi bi-clipboard-x"></i>
                        <strong>Aucune candidature</strong>
                        <p>Commencez à postuler aux annonces qui vous intéressent.</p>
                    </div>
                @endforelse
            </div>
            @if(count($stats['dernieresCandidatures']) > 2)
                <div class="td-card__foot">
                    <a href="{{ route('candidatures.tuteur') }}">Voir plus <i class="bi bi-arrow-right"></i></a>
                </div>
            @endif
        </div>
    </div>

    {{-- Domaines d'expertise --}}
    @if(!empty($stats['tutorSubjects']) && count($stats['tutorSubjects']) > 0)
        <div class="td-expertise">
            <h2><i class="bi bi-book"></i> Vos domaines d'expertise</h2>
            <div class="td-tags">
                @foreach($stats['tutorSubjects'] as $subject)
                    <span class="td-tag">{{ $subject }}</span>
                @endforeach
            </div>
        </div>
    @endif
@endsection
