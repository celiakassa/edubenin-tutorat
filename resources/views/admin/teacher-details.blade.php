@extends('layouts.dashboard')

@section('title', 'Détails du tuteur - Kopiao')
@section('page-title', 'Détails du tuteur')

@push('styles')
    <style>
        .td-page { max-width: 900px; margin: 0 auto; }
        .td-back { display: inline-flex; align-items: center; gap: 8px; color: var(--kp-muted); text-decoration: none; font-weight: 600; font-size: var(--kp-fs-base); margin-bottom: 18px; transition: color .2s; }
        .td-back:hover { color: var(--kp-blue); }

        .td-hero { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 6px; }
        .td-hero__avatar { width: 72px; height: 72px; border-radius: 50%; background: var(--kp-blue); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-xl); overflow: hidden; flex-shrink: 0; }
        .td-hero__avatar img { width: 100%; height: 100%; object-fit: cover; }
        .td-hero__name { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 700; color: var(--kp-ink); margin: 0; }
        .td-hero__mail { color: var(--kp-muted); font-size: var(--kp-fs-sm); margin: 2px 0 8px; }
        .td-badges { display: flex; gap: 8px; flex-wrap: wrap; }
        .td-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; }
        .td-badge--ok { background: #d1fae5; color: #065f46; }
        .td-badge--wait { background: #fef3c7; color: #92400e; }
        .td-badge--off { background: #fee2e2; color: #991b1b; }

        .td-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; margin-top: 22px; }
        @media (max-width: 820px) { .td-grid { grid-template-columns: 1fr; } }

        .td-card { background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; padding: 20px 22px; box-shadow: var(--kp-shadow); margin-bottom: 18px; }
        .td-card__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-lg); font-weight: 700; color: var(--kp-ink); margin: 0 0 14px; display: flex; align-items: center; gap: 9px; }
        .td-card__title i { color: var(--kp-blue); }
        .td-row { display: flex; justify-content: space-between; gap: 14px; padding: 9px 0; border-bottom: 1px dashed var(--kp-border); font-size: var(--kp-fs-base); }
        .td-row:last-child { border-bottom: none; }
        .td-row .lbl { color: var(--kp-muted); flex-shrink: 0; }
        .td-row .val { color: var(--kp-ink); font-weight: 600; text-align: right; }
        .td-row .val.empty { color: var(--kp-muted); font-weight: 400; font-style: italic; }
        .td-tags { display: flex; flex-wrap: wrap; gap: 7px; }
        .td-tag { background: var(--kp-blue-soft); color: var(--kp-blue); padding: 5px 13px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; }
        .td-bio { color: var(--kp-text); font-size: var(--kp-fs-base); line-height: 1.65; margin: 0; }
        .td-bio.empty { color: var(--kp-muted); font-style: italic; }

        .td-doc { display: flex; align-items: center; gap: 12px; padding: 13px; background: var(--kp-surface); border-radius: 12px; margin-bottom: 12px; }
        .td-doc__ico { width: 40px; height: 40px; border-radius: 10px; background: var(--kp-blue); color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .td-doc__txt { font-size: var(--kp-fs-sm); font-weight: 600; color: var(--kp-ink); }
        .td-doc__txt small { display: block; color: var(--kp-muted); font-weight: 400; font-size: var(--kp-fs-2xs); }
        .td-actions { display: flex; flex-direction: column; gap: 10px; }
        .td-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; height: 44px; border-radius: var(--kp-radius-pill); font-size: var(--kp-fs-sm); font-weight: 600; text-decoration: none; cursor: pointer; border: none; transition: all .2s; }
        .td-btn--approve { background: #16a34a; color: #fff; }
        .td-btn--approve:hover { background: #128a3e; color: #fff; }
        .td-btn--reject { background: #dc2626; color: #fff; }
        .td-btn--reject:hover { background: #b91c1c; color: #fff; }
        .td-btn--blue { background: var(--kp-blue); color: #fff; }
        .td-btn--blue:hover { background: var(--kp-blue-darker); color: #fff; }
        .td-btn--ghost { background: #fff; color: var(--kp-ink); border: 1.5px solid var(--kp-border); }
        .td-btn--ghost:hover { background: var(--kp-blue); color: #fff; border-color: var(--kp-blue); }

        /* Modal d'action */
        .adm-modal { display: none; position: fixed; inset: 0; background: rgba(11, 18, 32, .5); z-index: 3600; align-items: center; justify-content: center; padding: 20px; }
        .adm-modal.active { display: flex; }
        .adm-modal__box { background: #fff; border-radius: 18px; padding: 28px; max-width: 440px; width: 100%; position: relative; box-shadow: 0 24px 60px rgba(0, 0, 0, .25); }
        .adm-modal__icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-2xl); margin: 0 auto 14px; background: var(--kp-surface); color: var(--kp-muted); }
        .adm-modal__icon.green { background: #d1fae5; color: #16a34a; }
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
    </style>
@endpush

@section('content')
    <div class="td-page">
        <a href="{{ url()->previous() }}" class="td-back"><i class="fas fa-arrow-left"></i> Retour</a>

        {{-- Hero --}}
        <div class="td-hero">
            <div class="td-hero__avatar">
                @if ($teacher->photo_path && Storage::disk('public')->exists($teacher->photo_path))
                    <img src="{{ asset('storage/' . $teacher->photo_path) }}" alt="Profil">
                @else
                    {{ strtoupper(substr($teacher->firstname, 0, 1) . substr($teacher->lastname, 0, 1)) }}
                @endif
            </div>
            <div>
                <h1 class="td-hero__name">{{ $teacher->firstname }} {{ $teacher->lastname }}</h1>
                <p class="td-hero__mail">{{ $teacher->email }}</p>
                <div class="td-badges">
                    @if ($teacher->identity_verified)
                        <span class="td-badge td-badge--ok"><i class="fas fa-check-circle"></i> Vérifié</span>
                    @elseif ($teacher->identity_rejected)
                        <span class="td-badge td-badge--off"><i class="fas fa-times-circle"></i> Rejeté</span>
                    @else
                        <span class="td-badge td-badge--wait"><i class="fas fa-clock"></i> En attente</span>
                    @endif
                    @if ($teacher->is_active)
                        <span class="td-badge td-badge--ok"><i class="fas fa-user-check"></i> Actif</span>
                    @else
                        <span class="td-badge td-badge--off"><i class="fas fa-user-slash"></i> Désactivé</span>
                    @endif
                    <span class="td-badge" style="background: var(--kp-blue-soft); color: var(--kp-blue);"><i class="fas fa-chart-pie"></i> Profil {{ $profileCompletion }}%</span>
                </div>
            </div>
        </div>

        <div class="td-grid">
            {{-- Colonne principale --}}
            <div>
                <div class="td-card">
                    <h3 class="td-card__title"><i class="fas fa-user"></i> Informations personnelles</h3>
                    <div class="td-row"><span class="lbl">Email</span><span class="val">{{ $teacher->email }}</span></div>
                    <div class="td-row"><span class="lbl">Téléphone</span><span class="val {{ empty($teacher->telephone) ? 'empty' : '' }}">{{ $teacher->telephone ?? 'Non renseigné' }}</span></div>
                    <div class="td-row"><span class="lbl">Ville</span><span class="val {{ empty($teacher->city) ? 'empty' : '' }}">{{ $teacher->city ?? 'Non renseignée' }}</span></div>
                    <div class="td-row"><span class="lbl">Inscrit le</span><span class="val">{{ $teacher->created_at->format('d/m/Y à H:i') }}</span></div>
                </div>

                <div class="td-card">
                    <h3 class="td-card__title"><i class="fas fa-briefcase"></i> Informations professionnelles</h3>
                    <div class="td-row"><span class="lbl">Tarif horaire</span><span class="val {{ empty($teacher->rate_per_hour) ? 'empty' : '' }}">{{ $teacher->rate_per_hour ? number_format($teacher->rate_per_hour, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}</span></div>
                    <div class="td-row"><span class="lbl">Préférence</span><span class="val {{ empty($teacher->learning_preference) ? 'empty' : '' }}">{{ $teacher->learning_preference == 'online' ? 'En ligne' : ($teacher->learning_preference == 'in_person' ? 'Présentiel' : ($teacher->learning_preference == 'hybrid' ? 'Hybride' : 'Non renseignée')) }}</span></div>
                    <div class="td-row"><span class="lbl">Qualifications</span><span class="val {{ empty($teacher->qualifications) ? 'empty' : '' }}">{{ $teacher->qualifications ?? 'Non renseignées' }}</span></div>
                    @if ($teacher->subjects && $teacher->subjects->count() > 0)
                        <div style="padding-top: 12px;">
                            <span class="lbl" style="color: var(--kp-muted); font-size: var(--kp-fs-sm); display: block; margin-bottom: 8px;">Matières enseignées</span>
                            <div class="td-tags">
                                @foreach ($teacher->subjects as $subject)
                                    <span class="td-tag">{{ $subject->nom ?? $subject->name ?? '' }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="td-card">
                    <h3 class="td-card__title"><i class="fas fa-align-left"></i> Biographie</h3>
                    <p class="td-bio {{ empty($teacher->bio) ? 'empty' : '' }}">{{ $teacher->bio ?? 'Aucune biographie renseignée.' }}</p>
                </div>
            </div>

            {{-- Colonne latérale --}}
            <div>
                <div class="td-card">
                    <h3 class="td-card__title"><i class="fas fa-id-card"></i> Pièce d'identité</h3>
                    @if ($teacher->identity_document_path)
                        <div class="td-doc">
                            <div class="td-doc__ico"><i class="fas fa-file-alt"></i></div>
                            <div class="td-doc__txt">Document fourni<small>{{ $teacher->identity_verified ? 'Vérifiée' : 'En attente de validation' }}</small></div>
                        </div>
                        <a href="{{ route('admin.viewIdentityDocument', $teacher->id) }}" target="_blank" class="td-btn td-btn--ghost"><i class="fas fa-eye"></i> Voir le document</a>
                    @else
                        <p class="td-bio empty">Aucune pièce d'identité fournie.</p>
                    @endif
                </div>

                <div class="td-card">
                    <h3 class="td-card__title"><i class="fas fa-cog"></i> Actions</h3>
                    <div class="td-actions">
                        @if (! $teacher->identity_verified && $teacher->identity_document_path)
                            <button type="button" class="td-btn td-btn--approve"
                                onclick="admAction({action: '{{ route('admin.teachers.approve', $teacher->id) }}', title: 'Approuver ce tuteur ?', message: 'Le compte sera vérifié et activé.', reasonName: 'approval_reason', required: false, confirmText: 'Approuver', confirmColor: '#16a34a', icon: 'fa-check-circle', iconType: 'green'})">
                                <i class="fas fa-check"></i> Approuver
                            </button>
                            @if (! $teacher->identity_rejected)
                                <button type="button" class="td-btn td-btn--reject"
                                    onclick="admAction({action: '{{ route('admin.teachers.reject', $teacher->id) }}', title: 'Rejeter ce tuteur ?', message: 'Indiquez le motif du rejet (obligatoire).', reasonName: 'rejection_reason', required: true, confirmText: 'Rejeter', confirmColor: '#dc2626', icon: 'fa-times-circle', iconType: 'red'})">
                                    <i class="fas fa-times"></i> Rejeter
                                </button>
                            @endif
                        @endif

                        @if ($teacher->is_active)
                            <button type="button" class="td-btn td-btn--reject"
                                onclick="admAction({action: '{{ route('admin.teachers.deactivate', $teacher->id) }}', title: 'Désactiver ce compte ?', message: 'Indiquez le motif de la désactivation (obligatoire).', reasonName: 'deactivation_reason', required: true, confirmText: 'Désactiver', confirmColor: '#dc2626', icon: 'fa-user-slash', iconType: 'red'})">
                                <i class="fas fa-user-slash"></i> Désactiver le compte
                            </button>
                        @else
                            <button type="button" class="td-btn td-btn--blue"
                                onclick="admAction({action: '{{ route('admin.teachers.reactivate', $teacher->id) }}', title: 'Réactiver ce compte ?', message: 'Le tuteur pourra de nouveau accéder à la plateforme.', reasonName: 'reactivation_reason', required: false, confirmText: 'Réactiver', confirmColor: '#0B69F1', icon: 'fa-user-check', iconType: 'blue'})">
                                <i class="fas fa-user-check"></i> Réactiver le compte
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal d'action réutilisable --}}
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
    </script>
@endpush
