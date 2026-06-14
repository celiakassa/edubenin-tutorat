@extends('layouts.dashboard')

@section('title', 'Mes candidatures - Kopiao')
@section('page-title', 'Mes candidatures')

@push('styles')
    <style>
        .mc-head { margin-bottom: 20px; }
        .mc-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .mc-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .mc-table-wrap { background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; overflow: hidden; }
        .mc-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .mc-table thead th { text-align: left; padding: 12px 16px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: var(--kp-surface); white-space: nowrap; }
        .mc-table tbody td { padding: 13px 16px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); vertical-align: middle; }
        .mc-table tbody tr:last-child td { border-bottom: none; }
        .mc-row { cursor: pointer; transition: background .15s; }
        .mc-row:hover { background: var(--kp-surface); }
        .mc-row:hover .mc-arrow { color: var(--kp-blue); transform: translateX(2px); }
        .mc-subject { display: flex; align-items: center; gap: 12px; font-weight: 700; color: var(--kp-ink); }
        .mc-ico { width: 40px; height: 40px; border-radius: 11px; background: var(--kp-blue-soft); color: var(--kp-blue); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .mc-student { color: var(--kp-text); }
        .mc-status { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; white-space: nowrap; }
        .mc-status--acceptee { background: #d1fae5; color: #065f46; }
        .mc-status--attente { background: #fef3c7; color: #92400e; }
        .mc-status--refusee { background: #fee2e2; color: #991b1b; }
        .mc-date { color: var(--kp-muted); white-space: nowrap; }
        .mc-arrow { text-align: right; color: var(--kp-muted); transition: all .2s; }

        .mc-empty { text-align: center; padding: 40px 20px; min-height: 55vh; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .mc-empty i { font-size: 60px; color: var(--kp-border); margin-bottom: 16px; display: block; }
        .mc-empty h3 { color: var(--kp-ink); font-size: var(--kp-fs-xl); margin: 0 0 8px; }
        .mc-empty p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0 0 20px; }

        .mc-pagination { display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; padding: 16px 0; }
        .mc-pagination .info { font-size: var(--kp-fs-sm); color: var(--kp-muted); }

        @media (max-width: 640px) {
            .mc-table-wrap { background: transparent; border: none; border-radius: 0; overflow: visible; }
            .mc-table thead { display: none; }
            .mc-table, .mc-table tbody, .mc-table tr, .mc-table td { display: block; }
            .mc-table tr.mc-row { position: relative; background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; margin-bottom: 10px; padding: 14px 40px 14px 14px; }
            .mc-table tbody td { border: none !important; padding: 3px 0; }
            .mc-subject { font-size: var(--kp-fs-md); margin-bottom: 6px; padding-right: 90px; }
            .mc-cell-status { position: absolute; top: 14px; right: 40px; }
            .mc-cell-student { display: inline-block; color: var(--kp-muted); font-size: var(--kp-fs-sm); }
            .mc-cell-student::before { content: 'Étudiant : '; }
            .mc-cell-date { display: inline-block; margin-left: 12px; }
            .mc-cell-date::before { content: '· '; }
            .mc-arrow { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); }
        }
    </style>
@endpush

@section('content')
    <div class="mc-head">
        <h2>Suivez vos candidatures</h2>
        <p>{{ $candidatures->total() }} candidature(s) envoyée(s) — cliquez une ligne pour voir l'annonce.</p>
    </div>

    @if ($candidatures->count() > 0)
        <div class="mc-table-wrap">
            <table class="mc-table">
                <thead>
                    <tr>
                        <th>Annonce</th>
                        <th>Étudiant</th>
                        <th>Statut</th>
                        <th>Postulé le</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($candidatures as $candidature)
                        @php
                            $statut = $candidature->statut;
                            $matiere = $candidature->annonce->subject->nom ?? ($candidature->annonce->domaine ?? 'Matière');
                            $detailUrl = route('annonces.dashboard.detail', $candidature->annonce->hashid);
                        @endphp
                        <tr class="mc-row" onclick="window.location='{{ $detailUrl }}'">
                            <td>
                                <div class="mc-subject">
                                    <div class="mc-ico"><i class="fas fa-book"></i></div>
                                    {{ ucfirst($matiere) }}
                                </div>
                            </td>
                            <td class="mc-cell-student mc-student">{{ $candidature->annonce->student->firstname ?? '—' }}</td>
                            <td class="mc-cell-status">
                                @if ($statut === 'acceptee')
                                    <span class="mc-status mc-status--acceptee"><i class="fas fa-check-circle"></i> Acceptée</span>
                                @elseif ($statut === 'en_attente')
                                    <span class="mc-status mc-status--attente"><i class="fas fa-clock"></i> En attente</span>
                                @else
                                    <span class="mc-status mc-status--refusee"><i class="fas fa-times-circle"></i> Refusée</span>
                                @endif
                            </td>
                            <td class="mc-cell-date mc-date">{{ $candidature->created_at->format('d/m/Y') }}</td>
                            <td class="mc-arrow"><i class="fas fa-chevron-right"></i></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($candidatures->hasPages())
            <div class="mc-pagination">
                <div class="info">Affichage de {{ $candidatures->firstItem() }} à {{ $candidatures->lastItem() }} sur {{ $candidatures->total() }} candidatures</div>
                <div>{{ $candidatures->links() }}</div>
            </div>
        @endif
    @else
        <div class="mc-empty">
            <i class="fas fa-clipboard-list"></i>
            <h3>Aucune candidature</h3>
            <p>Vous n'avez pas encore postulé à une annonce. Trouvez votre prochaine mission !</p>
            <a href="{{ route('annonces') }}" class="kp-btn kp-btn--primary">Voir les annonces</a>
        </div>
    @endif
@endsection
