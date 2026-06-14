@extends('layouts.dashboard')

@section('title', 'Mes abonnements - Kopiao')
@section('page-title', 'Mes abonnements')

@push('styles')
    <style>
        .sub-head { margin-bottom: 20px; }
        .sub-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .sub-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .sub-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; }
        .sub-stat { background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; transition: border-color .2s, transform .2s; }
        .sub-stat:hover { border-color: var(--kp-blue); transform: translateY(-1px); }
        .sub-stat__icon { width: 44px; height: 44px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-md); flex-shrink: 0; }
        .sub-stat__icon.active { background: #d1fae5; color: #065f46; }
        .sub-stat__icon.total { background: var(--kp-blue-soft); color: var(--kp-blue); }
        .sub-stat__icon.exp { background: var(--kp-surface); color: var(--kp-muted); }
        .sub-stat__info { display: flex; align-items: baseline; gap: 7px; min-width: 0; flex-wrap: wrap; }
        .sub-stat__val { font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0; }
        .sub-stat__lbl { font-size: var(--kp-fs-xs); color: var(--kp-muted); margin: 0; }

        .sub-table-wrap { background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; overflow: hidden; }
        .sub-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .sub-table thead th { text-align: left; padding: 12px 16px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: var(--kp-surface); white-space: nowrap; }
        .sub-table tbody td { padding: 13px 16px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); }
        .sub-table tbody tr:last-child td { border-bottom: none; }
        .sub-table tbody tr:hover { background: var(--kp-surface); }
        .sub-ref { color: var(--kp-blue); font-weight: 700; }
        .sub-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; white-space: nowrap; }
        .sub-badge--active { background: #d1fae5; color: #065f46; }
        .sub-badge--exp { background: var(--kp-surface); color: var(--kp-muted); }
        .sub-badge--warn { background: #fef3c7; color: #92400e; }
        .sub-badge--days { background: var(--kp-blue-soft); color: var(--kp-blue); }

        .sub-empty { text-align: center; padding: 40px 20px; min-height: 55vh; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .sub-empty i { font-size: 56px; color: var(--kp-border); margin-bottom: 16px; display: block; }
        .sub-empty h3 { color: var(--kp-ink); font-size: var(--kp-fs-xl); margin: 0 0 8px; }
        .sub-empty p { color: var(--kp-muted); margin: 0 0 20px; }

        .sub-pagination { display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; padding: 16px 0; }
        .sub-pagination .info { font-size: var(--kp-fs-sm); color: var(--kp-muted); }

        @media (max-width: 640px) {
            .sub-stats { grid-template-columns: 1fr; }
            .sub-table-wrap { background: transparent; border: none; border-radius: 0; overflow: visible; }
            .sub-table thead { display: none; }
            .sub-table, .sub-table tbody, .sub-table tr, .sub-table td { display: block; }
            .sub-table tr { background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; margin-bottom: 10px; padding: 14px; }
            .sub-table tbody td { border: none !important; padding: 4px 0 4px 120px; position: relative; font-size: var(--kp-fs-sm); }
            .sub-table tbody td::before { content: attr(data-label); position: absolute; left: 0; top: 4px; width: 108px; color: var(--kp-muted); font-weight: 700; font-size: var(--kp-fs-2xs); text-transform: uppercase; }
        }
    </style>
@endpush

@section('content')
    <div class="sub-head">
        <h2>Suivez vos abonnements</h2>
        <p>Consultez l'ensemble de vos abonnements et leur statut.</p>
    </div>

    @if ($subscriptions->count() > 0)
        {{-- Statistiques --}}
        <div class="sub-stats">
            <div class="sub-stat">
                <div class="sub-stat__icon active"><i class="fas fa-check-circle"></i></div>
                <div class="sub-stat__info">
                    <h3 class="sub-stat__val">{{ $subscriptions->where('statut', 'active')->where('date_fin', '>', now())->count() }}</h3>
                    <p class="sub-stat__lbl">Actif(s)</p>
                </div>
            </div>
            <div class="sub-stat">
                <div class="sub-stat__icon total"><i class="fas fa-layer-group"></i></div>
                <div class="sub-stat__info">
                    <h3 class="sub-stat__val">{{ $subscriptions->total() }}</h3>
                    <p class="sub-stat__lbl">Total</p>
                </div>
            </div>
            <div class="sub-stat">
                <div class="sub-stat__icon exp"><i class="fas fa-hourglass-end"></i></div>
                <div class="sub-stat__info">
                    <h3 class="sub-stat__val">{{ $subscriptions->where('date_fin', '<', now())->count() }}</h3>
                    <p class="sub-stat__lbl">Expiré(s)</p>
                </div>
            </div>
        </div>

        <div class="sub-table-wrap">
            <table class="sub-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Jours restants</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscriptions as $subscription)
                        <tr>
                            <td data-label="Référence"><span class="sub-ref">AB-{{ str_pad($loop->iteration + ($subscriptions->currentPage() - 1) * $subscriptions->perPage(), 4, '0', STR_PAD_LEFT) }}</span></td>
                            <td data-label="Date début">{{ $subscription->date_debut->format('d/m/Y') }}</td>
                            <td data-label="Date fin">{{ $subscription->date_fin->format('d/m/Y') }}</td>
                            <td data-label="Jours restants">
                                @if ($subscription->date_fin->isFuture())
                                    @php $joursRestants = max(0, now()->startOfDay()->diffInDays($subscription->date_fin->startOfDay(), false)); @endphp
                                    <span class="sub-badge sub-badge--days">{{ $joursRestants }} jour(s)</span>
                                @else
                                    <span style="color: var(--kp-muted);">—</span>
                                @endif
                            </td>
                            <td data-label="Statut">
                                @if ($subscription->statut === 'active' && $subscription->date_fin->isFuture())
                                    <span class="sub-badge sub-badge--active">Actif</span>
                                @elseif ($subscription->statut === 'active' && $subscription->date_fin->isPast())
                                    <span class="sub-badge sub-badge--exp">Expiré</span>
                                @else
                                    <span class="sub-badge sub-badge--warn">{{ ucfirst($subscription->statut) }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($subscriptions->hasPages())
            <div class="sub-pagination">
                <div class="info">Affichage de {{ $subscriptions->firstItem() }} à {{ $subscriptions->lastItem() }} sur {{ $subscriptions->total() }} résultats</div>
                <div>{{ $subscriptions->links() }}</div>
            </div>
        @endif
    @else
        <div class="sub-empty">
            <i class="fas fa-inbox"></i>
            <h3>Aucun abonnement trouvé</h3>
            <p>Vous n'avez pas encore d'historique d'abonnements.</p>
            <a href="{{ route('subscription.user') }}" class="kp-btn kp-btn--primary">Souscrire maintenant</a>
        </div>
    @endif
@endsection
