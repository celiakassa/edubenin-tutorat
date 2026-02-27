{{-- Banner de profil existant --}}
<div class="profile-banner">
    <div class="profile-banner-content">
        <div class="profile-banner-icon">
            <i class="fas fa-user-edit"></i>
        </div>
        <div class="profile-banner-text">
            <h3>Complétez votre profil</h3>
            <p>Votre profil est complété à {{ $profileCompletion }}%. Ajoutez plus d'informations pour améliorer votre
                visibilité.</p>
            <div class="progress-bar" style="background: #e0e0e0; border-radius: 5px; height: 20px; width: 100%;">
                <div class="progress-bar-fill"
                    style="background: {{ $profileCompletion < 100 ? '#f44336' : '#4caf50' }};
                    width: {{ $profileCompletion }}%;
                    height: 100%;
                    border-radius: 5px;">
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('CompleterProfilUser.edit') }}" class="btn-complete-profile" style="text-decoration: none;">
        <i class="fas fa-pencil-alt"></i>
        Compléter mon profil
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
                                ->withCount('candidatures')
                                ->orderBy('created_at', 'desc')
                                ->limit(6)
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
    padding: 32px;
    background: #f0f4fb;
    border-radius: 20px;
    margin-top: 24px;
}

/* ── Titre section ── */
.etu-section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 28px 0;
}
.etu-title-icon { color: var(--etu-primary); }

.etu-subsection-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 40px 0 20px 0;
}

/* ── Grilles ── */
.etu-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}
.etu-stats-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}
.etu-annonces-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

/* ── Carte statistique ── */
.etu-stat-card {
    background: #fff;
    border-radius: var(--etu-radius);
    padding: 22px 20px;
    box-shadow: var(--etu-shadow);
    border: 1px solid var(--etu-border);
    transition: transform 0.25s, box-shadow 0.25s;
    display: flex;
    flex-direction: column;
}
.etu-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--etu-shadow-hover);
}
.etu-stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}
.etu-stat-label {
    color: var(--etu-gray);
    font-size: 0.82rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}
.etu-stat-value {
    font-size: 2.4rem;
    font-weight: 800;
    margin: 0;
    line-height: 1;
}
.etu-stat-footer { margin-top: 12px; }

/* ── Icône circulaire ── */
.etu-icon-circle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.etu-icon-circle i { font-size: 1.2rem; }

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
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    white-space: nowrap;
}
.etu-badge-success   { background: var(--etu-success); color: #fff; }
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
    font-size: 1.3rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 10px;
}
.etu-empty-text {
    color: var(--etu-gray);
    font-size: 0.95rem;
    margin-bottom: 28px;
}

/* ── Boutons ── */
.etu-btn-primary {
    background: var(--etu-primary);
    color: #fff;
    padding: 12px 32px;
    border-radius: 60px;
    font-weight: 600;
    font-size: 0.95rem;
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
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
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
    font-size: 0.9rem;
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
    font-size: 0.95rem;
    margin: 0;
    color: #1e293b;
    flex: 1;
}
.etu-annonce-description {
    color: var(--etu-gray);
    font-size: 0.82rem;
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
    font-size: 0.95rem;
}
.etu-candidature-info {
    color: var(--etu-success);
    font-size: 0.78rem;
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
    .etu-dashboard    { padding: 16px; }
    .etu-stats-grid,
    .etu-stats-grid-3,
    .etu-annonces-grid { grid-template-columns: 1fr; gap: 12px; }
    .etu-stat-value   { font-size: 1.8rem; }
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
        <h5 class="etu-subsection-title">
            <i class="fas fa-clock etu-title-icon"></i>
            Vos annonces récentes
        </h5>

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
                @endphp
                <div class="etu-annonce-card">
                    <div class="etu-annonce-header">
                        <h6 class="etu-annonce-title">{{ Str::limit($annonce->domaine, 28) }}</h6>
                        <span class="etu-badge etu-badge-{{ $statusColor }}">{{ $annonce->status }}</span>
                    </div>
                    <p class="etu-annonce-description">{{ Str::limit($annonce->description, 80) }}</p>
                    <div class="etu-annonce-footer">
                        <span class="etu-annonce-price">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span>
                        <a href="{{ route('annonces.show', $annonce->id) }}" class="etu-btn-outline">Voir</a>
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

        <div class="etu-text-center">
            <a href="{{ route('annonces.index') }}" class="etu-btn-outline-primary">
                Voir toutes mes annonces
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @endif

</div>

@endif

@if (auth()->user()->isTuteur())
    <div class="profile-banner mt-4" style="padding: 30px;">
        <div class="container-fluid p-0">
            <div class="row" style="margin-left: -15px; margin-right: -15px;">
                {{-- Tes cartes pour tuteurs ici --}}
            </div>
        </div>
    </div>
@endif
