@extends('layouts.dashboard')

@section('title', 'Candidatures - Kopiao')
@section('page-title', 'Candidatures')

@push('styles')
    <style>
        .cd-page { max-width: 900px; margin: 0 auto; }
        .cd-back { display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--kp-border); background: #fff; color: var(--kp-ink); text-decoration: none; margin-bottom: 16px; transition: all .2s; }
        .cd-back:hover { background: var(--kp-blue); color: #fff; border-color: var(--kp-blue); }
        .cd-head { margin-bottom: 20px; }
        .cd-head h1 { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 8px; display: flex; align-items: center; gap: 10px; }
        .cd-head h1 i { color: var(--kp-blue); }
        .cd-meta { display: flex; gap: 16px; flex-wrap: wrap; }
        .cd-meta span { display: inline-flex; align-items: center; gap: 6px; color: var(--kp-muted); font-size: var(--kp-fs-sm); }
        .cd-meta i { color: var(--kp-blue); }

        .alert-message { padding: 12px 16px; border-radius: 11px; margin-bottom: 16px; font-weight: 500; font-size: var(--kp-fs-base); display: flex; align-items: center; gap: 9px; }
        .alert-success { background: #e7f6ee; color: #1d7a48; }
        .alert-error { background: #fee2e2; color: #991b1b; }

        .cd-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; padding: 13px 15px; display: flex; align-items: center; gap: 11px; transition: border-color .2s, transform .2s; }
        .stat-card:hover { border-color: var(--kp-blue); transform: translateY(-1px); }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-md); color: #fff; flex-shrink: 0; }
        .stat-icon.total { background: var(--kp-blue); }
        .stat-icon.en-attente { background: #f59e0b; }
        .stat-icon.acceptee { background: #10b981; }
        .stat-icon.refusee { background: #e02c18; }
        .stat-info { display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap; }
        .stat-info h3 { font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0; }
        .stat-info p { font-size: var(--kp-fs-xs); color: var(--kp-muted); margin: 0; }

        .charts-section { background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; padding: 18px; margin-bottom: 20px; }
        .chart-container { position: relative; height: 210px; max-width: 340px; margin: 0 auto; }

        .cd-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 16px; }
        .cd-toolbar h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-lg); font-weight: 700; color: var(--kp-ink); margin: 0; display: flex; align-items: center; gap: 8px; }
        .filter-buttons { display: flex; gap: 8px; flex-wrap: wrap; }
        .filter-btn { padding: 7px 14px; border: 1px solid var(--kp-border); border-radius: 20px; background: #fff; color: var(--kp-text); font-size: var(--kp-fs-sm); font-weight: 600; cursor: pointer; transition: all .2s; }
        .filter-btn:hover { border-color: var(--kp-blue); }
        .filter-btn.active { background: var(--kp-blue); color: #fff; border-color: var(--kp-blue); }

        .candidature-status { padding: 3px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 600; display: inline-block; white-space: nowrap; }
        .status-en_attente { background: #fef3c7; color: #92400e; }
        .status-acceptee { background: #d1fae5; color: #065f46; }
        .status-refusee { background: #fee2e2; color: #991b1b; }

        /* Tableau des candidats */
        .cand-table-wrap { background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; overflow: auto; }
        .cand-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .cand-table thead th { text-align: left; padding: 12px 16px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: var(--kp-surface); white-space: nowrap; }
        .cand-table tbody td { padding: 11px 16px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); vertical-align: middle; white-space: nowrap; }
        .cand-table tbody tr:last-child td { border-bottom: none; }
        .candidature-card:hover { background: var(--kp-surface); }
        .cand-tuteur { display: flex; align-items: center; gap: 10px; font-weight: 600; }
        .cand-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--kp-blue-soft); color: var(--kp-blue); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-xs); flex-shrink: 0; }
        .cand-matiere { color: var(--kp-muted); }
        .cand-rate { font-weight: 700; color: var(--kp-blue); }
        .cand-actions { display: flex; gap: 6px; }
        .cand-btn { width: 32px; height: 32px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: var(--kp-fs-sm); transition: all .2s; text-decoration: none; }
        .cand-btn.accept { background: #d1fae5; color: #10b981; }
        .cand-btn.accept:hover { background: #10b981; color: #fff; }
        .cand-btn.reject { background: #fee2e2; color: #e02c18; }
        .cand-btn.reject:hover { background: #e02c18; color: #fff; }
        .cand-btn:disabled { opacity: .5; cursor: default; }
        @media (max-width: 640px) { .col-hide-sm { display: none; } }
        .candidature-card { cursor: pointer; }

        /* Panneau candidat (droite) */
        .cdrawer { position: fixed; inset: 0; z-index: 3200; display: none; }
        .cdrawer.open { display: block; }
        .cdrawer__overlay { position: fixed; inset: 0; background: rgba(11,18,32,.45); opacity: 0; transition: opacity .25s; }
        .cdrawer.open .cdrawer__overlay { opacity: 1; }
        .cdrawer__panel { position: absolute; top: 0; right: 0; bottom: 0; width: 420px; max-width: 92vw; background: #fff; box-shadow: -14px 0 50px rgba(0,0,0,.22); transform: translateX(100%); transition: transform .3s ease; display: flex; flex-direction: column; }
        .cdrawer.open .cdrawer__panel { transform: translateX(0); }
        .cdrawer__head { display: flex; justify-content: flex-end; padding: 14px 18px 0; }
        .cdrawer__close { width: 34px; height: 34px; border-radius: 50%; border: none; background: var(--kp-surface); color: var(--kp-ink); cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .cdrawer__close:hover { background: var(--kp-blue); color: #fff; }
        .cdrawer__body { flex: 1; overflow-y: auto; padding: 0; }
        /* En-tête identité (centré, anneau jaune) */
        .cdd-header { text-align: center; padding: 6px 22px 20px; background: linear-gradient(180deg, var(--kp-blue-soft), #fff); border-bottom: 1px solid var(--kp-border); }
        .cdd-avatar { width: 84px; height: 84px; border-radius: 50%; background: #fff; color: var(--kp-blue); display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-2xl); margin-bottom: 12px; border: 3px solid var(--kp-yellow); box-shadow: var(--kp-shadow-sm); }
        .cdd-name { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .cdd-subjects { color: var(--kp-muted); font-size: var(--kp-fs-sm); margin-bottom: 12px; }
        /* Corps */
        .cdd-content { padding: 18px 22px; }
        /* Bandeau taux horaire (accent jaune) */
        .cdd-rate-band { background: var(--kp-yellow); border-radius: 14px; padding: 13px 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
        .cdd-rate-band .lbl { font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: #1a1a1a; display: inline-flex; align-items: center; gap: 6px; }
        .cdd-rate-band .val { font-family: var(--kp-font-title); font-size: var(--kp-fs-lg); font-weight: 800; color: #1a1a1a; white-space: nowrap; }
        /* Grille détails */
        .cdd-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .cdd-item { background: var(--kp-surface); border-radius: 11px; padding: 10px 13px; }
        .cdd-item--full { grid-column: 1 / -1; }
        .cdd-item .lbl { display: flex; align-items: center; gap: 6px; font-size: var(--kp-fs-2xs); color: var(--kp-muted); font-weight: 700; text-transform: uppercase; letter-spacing: .3px; margin-bottom: 3px; }
        .cdd-item .lbl i { color: var(--kp-blue); }
        .cdd-item .val { font-size: var(--kp-fs-base); font-weight: 700; color: var(--kp-ink); }
        .cdd-bio { margin-top: 16px; }
        .cdd-bio .lbl { font-size: var(--kp-fs-2xs); color: var(--kp-muted); font-weight: 700; text-transform: uppercase; letter-spacing: .3px; display: block; margin-bottom: 6px; }
        .cdd-bio p { color: var(--kp-text); font-size: var(--kp-fs-sm); line-height: 1.65; margin: 0; background: var(--kp-surface); border-radius: 11px; padding: 12px 14px; }
        .cdrawer__foot { padding: 14px 22px; border-top: 1px solid var(--kp-border); display: flex; gap: 10px; }
        .cdrawer__foot .kp-btn { flex: 1; justify-content: center; }
        .cdd-btn-accept { background: #10b981; color: #fff; }
        .cdd-btn-accept:hover { background: #0ea271; color: #fff; }
        .cdd-btn-reject { background: #e02c18; color: #fff; }
        .cdd-btn-reject:hover { background: #c62411; color: #fff; }

        .empty-state { text-align: center; padding: 50px 20px; }
        .empty-icon { font-size: 54px; color: var(--kp-border); margin-bottom: 14px; }
        .empty-state h3 { color: var(--kp-ink); font-size: var(--kp-fs-xl); margin-bottom: 8px; }
        .empty-state p { color: var(--kp-muted); max-width: 440px; margin: 0 auto; }

        /* Modale de confirmation */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(11,18,32,.5); z-index: 3500; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.active { display: flex; }
        .modal-container { background: #fff; border-radius: 18px; padding: 28px; max-width: 420px; width: 100%; text-align: center; position: relative; box-shadow: 0 24px 60px rgba(0,0,0,.25); }
        .modal-close { position: absolute; top: 12px; right: 16px; background: none; border: none; font-size: 24px; color: var(--kp-muted); cursor: pointer; line-height: 1; }
        .modal-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 16px; }
        .modal-icon.success { background: #d1fae5; color: #10b981; }
        .modal-icon.danger { background: #fee2e2; color: #e02c18; }
        .modal-title { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 10px; }
        .modal-message { color: var(--kp-text); font-size: var(--kp-fs-base); line-height: 1.55; margin: 0 0 22px; }
        .modal-buttons { display: flex; gap: 10px; }
        .modal-btn { flex: 1; padding: 11px; border-radius: 10px; font-weight: 600; font-size: var(--kp-fs-base); cursor: pointer; border: none; }
        .modal-btn.cancel { background: var(--kp-surface); color: var(--kp-ink); }
        .modal-btn.confirm-success { background: #10b981; color: #fff; }
        .modal-btn.confirm-danger { background: #e02c18; color: #fff; }

        @media (max-width: 600px) { .candidatures-grid { grid-template-columns: 1fr; } }

        /* ===== Mobile : tableau candidats → cartes ===== */
        @media (max-width: 640px) {
            .cd-head h1 { font-size: var(--kp-fs-xl); }
            .cd-toolbar { flex-direction: column; align-items: stretch; gap: 12px; }
            .filter-buttons { overflow-x: auto; flex-wrap: nowrap; padding-bottom: 4px; -webkit-overflow-scrolling: touch; }
            .filter-btn { flex-shrink: 0; }

            .cand-table-wrap { background: transparent; border: none; border-radius: 0; overflow: visible; }
            .cand-table thead { display: none; }
            .cand-table, .cand-table tbody, .cand-table tr, .cand-table td { display: block; }
            /* Masquer Ville + Date (sinon td{display:block} les réaffiche) */
            .cand-table td.col-hide-sm { display: none !important; }
            /* Carte en flex : nom + badge sur la 1re ligne, le reste en dessous */
            .cand-table tr.candidature-card { display: flex; flex-wrap: wrap; align-items: center; background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; margin-bottom: 10px; padding: 15px 14px; }
            .cand-table tbody td { border: none !important; padding: 0; white-space: normal; }
            .cand-tuteur { order: 1; flex: 1 1 0%; width: auto; min-width: 0; gap: 11px; align-items: center; font-size: var(--kp-fs-md); font-weight: 700; color: var(--kp-ink); }
            .cand-avatar { width: 42px; height: 42px; font-size: var(--kp-fs-sm); }
            /* Statut : à droite du nom, même ligne (plus de chevauchement) */
            .cand-col-status { order: 2; flex: 0 0 auto; width: auto; margin-left: 8px; }
            /* Matière, taux et actions : chacun sur sa ligne, alignés sous le nom */
            .cand-matiere { order: 3; flex: 0 0 100%; padding-left: 53px; margin-top: 9px; color: var(--kp-muted); font-size: var(--kp-fs-sm); }
            .cand-rate { order: 4; flex: 0 0 100%; padding-left: 53px; margin-top: 3px; color: var(--kp-blue); font-weight: 700; font-size: var(--kp-fs-sm); }
            .cand-rate::before { content: 'Taux : '; color: var(--kp-muted); font-weight: 400; }
            .cand-col-actions { order: 5; flex: 0 0 100%; padding-left: 53px; margin-top: 12px; }
            .cand-actions { justify-content: flex-start; gap: 8px; }
            .cand-btn { width: 40px; height: 40px; font-size: var(--kp-fs-base); }
        }

        /* ===== Mobile : panneau candidat → bottom sheet ===== */
        @media (max-width: 575px) {
            .cdrawer__panel { top: auto; left: 0; right: 0; bottom: 0; width: 100%; max-width: 100%; max-height: 90vh; border-radius: 20px 20px 0 0; transform: translateY(100%); box-shadow: 0 -14px 40px rgba(0, 0, 0, .25); }
            .cdrawer.open .cdrawer__panel { transform: translateY(0); }
            .cdrawer__panel::before { content: ''; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); width: 42px; height: 4px; border-radius: 4px; background: #d5dae2; z-index: 2; }
            .modal-container { padding: 24px 18px; }
        }
    </style>
@endpush

@section('content')
    <div class="cd-page">
        <a href="{{ route('candidatures.mes') }}" class="cd-back" title="Retour"><i class="fas fa-arrow-left"></i></a>

        <div class="cd-head">
            <h1><i class="fas fa-users"></i> Candidatures — {{ $annonce->subject->nom ?? 'Matière' }}</h1>
            <div class="cd-meta">
                <span><i class="fas fa-calendar"></i> {{ $annonce->created_at->format('d/m/Y') }}</span>
                <span><i class="fas fa-money-bill-wave"></i> {{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span>
                <span><i class="fas fa-laptop"></i> {{ ucfirst(str_replace('_', ' ', $annonce->format)) }}</span>
            </div>
        </div>


        {{-- Stats --}}
        <div class="cd-stats">
            <div class="stat-card">
                <div class="stat-icon total"><i class="fas fa-users"></i></div>
                <div class="stat-info"><h3>{{ $stats['total'] }}</h3><p>Total</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon en-attente"><i class="fas fa-clock"></i></div>
                <div class="stat-info"><h3>{{ $stats['en_attente'] }}</h3><p>En attente</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon acceptee"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info"><h3>{{ $stats['acceptees'] }}</h3><p>Acceptées</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon refusee"><i class="fas fa-times-circle"></i></div>
                <div class="stat-info"><h3>{{ $stats['refusees'] }}</h3><p>Refusées</p></div>
            </div>
        </div>

        <div class="cd-toolbar">
            <h2><i class="fas fa-list"></i> Tuteurs candidats</h2>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Tous ({{ $stats['total'] }})</button>
                <button class="filter-btn" data-filter="en_attente">En attente ({{ $stats['en_attente'] }})</button>
                <button class="filter-btn" data-filter="acceptee">Acceptées ({{ $stats['acceptees'] }})</button>
                <button class="filter-btn" data-filter="refusee">Refusées ({{ $stats['refusees'] }})</button>
            </div>
        </div>

        @if ($stats['total'] > 0)
            <div class="cand-table-wrap">
                <table class="cand-table">
                    <thead>
                        <tr>
                            <th>Tuteur</th>
                            <th>Matière</th>
                            <th>Taux/h</th>
                            <th class="col-hide-sm">Ville</th>
                            <th>Statut</th>
                            <th class="col-hide-sm">Postulé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="candidaturesGrid">
                        @foreach ($candidaturesParStatut as $statut => $candidatures)
                            @foreach ($candidatures as $candidature)
                                @php
                                    $cdName = $candidature->tuteur->firstname . ' ' . $candidature->tuteur->lastname;
                                    $cdInit = strtoupper(substr($candidature->tuteur->firstname, 0, 1) . substr($candidature->tuteur->lastname, 0, 1));
                                    $cdSubjects = $candidature->tuteur->subjects && $candidature->tuteur->subjects->count() > 0 ? $candidature->tuteur->subjects->pluck('nom')->implode(', ') : 'Non spécifiée';
                                    $cdNote = $candidature->tuteur->satisfaction_score ? $candidature->tuteur->satisfaction_score . '/5' : 'Nouveau tuteur';
                                @endphp
                                <tr class="candidature-card" onclick="openCandidat(this)"
                                    data-statut="{{ $candidature->statut }}"
                                    data-id="{{ $candidature->id }}"
                                    data-editable="{{ $candidature->estEnAttente() ? '1' : '' }}"
                                    data-initials="{{ $cdInit }}"
                                    data-name="{{ $cdName }}"
                                    data-subjects="{{ $cdSubjects }}"
                                    data-rate="{{ number_format($candidature->tuteur->rate_per_hour, 0, ',', ' ') }}"
                                    data-city="{{ $candidature->tuteur->city ?? '—' }}"
                                    data-note="{{ $cdNote }}"
                                    data-bio="{{ $candidature->tuteur->bio ?? '' }}"
                                    data-date="{{ $candidature->created_at->format('d/m/Y') }}">
                                    <td>
                                        <div class="cand-tuteur">
                                            <div class="cand-avatar">{{ $cdInit }}</div>
                                            {{ $cdName }}
                                        </div>
                                    </td>
                                    <td class="cand-matiere">{{ $cdSubjects }}</td>
                                    <td class="cand-rate">{{ number_format($candidature->tuteur->rate_per_hour, 0, ',', ' ') }} F</td>
                                    <td class="col-hide-sm">{{ $candidature->tuteur->city ?? '—' }}</td>
                                    <td class="cand-col-status"><span class="candidature-status status-{{ $candidature->statut }}">{{ $candidature->statut }}</span></td>
                                    <td class="col-hide-sm">{{ $candidature->created_at->format('d/m/Y') }}</td>
                                    <td class="cand-col-actions" onclick="event.stopPropagation();">
                                        <div class="cand-actions">
                                            @if ($candidature->estEnAttente())
                                                <button type="button" class="cand-btn accept" title="Accepter" onclick="showAcceptModal({{ $candidature->id }}, '{{ addslashes($cdName) }}')"><i class="fas fa-check"></i></button>
                                                <button type="button" class="cand-btn reject" title="Refuser" onclick="showRejectModal({{ $candidature->id }}, '{{ addslashes($cdName) }}')"><i class="fas fa-times"></i></button>
                                            @else
                                                <span style="color: var(--kp-muted); font-size: var(--kp-fs-sm);">—</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-user-friends"></i></div>
                <h3>Aucune candidature reçue</h3>
                <p>Votre annonce n'a pas encore reçu de candidatures. Partagez-la pour attirer des tuteurs qualifiés.</p>
            </div>
        @endif
    </div>

    {{-- Panneau détails candidat (droite) --}}
    <div class="cdrawer" id="candidatDrawer">
        <div class="cdrawer__overlay" onclick="closeCandidat()"></div>
        <aside class="cdrawer__panel">
            <div class="cdrawer__head">
                <button type="button" class="cdrawer__close" onclick="closeCandidat()"><i class="fas fa-times"></i></button>
            </div>
            <div class="cdrawer__body">
                <div class="cdd-header">
                    <div class="cdd-avatar" id="cdd-avatar"></div>
                    <h2 class="cdd-name" id="cdd-name"></h2>
                    <div class="cdd-subjects" id="cdd-subjects"></div>
                    <span class="candidature-status" id="cdd-status"></span>
                </div>
                <div class="cdd-content">
                    <div class="cdd-rate-band">
                        <span class="lbl"><i class="fas fa-coins"></i> Taux horaire</span>
                        <span class="val" id="cdd-rate"></span>
                    </div>
                    <div class="cdd-grid">
                        <div class="cdd-item"><span class="lbl"><i class="fas fa-map-marker-alt"></i> Ville</span><span class="val" id="cdd-city"></span></div>
                        <div class="cdd-item"><span class="lbl"><i class="fas fa-star"></i> Évaluation</span><span class="val" id="cdd-note"></span></div>
                        <div class="cdd-item cdd-item--full"><span class="lbl"><i class="far fa-calendar"></i> Postulé le</span><span class="val" id="cdd-date"></span></div>
                    </div>
                    <div class="cdd-bio">
                        <span class="lbl">À propos</span>
                        <p id="cdd-bio"></p>
                    </div>
                </div>
            </div>
            <div class="cdrawer__foot" id="cdd-foot">
                <button type="button" class="kp-btn cdd-btn-accept" id="cdd-accept"><i class="fas fa-check"></i> Accepter</button>
                <button type="button" class="kp-btn cdd-btn-reject" id="cdd-reject"><i class="fas fa-times"></i> Refuser</button>
            </div>
        </aside>
    </div>

    {{-- Modale de confirmation --}}
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-container" id="modalContainer">
            <button class="modal-close" id="modalClose">&times;</button>
            <div class="modal-icon" id="modalIcon"></div>
            <h2 class="modal-title" id="modalTitle">Confirmation</h2>
            <p class="modal-message" id="modalMessage"></p>
            <div class="modal-buttons">
                <button class="modal-btn cancel" id="modalCancel">Annuler</button>
                <button class="modal-btn" id="modalConfirm">Confirmer</button>
            </div>
        </div>
    </div>

    <form id="actionForm" method="POST" style="display: none;">@csrf</form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Filtres
            const filterButtons = document.querySelectorAll('.filter-btn');
            const candidatureCards = document.querySelectorAll('.candidature-card');
            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.dataset.filter;
                    candidatureCards.forEach(card => {
                        card.style.display = (filter === 'all' || card.dataset.statut === filter) ? '' : 'none';
                    });
                });
            });

        });

        // Panneau détails candidat (droite)
        let currentCandidat = null;
        function openCandidat(row) {
            const d = row.dataset;
            currentCandidat = d;
            document.getElementById('cdd-avatar').textContent = d.initials;
            document.getElementById('cdd-name').textContent = d.name;
            document.getElementById('cdd-subjects').textContent = d.subjects;
            const st = document.getElementById('cdd-status');
            st.textContent = d.statut;
            st.className = 'candidature-status status-' + d.statut;
            document.getElementById('cdd-rate').textContent = d.rate + ' FCFA/h';
            document.getElementById('cdd-city').textContent = d.city;
            document.getElementById('cdd-note').textContent = d.note;
            document.getElementById('cdd-date').textContent = d.date;
            document.getElementById('cdd-bio').textContent = (d.bio && d.bio.trim()) ? d.bio : 'Aucune description fournie.';
            document.getElementById('cdd-foot').style.display = (d.editable === '1') ? 'flex' : 'none';
            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
            document.getElementById('candidatDrawer').classList.add('open');
            const b = document.querySelector('.cdrawer__body'); if (b) b.scrollTop = 0;
        }
        function closeCandidat() {
            document.getElementById('candidatDrawer').classList.remove('open');
            document.documentElement.style.overflow = '';
            document.body.style.overflow = '';
        }
        document.getElementById('cdd-accept').addEventListener('click', function () {
            if (currentCandidat) { const c = currentCandidat; closeCandidat(); showAcceptModal(c.id, c.name); }
        });
        document.getElementById('cdd-reject').addEventListener('click', function () {
            if (currentCandidat) { const c = currentCandidat; closeCandidat(); showRejectModal(c.id, c.name); }
        });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeCandidat(); });

        // Modale
        const modalOverlay = document.getElementById('modalOverlay');
        const modalIcon = document.getElementById('modalIcon');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalCancel = document.getElementById('modalCancel');
        const modalConfirm = document.getElementById('modalConfirm');
        const modalClose = document.getElementById('modalClose');
        const actionForm = document.getElementById('actionForm');
        let currentAction = null, currentCandidatureId = null;

        function closeModal() { modalOverlay.classList.remove('active'); }

        function showAcceptModal(candidatureId, tuteurName) {
            currentAction = 'accept'; currentCandidatureId = candidatureId;
            modalIcon.className = 'modal-icon success';
            modalIcon.innerHTML = '<i class="fas fa-check-circle"></i>';
            modalTitle.textContent = 'Accepter ce tuteur ?';
            modalMessage.innerHTML = `Accepter <strong>${tuteurName}</strong> ?<br><span style="color:#856404;font-size: var(--kp-fs-base);">Cela refusera automatiquement les autres candidatures.</span>`;
            modalConfirm.className = 'modal-btn confirm-success';
            modalConfirm.textContent = 'Oui, accepter';
            modalOverlay.classList.add('active');
        }

        function showRejectModal(candidatureId, tuteurName) {
            currentAction = 'reject'; currentCandidatureId = candidatureId;
            modalIcon.className = 'modal-icon danger';
            modalIcon.innerHTML = '<i class="fas fa-times-circle"></i>';
            modalTitle.textContent = 'Refuser ce tuteur ?';
            modalMessage.innerHTML = `Refuser <strong>${tuteurName}</strong> ?<br><span style="color:var(--kp-muted);font-size: var(--kp-fs-base);">Cette action est irréversible.</span>`;
            modalConfirm.className = 'modal-btn confirm-danger';
            modalConfirm.textContent = 'Oui, refuser';
            modalOverlay.classList.add('active');
        }

        modalConfirm.addEventListener('click', function () {
            if (currentAction && currentCandidatureId) {
                actionForm.action = currentAction === 'accept'
                    ? '/annonces/candidatures/' + currentCandidatureId + '/accepter'
                    : '/annonces/candidatures/' + currentCandidatureId + '/refuser';
                actionForm.submit();
            }
            closeModal();
        });
        modalCancel.addEventListener('click', closeModal);
        modalClose.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', e => { if (e.target === modalOverlay) closeModal(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
    </script>
@endpush
