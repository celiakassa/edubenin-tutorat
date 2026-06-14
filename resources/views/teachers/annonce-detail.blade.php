@extends('layouts.dashboard')

@section('title', 'Détail de la mission - Kopiao')
@section('page-title', 'Détail de la mission')

@push('styles')
    <style>
        .tad-page { max-width: 900px; margin: 0 auto; }
        .tad-back { display: inline-flex; align-items: center; gap: 8px; color: var(--kp-muted); text-decoration: none; font-weight: 600; font-size: var(--kp-fs-base); margin-bottom: 18px; transition: color .2s; }
        .tad-back:hover { color: var(--kp-blue); }

        .tad-domain { display: inline-flex; align-items: center; gap: 6px; background: var(--kp-blue-soft); color: var(--kp-blue); padding: 5px 14px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; }
        .tad-title { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 700; color: var(--kp-ink); margin: 10px 0 9px; line-height: 1.2; }
        .tad-meta { display: flex; gap: 18px; flex-wrap: wrap; color: var(--kp-muted); font-size: var(--kp-fs-sm); }
        .tad-meta i { color: var(--kp-blue); margin-right: 5px; }

        .tad-grid { display: grid; grid-template-columns: 1fr 330px; gap: 20px; align-items: stretch; margin-top: 22px; }
        .tad-col { display: flex; flex-direction: column; }
        .tad-col > *:last-child { margin-bottom: 0; }
        .tad-col > .tad-card:last-child { flex: 1; }
        @media (max-width: 820px) { .tad-grid { grid-template-columns: 1fr; } .tad-col > .tad-card:last-child { flex: 0 0 auto; } .tad-col > *:last-child { margin-bottom: 18px; } }

        .tad-card { background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; padding: 20px 22px; box-shadow: var(--kp-shadow); margin-bottom: 18px; }
        .tad-card__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-lg); font-weight: 700; color: var(--kp-ink); margin: 0 0 14px; display: flex; align-items: center; gap: 9px; }
        .tad-card__title i { color: var(--kp-blue); }
        .tad-desc { color: var(--kp-text); font-size: var(--kp-fs-md); line-height: 1.7; margin: 0; }

        .tad-info { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .tad-info__item { background: var(--kp-surface); border-radius: 11px; padding: 11px 13px; }
        .tad-info__item .lbl { display: block; font-size: var(--kp-fs-2xs); color: var(--kp-muted); font-weight: 700; text-transform: uppercase; }
        .tad-info__item .val { display: block; font-size: var(--kp-fs-base); font-weight: 600; color: var(--kp-ink); margin-top: 2px; }

        .tad-budget { background: var(--kp-blue); color: #fff; border-radius: 16px; padding: 22px; text-align: center; margin-bottom: 18px; }
        .tad-budget .lbl { font-size: var(--kp-fs-xs); opacity: .85; }
        .tad-budget .amt { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 800; margin: 4px 0 16px; }
        .tad-budget .amt small { font-size: var(--kp-fs-md); opacity: .85; }
        .tad-cta { width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 48px; border: none; border-radius: var(--kp-radius-pill); background: #fff; color: var(--kp-blue); font-weight: 700; font-size: var(--kp-fs-base); cursor: pointer; transition: all .2s; }
        .tad-cta:hover { background: var(--kp-yellow); color: #1a1a1a; }
        .tad-applied { width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 48px; border-radius: var(--kp-radius-pill); background: rgba(255, 255, 255, .18); border: 1px solid rgba(255, 255, 255, .4); color: #fff; font-weight: 600; }
        .tad-secure { font-size: var(--kp-fs-2xs); opacity: .8; margin: 10px 0 0; }

        .tad-status { display: flex; align-items: center; gap: 10px; padding: 12px 14px; border-radius: 11px; font-weight: 700; font-size: var(--kp-fs-sm); }

        .tad-student { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .tad-student__avatar { width: 50px; height: 50px; border-radius: 50%; background: var(--kp-blue); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-md); flex-shrink: 0; overflow: hidden; }
        .tad-student__avatar img { width: 100%; height: 100%; object-fit: cover; }
        .tad-student__name { font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-base); }
        .tad-student__verified { color: #1d7a48; font-size: var(--kp-fs-2xs); font-weight: 600; }
        .tad-contact { background: var(--kp-surface); border-radius: 11px; padding: 12px 14px; }
        .tad-contact p { margin: 0 0 6px; font-size: var(--kp-fs-sm); color: var(--kp-text); display: flex; align-items: center; gap: 8px; word-break: break-all; }
        .tad-contact p:last-child { margin-bottom: 0; }
        .tad-contact i { color: var(--kp-blue); flex-shrink: 0; }
        .tad-locked { text-align: center; padding: 16px; border: 1.5px dashed var(--kp-border); border-radius: 11px; }
        .tad-locked i { color: var(--kp-muted); font-size: var(--kp-fs-lg); display: block; margin-bottom: 6px; }
        .tad-locked p { margin: 0; font-size: var(--kp-fs-sm); color: var(--kp-muted); }

        @media (max-width: 575px) { .tad-title { font-size: var(--kp-fs-xl); } .tad-info { grid-template-columns: 1fr; } }
    </style>
@endpush

@section('content')
    @php
        $dispoAffiche = ($annonce->disponibilite && strtotime($annonce->disponibilite))
            ? \Carbon\Carbon::parse($annonce->disponibilite)->locale('fr')->translatedFormat('d F Y')
            : ($annonce->disponibilite ?: 'Dès que possible');
    @endphp

    <div class="tad-page">
        <a href="{{ route('annonces') }}" class="tad-back"><i class="fas fa-arrow-left"></i> Retour aux offres</a>

        <span class="tad-domain"><i class="fas fa-book"></i> {{ $annonce->domaine }}</span>
        <h1 class="tad-title">{{ $annonce->title ?? 'Mission en ' . $annonce->domaine }}</h1>
        <div class="tad-meta">
            <span><i class="far fa-calendar-alt"></i> {{ $dispoAffiche }}</span>
            <span><i class="fas fa-video"></i> {{ ucfirst(str_replace('_', ' ', $annonce->format)) }}</span>
            <span><i class="fas fa-clock"></i> Publié le {{ \Carbon\Carbon::parse($annonce->created_at)->locale('fr')->translatedFormat('d F Y') }}</span>
        </div>

        <div class="tad-grid">
            {{-- Colonne principale --}}
            <div class="tad-col">
                <div class="tad-card">
                    <h3 class="tad-card__title"><i class="fas fa-align-left"></i> Description de la mission</h3>
                    <p class="tad-desc">{!! nl2br(e($annonce->description)) !!}</p>
                </div>

                <div class="tad-card">
                    <h3 class="tad-card__title"><i class="fas fa-info-circle"></i> Informations</h3>
                    <div class="tad-info">
                        <div class="tad-info__item"><span class="lbl">Début de mission</span><span class="val">{{ $dispoAffiche }}</span></div>
                        <div class="tad-info__item"><span class="lbl">Format</span><span class="val" style="text-transform: capitalize;">{{ str_replace('_', ' ', $annonce->format) }}</span></div>
                        <div class="tad-info__item"><span class="lbl">Acompte requis</span><span class="val">{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</span></div>
                        <div class="tad-info__item"><span class="lbl">Publié le</span><span class="val">{{ \Carbon\Carbon::parse($annonce->created_at)->locale('fr')->translatedFormat('d F Y') }}</span></div>
                    </div>
                </div>
            </div>

            {{-- Colonne latérale --}}
            <div class="tad-col">
                <div class="tad-budget">
                    <div class="lbl">Rémunération totale</div>
                    <div class="amt">{{ number_format($annonce->budget, 0, ',', ' ') }} <small>FCFA</small></div>
                    @auth
                        @if (auth()->user()->isTuteur())
                            @if ($hasApplied)
                                <div class="tad-applied"><i class="fas fa-check-circle"></i> Candidature envoyée</div>
                            @else
                                <form action="{{ route('annonce.postuler', $annonce->id) }}" method="POST"
                                      onsubmit="return kpConfirmDelete(event, this, {icon: 'success', iconClass: 'fa-paper-plane', title: 'Postuler à cette annonce ?', text: 'Votre candidature sera envoyée à l\'apprenant.', confirmText: 'Oui, postuler', confirmColor: '#0B69F1'});">
                                    @csrf
                                    <button type="submit" class="tad-cta"><i class="fas fa-paper-plane"></i> Postuler maintenant</button>
                                </form>
                                <p class="tad-secure"><i class="fas fa-shield-alt"></i> Paiement sécurisé via Kopiao</p>
                            @endif
                        @endif
                    @endauth
                </div>

                @if (isset($candidature) && $candidature)
                    @php
                        $statusStyle = [
                            'acceptee' => ['bg' => '#16a34a', 'text' => '#fff', 'icon' => 'fa-check-circle', 'label' => 'Validée'],
                            'en_attente' => ['bg' => '#f97316', 'text' => '#fff', 'icon' => 'fa-clock', 'label' => 'En attente'],
                            'refuse' => ['bg' => '#dc2626', 'text' => '#fff', 'icon' => 'fa-times-circle', 'label' => 'Refusée'],
                            'refusee' => ['bg' => '#dc2626', 'text' => '#fff', 'icon' => 'fa-times-circle', 'label' => 'Refusée'],
                        ];
                        $st = $statusStyle[$candidature->statut] ?? ['bg' => '#f1f5f9', 'text' => '#64748b', 'icon' => 'fa-info-circle', 'label' => $candidature->statut];
                    @endphp
                    <div class="tad-card">
                        <h3 class="tad-card__title"><i class="fas fa-folder-open"></i> Statut du dossier</h3>
                        <div class="tad-status" style="background: {{ $st['bg'] }}; color: {{ $st['text'] }};">
                            <i class="fas {{ $st['icon'] }}"></i> {{ $st['label'] }}
                        </div>
                    </div>
                @endif

                <div class="tad-card">
                    <h3 class="tad-card__title"><i class="fas fa-user-graduate"></i> Profil de l'étudiant</h3>
                    @if ($student)
                        @php $validated = isset($teacher_validate) && $teacher_validate; @endphp
                        <div class="tad-student">
                            <div class="tad-student__avatar">
                                @if ($validated && $student->photo_path)
                                    <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Profil">
                                @elseif ($validated)
                                    {{ strtoupper(substr($student->firstname, 0, 1)) }}
                                @else
                                    <i class="fas fa-lock"></i>
                                @endif
                            </div>
                            <div>
                                <div class="tad-student__name">{{ $student->firstname }} {{ $validated ? $student->lastname : '***' }}</div>
                                <span class="tad-student__verified"><i class="fas fa-check-double"></i> Vérifié</span>
                            </div>
                        </div>

                        @if ($validated)
                            <div class="tad-contact">
                                <p><i class="fas fa-phone-alt"></i> {{ $student->telephone ?? 'N/A' }}</p>
                                <p><i class="fas fa-envelope"></i> {{ $student->email ?? 'N/A' }}</p>
                            </div>
                        @else
                            <div class="tad-locked">
                                <i class="fas fa-lock"></i>
                                <p>Coordonnées visibles après validation de votre candidature.</p>
                            </div>
                        @endif
                    @else
                        <p style="color: var(--kp-muted); font-size: var(--kp-fs-sm); margin: 0;">Informations étudiant non disponibles.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
