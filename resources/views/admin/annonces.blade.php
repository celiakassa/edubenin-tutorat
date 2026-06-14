@extends('layouts.dashboard')

@section('title', 'Annonces - Administration')
@section('page-title', 'Annonces')

@push('styles')
    <style>
        .aa-head { margin-bottom: 18px; }
        .aa-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .aa-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .aa-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 18px; }
        .aa-stat { background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; transition: border-color .2s, transform .2s; }
        .aa-stat:hover { border-color: var(--kp-blue); transform: translateY(-1px); }
        .aa-stat__icon { width: 44px; height: 44px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-md); flex-shrink: 0; background: rgba(26, 26, 26, .06); color: #1a1a1a; }
        .aa-stat__info { display: flex; align-items: baseline; gap: 7px; min-width: 0; flex-wrap: wrap; }
        .aa-stat__val { font-size: var(--kp-fs-xl); font-weight: 700; color: #1a1a1a; margin: 0; }
        .aa-stat__lbl { font-size: var(--kp-fs-xs); color: var(--kp-muted); margin: 0; }

        .aa-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
        .aa-tab { padding: 8px 14px; border: 1px solid var(--kp-border); border-radius: 20px; background: #fff; color: var(--kp-text); font-size: var(--kp-fs-sm); font-weight: 600; text-decoration: none; transition: all .2s; white-space: nowrap; }
        .aa-tab:hover { border-color: var(--kp-blue); color: var(--kp-blue); }
        .aa-tab.active { background: var(--kp-blue); color: #fff; border-color: var(--kp-blue); }
        .aa-search { position: relative; margin-bottom: 14px; max-width: 380px; }
        .aa-search input { width: 100%; height: 46px; padding: 0 16px 0 44px; border: 1.5px solid var(--kp-border); border-radius: 12px; font-size: var(--kp-fs-base); background: #fff; }
        .aa-search input:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }
        .aa-search i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--kp-muted); }

        .aa-table-wrap { background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; overflow: hidden; }
        .aa-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .aa-table thead th { text-align: left; padding: 12px 16px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: var(--kp-surface); white-space: nowrap; }
        .aa-table tbody td { padding: 12px 16px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); vertical-align: middle; }
        .aa-table tbody tr:last-child td { border-bottom: none; }
        .aa-subject { display: flex; align-items: center; gap: 11px; font-weight: 700; color: var(--kp-ink); }
        .aa-ico { width: 38px; height: 38px; border-radius: 10px; background: var(--kp-blue-soft); color: var(--kp-blue); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .aa-sub { color: var(--kp-muted); font-size: var(--kp-fs-xs); }
        .aa-budget { color: var(--kp-blue); font-weight: 700; white-space: nowrap; }
        .aa-status { padding: 4px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; white-space: nowrap; }
        .status-en_attente { background: #fef3c7; color: #92400e; }
        .status-en_paiement { background: #dbeafe; color: #1e40af; }
        .status-publiee { background: #d1fae5; color: #065f46; }
        .status-attribuee { background: #ede9fe; color: #5b21b6; }
        .status-refusee { background: #fee2e2; color: #991b1b; }
        .aa-row { cursor: pointer; transition: background .15s, box-shadow .15s; }
        .aa-row:hover { background: #fff; box-shadow: var(--kp-shadow-sm); }
        .aa-chevron { color: var(--kp-muted); transition: all .2s; }
        .aa-row:hover .aa-chevron { color: var(--kp-blue); transform: translateX(2px); }

        /* Drawer détails annonce */
        .aadrawer { position: fixed; inset: 0; z-index: 3000; display: none; }
        .aadrawer.open { display: block; }
        .aadrawer__overlay { position: absolute; inset: 0; background: rgba(11, 18, 32, .45); opacity: 0; transition: opacity .25s; }
        .aadrawer.open .aadrawer__overlay { opacity: 1; }
        .aadrawer__panel { position: absolute; top: 0; right: 0; bottom: 0; width: 440px; max-width: 92vw; background: #fff; box-shadow: -12px 0 44px rgba(0, 0, 0, .22); transform: translateX(100%); transition: transform .3s ease; display: flex; flex-direction: column; }
        .aadrawer.open .aadrawer__panel { transform: translateX(0); }
        .aadrawer__head { display: flex; align-items: center; gap: 10px; padding: 18px 20px; border-bottom: 1px solid var(--kp-border); flex-wrap: wrap; }
        .aadrawer__badge { background: var(--kp-blue); color: #fff; padding: 5px 14px; border-radius: 25px; font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; }
        .aadrawer__close { margin-left: auto; width: 34px; height: 34px; border-radius: 50%; border: none; background: var(--kp-surface); color: var(--kp-ink); cursor: pointer; }
        .aadrawer__close:hover { background: var(--kp-blue); color: #fff; }
        .aadrawer__body { flex: 1; overflow-y: auto; padding: 20px; }
        .aad-student { display: flex; align-items: center; gap: 9px; color: var(--kp-text); font-size: var(--kp-fs-base); margin-bottom: 16px; font-weight: 600; }
        .aad-student i { color: var(--kp-blue); }
        .aad-budget { background: var(--kp-yellow); border-radius: 14px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
        .aad-budget .lbl { font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; color: #1a1a1a; }
        .aad-budget .amt { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 800; color: #1a1a1a; }
        .aad-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .aad-item { background: var(--kp-surface); border-radius: 11px; padding: 10px 13px; }
        .aad-item--full { grid-column: 1 / -1; }
        .aad-item .lbl { display: block; font-size: var(--kp-fs-2xs); color: var(--kp-muted); font-weight: 700; text-transform: uppercase; }
        .aad-item .val { display: block; font-size: var(--kp-fs-base); font-weight: 600; color: var(--kp-ink); margin-top: 2px; white-space: pre-line; }
        .aad-desc .lbl { display: block; font-size: var(--kp-fs-2xs); color: var(--kp-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px; }
        .aad-desc p { color: var(--kp-text); font-size: var(--kp-fs-base); line-height: 1.6; margin: 0; }
        .aadrawer__foot { padding: 14px 20px; border-top: 1px solid var(--kp-border); }
        .aad-del-btn { width: 100%; height: 44px; border: none; border-radius: var(--kp-radius-pill); background: #e02c18; color: #fff; font-weight: 700; font-size: var(--kp-fs-sm); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
        .aad-del-btn:hover { background: #c62411; }
        @media (max-width: 575px) {
            .aadrawer__panel { top: auto; left: 0; right: 0; bottom: 0; width: 100%; max-width: 100%; max-height: 90vh; border-radius: 20px 20px 0 0; transform: translateY(100%); box-shadow: 0 -14px 40px rgba(0, 0, 0, .25); }
            .aadrawer.open .aadrawer__panel { transform: translateY(0); }
        }

        .aa-empty { text-align: center; padding: 50px 20px; color: var(--kp-muted); }
        .aa-pagination { padding: 16px 0; }

        @media (max-width: 700px) {
            .aa-stats { grid-template-columns: repeat(2, 1fr); }
            .aa-table thead { display: none; }
            .aa-table, .aa-table tbody, .aa-table tr, .aa-table td { display: block; }
            .aa-table tbody tr { position: relative; padding: 14px 50px 14px 14px; border-bottom: 1px solid var(--kp-border); }
            .aa-table tbody td { border: none !important; padding: 4px 0; }
            .aa-subject { margin-bottom: 6px; }
            .aa-cell-del { position: absolute; top: 50%; right: 14px; transform: translateY(-50%); padding: 0; }
        }
    </style>
@endpush

@section('content')
    <div class="aa-head">
        <h2>Modération des annonces</h2>
        <p>Suivez et modérez toutes les annonces de la plateforme.</p>
    </div>

    <div class="aa-stats">
        <div class="aa-stat"><div class="aa-stat__icon"><i class="fas fa-bullhorn"></i></div><div class="aa-stat__info"><h3 class="aa-stat__val">{{ $stats['total'] }}</h3><p class="aa-stat__lbl">Total</p></div></div>
        <div class="aa-stat"><div class="aa-stat__icon"><i class="fas fa-check-circle"></i></div><div class="aa-stat__info"><h3 class="aa-stat__val">{{ $stats['publiees'] }}</h3><p class="aa-stat__lbl">Publiées</p></div></div>
        <div class="aa-stat"><div class="aa-stat__icon"><i class="fas fa-clock"></i></div><div class="aa-stat__info"><h3 class="aa-stat__val">{{ $stats['attente'] }}</h3><p class="aa-stat__lbl">En attente</p></div></div>
        <div class="aa-stat"><div class="aa-stat__icon"><i class="fas fa-coins"></i></div><div class="aa-stat__info"><h3 class="aa-stat__val">{{ number_format($stats['budget'], 0, ',', ' ') }}</h3><p class="aa-stat__lbl">FCFA d'acomptes</p></div></div>
    </div>

    <form method="GET" action="{{ route('admin.annonces') }}" class="aa-search" id="aaSearchForm">
        <i class="fas fa-search"></i>
        <input type="text" name="q" value="{{ $q ?? '' }}" id="aaSearchInput" placeholder="Rechercher (matière, étudiant, description)…" autocomplete="off">
        <input type="hidden" name="status" value="{{ $status }}">
    </form>

    <div class="aa-tabs">
        @php $tabs = ['' => 'Toutes', 'publiée' => 'Publiées', 'en_attente' => 'En attente', 'attribuée' => 'Attribuées', 'refusée' => 'Refusées']; @endphp
        @foreach ($tabs as $k => $label)
            <a href="{{ route('admin.annonces', array_filter(['status' => $k ?: null, 'q' => $q ?? null])) }}" class="aa-tab {{ (string) $status === (string) $k ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    @if ($annonces->count() > 0)
        <div class="aa-table-wrap">
            <table class="aa-table">
                <thead>
                    <tr><th>Matière</th><th>Étudiant</th><th>Budget</th><th>Statut</th><th>Date</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach ($annonces as $annonce)
                        @php $fmt = $annonce->format === 'en_ligne' ? 'En ligne' : ($annonce->format === 'presentiel' ? 'Présentiel' : 'Hybride'); @endphp
                        <tr class="aa-row"
                            data-matiere="{{ $annonce->subject->nom ?? 'Matière' }}"
                            data-student="{{ trim(($annonce->student->firstname ?? '—') . ' ' . ($annonce->student->lastname ?? '')) }}"
                            data-budget="{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA"
                            data-acompte="{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA"
                            data-format="{{ $fmt }}"
                            data-dispo="{{ $annonce->disponibilite ?: '—' }}"
                            data-description="{{ $annonce->description }}"
                            data-status="{{ $annonce->status }}"
                            data-statusclass="status-{{ str_replace('é', 'e', $annonce->status) }}"
                            data-date="{{ $annonce->created_at->format('d/m/Y') }}"
                            data-delete="{{ route('admin.annonces.destroy', $annonce->id) }}"
                            onclick="openAaDrawer(this)">
                            <td>
                                <div class="aa-subject">
                                    <div class="aa-ico"><i class="fas fa-book"></i></div>
                                    {{ $annonce->subject->nom ?? 'Matière' }}
                                </div>
                            </td>
                            <td class="aa-sub">{{ $annonce->student->firstname ?? '—' }} {{ $annonce->student->lastname ?? '' }}</td>
                            <td class="aa-budget">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</td>
                            <td><span class="aa-status status-{{ str_replace('é', 'e', $annonce->status) }}">{{ $annonce->status }}</span></td>
                            <td class="aa-sub">{{ $annonce->created_at->format('d/m/Y') }}</td>
                            <td class="aa-cell-del" style="text-align: right;"><i class="fas fa-chevron-right aa-chevron"></i></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="aa-pagination">{{ $annonces->links() }}</div>
    @else
        <div class="aa-empty"><i class="fas fa-bullhorn" style="font-size: 50px; color: var(--kp-border); display: block; margin-bottom: 12px;"></i>Aucune annonce dans cette catégorie.</div>
    @endif

    {{-- Drawer détails annonce --}}
    <div class="aadrawer" id="aaDrawer">
        <div class="aadrawer__overlay" onclick="closeAaDrawer()"></div>
        <aside class="aadrawer__panel">
            <div class="aadrawer__head">
                <span class="aadrawer__badge" id="aad-matiere"></span>
                <span class="aa-status" id="aad-status"></span>
                <button type="button" class="aadrawer__close" onclick="closeAaDrawer()"><i class="fas fa-times"></i></button>
            </div>
            <div class="aadrawer__body">
                <div class="aad-student"><i class="fas fa-user-graduate"></i> <span id="aad-student"></span></div>
                <div class="aad-budget"><span class="lbl">Budget total</span><span class="amt" id="aad-budget"></span></div>
                <div class="aad-grid">
                    <div class="aad-item"><span class="lbl">Acompte</span><span class="val" id="aad-acompte"></span></div>
                    <div class="aad-item"><span class="lbl">Format</span><span class="val" id="aad-format"></span></div>
                    <div class="aad-item"><span class="lbl">Date</span><span class="val" id="aad-date"></span></div>
                    <div class="aad-item aad-item--full"><span class="lbl">Disponibilités</span><span class="val" id="aad-dispo"></span></div>
                </div>
                <div class="aad-desc"><span class="lbl">Description</span><p id="aad-description"></p></div>
            </div>
            <div class="aadrawer__foot">
                <form method="POST" id="aad-delete-form" action=""
                      onsubmit="return kpConfirmDelete(event, this, {title: 'Supprimer cette annonce ?', text: 'L\'annonce et ses candidatures seront supprimées définitivement.', confirmText: 'Oui, supprimer'});">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="aad-del-btn"><i class="fas fa-trash"></i> Supprimer l'annonce</button>
                </form>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        function openAaDrawer(row) {
            const d = row.dataset;
            document.getElementById('aad-matiere').textContent = d.matiere;
            const st = document.getElementById('aad-status');
            st.textContent = d.status;
            st.className = 'aa-status ' + d.statusclass;
            document.getElementById('aad-student').textContent = d.student;
            document.getElementById('aad-budget').textContent = d.budget;
            document.getElementById('aad-acompte').textContent = d.acompte;
            document.getElementById('aad-format').textContent = d.format;
            document.getElementById('aad-date').textContent = d.date;
            document.getElementById('aad-dispo').textContent = d.dispo || '—';
            document.getElementById('aad-description').textContent = d.description || 'Aucune description.';
            document.getElementById('aad-delete-form').action = d.delete;
            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
            const dr = document.getElementById('aaDrawer');
            dr.classList.add('open');
            const body = dr.querySelector('.aadrawer__body');
            if (body) body.scrollTop = 0;
        }
        function closeAaDrawer() {
            document.getElementById('aaDrawer').classList.remove('open');
            document.documentElement.style.overflow = '';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeAaDrawer(); });

        // Recherche auto à la frappe (débounce)
        (function () {
            const form = document.getElementById('aaSearchForm');
            const input = document.getElementById('aaSearchInput');
            if (form && input) {
                let timer;
                input.addEventListener('input', function () {
                    clearTimeout(timer);
                    timer = setTimeout(function () { form.submit(); }, 450);
                });
                if (input.value) {
                    input.focus();
                    const v = input.value;
                    input.setSelectionRange(v.length, v.length);
                }
            }
        })();
    </script>
@endpush
