{{-- Carte « Complétez votre profil » — fond jaune, moderne --}}
<style>
    .kp-profile-cta {
        display: flex; align-items: center; gap: 22px;
        background: linear-gradient(135deg, var(--kp-blue), var(--kp-blue-darker)); border-radius: 18px;
        padding: 22px 26px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .kp-profile-cta__icon { width: 54px; height: 54px; border-radius: 14px; background: rgba(255,255,255,.18); color: #fff; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-2xl); flex-shrink: 0; }
    .kp-profile-cta__body { flex: 1; min-width: 240px; }
    .kp-profile-cta__body h3 { font-family: var(--kp-font-title); font-weight: 700; font-size: var(--kp-fs-xl); color: #fff; margin: 0 0 4px; }
    .kp-profile-cta__body p { color: rgba(255,255,255,.85); font-size: var(--kp-fs-base); margin: 0 0 12px; }
    .kp-profile-cta__bar { height: 8px; background: rgba(255,255,255,.25); border-radius: 6px; overflow: hidden; }
    .kp-profile-cta__bar span { display: block; height: 100%; background: #fff; border-radius: 6px; transition: width .5s ease; }
    .kp-profile-cta__btn { background: #fff; color: var(--kp-blue); padding: 12px 22px; border-radius: var(--kp-radius-pill); font-weight: 600; font-size: var(--kp-fs-base); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; transition: var(--kp-transition); }
    .kp-profile-cta__btn:hover { background: var(--kp-yellow); color: #1a1a1a; }
    @media (max-width: 575px) { .kp-profile-cta { justify-content: center; text-align: center; } .kp-profile-cta__btn { width: 100%; justify-content: center; } }
</style>

<div class="kp-profile-cta">
    <div class="kp-profile-cta__icon"><i class="bi bi-person-gear"></i></div>
    <div class="kp-profile-cta__body">
        <h3>Complétez votre profil</h3>
        <p>Votre profil est complété à {{ $profileCompletion }}%. Ajoutez plus d'informations pour améliorer votre visibilité.</p>
        <div class="kp-profile-cta__bar"><span style="width: {{ $profileCompletion }}%;"></span></div>
    </div>
    <a href="{{ route('CompleterProfilUser.edit') }}" class="kp-profile-cta__btn">
        <i class="bi bi-pencil"></i> Compléter mon profil
    </a>
</div>

{{-- Section Tableau de bord - UNIQUEMENT POUR LES ÉTUDIANTS --}}
@if (auth()->user()->isEtudiant())

@php
    $userId = auth()->id();
    $annoncesPubliees      = \App\Models\Annonce::where('student_id', $userId)->where('status', 'publiée')->count();
    $annoncesEnAttente     = \App\Models\Annonce::where('student_id', $userId)->where('status', 'en_attente')->count();
    $annoncesAttribuees    = \App\Models\Annonce::where('student_id', $userId)->where('status', 'attribuée')->count();
    $annoncesRefusees      = \App\Models\Annonce::where('student_id', $userId)->where('status', 'refusée')->count();
    $totalAnnonces         = \App\Models\Annonce::where('student_id', $userId)->count();
    $annoncesAvecCandidatures = \App\Models\Annonce::where('student_id', $userId)->has('candidatures')->count();
    $tauxReponse           = $annoncesPubliees > 0 ? round(($annoncesAvecCandidatures / $annoncesPubliees) * 100) : 0;
    $recentAnnonces        = \App\Models\Annonce::where('student_id', $userId)
                                ->with('subject') // Ajout de la relation subject
                                ->withCount('candidatures')
                                ->orderBy('created_at', 'desc')
                                ->limit(3)
                                ->get();
@endphp

<style>
/* ── Variables ── */
:root {
    --etu-primary:       #0351BC;
    --etu-primary-light: rgba(3,81,188,0.08);
    --etu-success:       #28a745;
    --etu-success-light: rgba(40,167,69,0.08);
    --etu-warning:       #f59e0b;
    --etu-warning-light: rgba(245,158,11,0.08);
    --etu-info:          #17a2b8;
    --etu-info-light:    rgba(23,162,184,0.08);
    --etu-danger:        #dc3545;
    --etu-danger-light:  rgba(220,53,69,0.08);
    --etu-purple:        #6f42c1;
    --etu-purple-light:  rgba(111,66,193,0.08);
    --etu-teal:          #20c997;
    --etu-teal-light:    rgba(32,201,151,0.08);
    --etu-gray:          #6c757d;
    --etu-border:        #e9ecef;
    --etu-radius:        16px;
    --etu-shadow:        0 2px 12px rgba(0,0,0,0.06);
    --etu-shadow-hover:  0 8px 24px rgba(0,0,0,0.10);
}

/* ── Wrapper général ── */
.etu-dashboard {
    padding: 0;
    background: transparent;
    margin-top: 8px;
}

/* ── Titre section ── */
.etu-section-title {
    font-size: var(--kp-fs-xl);
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 28px 0;
}
.etu-title-icon { color: inherit; }

.etu-subsection-title {
    font-size: var(--kp-fs-lg);
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 40px 0 20px 0;
}
.etu-subsection-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin: 34px 0 18px; }
.etu-subsection-head .etu-subsection-title { margin: 0; }
.etu-see-more { color: var(--etu-primary); font-weight: 600; font-size: var(--kp-fs-base); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; }
.etu-see-more:hover { text-decoration: underline; }

/* ── Grilles ── */
.etu-stats-grid,
.etu-stats-grid-3 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(138px, 1fr));
    gap: 10px;
    margin-bottom: 10px;
}
.etu-stats-grid-3 { margin-bottom: 28px; }
.etu-annonces-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

/* ── Carte statistique ── */
.etu-stat-card {
    background: #fff;
    border-radius: 11px;
    padding: 11px 13px;
    box-shadow: none;
    border: 1px solid var(--etu-border);
    transition: transform 0.2s, border-color 0.2s;
    display: flex;
    flex-direction: column;
}
.etu-stat-card:hover {
    transform: translateY(-2px);
    border-color: var(--etu-primary);
}
.etu-stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}
.etu-stat-label {
    color: var(--etu-gray);
    font-size: var(--kp-fs-sm);
    font-weight: 600;
    margin: 0;
}
.etu-stat-value {
    font-size: var(--kp-fs-2xl);
    font-weight: 800;
    margin: 0;
    line-height: 1;
}
.etu-stat-footer { margin-top: 12px; }

/* ── Icône circulaire ── */
.etu-icon-circle {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.etu-icon-circle i { font-size: var(--kp-fs-xs); }
.etu-stat-label { font-size: var(--kp-fs-xs); }

/* Cartes stats : tout en noir, opacité réduite (monochrome) */
.etu-stat-card:has(.etu-bg-primary-light),
.etu-stat-card:has(.etu-bg-success-light),
.etu-stat-card:has(.etu-bg-warning-light),
.etu-stat-card:has(.etu-bg-info-light),
.etu-stat-card:has(.etu-bg-danger-light),
.etu-stat-card:has(.etu-bg-purple-light),
.etu-stat-card:has(.etu-bg-teal-light) { background: rgba(26,26,26,.025); border-color: rgba(26,26,26,.06); }
.etu-stat-card .etu-stat-value { color: #1a1a1a !important; font-weight: 600; }
.etu-stat-card .etu-stat-label { color: #1a1a1a; opacity: .55; }
.etu-stat-card .etu-icon-circle { background: rgba(26,26,26,.07) !important; box-shadow: none; }
.etu-stat-card .etu-icon-circle i { color: #1a1a1a !important; }

/* ── Couleurs texte ── */
.etu-text-primary { color: var(--etu-primary) !important; }
.etu-text-success { color: var(--etu-success) !important; }
.etu-text-warning { color: var(--etu-warning) !important; }
.etu-text-info    { color: var(--etu-info)    !important; }
.etu-text-danger  { color: var(--etu-danger)  !important; }
.etu-text-purple  { color: var(--etu-purple)  !important; }
.etu-text-teal    { color: var(--etu-teal)    !important; }

/* ── Couleurs fond icône ── */
.etu-bg-primary-light { background: var(--etu-primary-light); }
.etu-bg-success-light { background: var(--etu-success-light); }
.etu-bg-warning-light { background: var(--etu-warning-light); }
.etu-bg-info-light    { background: var(--etu-info-light);    }
.etu-bg-danger-light  { background: var(--etu-danger-light);  }
.etu-bg-purple-light  { background: var(--etu-purple-light);  }
.etu-bg-teal-light    { background: var(--etu-teal-light);    }

/* ── Badges ── */
.etu-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 30px;
    font-size: var(--kp-fs-2xs);
    font-weight: 700;
    letter-spacing: 0.3px;
    white-space: nowrap;
}
.etu-badge-success   { background: var(--kp-yellow); color: #1a1a1a; }
.etu-badge-warning   { background: var(--etu-warning); color: #1e293b; }
.etu-badge-danger    { background: var(--etu-danger);  color: #fff; }
.etu-badge-info      { background: var(--etu-info);    color: #fff; }
.etu-badge-secondary { background: var(--etu-gray);    color: #fff; }

/* ── État vide ── */
.etu-empty-state {
    background: #fafbfc;
    border-radius: 20px;
    border: 2px dashed #cdd5e0;
    padding: 60px 40px;
    text-align: center;
    margin: 20px 0 32px;
}
.etu-empty-icon {
    width: 90px;
    height: 90px;
    background: var(--etu-primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}
.etu-empty-icon i { font-size: 2.5rem; color: var(--etu-primary); }
.etu-empty-title {
    font-size: var(--kp-fs-2xl);
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 10px;
}
.etu-empty-text {
    color: var(--etu-gray);
    font-size: var(--kp-fs-md);
    margin-bottom: 28px;
}

/* ── Boutons ── */
.etu-btn-primary {
    background: var(--etu-primary);
    color: #fff;
    padding: 12px 32px;
    border-radius: 60px;
    font-weight: 600;
    font-size: var(--kp-fs-md);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s, transform 0.2s;
    border: none;
    cursor: pointer;
}
.etu-btn-primary:hover { background: #02459c; color: #fff; transform: translateY(-1px); }

.etu-btn-outline {
    background: #fff;
    border: 1.5px solid var(--etu-primary);
    color: var(--etu-primary);
    padding: 5px 14px;
    border-radius: 30px;
    font-size: var(--kp-fs-sm);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
    cursor: pointer;
    font-family: inherit;
}
.etu-btn-outline:hover { background: var(--etu-primary); color: #fff; }

.etu-btn-outline-primary {
    border: 1.5px solid var(--etu-primary);
    color: var(--etu-primary);
    padding: 10px 28px;
    border-radius: 60px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: var(--kp-fs-base);
    font-weight: 600;
    transition: all 0.2s;
}
.etu-btn-outline-primary:hover { background: var(--etu-primary); color: #fff; }

.etu-text-center { text-align: center; margin-top: 16px; }

/* ── Cartes annonces ── */
.etu-annonce-card {
    background: #fff;
    border-radius: var(--etu-radius);
    padding: 20px;
    box-shadow: var(--etu-shadow);
    border: 1px solid var(--etu-border);
    display: flex;
    flex-direction: column;
    gap: 10px;
    transition: transform 0.25s, box-shadow 0.25s;
}
.etu-annonce-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--etu-shadow-hover);
}
.etu-annonce-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 8px;
}
.etu-annonce-title {
    font-weight: 700;
    font-size: var(--kp-fs-md);
    margin: 0;
    color: #1e293b;
    flex: 1;
}
.etu-annonce-description {
    color: var(--etu-gray);
    font-size: var(--kp-fs-sm);
    line-height: 1.5;
    margin: 0;
    flex: 1;
}
.etu-annonce-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid var(--etu-border);
}
.etu-annonce-price {
    font-weight: 800;
    color: var(--etu-primary);
    font-size: var(--kp-fs-md);
}
.etu-candidature-info {
    color: var(--etu-success);
    font-size: var(--kp-fs-xs);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
    padding-top: 8px;
    border-top: 1px solid var(--etu-border);
}

/* ── Responsive ── */
@media (max-width: 1100px) {
    .etu-stats-grid   { grid-template-columns: repeat(2, 1fr); }
    .etu-stats-grid-3 { grid-template-columns: repeat(2, 1fr); }
    .etu-annonces-grid{ grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .etu-dashboard    { padding: 0; }
    .etu-stats-grid,
    .etu-stats-grid-3 { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .etu-annonces-grid { grid-template-columns: 1fr; gap: 12px; }
    .etu-stat-value   { font-size: var(--kp-fs-2xl); }
    .etu-section-title { margin-bottom: 18px; }
    .etu-subsection-head { margin: 24px 0 14px; }
}

/* ── Modal détails annonce (bleu / jaune / noir / blanc) ── */
.kp-amodal { display: none; position: fixed; inset: 0; z-index: 3000; }
.kp-amodal.open { display: block; }
.kp-amodal__overlay { position: fixed; inset: 0; background: rgba(11,18,32,.5); opacity: 0; transition: opacity .25s; }
.kp-amodal.open .kp-amodal__overlay { opacity: 1; }
.kp-amodal__box { position: absolute; top: 0; right: 0; bottom: 0; width: 440px; max-width: 92vw; background: #fff; padding: 24px; box-shadow: -14px 0 50px rgba(0,0,0,.22); transform: translateX(100%); transition: transform .3s ease; overflow-y: auto; }
.kp-amodal.open .kp-amodal__box { transform: translateX(0); }
.kp-amodal__close { position: absolute; top: 14px; right: 14px; width: 32px; height: 32px; border-radius: 50%; border: none; background: #f1f3f7; color: #1a1a1a; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-sm); transition: all .2s; }
.kp-amodal__close:hover { background: #0B69F1; color: #fff; }
.kp-amodal__head { display: flex; align-items: center; gap: 9px; margin-bottom: 12px; flex-wrap: wrap; padding-right: 30px; }
.kp-amodal__badge { background: #0B69F1; color: #fff; padding: 5px 14px; border-radius: 25px; font-size: var(--kp-fs-2xs); font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }
.kp-amodal__status { padding: 4px 12px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 600; background: rgba(26,26,26,.07); color: #1a1a1a; }
.kp-amodal__meta { display: flex; gap: 16px; color: #5b6573; font-size: var(--kp-fs-xs); margin-bottom: 14px; flex-wrap: wrap; }
.kp-amodal__meta i { margin-right: 4px; color: #0B69F1; }
.kp-amodal__budget { background: var(--kp-yellow, #ffc107); border-radius: 14px; padding: 13px 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
.kp-amodal__budget .lbl { color: #1a1a1a; font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; }
.kp-amodal__budget .amt { color: #1a1a1a; font-size: var(--kp-fs-xl); font-weight: 800; }
.kp-amodal__grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
.kp-amodal__item { background: #f6f8fb; border-radius: 11px; padding: 10px 13px; display: flex; flex-direction: column; gap: 2px; }
.kp-amodal__item--full { grid-column: 1 / -1; }
.kp-amodal__item .lbl { font-size: var(--kp-fs-2xs); color: #8a93a3; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; }
.kp-amodal__item .val { font-size: var(--kp-fs-base); font-weight: 600; color: #1a1a1a; }
.kp-amodal__desc { margin-bottom: 20px; }
.kp-amodal__desc .lbl { font-size: var(--kp-fs-2xs); color: #8a93a3; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; display: block; margin-bottom: 6px; }
.kp-amodal__desc p { color: #475569; font-size: var(--kp-fs-base); line-height: 1.6; margin: 0; }
.kp-amodal__actions { display: flex; justify-content: flex-end; }
.kp-amodal__btn { background: #0B69F1; color: #fff; padding: 10px 20px; border-radius: 30px; font-weight: 600; font-size: var(--kp-fs-sm); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background .2s; }
.kp-amodal__btn:hover { background: #1a1a1a; color: #fff; }
/* Mobile : le modal « Voir » monte du bas (bottom sheet) */
@media (max-width: 575px) {
    .kp-amodal__box {
        top: auto; left: 0; right: 0; bottom: 0;
        width: 100%; max-width: 100%; max-height: 90vh;
        border-radius: 20px 20px 0 0; padding: 28px 16px 24px;
        transform: translateY(100%); box-shadow: 0 -14px 40px rgba(0, 0, 0, .25);
    }
    .kp-amodal.open .kp-amodal__box { transform: translateY(0); }
    .kp-amodal__box::before { content: ''; position: absolute; top: 10px; left: 50%; transform: translateX(-50%); width: 42px; height: 4px; border-radius: 4px; background: #d5dae2; }
    .kp-amodal__close { top: 16px; right: 14px; }
    .kp-amodal__grid { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="etu-dashboard">

    {{-- Titre --}}
    <h4 class="etu-section-title">
        <i class="fas fa-chart-line etu-title-icon"></i>
        Tableau de bord de vos annonces
    </h4>

    {{-- Ligne 1 : 4 cartes --}}
    <div class="etu-stats-grid">
        <div class="etu-stat-card">
            <div class="etu-stat-header">
                <p class="etu-stat-label">Total annonces</p>
                <div class="etu-icon-circle etu-bg-primary-light">
                    <i class="fas fa-file-alt etu-text-primary"></i>
                </div>
            </div>
            <h3 class="etu-stat-value etu-text-primary">{{ $totalAnnonces }}</h3>
        </div>

        <div class="etu-stat-card">
            <div class="etu-stat-header">
                <p class="etu-stat-label">Publiées</p>
                <div class="etu-icon-circle etu-bg-success-light">
                    <i class="fas fa-bullhorn etu-text-success"></i>
                </div>
            </div>
            <h3 class="etu-stat-value etu-text-success">{{ $annoncesPubliees }}</h3>
        </div>

        <div class="etu-stat-card">
            <div class="etu-stat-header">
                <p class="etu-stat-label">En attente</p>
                <div class="etu-icon-circle etu-bg-warning-light">
                    <i class="fas fa-clock etu-text-warning"></i>
                </div>
            </div>
            <h3 class="etu-stat-value etu-text-warning">{{ $annoncesEnAttente }}</h3>
        </div>

        <div class="etu-stat-card">
            <div class="etu-stat-header">
                <p class="etu-stat-label">Attribuées</p>
                <div class="etu-icon-circle etu-bg-info-light">
                    <i class="fas fa-check-double etu-text-info"></i>
                </div>
            </div>
            <h3 class="etu-stat-value etu-text-info">{{ $annoncesAttribuees }}</h3>
        </div>
    </div>

    {{-- Ligne 2 : 3 cartes --}}
    <div class="etu-stats-grid-3">
        <div class="etu-stat-card">
            <div class="etu-stat-header">
                <p class="etu-stat-label">Refusées</p>
                <div class="etu-icon-circle etu-bg-danger-light">
                    <i class="fas fa-times-circle etu-text-danger"></i>
                </div>
            </div>
            <h3 class="etu-stat-value etu-text-danger">{{ $annoncesRefusees }}</h3>
        </div>

        <div class="etu-stat-card">
            <div class="etu-stat-header">
                <p class="etu-stat-label">Avec candidatures</p>
                <div class="etu-icon-circle etu-bg-purple-light">
                    <i class="fas fa-users etu-text-purple"></i>
                </div>
            </div>
            <h3 class="etu-stat-value etu-text-purple">{{ $annoncesAvecCandidatures }}</h3>
        </div>

        <div class="etu-stat-card">
            <div class="etu-stat-header">
                <p class="etu-stat-label">Taux de réponse</p>
                <div class="etu-icon-circle etu-bg-teal-light">
                    <i class="fas fa-percent etu-text-teal"></i>
                </div>
            </div>
            <h3 class="etu-stat-value etu-text-teal">{{ $tauxReponse }}%</h3>
            <div class="etu-stat-footer">
                @if($tauxReponse >= 70)
                    <span class="etu-badge etu-badge-success">Excellent !</span>
                @elseif($tauxReponse >= 40)
                    <span class="etu-badge etu-badge-warning">Bon début</span>
                @elseif($tauxReponse > 0)
                    <span class="etu-badge etu-badge-danger">À améliorer</span>
                @else
                    <span class="etu-badge etu-badge-secondary">Pas encore de réponses</span>
                @endif
            </div>
        </div>
    </div>

    {{-- État vide --}}
    @if($totalAnnonces == 0)
        <div class="etu-empty-state">
            <div class="etu-empty-icon">
                <i class="fas fa-bullhorn"></i>
            </div>
            <h4 class="etu-empty-title">Vous n'avez pas encore créé d'annonce</h4>
            <p class="etu-empty-text">Publiez votre première annonce pour trouver le tuteur idéal !</p>
            <a href="{{ route('annonces.create') }}" class="etu-btn-primary">
                <i class="fas fa-plus-circle"></i>
                Créer votre première annonce
            </a>
        </div>
    @endif

    {{-- Annonces récentes --}}
    @if($recentAnnonces->count() > 0)
        <div class="etu-subsection-head">
            <h5 class="etu-subsection-title">
                <i class="fas fa-clock etu-title-icon"></i>
                Vos annonces récentes
            </h5>
            <a href="{{ route('annonces.index') }}" class="etu-see-more">
                Voir plus <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="etu-annonces-grid">
            @foreach($recentAnnonces as $annonce)
                @php
                    $statusColor = match($annonce->status) {
                        'publiée'    => 'success',
                        'en_attente' => 'warning',
                        'attribuée'  => 'info',
                        'refusée'    => 'danger',
                        default      => 'secondary'
                    };
                    $matiereNom = $annonce->subject->nom ?? 'Matière non spécifiée';
                @endphp
                <div class="etu-annonce-card">
                    <div class="etu-annonce-header">
                        <h6 class="etu-annonce-title" title="{{ $matiereNom }}">{{ Str::limit($matiereNom, 28) }}</h6>
                        <span class="etu-badge etu-badge-{{ $statusColor }}">{{ $annonce->status }}</span>
                    </div>
                    <p class="etu-annonce-description">{{ Str::limit($annonce->description, 80) }}</p>
                    <div class="etu-annonce-footer">
                        <span class="etu-annonce-price">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span>
                        <button type="button" class="etu-btn-outline"
                            data-matiere="{{ $matiereNom }}"
                            data-status="{{ $annonce->status }}"
                            data-budget="{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA"
                            data-acompte="{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA"
                            data-format="{{ $annonce->format }}"
                            data-dispo="{{ $annonce->disponibilite }}"
                            data-description="{{ $annonce->description }}"
                            data-date="{{ $annonce->created_at->format('d/m/Y') }}"
                            data-candidatures="{{ $annonce->candidatures_count }}"
                            data-paid="{{ $annonce->is_paid ? 'Payée' : 'Non payée' }}"
                            data-published="{{ $annonce->published_at ? \Carbon\Carbon::parse($annonce->published_at)->format('d/m/Y') : '—' }}"
                            data-url="{{ route('annonces.show', $annonce->id) }}"
                            onclick="openAnnonceModal(this)">Voir</button>
                    </div>
                    @if($annonce->candidatures_count > 0)
                        <div class="etu-candidature-info">
                            <i class="fas fa-user-check"></i>
                            {{ $annonce->candidatures_count }} candidature(s)
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    @endif

</div>

{{-- Modal détails d'une annonce --}}
<div class="kp-amodal" id="annonceModal">
    <div class="kp-amodal__overlay" onclick="closeAnnonceModal()"></div>
    <div class="kp-amodal__box">
        <button type="button" class="kp-amodal__close" onclick="closeAnnonceModal()"><i class="bi bi-x-lg"></i></button>
        <div class="kp-amodal__head">
            <span class="kp-amodal__badge" id="am-matiere"></span>
            <span class="kp-amodal__status" id="am-status"></span>
        </div>
        <div class="kp-amodal__meta">
            <span><i class="bi bi-calendar3"></i><span id="am-date"></span></span>
            <span><i class="bi bi-people"></i><span id="am-candidatures"></span></span>
        </div>
        <div class="kp-amodal__budget">
            <span class="lbl">Budget total</span>
            <span class="amt" id="am-budget"></span>
        </div>
        <div class="kp-amodal__grid">
            <div class="kp-amodal__item"><span class="lbl">Acompte</span><span class="val" id="am-acompte"></span></div>
            <div class="kp-amodal__item"><span class="lbl">Format</span><span class="val" id="am-format"></span></div>
            <div class="kp-amodal__item"><span class="lbl">Paiement</span><span class="val" id="am-paid"></span></div>
            <div class="kp-amodal__item"><span class="lbl">Publiée le</span><span class="val" id="am-published"></span></div>
            <div class="kp-amodal__item kp-amodal__item--full"><span class="lbl">Disponibilités</span><span class="val" id="am-dispo"></span></div>
        </div>
        <div class="kp-amodal__desc">
            <span class="lbl">Description</span>
            <p id="am-description"></p>
        </div>
        <div class="kp-amodal__actions">
            <a href="#" id="am-url" class="kp-amodal__btn">Ouvrir la page complète <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>

<script>
    function openAnnonceModal(btn) {
        const d = btn.dataset;
        const fmt = d.format === 'presentiel' ? 'Présentiel' : (d.format === 'en_ligne' ? 'En ligne' : 'Hybride');
        document.getElementById('am-matiere').textContent = d.matiere;
        document.getElementById('am-status').textContent = d.status;
        document.getElementById('am-date').textContent = ' ' + d.date;
        document.getElementById('am-candidatures').textContent = ' ' + d.candidatures + ' candidature(s)';
        document.getElementById('am-budget').textContent = d.budget;
        document.getElementById('am-acompte').textContent = d.acompte;
        document.getElementById('am-format').textContent = fmt;
        document.getElementById('am-paid').textContent = d.paid;
        document.getElementById('am-published').textContent = d.published;
        document.getElementById('am-dispo').textContent = d.dispo || '—';
        document.getElementById('am-description').textContent = d.description || 'Aucune description fournie.';
        document.getElementById('am-url').href = d.url;
        document.documentElement.style.overflow = 'hidden';
        document.body.style.overflow = 'hidden';
        const m = document.getElementById('annonceModal');
        m.classList.add('open');
        const box = m.querySelector('.kp-amodal__box');
        if (box) box.scrollTop = 0;
    }
    function closeAnnonceModal() {
        document.getElementById('annonceModal').classList.remove('open');
        document.documentElement.style.overflow = '';
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeAnnonceModal(); });
</script>

@endif

