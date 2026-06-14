@extends('layouts.dashboard')

@section('title', 'Finances - Administration')
@section('page-title', 'Finances')

@push('styles')
    <style>
        .af-head { margin-bottom: 18px; }
        .af-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .af-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .af-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 12px; margin-bottom: 22px; }
        .af-stat { border-radius: 14px; padding: 16px 18px; }
        .af-stat--main { background: linear-gradient(160deg, var(--kp-blue), var(--kp-blue-darker)); color: #fff; }
        .af-stat--main .af-stat__lbl { color: rgba(255, 255, 255, .8); }
        .af-stat--main .af-stat__val { color: #fff; }
        .af-stat--plain { background: #fff; border: 1px solid var(--kp-border); }
        .af-stat__lbl { font-size: var(--kp-fs-xs); color: var(--kp-muted); margin: 0 0 4px; display: flex; align-items: center; gap: 7px; }
        .af-stat__val { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 800; color: var(--kp-ink); margin: 0; }
        .af-stat__val small { font-size: var(--kp-fs-sm); font-weight: 600; opacity: .8; }

        .af-section { background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; overflow: hidden; margin-bottom: 18px; }
        .af-section__head { padding: 15px 18px; border-bottom: 1px solid var(--kp-border); }
        .af-section__head h3 { font-family: var(--kp-font-title); font-size: var(--kp-fs-md); font-weight: 700; color: var(--kp-ink); margin: 0; display: flex; align-items: center; gap: 9px; }
        .af-section__head h3 i { color: var(--kp-blue); }

        .af-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .af-table thead th { text-align: left; padding: 11px 18px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: var(--kp-surface); white-space: nowrap; }
        .af-table tbody td { padding: 11px 18px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); vertical-align: middle; }
        .af-table tbody tr:last-child td { border-bottom: none; }
        .af-user { font-weight: 600; }
        .af-amount { font-weight: 700; color: var(--kp-blue); white-space: nowrap; }
        .af-type { padding: 3px 10px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; }
        .af-type--acompte { background: var(--kp-blue-soft); color: var(--kp-blue); }
        .af-type--abo { background: #fff3cd; color: #856404; }
        .af-badge { padding: 3px 10px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; }
        .af-badge--ok { background: #d1fae5; color: #065f46; }
        .af-badge--wait { background: #fef3c7; color: #92400e; }
        .af-badge--off { background: var(--kp-surface); color: var(--kp-muted); }
        .af-sub { color: var(--kp-muted); font-size: var(--kp-fs-xs); }
        .af-empty { padding: 28px; text-align: center; color: var(--kp-muted); font-size: var(--kp-fs-sm); }
        .af-pagination { padding: 12px 18px; }

        @media (max-width: 700px) {
            .af-table thead { display: none; }
            .af-table, .af-table tbody, .af-table tr, .af-table td { display: block; }
            .af-table tbody tr { padding: 12px 18px; border-bottom: 1px solid var(--kp-border); }
            .af-table tbody td { border: none !important; padding: 3px 0; }
            .af-table tbody td::before { content: attr(data-label) ' '; color: var(--kp-muted); font-weight: 700; font-size: var(--kp-fs-2xs); text-transform: uppercase; }
        }
    </style>
@endpush

@section('content')
    <div class="af-head">
        <h2>Finances</h2>
        <p>Revenus, paiements et abonnements de la plateforme.</p>
    </div>

    <div class="af-stats">
        <div class="af-stat af-stat--main">
            <p class="af-stat__lbl"><i class="fas fa-wallet"></i> Revenu total</p>
            <p class="af-stat__val">{{ number_format($stats['total'], 0, ',', ' ') }} <small>FCFA</small></p>
        </div>
        <div class="af-stat af-stat--plain">
            <p class="af-stat__lbl"><i class="fas fa-hand-holding-usd"></i> Acomptes</p>
            <p class="af-stat__val">{{ number_format($stats['acomptes'], 0, ',', ' ') }} <small>F</small></p>
        </div>
        <div class="af-stat af-stat--plain">
            <p class="af-stat__lbl"><i class="fas fa-id-card"></i> Abonnements</p>
            <p class="af-stat__val">{{ number_format($stats['abonnements'], 0, ',', ' ') }} <small>F</small></p>
        </div>
        <div class="af-stat af-stat--plain">
            <p class="af-stat__lbl"><i class="fas fa-sync"></i> Abonnements actifs</p>
            <p class="af-stat__val">{{ $stats['abosActifs'] }}</p>
        </div>
    </div>

    {{-- Paiements --}}
    <div class="af-section">
        <div class="af-section__head"><h3><i class="fas fa-receipt"></i> Paiements récents</h3></div>
        @if ($payments->count() > 0)
            <div style="overflow-x: auto;">
                <table class="af-table">
                    <thead><tr><th>Utilisateur</th><th>Type</th><th>Montant</th><th>Méthode</th><th>Statut</th><th>Date</th></tr></thead>
                    <tbody>
                        @foreach ($payments as $p)
                            <tr>
                                <td data-label="Utilisateur" class="af-user">{{ $p->user->firstname ?? '—' }} {{ $p->user->lastname ?? '' }}</td>
                                <td data-label="Type">
                                    @if ($p->subscription_id)
                                        <span class="af-type af-type--abo">Abonnement</span>
                                    @else
                                        <span class="af-type af-type--acompte">Acompte</span>
                                    @endif
                                </td>
                                <td data-label="Montant" class="af-amount">{{ number_format($p->amount, 0, ',', ' ') }} {{ $p->currency ?? 'FCFA' }}</td>
                                <td data-label="Méthode" class="af-sub">{{ ucfirst($p->payment_method ?? 'Moneroo') }}</td>
                                <td data-label="Statut">
                                    @if ($p->status === 'completed')
                                        <span class="af-badge af-badge--ok">Payé</span>
                                    @elseif ($p->status === 'pending')
                                        <span class="af-badge af-badge--wait">En attente</span>
                                    @else
                                        <span class="af-badge af-badge--off">{{ ucfirst($p->status ?? '—') }}</span>
                                    @endif
                                </td>
                                <td data-label="Date" class="af-sub">{{ ($p->paid_at ?? $p->created_at)?->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="af-pagination">{{ $payments->links() }}</div>
        @else
            <div class="af-empty">Aucun paiement enregistré.</div>
        @endif
    </div>

    {{-- Abonnements --}}
    <div class="af-section">
        <div class="af-section__head"><h3><i class="fas fa-id-card"></i> Abonnements</h3></div>
        @if ($subscriptions->count() > 0)
            <div style="overflow-x: auto;">
                <table class="af-table">
                    <thead><tr><th>Tuteur</th><th>Type</th><th>Début</th><th>Fin</th><th>Statut</th></tr></thead>
                    <tbody>
                        @foreach ($subscriptions as $s)
                            <tr>
                                <td data-label="Tuteur" class="af-user">{{ $s->user->firstname ?? '—' }} {{ $s->user->lastname ?? '' }}</td>
                                <td data-label="Type" class="af-sub">{{ ucfirst($s->type_abonnement ?? 'Mensuel') }}</td>
                                <td data-label="Début" class="af-sub">{{ $s->date_debut?->format('d/m/Y') }}</td>
                                <td data-label="Fin" class="af-sub">{{ $s->date_fin?->format('d/m/Y') }}</td>
                                <td data-label="Statut">
                                    @if ($s->statut === 'active' && $s->date_fin && $s->date_fin->isFuture())
                                        <span class="af-badge af-badge--ok">Actif</span>
                                    @else
                                        <span class="af-badge af-badge--off">Expiré</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="af-pagination">{{ $subscriptions->links() }}</div>
        @else
            <div class="af-empty">Aucun abonnement enregistré.</div>
        @endif
    </div>
@endsection
