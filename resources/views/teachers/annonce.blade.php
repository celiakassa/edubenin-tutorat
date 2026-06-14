@extends('layouts.dashboard')

@section('title', 'Kopiao - Annonces')
@section('page-title', 'Annonces disponibles')

@push('styles')
    <style>
        .tan-head { margin-bottom: 20px; }
        .tan-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .tan-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        /* ===== Tableau ===== */
        .tan-table-wrap { background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; overflow: hidden; }
        .tan-table { width: 100%; border-collapse: collapse; font-size: var(--kp-fs-base); }
        .tan-table thead th { text-align: left; padding: 12px 16px; font-size: var(--kp-fs-2xs); text-transform: uppercase; letter-spacing: .5px; color: var(--kp-muted); font-weight: 700; border-bottom: 1px solid var(--kp-border); background: var(--kp-surface); white-space: nowrap; }
        .tan-table tbody td { padding: 13px 16px; border-bottom: 1px solid var(--kp-border); color: var(--kp-ink); vertical-align: middle; }
        .tan-table tbody tr:last-child td { border-bottom: none; }
        .tan-row { cursor: pointer; transition: background .15s; }
        .tan-row:hover { background: var(--kp-surface); }
        .tan-row:hover .tan-arrow { color: var(--kp-blue); transform: translateX(2px); }

        .tan-subject { display: flex; align-items: center; gap: 12px; font-weight: 700; color: var(--kp-ink); }
        .tan-subject__ico { width: 40px; height: 40px; border-radius: 11px; background: var(--kp-blue-soft); color: var(--kp-blue); display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-base); flex-shrink: 0; }
        .tan-student { display: flex; align-items: center; gap: 9px; }
        .tan-mini-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--kp-blue); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-2xs); flex-shrink: 0; overflow: hidden; }
        .tan-mini-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .tan-col-budget { color: var(--kp-blue); font-weight: 700; white-space: nowrap; }
        .tan-fmt { display: inline-flex; align-items: center; gap: 5px; background: var(--kp-surface); color: var(--kp-ink); padding: 4px 11px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; white-space: nowrap; }
        .tan-date { color: var(--kp-muted); white-space: nowrap; }
        .tan-applied-tag { display: inline-flex; align-items: center; gap: 4px; color: #1d7a48; font-size: var(--kp-fs-2xs); font-weight: 700; }
        .tan-arrow { text-align: right; color: var(--kp-muted); transition: all .2s; }

        .tan-pagination { display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; padding: 16px 0; }
        .tan-pagination .info { font-size: var(--kp-fs-sm); color: var(--kp-muted); }

        .tan-empty { text-align: center; padding: 40px 20px; min-height: 55vh; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .tan-empty i { font-size: 64px; color: var(--kp-border); margin-bottom: 16px; display: block; }
        .tan-empty h3 { color: var(--kp-ink); font-size: var(--kp-fs-xl); margin: 0 0 8px; }
        .tan-empty p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        /* ===== Panneau détails (droite) ===== */
        .tadrawer { position: fixed; inset: 0; z-index: 3000; display: none; }
        .tadrawer.open { display: block; }
        .tadrawer__overlay { position: absolute; inset: 0; background: rgba(11, 18, 32, .45); opacity: 0; transition: opacity .25s; }
        .tadrawer.open .tadrawer__overlay { opacity: 1; }
        .tadrawer__panel { position: absolute; top: 0; right: 0; bottom: 0; width: 440px; max-width: 92vw; background: #fff; box-shadow: -12px 0 44px rgba(0, 0, 0, .22); transform: translateX(100%); transition: transform .3s ease; display: flex; flex-direction: column; }
        .tadrawer.open .tadrawer__panel { transform: translateX(0); }
        .tadrawer__head { display: flex; align-items: center; gap: 10px; padding: 18px 20px; border-bottom: 1px solid var(--kp-border); }
        .tadrawer__badge { background: var(--kp-blue); color: #fff; padding: 5px 14px; border-radius: 25px; font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; }
        .tadrawer__close { margin-left: auto; width: 34px; height: 34px; border-radius: 50%; border: none; background: var(--kp-surface); color: var(--kp-ink); cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .tadrawer__close:hover { background: var(--kp-blue); color: #fff; }
        .tadrawer__body { flex: 1; overflow-y: auto; padding: 20px; }

        .tad-student { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .tad-student__avatar { width: 48px; height: 48px; border-radius: 50%; background: var(--kp-blue); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; }
        .tad-student__name { font-weight: 700; color: var(--kp-ink); font-size: var(--kp-fs-base); }
        .tad-student__city { color: var(--kp-muted); font-size: var(--kp-fs-xs); }

        .tad-budget { background: var(--kp-yellow); border-radius: 14px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
        .tad-budget .lbl { font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; color: #1a1a1a; }
        .tad-budget .amt { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 800; color: #1a1a1a; white-space: nowrap; }

        .tad-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .tad-item { background: var(--kp-surface); border-radius: 11px; padding: 10px 13px; }
        .tad-item--full { grid-column: 1 / -1; }
        .tad-item .lbl { display: block; font-size: var(--kp-fs-2xs); color: var(--kp-muted); font-weight: 700; text-transform: uppercase; }
        .tad-item .val { display: block; font-size: var(--kp-fs-base); font-weight: 600; color: var(--kp-ink); margin-top: 2px; white-space: pre-line; }
        .tad-desc { margin-bottom: 8px; }
        .tad-desc .lbl { display: block; font-size: var(--kp-fs-2xs); color: var(--kp-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px; }
        .tad-desc p { color: var(--kp-text); font-size: var(--kp-fs-base); line-height: 1.6; margin: 0; }

        .tadrawer__foot { padding: 14px 20px; border-top: 1px solid var(--kp-border); display: flex; gap: 10px; flex-wrap: wrap; }
        .tan-btn { flex: 1; min-width: 0; display: inline-flex; align-items: center; justify-content: center; gap: 7px; height: 44px; border-radius: var(--kp-radius-pill); font-size: var(--kp-fs-sm); font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: all .2s; }
        .tan-btn--primary { background: var(--kp-blue); color: #fff; }
        .tan-btn--primary:hover { background: var(--kp-blue-darker); color: #fff; }
        .tan-btn--ghost { background: #fff; color: var(--kp-ink); border: 1.5px solid var(--kp-border); }
        .tan-btn--ghost:hover { background: var(--kp-blue); color: #fff; border-color: var(--kp-blue); }
        .tan-btn--done { background: var(--kp-surface); color: #1d7a48; cursor: default; }
        .tadrawer__foot form { flex: 1; display: flex; }
        .tadrawer__foot form .tan-btn { width: 100%; }

        /* ===== Mobile ===== */
        @media (max-width: 640px) {
            .tan-table-wrap { background: transparent; border: none; border-radius: 0; overflow: visible; }
            .tan-table thead { display: none; }
            .tan-table, .tan-table tbody, .tan-table tr, .tan-table td { display: block; }
            .tan-table tr.tan-row { position: relative; background: #fff; border: 1px solid var(--kp-border); border-radius: 14px; margin-bottom: 10px; padding: 14px 40px 14px 14px; }
            .tan-table tbody td { border: none !important; padding: 3px 0; }
            .tan-subject { font-size: var(--kp-fs-md); margin-bottom: 6px; }
            .tan-cell-student { margin-bottom: 6px; }
            .tan-cell-budget { display: inline-block; }
            .tan-cell-fmt { display: inline-block; margin-left: 12px; }
            .tan-cell-date { display: none; }
            .tan-arrow { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); }
        }
        @media (max-width: 575px) {
            .tadrawer__panel { top: auto; left: 0; right: 0; bottom: 0; width: 100%; max-width: 100%; max-height: 90vh; border-radius: 20px 20px 0 0; transform: translateY(100%); box-shadow: 0 -14px 40px rgba(0, 0, 0, .25); }
            .tadrawer.open .tadrawer__panel { transform: translateY(0); }
            .tadrawer__panel::before { content: ''; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); width: 42px; height: 4px; border-radius: 4px; background: #d5dae2; z-index: 2; }
            .tadrawer__foot { flex-direction: column; }
            .tadrawer__foot .tan-btn { width: 100%; }
        }
    </style>
@endpush

@section('content')
    <div class="tan-head">
        <h2>Trouvez votre prochaine mission</h2>
        <p>{{ $annonces->total() }} annonce(s) disponible(s) dans votre domaine.</p>
    </div>

    @if ($annonces->count() > 0)
        <div class="tan-table-wrap">
            <table class="tan-table">
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Étudiant</th>
                        <th>Budget</th>
                        <th>Format</th>
                        <th>Publié</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($annonces as $annonce)
                        @php
                            $hasApplied = \App\Models\Candidature::where('annonce_id', $annonce->id)->where('user_id', auth()->id())->exists();
                            $fmtLabel = $annonce->format === 'en_ligne' ? 'En ligne' : ($annonce->format === 'presentiel' ? 'Présentiel' : 'Hybride');
                            $fmtIcon = $annonce->format === 'en_ligne' ? 'fa-laptop' : ($annonce->format === 'presentiel' ? 'fa-user-friends' : 'fa-globe');
                            $datePub = $annonce->published_at ?? $annonce->created_at;
                            $initials = strtoupper(substr($annonce->student->firstname, 0, 1) . substr($annonce->student->lastname, 0, 1));
                        @endphp
                        <tr class="tan-row"
                            data-domaine="{{ ucfirst($annonce->domaine) }}"
                            data-fmtlabel="{{ $fmtLabel }}"
                            data-fmticon="{{ $fmtIcon }}"
                            data-studentname="{{ $annonce->student->firstname }} {{ $annonce->student->lastname }}"
                            data-studentcity="{{ $annonce->student->city ?? 'Non spécifié' }}"
                            data-initials="{{ $initials }}"
                            data-budget="{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA"
                            data-acompte="{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA"
                            data-dispo="{{ $annonce->disponibilite ?: '—' }}"
                            data-description="{{ $annonce->description }}"
                            data-date="{{ $datePub->format('d/m/Y') }}"
                            data-hasapplied="{{ $hasApplied ? '1' : '' }}"
                            data-postulerurl="{{ route('annonce.postuler', $annonce->id) }}"
                            data-showurl="{{ route('annonces.dashboard.detail', $annonce->hashid) }}"
                            onclick="openTanDrawer(this)">
                            <td>
                                <div class="tan-subject">
                                    <div class="tan-subject__ico"><i class="fas fa-book"></i></div>
                                    {{ ucfirst($annonce->domaine) }}
                                </div>
                            </td>
                            <td class="tan-cell-student">
                                <div class="tan-student">
                                    <div class="tan-mini-avatar">
                                        @if ($annonce->student->photo_path && Storage::disk('public')->exists($annonce->student->photo_path))
                                            <img src="{{ asset('storage/' . $annonce->student->photo_path) }}" alt="Profil">
                                        @else
                                            {{ $initials }}
                                        @endif
                                    </div>
                                    {{ $annonce->student->firstname }}
                                </div>
                            </td>
                            <td class="tan-cell-budget"><span class="tan-col-budget">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span></td>
                            <td class="tan-cell-fmt"><span class="tan-fmt"><i class="fas {{ $fmtIcon }}"></i> {{ $fmtLabel }}</span></td>
                            <td class="tan-cell-date tan-date">{{ $datePub->format('d/m/Y') }}</td>
                            <td class="tan-arrow">
                                @if ($hasApplied)<span class="tan-applied-tag"><i class="fas fa-check-circle"></i></span>@else<i class="fas fa-chevron-right"></i>@endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($annonces->hasPages())
            <div class="tan-pagination">
                <div class="info">Affichage de {{ $annonces->firstItem() }} à {{ $annonces->lastItem() }} sur {{ $annonces->total() }} annonces</div>
                <div>{{ $annonces->links() }}</div>
            </div>
        @endif
    @else
        <div class="tan-empty">
            <i class="fas fa-inbox"></i>
            <h3>Aucune annonce disponible</h3>
            <p>Il n'y a pas d'annonces dans votre domaine pour le moment. Revenez plus tard !</p>
        </div>
    @endif

    {{-- Panneau de détails --}}
    <div class="tadrawer" id="tanDrawer">
        <div class="tadrawer__overlay" onclick="closeTanDrawer()"></div>
        <aside class="tadrawer__panel">
            <div class="tadrawer__head">
                <span class="tadrawer__badge" id="tad-domaine"></span>
                <button type="button" class="tadrawer__close" onclick="closeTanDrawer()"><i class="fas fa-times"></i></button>
            </div>
            <div class="tadrawer__body">
                <div class="tad-student">
                    <div class="tad-student__avatar" id="tad-initials"></div>
                    <div>
                        <div class="tad-student__name" id="tad-studentname"></div>
                        <div class="tad-student__city"><i class="fas fa-map-marker-alt"></i> <span id="tad-studentcity"></span></div>
                    </div>
                </div>

                <div class="tad-budget">
                    <span class="lbl">Budget total</span>
                    <span class="amt" id="tad-budget"></span>
                </div>

                <div class="tad-grid">
                    <div class="tad-item"><span class="lbl">Acompte</span><span class="val" id="tad-acompte"></span></div>
                    <div class="tad-item"><span class="lbl">Format</span><span class="val" id="tad-format"></span></div>
                    <div class="tad-item"><span class="lbl">Publié le</span><span class="val" id="tad-date"></span></div>
                    <div class="tad-item tad-item--full"><span class="lbl">Disponibilités</span><span class="val" id="tad-dispo"></span></div>
                </div>

                <div class="tad-desc">
                    <span class="lbl">Description</span>
                    <p id="tad-description"></p>
                </div>
            </div>
            <div class="tadrawer__foot">
                <form method="POST" id="tan-postuler-form" action=""
                      onsubmit="return kpConfirmDelete(event, this, {icon: 'success', iconClass: 'fa-paper-plane', title: 'Postuler à cette annonce ?', text: 'Votre candidature sera envoyée à l\'apprenant.', confirmText: 'Oui, postuler', confirmColor: '#0B69F1'});">
                    @csrf
                    <button type="submit" class="tan-btn tan-btn--primary" id="tan-postuler-btn"><i class="fas fa-paper-plane"></i> Postuler</button>
                </form>
                <button type="button" class="tan-btn tan-btn--done" id="tan-applied-btn" style="display:none;" disabled><i class="fas fa-check-circle"></i> Déjà postulé</button>
                <a href="#" class="tan-btn tan-btn--ghost" id="tan-open-btn"><i class="fas fa-external-link-alt"></i> Page complète</a>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        function openTanDrawer(row) {
            const d = row.dataset;
            document.getElementById('tad-domaine').textContent = d.domaine;
            document.getElementById('tad-initials').textContent = d.initials;
            document.getElementById('tad-studentname').textContent = d.studentname;
            document.getElementById('tad-studentcity').textContent = d.studentcity;
            document.getElementById('tad-budget').textContent = d.budget;
            document.getElementById('tad-acompte').textContent = d.acompte;
            document.getElementById('tad-format').textContent = d.fmtlabel;
            document.getElementById('tad-date').textContent = d.date;
            document.getElementById('tad-dispo').textContent = d.dispo || '—';
            document.getElementById('tad-description').textContent = d.description || 'Aucune description.';
            document.getElementById('tan-open-btn').href = d.showurl;

            const form = document.getElementById('tan-postuler-form');
            const applied = document.getElementById('tan-applied-btn');
            if (d.hasapplied) {
                form.style.display = 'none';
                applied.style.display = '';
            } else {
                form.style.display = '';
                form.action = d.postulerurl;
                applied.style.display = 'none';
            }

            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
            const dr = document.getElementById('tanDrawer');
            dr.classList.add('open');
            const body = dr.querySelector('.tadrawer__body');
            if (body) body.scrollTop = 0;
        }
        function closeTanDrawer() {
            document.getElementById('tanDrawer').classList.remove('open');
            document.documentElement.style.overflow = '';
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeTanDrawer(); });
    </script>
@endpush
