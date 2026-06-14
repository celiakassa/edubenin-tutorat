@extends('layouts.dashboard')

@section('title', 'Mes Annonces - Kopiao')
@section('page-title', 'Mes annonces')

@push('styles')
    <style>
        :root {
            --primary-color: #0351BC;
            --dark-gray: #64748b;
            --medium-gray: #e2e8f0;
            --text-dark: #1e293b;
        }

        .an-header { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 18px; }
        .an-header__sub { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 2px 0 0; }
        .btn-create { background: var(--kp-blue); color: #fff; height: 46px; padding: 0 22px; border: none; border-radius: var(--kp-radius-pill); font-size: var(--kp-fs-base); font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.25s ease; text-decoration: none; white-space: nowrap; }
        .btn-create:hover { background: #1a1a1a; color: #fff; transform: translateY(-1px); }

        .alert-message { padding: 13px 16px; border-radius: 10px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; font-weight: 500; font-size: var(--kp-fs-base); }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; transition: border-color .2s, transform .2s; }
        .stat-card:hover { border-color: var(--kp-blue); transform: translateY(-1px); }
        .stat-icon { width: 44px; height: 44px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-md); color: #fff; flex-shrink: 0; }
        .stat-icon.total { background: var(--kp-blue); color: #fff; }
        .stat-icon.published { background: var(--kp-yellow); color: #1a1a1a; }
        .stat-icon.budget { background: #1a1a1a; color: #fff; }
        .stat-info { display: flex; align-items: baseline; gap: 7px; white-space: nowrap; min-width: 0; }
        .stat-info h3 { font-size: var(--kp-fs-xl); font-weight: 700; color: var(--text-dark); margin: 0; }
        .stat-info p { font-size: var(--kp-fs-xs); color: var(--dark-gray); margin: 0; }

        /* Barre d'outils */
        .an-toolbar { display: flex; gap: 12px; flex-wrap: wrap; align-items: stretch; margin-bottom: 14px; }
        .search-box { position: relative; flex: 1; min-width: 150px; }
        .search-box input { width: 100%; height: 46px; padding: 0 16px 0 44px; border: 1.5px solid var(--kp-border); border-radius: 12px; font-size: var(--kp-fs-base); background: #fff; }
        .search-box input:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }
        .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--dark-gray); font-size: var(--kp-fs-base); }
        .filter-box { position: relative; flex-shrink: 0; }
        .filter-box select { height: 46px; padding: 0 36px 0 38px; border: 1.5px solid var(--kp-border); border-radius: 12px; font-size: var(--kp-fs-base); background: #fff; color: var(--text-dark); cursor: pointer; appearance: none; min-width: 160px; }
        .filter-box select:focus { outline: none; border-color: var(--kp-blue); }
        .filter-box > i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--dark-gray); font-size: var(--kp-fs-sm); }
        .filter-box::after { content: '⌄'; position: absolute; right: 14px; top: 42%; transform: translateY(-50%); color: var(--dark-gray); }
        .btn-bulk-del { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 46px; padding: 0 22px; border: none; border-radius: var(--kp-radius-pill); background: #e02c18; color: #fff; font-weight: 600; font-size: var(--kp-fs-base); cursor: pointer; flex-shrink: 0; transition: all .2s; }
        .btn-bulk-del:not(:disabled):hover { background: #c62411; }
        .btn-bulk-del:disabled { background: var(--kp-border); color: var(--kp-muted); cursor: not-allowed; }

        /* Tableau */
        .an-table-wrap { background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; overflow: hidden; }
        .an-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .an-table thead th { text-align: left; padding: 12px 16px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: var(--kp-surface); white-space: nowrap; }
        .an-table tbody td { padding: 13px 16px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); vertical-align: middle; }
        .an-table tbody tr:last-child td { border-bottom: none; }
        .an-row { cursor: pointer; transition: background .15s; }
        .an-row:hover { background: var(--kp-surface); }
        .an-row.is-selected { background: var(--kp-blue-soft); }
        .col-check { width: 46px; text-align: center; }
        .col-check input { width: 16px; height: 16px; accent-color: var(--kp-blue); cursor: pointer; }
        .col-subject { font-weight: 600; }
        .col-budget { font-weight: 700; color: var(--kp-blue); white-space: nowrap; }
        .col-date { color: var(--kp-muted); white-space: nowrap; }
        .col-arrow { width: 40px; text-align: center; color: var(--kp-muted); }
        .annonce-status { padding: 4px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 600; display: inline-block; white-space: nowrap; }
        .status-en_attente { background: #fef3c7; color: #92400e; }
        .status-en_paiement { background: #dbeafe; color: #1e40af; }
        .status-publiee { background: #d1fae5; color: #065f46; }
        .status-attribuee { background: #ede9fe; color: #5b21b6; }
        .status-refusee { background: #fee2e2; color: #991b1b; }
        .an-empty-row td { text-align: center; padding: 40px; color: var(--kp-muted); }

        /* État vide */
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-icon { font-size: 60px; color: var(--medium-gray); margin-bottom: 18px; }
        .empty-state h3 { color: var(--text-dark); font-size: var(--kp-fs-xl); margin-bottom: 8px; }
        .empty-state p { color: var(--dark-gray); max-width: 460px; margin: 0 auto 22px; }

        /* ===== Panneau latéral (drawer droite) ===== */
        .adrawer { position: fixed; inset: 0; z-index: 3000; display: none; }
        .adrawer.open { display: block; }
        .adrawer__overlay { position: absolute; inset: 0; background: rgba(11, 18, 32, .45); opacity: 0; transition: opacity .25s; }
        .adrawer.open .adrawer__overlay { opacity: 1; }
        .adrawer__panel { position: absolute; top: 0; right: 0; bottom: 0; width: 440px; max-width: 92vw; background: #fff; box-shadow: -12px 0 44px rgba(0, 0, 0, .22); transform: translateX(100%); transition: transform .3s ease; display: flex; flex-direction: column; }
        .adrawer.open .adrawer__panel { transform: translateX(0); }
        .adrawer__head { display: flex; align-items: center; gap: 12px; padding: 18px 20px; border-bottom: 1px solid var(--kp-border); }
        .adrawer__badge { background: #0B69F1; color: #fff; padding: 5px 14px; border-radius: 25px; font-size: var(--kp-fs-2xs); font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }
        .adrawer__close { margin-left: auto; width: 34px; height: 34px; border-radius: 50%; border: none; background: var(--kp-surface); color: var(--kp-ink); cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .adrawer__close:hover { background: var(--kp-blue); color: #fff; }
        .adrawer__body { flex: 1; overflow-y: auto; padding: 20px; }
        .ad-meta { display: flex; gap: 16px; color: var(--kp-muted); font-size: var(--kp-fs-sm); margin-bottom: 14px; flex-wrap: wrap; }
        .ad-meta i { margin-right: 4px; color: var(--kp-blue); }
        .ad-budget { background: var(--kp-yellow); border-radius: 13px; padding: 13px 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
        .ad-budget .lbl { color: #1a1a1a; font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; }
        .ad-budget .amt { color: #1a1a1a; font-size: var(--kp-fs-xl); font-weight: 800; }
        .ad-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .ad-item { background: #f6f8fb; border-radius: 11px; padding: 10px 13px; display: flex; flex-direction: column; gap: 2px; }
        .ad-item--full { grid-column: 1 / -1; }
        .ad-item .lbl { font-size: var(--kp-fs-2xs); color: #8a93a3; font-weight: 700; text-transform: uppercase; }
        .ad-item .val { font-size: var(--kp-fs-base); font-weight: 600; color: #1a1a1a; }
        .ad-desc .lbl { font-size: var(--kp-fs-2xs); color: #8a93a3; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 6px; }
        .ad-desc p { color: #475569; font-size: var(--kp-fs-base); line-height: 1.6; margin: 0; }
        .adrawer__foot { padding: 14px 20px; border-top: 1px solid var(--kp-border); display: flex; gap: 10px; flex-wrap: wrap; }
        .adrawer__foot .kp-btn { flex: 1; justify-content: center; }

        @media (max-width: 640px) {
            /* En-tête : bouton pleine largeur */
            .an-header { flex-direction: column; align-items: stretch; }
            .btn-create { width: 100%; justify-content: center; }

            /* Barre d'outils empilée */
            .an-toolbar { flex-direction: column; }
            .search-box, .filter-box, .filter-box select, .btn-bulk-del { width: 100%; }
            .filter-box select { min-width: 0; }

            /* Tableau → cartes côte à côte (2 colonnes) */
            .an-table-wrap { background: transparent; border: none; border-radius: 0; overflow: visible; }
            .an-table thead { display: none; }
            .an-table, .an-table tr, .an-table td { display: block; width: 100%; }
            .an-table tbody { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .an-table tr.an-row { position: relative; background: #fff; border: 1px solid var(--kp-border); border-radius: 12px; margin: 0; padding: 13px 14px; }
            .an-table tr.an-row.is-selected { background: var(--kp-blue-soft); border-color: var(--kp-blue); }
            .an-table tbody td { border: none !important; padding: 0; }
            .an-table .col-check { position: absolute; top: 10px; right: 10px; left: auto; width: auto; padding: 0; }
            .an-table .col-subject { font-weight: 700; font-size: var(--kp-fs-base); color: var(--kp-ink); padding-right: 22px; margin-bottom: 8px; line-height: 1.3; }
            .an-table td:nth-child(3) { margin-bottom: 8px; }
            .an-table .col-budget { display: block; color: var(--kp-blue); font-weight: 700; margin-bottom: 2px; }
            .an-table .col-date { display: block; color: var(--kp-muted); font-size: var(--kp-fs-2xs); }
            .an-table .col-arrow { display: none; }
            .an-empty-row { grid-column: 1 / -1; }
            .an-empty-row td { padding: 30px 10px !important; text-align: center; }
        }

        /* Mobile : le panneau de détails monte du bas (bottom sheet) */
        @media (max-width: 575px) {
            .adrawer__panel { top: auto; left: 0; right: 0; bottom: 0; width: 100%; max-width: 100%; max-height: 90vh; border-radius: 20px 20px 0 0; transform: translateY(100%); box-shadow: 0 -14px 40px rgba(0, 0, 0, .25); }
            .adrawer.open .adrawer__panel { transform: translateY(0); }
            .adrawer__panel::before { content: ''; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); width: 42px; height: 4px; border-radius: 4px; background: #d5dae2; z-index: 2; }
            .adrawer__foot { flex-direction: column; }
            .adrawer__foot .kp-btn { width: 100%; }
        }
    </style>
@endpush

@section('content')
    <div class="an-header">
        <div>
            <p class="an-header__sub">Gérez et suivez toutes vos annonces.</p>
        </div>
        <a href="{{ route('annonces.create') }}" class="btn-create"
           onclick="if(window.openCreateAnnonceModal && document.getElementById('createAnnonceModal')){if(window.kpAnnonceFormToCreate)window.kpAnnonceFormToCreate();openCreateAnnonceModal();return false;}">
            <i class="fas fa-plus"></i> Nouvelle annonce
        </a>
    </div>

    @if ($annonces->count() > 0)
        {{-- Stats --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total"><i class="fas fa-list"></i></div>
                <div class="stat-info"><h3>{{ $annonces->count() }}</h3><p>Total annonces</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon published"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info"><h3>{{ $annonces->where('status', 'publiée')->count() }}</h3><p>Publiées</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon budget"><i class="fas fa-money-bill-wave"></i></div>
                <div class="stat-info"><h3>{{ number_format($annonces->sum('budget'), 0, ',', ' ') }} F</h3><p>Budget total</p></div>
            </div>
        </div>

        <form id="bulkForm" action="{{ route('annonces.bulkDestroy') }}" method="POST"
              onsubmit="return kpConfirmDelete(event, this, {title: 'Supprimer la sélection', text: 'Les annonces sélectionnées seront supprimées définitivement.'});">
            @csrf

            {{-- Barre d'outils --}}
            <div class="an-toolbar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher une annonce...">
                </div>
                <div class="filter-box">
                    <i class="fas fa-filter"></i>
                    <select id="statusFilter">
                        <option value="">Tous les statuts</option>
                        <option value="publiée">Publiées</option>
                        <option value="en_attente">En attente</option>
                        <option value="en_paiement">En paiement</option>
                        <option value="attribuée">Attribuées</option>
                        <option value="refusée">Refusées</option>
                    </select>
                </div>
                <button type="submit" class="btn-bulk-del" id="bulkDeleteBtn" disabled>
                    <i class="fas fa-trash"></i> Supprimer (<span id="selCount">0</span>)
                </button>
            </div>

            {{-- Tableau --}}
            <div class="an-table-wrap">
                <table class="an-table">
                    <thead>
                        <tr>
                            <th class="col-check"><input type="checkbox" id="selectAll" title="Tout sélectionner"></th>
                            <th>Matière</th>
                            <th>Statut</th>
                            <th>Budget</th>
                            <th>Date</th>
                            <th class="col-arrow"></th>
                        </tr>
                    </thead>
                    <tbody id="annoncesBody">
                        @foreach ($annonces as $annonce)
                            <tr class="an-row"
                                data-search="{{ strtolower(($annonce->subject->nom ?? '') . ' ' . $annonce->description) }}"
                                data-id="{{ $annonce->id }}"
                                data-note="{{ $annonce->budget ? round(($annonce->acompte / $annonce->budget) * 100) . '% du budget total' : '' }}"
                                data-status="{{ $annonce->status }}"
                                data-matiere="{{ $annonce->subject->nom ?? 'Matière non spécifiée' }}"
                                data-statuslabel="{{ $annonce->status }}"
                                data-budget="{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA"
                                data-acompte="{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA"
                                data-format="{{ $annonce->format }}"
                                data-dispo="{{ $annonce->disponibilite }}"
                                data-description="{{ $annonce->description }}"
                                data-date="{{ $annonce->created_at->format('d/m/Y') }}"
                                data-paid="{{ $annonce->is_paid ? 'Payée' : 'Non payée' }}"
                                data-published="{{ $annonce->published_at ? \Carbon\Carbon::parse($annonce->published_at)->format('d/m/Y') : '—' }}"
                                data-candidatures="{{ $annonce->candidatures()->count() }}"
                                data-editable="{{ $annonce->status == 'en_attente' ? '1' : '' }}"
                                data-subjectid="{{ $annonce->subject_id }}"
                                data-budgetraw="{{ $annonce->budget }}"
                                data-updateurl="{{ route('annonces.update', $annonce->id) }}"
                                data-showurl="{{ route('annonces.show', $annonce->id) }}"
                                data-payurl="{{ !$annonce->is_paid && $annonce->status == 'en_attente' ? '1' : '' }}"
                                onclick="openDrawer(this)">
                                <td class="col-check" onclick="event.stopPropagation();">
                                    <input type="checkbox" name="ids[]" value="{{ $annonce->id }}" class="rowCheck" onchange="updateSelection()">
                                </td>
                                <td class="col-subject">{{ $annonce->subject->nom ?? 'Matière non spécifiée' }}</td>
                                <td><span class="annonce-status status-{{ str_replace('é', 'e', $annonce->status) }}">{{ $annonce->status }}</span></td>
                                <td class="col-budget">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</td>
                                <td class="col-date">{{ $annonce->created_at->format('d/m/Y') }}</td>
                                <td class="col-arrow"><i class="fas fa-chevron-right"></i></td>
                            </tr>
                        @endforeach
                        <tr class="an-empty-row" id="noResultsRow" style="display:none;">
                            <td colspan="6">Aucune annonce ne correspond à votre recherche.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-bullhorn"></i></div>
            <h3>Aucune annonce créée</h3>
            <p>Commencez par publier votre première annonce pour trouver le tuteur idéal.</p>
            <a href="{{ route('annonces.create') }}" class="btn-create"
               onclick="if(window.openCreateAnnonceModal && document.getElementById('createAnnonceModal')){if(window.kpAnnonceFormToCreate)window.kpAnnonceFormToCreate();openCreateAnnonceModal();return false;}">
                <i class="fas fa-plus"></i> Créer ma première annonce
            </a>
        </div>
    @endif

    {{-- Panneau de détails (glisse depuis la droite) --}}
    <div class="adrawer" id="annonceDrawer">
        <div class="adrawer__overlay" onclick="closeDrawer()"></div>
        <aside class="adrawer__panel">
            <div class="adrawer__head">
                <span class="adrawer__badge" id="ad-matiere"></span>
                <span class="annonce-status" id="ad-status"></span>
                <button type="button" class="adrawer__close" onclick="closeDrawer()"><i class="fas fa-times"></i></button>
            </div>
            <div class="adrawer__body">
                <div class="ad-meta">
                    <span><i class="far fa-calendar"></i><span id="ad-date"></span></span>
                    <span><i class="fas fa-users"></i><span id="ad-candidatures"></span> candidature(s)</span>
                </div>
                <div class="ad-budget">
                    <span class="lbl">Budget total</span>
                    <span class="amt" id="ad-budget"></span>
                </div>
                <div class="ad-grid">
                    <div class="ad-item"><span class="lbl">Acompte</span><span class="val" id="ad-acompte"></span></div>
                    <div class="ad-item"><span class="lbl">Format</span><span class="val" id="ad-format"></span></div>
                    <div class="ad-item"><span class="lbl">Paiement</span><span class="val" id="ad-paid"></span></div>
                    <div class="ad-item"><span class="lbl">Publiée le</span><span class="val" id="ad-published"></span></div>
                    <div class="ad-item ad-item--full"><span class="lbl">Disponibilités</span><span class="val" id="ad-dispo"></span></div>
                </div>
                <div class="ad-desc">
                    <span class="lbl">Description</span>
                    <p id="ad-description"></p>
                </div>
            </div>
            <div class="adrawer__foot" id="ad-foot">
                <a href="#" id="ad-open" class="kp-btn kp-btn--primary" style="flex: 1 1 100%;"><i class="fas fa-external-link-alt"></i> Ouvrir la page complète</a>
                <button type="button" id="ad-edit" class="kp-btn kp-btn--secondary" style="display:none;" onclick="editCurrentAnnonce()"><i class="fas fa-edit"></i> Modifier</button>
                <button type="button" id="ad-pay" class="kp-btn kp-btn--secondary" style="display:none;" onclick="payCurrentAnnonce()"><i class="fas fa-credit-card"></i> Payer l'acompte</button>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        // ===== Sélection (cases à cocher) =====
        const selectAll = document.getElementById('selectAll');
        const bulkBtn = document.getElementById('bulkDeleteBtn');
        function rowChecks() { return Array.from(document.querySelectorAll('.rowCheck')); }
        function updateSelection() {
            const checks = rowChecks().filter(c => c.closest('tr').style.display !== 'none');
            const selected = rowChecks().filter(c => c.checked);
            document.getElementById('selCount').textContent = selected.length;
            bulkBtn.disabled = selected.length === 0;
            rowChecks().forEach(c => c.closest('tr').classList.toggle('is-selected', c.checked));
            if (selectAll) selectAll.checked = checks.length > 0 && checks.every(c => c.checked);
        }
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                rowChecks().forEach(c => { if (c.closest('tr').style.display !== 'none') c.checked = this.checked; });
                updateSelection();
            });
        }

        // ===== Recherche + filtre =====
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        function filterRows() {
            const v = (searchInput ? searchInput.value : '').toLowerCase();
            const s = statusFilter ? statusFilter.value : '';
            let visible = 0;
            document.querySelectorAll('.an-row').forEach(row => {
                const ok = row.getAttribute('data-search').includes(v) && (!s || row.getAttribute('data-status') === s);
                row.style.display = ok ? '' : 'none';
                if (ok) visible++;
            });
            document.getElementById('noResultsRow').style.display = visible === 0 ? '' : 'none';
            updateSelection();
        }
        if (searchInput) searchInput.addEventListener('keyup', filterRows);
        if (statusFilter) statusFilter.addEventListener('change', filterRows);

        // ===== Panneau de détails =====
        let currentDrawerData = null;
        function openDrawer(row) {
            const d = row.dataset;
            currentDrawerData = d;
            const fmt = d.format === 'presentiel' ? 'Présentiel' : (d.format === 'en_ligne' ? 'En ligne' : 'Hybride');
            document.getElementById('ad-matiere').textContent = d.matiere;
            const st = document.getElementById('ad-status');
            st.textContent = d.statuslabel;
            st.className = 'annonce-status status-' + d.statuslabel.replace('é', 'e');
            document.getElementById('ad-date').textContent = ' ' + d.date;
            document.getElementById('ad-candidatures').textContent = ' ' + d.candidatures + ' ';
            document.getElementById('ad-budget').textContent = d.budget;
            document.getElementById('ad-acompte').textContent = d.acompte;
            document.getElementById('ad-format').textContent = fmt;
            document.getElementById('ad-paid').textContent = d.paid;
            document.getElementById('ad-published').textContent = d.published;
            document.getElementById('ad-dispo').textContent = d.dispo || '—';
            document.getElementById('ad-description').textContent = d.description || 'Aucune description.';

            document.getElementById('ad-open').href = d.showurl;
            const edit = document.getElementById('ad-edit');
            const pay = document.getElementById('ad-pay');
            edit.style.display = d.editable ? '' : 'none';
            pay.style.display = d.payurl ? '' : 'none';

            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
            const dr = document.getElementById('annonceDrawer');
            dr.classList.add('open');
            const body = dr.querySelector('.adrawer__body');
            if (body) body.scrollTop = 0;
        }
        function closeDrawer() {
            document.getElementById('annonceDrawer').classList.remove('open');
            document.documentElement.style.overflow = '';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });

        // Payer → ouvre le drawer de paiement à droite
        function payCurrentAnnonce() {
            const d = currentDrawerData;
            if (!d || !window.openPaymentDrawer) return;
            const fmt = d.format === 'presentiel' ? 'Présentiel' : (d.format === 'en_ligne' ? 'En ligne' : 'Hybride');
            closeDrawer();
            window.openPaymentDrawer({
                annonceId: d.id,
                matiere: d.matiere,
                format: d.format,
                disponibilite: d.dispo,
                budget: d.budget,
                acompte: d.acompte,
                note: d.note
            });
        }

        // Modifier → rouvre le modal de création pré-rempli (mode édition)
        function editCurrentAnnonce() {
            const d = currentDrawerData;
            if (!d || !d.editable || !window.kpAnnonceFormToEdit || !window.openCreateAnnonceModal) return;
            window.kpAnnonceFormToEdit({
                action: d.updateurl,
                subjectId: d.subjectid,
                subjectNom: d.matiere,
                description: d.description,
                format: d.format,
                disponibilite: d.dispo,
                budget: d.budgetraw
            });
            closeDrawer();
            openCreateAnnonceModal();
        }
    </script>
@endpush
