@extends('layouts.dashboard')

@section('title', "Détails de l'apprenant - Kopiao")
@section('page-title', "Détails de l'apprenant")

@push('styles')
    <style>
        .as-page { max-width: 900px; margin: 0 auto; }
        .as-back { display: inline-flex; align-items: center; gap: 8px; color: var(--kp-muted); text-decoration: none; font-weight: 600; font-size: var(--kp-fs-base); margin-bottom: 18px; transition: color .2s; }
        .as-back:hover { color: var(--kp-blue); }

        .as-hero { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 6px; }
        .as-hero__avatar { width: 72px; height: 72px; border-radius: 50%; background: var(--kp-blue); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: var(--kp-fs-xl); overflow: hidden; flex-shrink: 0; }
        .as-hero__avatar img { width: 100%; height: 100%; object-fit: cover; }
        .as-hero__name { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 700; color: var(--kp-ink); margin: 0; }
        .as-hero__mail { color: var(--kp-muted); font-size: var(--kp-fs-sm); margin: 2px 0 8px; }
        .as-badges { display: flex; gap: 8px; flex-wrap: wrap; }
        .as-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; }
        .as-badge--ok { background: #d1fae5; color: #065f46; }
        .as-badge--off { background: #fee2e2; color: #991b1b; }
        .as-badge--wait { background: #fef3c7; color: #92400e; }

        .as-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; margin-top: 22px; }
        @media (max-width: 820px) { .as-grid { grid-template-columns: 1fr; } }

        .as-card { background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; padding: 20px 22px; box-shadow: var(--kp-shadow); margin-bottom: 18px; }
        .as-card__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-lg); font-weight: 700; color: var(--kp-ink); margin: 0 0 14px; display: flex; align-items: center; gap: 9px; }
        .as-card__title i { color: var(--kp-blue); }
        .as-row { display: flex; justify-content: space-between; gap: 14px; padding: 9px 0; border-bottom: 1px dashed var(--kp-border); font-size: var(--kp-fs-base); }
        .as-row:last-child { border-bottom: none; }
        .as-row .lbl { color: var(--kp-muted); flex-shrink: 0; }
        .as-row .val { color: var(--kp-ink); font-weight: 600; text-align: right; }
        .as-row .val.empty { color: var(--kp-muted); font-weight: 400; font-style: italic; }
        .as-bio { color: var(--kp-text); font-size: var(--kp-fs-base); line-height: 1.65; margin: 0; }
        .as-bio.empty { color: var(--kp-muted); font-style: italic; }

        .as-comp { display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
        .as-comp__bar { flex: 1; height: 8px; background: var(--kp-border); border-radius: 6px; overflow: hidden; }
        .as-comp__bar span { display: block; height: 100%; background: var(--kp-blue); border-radius: 6px; }
        .as-comp__pct { font-weight: 700; color: var(--kp-blue); font-size: var(--kp-fs-base); }

        .as-actions { display: flex; flex-direction: column; gap: 10px; }
        .as-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; height: 44px; border-radius: var(--kp-radius-pill); font-size: var(--kp-fs-sm); font-weight: 600; text-decoration: none; cursor: pointer; border: none; transition: all .2s; }
        .as-btn--blue { background: var(--kp-blue); color: #fff; }
        .as-btn--blue:hover { background: var(--kp-blue-darker); color: #fff; }
        .as-btn--ghost { background: #fff; color: var(--kp-ink); border: 1.5px solid var(--kp-border); }
        .as-btn--ghost:hover { background: var(--kp-blue); color: #fff; border-color: var(--kp-blue); }
        .as-btn--danger { background: #e02c18; color: #fff; }
        .as-btn--danger:hover { background: #c62411; color: #fff; }
        .as-actions form { width: 100%; }
    </style>
@endpush

@section('content')
    <div class="as-page">
        <a href="{{ route('apprenants.index') }}" class="as-back"><i class="fas fa-arrow-left"></i> Retour aux apprenants</a>

        <div class="as-hero">
            <div class="as-hero__avatar">
                @if ($apprenant->photo_path && Storage::disk('public')->exists($apprenant->photo_path))
                    <img src="{{ asset('storage/' . $apprenant->photo_path) }}" alt="Profil">
                @else
                    {{ strtoupper(substr($apprenant->firstname, 0, 1) . substr($apprenant->lastname, 0, 1)) }}
                @endif
            </div>
            <div>
                <h1 class="as-hero__name">{{ $apprenant->firstname }} {{ $apprenant->lastname }}</h1>
                <p class="as-hero__mail">{{ $apprenant->email }}</p>
                <div class="as-badges">
                    @if ($apprenant->is_active)
                        <span class="as-badge as-badge--ok"><i class="fas fa-user-check"></i> Actif</span>
                    @else
                        <span class="as-badge as-badge--off"><i class="fas fa-user-slash"></i> Désactivé</span>
                    @endif
                    @if ($apprenant->is_valid)
                        <span class="as-badge as-badge--ok"><i class="fas fa-check-circle"></i> Validé</span>
                    @else
                        <span class="as-badge as-badge--wait"><i class="fas fa-clock"></i> Non validé</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="as-grid">
            <div>
                <div class="as-card">
                    <h3 class="as-card__title"><i class="fas fa-user"></i> Informations</h3>
                    <div class="as-row"><span class="lbl">Identifiant</span><span class="val">#{{ $apprenant->id }}</span></div>
                    <div class="as-row"><span class="lbl">Email</span><span class="val">{{ $apprenant->email }}</span></div>
                    <div class="as-row"><span class="lbl">Téléphone</span><span class="val {{ empty($apprenant->telephone) ? 'empty' : '' }}">{{ $apprenant->telephone ?? 'Non renseigné' }}</span></div>
                    <div class="as-row"><span class="lbl">Ville</span><span class="val {{ empty($apprenant->city) ? 'empty' : '' }}">{{ $apprenant->city ?? 'Non renseignée' }}</span></div>
                    <div class="as-row"><span class="lbl">Préférence</span><span class="val">{{ $apprenant->learning_preference == 'online' ? 'En ligne' : ($apprenant->learning_preference == 'in_person' ? 'Présentiel' : ($apprenant->learning_preference == 'hybrid' ? 'Hybride' : '—')) }}</span></div>
                    <div class="as-row"><span class="lbl">Inscrit le</span><span class="val">{{ $apprenant->created_at->format('d/m/Y à H:i') }}</span></div>
                    @if ($apprenant->last_login)
                        <div class="as-row"><span class="lbl">Dernière connexion</span><span class="val">{{ \Carbon\Carbon::parse($apprenant->last_login)->format('d/m/Y à H:i') }}</span></div>
                    @endif
                </div>

                <div class="as-card">
                    <h3 class="as-card__title"><i class="fas fa-align-left"></i> Biographie</h3>
                    <p class="as-bio {{ empty($apprenant->bio) ? 'empty' : '' }}">{{ $apprenant->bio ?? 'Aucune biographie renseignée.' }}</p>
                </div>
            </div>

            <div>
                <div class="as-card">
                    <h3 class="as-card__title"><i class="fas fa-chart-pie"></i> Profil</h3>
                    <div class="as-comp">
                        <div class="as-comp__bar"><span style="width: {{ $profileCompletion }}%;"></span></div>
                        <span class="as-comp__pct">{{ $profileCompletion }}%</span>
                    </div>
                    <p style="color: var(--kp-muted); font-size: var(--kp-fs-sm); margin: 0;">Taux de complétion du profil.</p>
                </div>

                <div class="as-card">
                    <h3 class="as-card__title"><i class="fas fa-cog"></i> Actions</h3>
                    <div class="as-actions">
                        <form action="{{ route('apprenants.toggle-status', $apprenant->id) }}" method="POST"
                              onsubmit="return kpConfirmDelete(event, this, {icon: '{{ $apprenant->is_active ? 'danger' : 'success' }}', iconClass: '{{ $apprenant->is_active ? 'fa-user-slash' : 'fa-user-check' }}', title: '{{ $apprenant->is_active ? 'Désactiver cet apprenant ?' : 'Réactiver cet apprenant ?' }}', text: '{{ $apprenant->is_active ? 'Le compte sera désactivé.' : 'Le compte sera réactivé.' }}', confirmText: '{{ $apprenant->is_active ? 'Désactiver' : 'Réactiver' }}', confirmColor: '{{ $apprenant->is_active ? '#dc2626' : '#0B69F1' }}'});">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="as-btn as-btn--ghost"><i class="fas {{ $apprenant->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i> {{ $apprenant->is_active ? 'Désactiver' : 'Réactiver' }}</button>
                        </form>

                        <form action="{{ route('apprenants.destroy', $apprenant->id) }}" method="POST"
                              onsubmit="return kpConfirmDelete(event, this, {title: 'Supprimer cet apprenant ?', text: 'Cette action est irréversible.', confirmText: 'Oui, supprimer'});">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="as-btn as-btn--danger"><i class="fas fa-trash"></i> Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
