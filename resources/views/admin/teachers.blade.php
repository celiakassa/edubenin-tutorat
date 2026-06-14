@extends('layouts.dashboard')

@section('title', 'Tuteurs - Administration')
@section('page-title', 'Tuteurs')

@push('styles')
    <style>
        .at-head { margin-bottom: 18px; }
        .at-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .at-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .at-toolbar { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; margin-bottom: 16px; }
        .at-search { position: relative; flex: 1; min-width: 200px; }
        .at-search input { width: 100%; height: 44px; padding: 0 16px 0 42px; border: 1.5px solid var(--kp-border); border-radius: 12px; font-size: var(--kp-fs-base); background: #fff; }
        .at-search input:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }
        .at-search i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--kp-muted); }
        .at-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
        .at-tab { padding: 8px 14px; border: 1px solid var(--kp-border); border-radius: 20px; background: #fff; color: var(--kp-text); font-size: var(--kp-fs-sm); font-weight: 600; text-decoration: none; transition: all .2s; white-space: nowrap; }
        .at-tab:hover { border-color: var(--kp-blue); color: var(--kp-blue); }
        .at-tab.active { background: var(--kp-blue); color: #fff; border-color: var(--kp-blue); }

        .at-table-wrap { background: transparent; border: none; border-radius: 0; overflow: visible; }
        .at-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .at-table thead th { text-align: left; padding: 10px 16px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: transparent; white-space: nowrap; }
        .at-table tbody td { padding: 14px 16px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); vertical-align: middle; }
        .at-table tbody tr.at-row { cursor: pointer; transition: background .15s, box-shadow .15s; }
        .at-table tbody tr.at-row:hover { background: #fff; box-shadow: var(--kp-shadow-sm); }
        .at-table tbody tr:last-child td { border-bottom: none; }
        .at-teacher { display: flex; align-items: center; gap: 11px; }
        .at-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--kp-blue); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-2xs); flex-shrink: 0; overflow: hidden; }
        .at-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .at-name { font-weight: 700; color: var(--kp-ink); }
        .at-mail { color: var(--kp-muted); font-size: var(--kp-fs-xs); }
        .at-badges { display: flex; gap: 5px; flex-wrap: wrap; }
        .at-badge { padding: 3px 10px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; white-space: nowrap; }
        .at-badge--ok { background: #d1fae5; color: #065f46; }
        .at-badge--wait { background: #fef3c7; color: #92400e; }
        .at-badge--off { background: #fee2e2; color: #991b1b; }
        .at-comp { display: flex; align-items: center; gap: 8px; min-width: 110px; }
        .at-comp__bar { flex: 1; height: 6px; background: var(--kp-border); border-radius: 6px; overflow: hidden; }
        .at-comp__bar span { display: block; height: 100%; background: var(--kp-blue); }
        .at-comp__pct { font-size: var(--kp-fs-2xs); font-weight: 700; color: var(--kp-muted); }
        .at-action { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; cursor: pointer; border: none; white-space: nowrap; transition: all .2s; }
        .at-action--off { background: #fee2e2; color: #e02c18; }
        .at-action--off:hover { background: #e02c18; color: #fff; }
        .at-action--on { background: #d1fae5; color: #065f46; }
        .at-action--on:hover { background: #16a34a; color: #fff; }

        /* Modal d'action */
        .adm-modal { display: none; position: fixed; inset: 0; background: rgba(11, 18, 32, .5); z-index: 3600; align-items: center; justify-content: center; padding: 20px; }
        .adm-modal.active { display: flex; }
        .adm-modal__box { background: #fff; border-radius: 18px; padding: 28px; max-width: 440px; width: 100%; box-shadow: 0 24px 60px rgba(0, 0, 0, .25); }
        .adm-modal__icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-2xl); margin: 0 auto 14px; background: var(--kp-surface); color: var(--kp-muted); }
        .adm-modal__icon.red { background: #fee2e2; color: #dc2626; }
        .adm-modal__icon.blue { background: var(--kp-blue-soft); color: var(--kp-blue); }
        .adm-modal__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 8px; text-align: center; }
        .adm-modal__msg { color: var(--kp-muted); font-size: var(--kp-fs-sm); margin: 0 0 16px; text-align: center; }
        .adm-modal__reason { width: 100%; padding: 11px 13px; border: 1.5px solid var(--kp-border); border-radius: 11px; font-size: var(--kp-fs-base); font-family: inherit; resize: none; margin-bottom: 16px; }
        .adm-modal__reason:focus { outline: none; border-color: var(--kp-blue); }
        .adm-modal__buttons { display: flex; gap: 10px; }
        .adm-modal__btn { flex: 1; padding: 11px; border-radius: 10px; font-weight: 600; font-size: var(--kp-fs-base); cursor: pointer; border: none; }
        .adm-modal__btn.cancel { background: var(--kp-surface); color: var(--kp-ink); }
        .adm-modal__btn.confirm { background: var(--kp-blue); color: #fff; }

        .at-empty { text-align: center; padding: 50px 20px; color: var(--kp-muted); }
        .at-pagination { padding: 16px 0; }

        @media (max-width: 700px) {
            .at-table thead { display: none; }
            .at-table, .at-table tbody, .at-table tr, .at-table td { display: block; }
            .at-table tbody tr { position: relative; background: #fff; padding: 14px; border-bottom: 1px solid var(--kp-border); }
            .at-table tbody td { border: none !important; padding: 4px 0; }
            .at-teacher { margin-bottom: 8px; }
            .at-comp { min-width: 0; max-width: 200px; }
        }
    </style>
@endpush

@section('content')
    <div class="at-head">
        <h2>Gestion des tuteurs</h2>
        <p>{{ $teachers->total() }} tuteur(s) — recherchez, filtrez et gérez les comptes.</p>
    </div>

    <div class="at-toolbar">
        <form method="GET" action="{{ route('admin.teachers') }}" class="at-search" id="atSearchForm">
            <i class="fas fa-search"></i>
            <input type="text" name="q" value="{{ $q }}" placeholder="Rechercher un tuteur (nom, email)…" id="atSearchInput" autocomplete="off">
            <input type="hidden" name="filter" value="{{ $filter }}">
        </form>
        <div class="at-tabs">
            @php $tabs = ['all' => 'Tous', 'pending' => 'En attente', 'verified' => 'Vérifiés', 'rejected' => 'Rejetés', 'nodoc' => 'Sans pièce', 'inactive' => 'Désactivés']; @endphp
            @foreach ($tabs as $k => $label)
                <a href="{{ route('admin.teachers', ['filter' => $k, 'q' => $q]) }}" class="at-tab {{ $filter == $k ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>

    @if ($teachers->count() > 0)
        <div class="at-table-wrap">
            <table class="at-table">
                <thead>
                    <tr><th>Tuteur</th><th>Statut</th><th>Complétion</th><th>Inscrit le</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                        <tr class="at-row" onclick="window.location='{{ route('admin.teacher.details', $teacher->id) }}'">
                            <td>
                                <div class="at-teacher">
                                    <div class="at-avatar">
                                        @if ($teacher->photo_path && Storage::disk('public')->exists($teacher->photo_path))
                                            <img src="{{ asset('storage/' . $teacher->photo_path) }}" alt="Profil">
                                        @else
                                            {{ strtoupper(substr($teacher->firstname, 0, 1) . substr($teacher->lastname, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="at-name">{{ $teacher->firstname }} {{ $teacher->lastname }}</div>
                                        <div class="at-mail">{{ $teacher->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="at-badges">
                                    @if ($teacher->identity_verified)
                                        <span class="at-badge at-badge--ok">Vérifié</span>
                                    @elseif ($teacher->identity_rejected)
                                        <span class="at-badge at-badge--off">Rejeté</span>
                                    @else
                                        <span class="at-badge at-badge--wait">En attente</span>
                                    @endif
                                    @if (! $teacher->is_active)
                                        <span class="at-badge at-badge--off">Désactivé</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="at-comp">
                                    <div class="at-comp__bar"><span style="width: {{ $teacher->profile_completion }}%;"></span></div>
                                    <span class="at-comp__pct">{{ $teacher->profile_completion }}%</span>
                                </div>
                            </td>
                            <td class="at-mail">{{ $teacher->created_at->format('d/m/Y') }}</td>
                            <td style="text-align: right;" onclick="event.stopPropagation();">
                                @if ($teacher->is_active)
                                    <button type="button" class="at-action at-action--off" onclick="admAction({action: '{{ route('admin.teachers.deactivate', $teacher->id) }}', title: 'Désactiver ce compte ?', message: 'Indiquez le motif de la désactivation (obligatoire).', reasonName: 'deactivation_reason', required: true, confirmText: 'Désactiver', confirmColor: '#dc2626', icon: 'fa-user-slash', iconType: 'red'})"><i class="fas fa-user-slash"></i> Désactiver</button>
                                @else
                                    <button type="button" class="at-action at-action--on" onclick="admAction({action: '{{ route('admin.teachers.reactivate', $teacher->id) }}', title: 'Réactiver ce compte ?', message: 'Le tuteur pourra de nouveau accéder à la plateforme.', reasonName: 'reactivation_reason', required: false, confirmText: 'Réactiver', confirmColor: '#0B69F1', icon: 'fa-user-check', iconType: 'blue'})"><i class="fas fa-user-check"></i> Réactiver</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="at-pagination">{{ $teachers->links() }}</div>
    @else
        <div class="at-empty"><i class="fas fa-chalkboard-teacher" style="font-size: 50px; color: var(--kp-border); display: block; margin-bottom: 12px;"></i>Aucun tuteur ne correspond.</div>
    @endif

    {{-- Modal d'action --}}
    <div class="adm-modal" id="admActionModal">
        <div class="adm-modal__box">
            <div class="adm-modal__icon" id="adm-modal-icon"><i class="fas fa-question"></i></div>
            <h3 class="adm-modal__title" id="adm-modal-title">Confirmation</h3>
            <p class="adm-modal__msg" id="adm-modal-msg"></p>
            <form method="POST" id="adm-modal-form" action="">
                @csrf
                <textarea id="adm-modal-reason" class="adm-modal__reason" rows="3"></textarea>
                <div class="adm-modal__buttons">
                    <button type="button" class="adm-modal__btn cancel" onclick="admActionClose()">Annuler</button>
                    <button type="submit" class="adm-modal__btn confirm" id="adm-modal-confirm">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function admAction(opts) {
            const f = document.getElementById('adm-modal-form');
            f.action = opts.action;
            document.getElementById('adm-modal-title').textContent = opts.title;
            document.getElementById('adm-modal-msg').textContent = opts.message || '';
            const ta = document.getElementById('adm-modal-reason');
            ta.name = opts.reasonName;
            ta.required = !!opts.required;
            ta.placeholder = opts.required ? 'Motif (obligatoire)' : 'Motif (facultatif)';
            ta.value = '';
            const icon = document.getElementById('adm-modal-icon');
            icon.className = 'adm-modal__icon ' + (opts.iconType || '');
            icon.innerHTML = '<i class="fas ' + (opts.icon || 'fa-question') + '"></i>';
            const btn = document.getElementById('adm-modal-confirm');
            btn.textContent = opts.confirmText || 'Confirmer';
            btn.style.background = opts.confirmColor || '';
            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
            document.getElementById('admActionModal').classList.add('active');
        }
        function admActionClose() {
            document.getElementById('admActionModal').classList.remove('active');
            document.documentElement.style.overflow = '';
            document.body.style.overflow = '';
        }
        document.getElementById('admActionModal').addEventListener('click', function (e) { if (e.target === this) admActionClose(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') admActionClose(); });

        // Recherche auto à la frappe (débounce) — cohérent avec les autres barres
        (function () {
            const form = document.getElementById('atSearchForm');
            const input = document.getElementById('atSearchInput');
            if (form && input) {
                let timer;
                input.addEventListener('input', function () {
                    clearTimeout(timer);
                    timer = setTimeout(function () { form.submit(); }, 450);
                });
                // Garder le focus + curseur en fin après le rechargement
                if (input.value) {
                    input.focus();
                    const v = input.value;
                    input.setSelectionRange(v.length, v.length);
                }
            }
        })();
    </script>
@endpush
