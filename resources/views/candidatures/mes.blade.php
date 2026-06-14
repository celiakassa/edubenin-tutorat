@extends('layouts.dashboard')

@section('title', 'Candidatures - Kopiao')
@section('page-title', 'Candidatures')

@push('styles')
    <style>
        .cm-page { max-width: 900px; margin: 0 auto; }
        .cm-sub { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0 0 20px; }

        .cm-table-wrap { background: transparent; border: none; border-radius: 0; overflow: visible; box-shadow: none; }
        .cm-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .cm-table thead th { text-align: left; padding: 10px 14px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); white-space: nowrap; }
        .cm-table tbody td { padding: 13px 14px; border-bottom: 1px solid var(--kp-border); vertical-align: middle; }
        .cm-table tbody tr:last-child td { border-bottom: none; }
        .cm-row { cursor: pointer; transition: background .15s; }
        .cm-row:hover { background: var(--kp-surface); }
        .cm-row:hover .cm-arrow { color: var(--kp-blue); transform: translateX(2px); }
        .cm-subject { display: flex; align-items: center; gap: 13px; font-weight: 600; color: var(--kp-ink); }
        .cm-ico { width: 42px; height: 42px; border-radius: 12px; background: var(--kp-blue-soft); color: var(--kp-blue); display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-lg); flex-shrink: 0; }
        .cm-count { display: inline-flex; align-items: center; gap: 6px; background: var(--kp-yellow); color: #1a1a1a; padding: 4px 13px; border-radius: 20px; font-weight: 700; font-size: var(--kp-fs-xs); white-space: nowrap; }
        .cm-status { padding: 4px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 600; white-space: nowrap; }
        .status-en_attente { background: #fef3c7; color: #92400e; }
        .status-en_paiement { background: #dbeafe; color: #1e40af; }
        .status-publiee { background: #d1fae5; color: #065f46; }
        .status-attribuee { background: #ede9fe; color: #5b21b6; }
        .status-refusee { background: #fee2e2; color: #991b1b; }
        .cm-date { color: var(--kp-muted); white-space: nowrap; }
        .cm-arrow { text-align: right; color: var(--kp-muted); transition: all .2s; }

        .cm-empty { text-align: center; padding: 64px 20px; background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; }
        .cm-empty i { font-size: 56px; color: var(--kp-border); margin-bottom: 16px; display: block; }
        .cm-empty h3 { color: var(--kp-ink); font-size: 19px; margin-bottom: 8px; }
        .cm-empty p { color: var(--kp-muted); max-width: 440px; margin: 0 auto 22px; }

        @media (max-width: 620px) { .cm-hide { display: none; } }
    </style>
@endpush

@section('content')
    <div class="cm-page">
        <p class="cm-sub">Les tuteurs qui ont postulé à vos annonces — cliquez une ligne pour voir les candidats.</p>

        @if ($annonces->count() > 0)
            <div class="cm-table-wrap">
                <table class="cm-table">
                    <thead>
                        <tr>
                            <th>Annonce</th>
                            <th>Candidatures</th>
                            <th class="cm-hide">Statut</th>
                            <th class="cm-hide">Publiée le</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($annonces as $annonce)
                            <tr class="cm-row" onclick="window.location='{{ route('annonces.candidatures.index', $annonce->id) }}'">
                                <td>
                                    <div class="cm-subject">
                                        <div class="cm-ico"><i class="fas fa-users"></i></div>
                                        {{ $annonce->subject->nom ?? 'Matière non spécifiée' }}
                                    </div>
                                </td>
                                <td><span class="cm-count"><i class="fas fa-user-check"></i> {{ $annonce->candidatures_count }}</span></td>
                                <td class="cm-hide"><span class="cm-status status-{{ str_replace('é', 'e', $annonce->status) }}">{{ $annonce->status }}</span></td>
                                <td class="cm-hide cm-date">{{ $annonce->created_at->format('d/m/Y') }}</td>
                                <td class="cm-arrow"><i class="fas fa-chevron-right"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="cm-empty">
                <i class="fas fa-user-friends"></i>
                <h3>Aucune candidature pour le moment</h3>
                <p>Quand des tuteurs postuleront à vos annonces publiées, elles apparaîtront ici.</p>
                <a href="{{ route('annonces.index') }}" class="kp-btn kp-btn--secondary"><i class="fas fa-megaphone"></i> Voir mes annonces</a>
            </div>
        @endif
    </div>
@endsection
