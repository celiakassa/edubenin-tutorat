@extends('layouts.dashboard')

@section('title', 'Apprenants - Kopiao')
@section('page-title', 'Apprenants')

@push('styles')
    <style>
        .ap-head { margin-bottom: 20px; }
        .ap-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .ap-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .ap-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 20px; }
        .ap-stat { background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; transition: border-color .2s, transform .2s; }
        .ap-stat:hover { border-color: var(--kp-blue); transform: translateY(-1px); }
        .ap-stat__icon { width: 44px; height: 44px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-md); flex-shrink: 0; background: rgba(26, 26, 26, .06); color: #1a1a1a; }
        .ap-stat__info { display: flex; align-items: baseline; gap: 7px; min-width: 0; flex-wrap: wrap; }
        .ap-stat__val { font-size: var(--kp-fs-xl); font-weight: 700; color: #1a1a1a; margin: 0; }
        .ap-stat__lbl { font-size: var(--kp-fs-xs); color: var(--kp-muted); margin: 0; }

        .ap-search { position: relative; margin-bottom: 14px; max-width: 360px; }
        .ap-search input { width: 100%; height: 46px; padding: 0 16px 0 44px; border: 1.5px solid var(--kp-border); border-radius: 12px; font-size: var(--kp-fs-base); background: #fff; }
        .ap-search input:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }
        .ap-search i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--kp-muted); }

        .ap-table-wrap { background: transparent; border: none; border-radius: 0; overflow: visible; }
        .ap-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .ap-table thead th { text-align: left; padding: 10px 16px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: transparent; white-space: nowrap; }
        .ap-table tbody td { padding: 14px 16px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); vertical-align: middle; }
        .ap-table tbody tr.ap-row { cursor: pointer; transition: background .15s, box-shadow .15s; }
        .ap-table tbody tr.ap-row:hover { background: #fff; box-shadow: var(--kp-shadow-sm); }
        .ap-action { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; cursor: pointer; border: none; white-space: nowrap; transition: all .2s; }
        .ap-action--off { background: #fee2e2; color: #e02c18; }
        .ap-action--off:hover { background: #e02c18; color: #fff; }
        .ap-action--on { background: #d1fae5; color: #065f46; }
        .ap-action--on:hover { background: #16a34a; color: #fff; }
        .ap-table tbody tr:last-child td { border-bottom: none; }
        .ap-learner { display: flex; align-items: center; gap: 11px; }
        .ap-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--kp-blue); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-2xs); flex-shrink: 0; overflow: hidden; }
        .ap-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .ap-name { font-weight: 700; color: var(--kp-ink); }
        .ap-sub { color: var(--kp-muted); font-size: var(--kp-fs-xs); }
        .ap-status { padding: 4px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; white-space: nowrap; }
        .ap-status--on { background: #d1fae5; color: #065f46; }
        .ap-status--off { background: #fee2e2; color: #991b1b; }
        .ap-actions { display: flex; gap: 7px; justify-content: flex-end; }
        .ap-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 7px 13px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; text-decoration: none; cursor: pointer; border: none; white-space: nowrap; transition: all .2s; }
        .ap-btn--primary { background: var(--kp-blue); color: #fff; }
        .ap-btn--primary:hover { background: var(--kp-blue-darker); color: #fff; }
        .ap-btn--icon { width: 34px; height: 34px; padding: 0; border-radius: 9px; background: var(--kp-surface); color: var(--kp-ink); }
        .ap-btn--on { background: #d1fae5; color: #065f46; }
        .ap-btn--off { background: #fee2e2; color: #991b1b; }

        .ap-empty { text-align: center; padding: 50px 20px; color: var(--kp-muted); }
        .ap-empty i { font-size: 54px; color: var(--kp-border); margin-bottom: 14px; display: block; }
        .ap-pagination { padding: 16px 0; }

        @media (max-width: 640px) {
            .ap-stats { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .ap-search { max-width: none; }
            .ap-table-wrap { background: transparent; border: none; border-radius: 0; overflow: visible; }
            .ap-table thead { display: none; }
            .ap-table, .ap-table tbody, .ap-table tr, .ap-table td { display: block; }
            .ap-table tbody tr { position: relative; background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; margin-bottom: 10px; padding: 14px; }
            .ap-table tbody td { border: none !important; padding: 3px 0; }
            .ap-learner { margin-bottom: 8px; }
            .ap-cell-email, .ap-cell-city { color: var(--kp-muted); font-size: var(--kp-fs-sm); }
            .ap-cell-status { position: absolute; top: 14px; right: 14px; }
            .ap-actions { justify-content: flex-start; margin-top: 10px; }
        }
        @media (max-width: 380px) { .ap-stats { grid-template-columns: 1fr; } }
    </style>
@endpush

@section('content')
    <div class="ap-head">
        <h2>Gestion des apprenants</h2>
        <p>{{ $stats['total'] ?? $apprenants->total() }} apprenant(s) inscrit(s) sur la plateforme.</p>
    </div>

    <div class="ap-stats">
        <div class="ap-stat"><div class="ap-stat__icon"><i class="fas fa-user-graduate"></i></div><div class="ap-stat__info"><h3 class="ap-stat__val">{{ $stats['total'] ?? 0 }}</h3><p class="ap-stat__lbl">Total</p></div></div>
        <div class="ap-stat"><div class="ap-stat__icon"><i class="fas fa-user-check"></i></div><div class="ap-stat__info"><h3 class="ap-stat__val">{{ $stats['actifs'] ?? 0 }}</h3><p class="ap-stat__lbl">Actifs</p></div></div>
        <div class="ap-stat"><div class="ap-stat__icon"><i class="fas fa-id-badge"></i></div><div class="ap-stat__info"><h3 class="ap-stat__val">{{ $stats['avecProfilComplet'] ?? 0 }}</h3><p class="ap-stat__lbl">Profils complets</p></div></div>
        <div class="ap-stat"><div class="ap-stat__icon"><i class="fas fa-user-slash"></i></div><div class="ap-stat__info"><h3 class="ap-stat__val">{{ $stats['inactifs'] ?? 0 }}</h3><p class="ap-stat__lbl">Désactivés</p></div></div>
    </div>

    <form method="GET" action="{{ route('apprenants.index') }}" class="ap-search" id="apSearchForm">
        <i class="fas fa-search"></i>
        <input type="text" name="q" value="{{ $q ?? '' }}" id="apSearchInput" placeholder="Rechercher (nom, email, ville)…" autocomplete="off">
    </form>

    @if ($apprenants->count() > 0)
        <div class="ap-table-wrap">
            <table class="ap-table">
                <thead>
                    <tr>
                        <th>Apprenant</th>
                        <th>Email</th>
                        <th>Ville</th>
                        <th>Statut</th>
                        <th>Inscrit le</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="apBody">
                    @foreach ($apprenants as $apprenant)
                        <tr class="ap-row" data-search="{{ strtolower($apprenant->firstname . ' ' . $apprenant->lastname . ' ' . $apprenant->email . ' ' . $apprenant->city) }}" onclick="window.location='{{ route('apprenants.show', $apprenant->id) }}'">
                            <td>
                                <div class="ap-learner">
                                    <div class="ap-avatar">
                                        @if ($apprenant->photo_path && Storage::disk('public')->exists($apprenant->photo_path))
                                            <img src="{{ asset('storage/' . $apprenant->photo_path) }}" alt="Profil">
                                        @else
                                            {{ strtoupper(substr($apprenant->firstname, 0, 1) . substr($apprenant->lastname, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="ap-name">{{ $apprenant->firstname }} {{ $apprenant->lastname }}</div>
                                        <div class="ap-sub">{{ $apprenant->telephone ?? 'Tél. non renseigné' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="ap-cell-email">{{ $apprenant->email }}</td>
                            <td class="ap-cell-city">{{ $apprenant->city ?? 'Non spécifiée' }}</td>
                            <td class="ap-cell-status">
                                <span class="ap-status {{ $apprenant->is_active ? 'ap-status--on' : 'ap-status--off' }}">{{ $apprenant->is_active ? 'Actif' : 'Désactivé' }}</span>
                            </td>
                            <td class="ap-sub">{{ $apprenant->created_at->format('d/m/Y') }}</td>
                            <td onclick="event.stopPropagation();" style="text-align: right;">
                                <form action="{{ route('apprenants.toggle-status', $apprenant->id) }}" method="POST"
                                      onsubmit="return kpConfirmDelete(event, this, {icon: '{{ $apprenant->is_active ? 'danger' : 'success' }}', iconClass: '{{ $apprenant->is_active ? 'fa-user-slash' : 'fa-user-check' }}', title: '{{ $apprenant->is_active ? 'Désactiver cet apprenant ?' : 'Réactiver cet apprenant ?' }}', text: '{{ $apprenant->is_active ? 'Le compte sera désactivé.' : 'Le compte sera réactivé.' }}', confirmText: '{{ $apprenant->is_active ? 'Désactiver' : 'Réactiver' }}', confirmColor: '{{ $apprenant->is_active ? '#dc2626' : '#0B69F1' }}'});">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="ap-action {{ $apprenant->is_active ? 'ap-action--off' : 'ap-action--on' }}"><i class="fas {{ $apprenant->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i> {{ $apprenant->is_active ? 'Désactiver' : 'Réactiver' }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="ap-pagination">{{ $apprenants->links() }}</div>
    @else
        <div class="ap-empty">
            <i class="fas fa-user-graduate"></i>
            <p>@if (!empty($q))Aucun apprenant ne correspond à « {{ $q }} ».@else Aucun apprenant inscrit pour le moment.@endif</p>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        (function () {
            const form = document.getElementById('apSearchForm');
            const input = document.getElementById('apSearchInput');
            if (form && input) {
                let timer;
                input.addEventListener('input', function () {
                    clearTimeout(timer);
                    timer = setTimeout(function () { form.submit(); }, 450);
                });
                // Garder le focus + curseur en fin après rechargement
                if (input.value) {
                    input.focus();
                    const v = input.value;
                    input.setSelectionRange(v.length, v.length);
                }
            }
        })();
    </script>
@endpush
