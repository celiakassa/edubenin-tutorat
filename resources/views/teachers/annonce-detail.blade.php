@extends('layouts.dashboard')

@section('title', 'Détail de la Mission')

@section('content')
    <div class="container-fluid py-5 px-md-5">

        <div class="d-flex justify-content-start mb-4">
            <a href="{{ url()->previous() }}" class="btn-back">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux offres
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card main-card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 p-lg-5">

                        <div class="mb-4">
                            <span class="category-tag mb-3">{{ $annonce->domaine }}</span>
                            <h1 class="display-title text-navy mb-4">{{ $annonce->title ?? 'Mission en ' . $annonce->domaine }}</h1>

                            <div class="quick-info-grid">
                                <div class="info-item">
                                    <div class="icon-box"><i class="far fa-calendar-alt"></i></div>
                                    <div>
                                        <p class="label">Début de mission</p>
                                        <p class="value text-navy">
                                            {{-- Formatage de la date de disponibilité --}}
                                            @if($annonce->disponibilite && strtotime($annonce->disponibilite))
                                                {{ \Carbon\Carbon::parse($annonce->disponibilite)->locale('fr')->translatedFormat('d F Y') }}
                                            @else
                                                {{ $annonce->disponibilite ?? 'Dès que possible' }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="icon-box"><i class="fas fa-video"></i></div>
                                    <div>
                                        <p class="label">Format</p>
                                        <p class="value text-navy text-capitalize">{{ str_replace('_', ' ', $annonce->format) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="custom-divider my-5"></div>

                        <div class="description-section mb-5">
                            <h5 class="section-subtitle text-navy mb-3">
                                <i class="fas fa-info-circle mr-2 text-primary"></i>Description de la mission
                            </h5>
                            <div class="content-text text-secondary">
                                {!! nl2br(e($annonce->description)) !!}
                            </div>
                        </div>

                        <div class="finance-footer-card p-4">
                            <div class="row align-items-center text-center text-md-left">
                                <div class="col-md-6 border-md-right">
                                    <p class="label-muted text-uppercase small mb-1">Acompte requis</p>
                                    <p class="h4 font-weight-bold text-navy mb-0">{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</p>
                                </div>
                                <div class="col-md-6 pl-md-4 mt-3 mt-md-0">
                                    <p class="label-muted text-uppercase small mb-1">Publié le</p>
                                    <p class="h6 font-weight-bold text-navy mb-0">
                                        {{-- Date de publication formatée --}}
                                        {{ \Carbon\Carbon::parse($annonce->created_at)->locale('fr')->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 20px;">

                    <div class="card action-card-blue border-0 shadow-lg mb-4 overflow-hidden">
                        <div class="card-body p-4 text-center text-white" style="background-color:#0351BC; border-radius: 20px;">
                            <p class="text-white-50 mb-1">Rémunération Totale</p>
                            <h2 class="budget-display mb-4">
                                {{ number_format($annonce->budget, 0, ',', ' ') }} <small>FCFA</small>
                            </h2>

                            @auth
                                @if(auth()->user()->isTuteur())
                                    @if($hasApplied)
                                        <button class="btn btn-applied w-100 py-3" disabled>
                                            <i class="fas fa-check-circle mr-2"></i>Candidature envoyée
                                        </button>
                                    @else
                                        <button class="btn btn-white-cta btn-apply-trigger w-100 py-3 mb-3 shadow" data-id="{{ $annonce->id }}">
                                            Postuler maintenant
                                        </button>
                                        <p class="small mb-0 opacity-75">
                                            <i class="fas fa-shield-alt mr-1"></i> Paiement sécurisé via Kopiao
                                        </p>
                                    @endif
                                @endif
                            @endauth
                        </div>
                    </div>

                    @if(isset($candidature) && $candidature)
                        <div class="card border-0 shadow-sm mb-4 card-status">
                            <div class="card-body p-4">
                                <h6 class="sidebar-title mb-3">Statut du dossier</h6>
                                @php
                                    $statusStyle = [
                                        'acceptee' => ['bg' => '#ecfdf5', 'text' => '#065f46', 'icon' => 'fa-check-circle', 'label' => 'Validée'],
                                        'en_attente' => ['bg' => '#fffbeb', 'text' => '#92400e', 'icon' => 'fa-clock', 'label' => 'En attente'],
                                        'refuse' => ['bg' => '#fef2f2', 'text' => '#991b1b', 'icon' => 'fa-times-circle', 'label' => 'Refusée'],
                                    ];
                                    $st = $statusStyle[$candidature->statut] ?? ['bg' => '#f8fafc', 'text' => '#64748b', 'icon' => 'fa-info-circle', 'label' => $candidature->statut];
                                @endphp
                                <div class="status-badge-box d-flex align-items-center p-3 rounded-lg" style="background-color: {{ $st['bg'] }}; color: {{ $st['text'] }};">
                                    <i class="fas {{ $st['icon'] }} mr-3 fa-lg"></i>
                                    <span class="font-weight-bold">{{ $st['label'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Section Profil de l'étudiant --}}
                    <div class="card border-0 shadow-sm profile-card">
                        <div class="card-body p-4">
                            <h6 class="sidebar-title mb-4">Profil de l'étudiant</h6>

                            @if($student)
                                <div class="d-flex align-items-center mb-4">
                                    <div class="avatar-box mr-3">
                                        {{-- Si validé : photo ou initiale. Si non validé : cadenas --}}
                                        @if(isset($teacher_validate) && $teacher_validate)
                                            @if($student->photo_path)
                                                <img src="{{ asset('storage/' . $student->photo_path) }}" class="rounded-circle shadow-sm">
                                            @else
                                                <div class="avatar-letter">{{ strtoupper(substr($student->firstname, 0, 1)) }}</div>
                                            @endif
                                        @else
                                            <div class="avatar-letter">
                                                <i class="fas fa-lock"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold text-navy">
                                            {{ $student->firstname }}
                                            {{ (isset($teacher_validate) && $teacher_validate) ? $student->lastname : '***' }}
                                        </h6>
                                        <span class="text-success small"><i class="fas fa-check-double mr-1"></i>Vérifié</span>
                                    </div>
                                </div>

                                @if(isset($teacher_validate) && $teacher_validate)
                                    <div class="contact-info bg-light p-3 rounded-lg">
                                        <p class="small mb-2 text-navy"><i class="fas fa-phone-alt text-primary mr-2"></i> {{ $student->telephone ?? 'N/A' }}</p>
                                        <p class="small mb-0 text-navy"><i class="fas fa-envelope text-primary mr-2"></i> {{ $student->email ?? 'N/A' }}</p>
                                    </div>
                                @else
                                    <div class="locked-info text-center p-3 border rounded-lg">
                                        <i class="fas fa-lock text-muted mb-2"></i>
                                        <p class="small text-muted mb-0">Coordonnées visibles après validation de votre candidature.</p>
                                    </div>
                                @endif
                            @else
                                <p class="text-muted small">Informations étudiant non disponibles.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@push('styles')
<style>
    /* VARIABLES & FONTS */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

    :root {
        --primary-blue: #0061f2;
        --dark-navy: #1a2b4b;
        --bg-soft: #f4f8fb;
        --text-muted: #64748b;
    }

    body {
        background-color: var(--bg-soft);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .text-navy { color: var(--dark-navy) !important; }

    /* CARDS */
    .main-card { border-radius: 24px; }
    .display-title { font-weight: 800; font-size: 2.25rem; letter-spacing: -1px; line-height: 1.2; }

    /* TAGS & INFO */
    .category-tag {
        display: inline-block;
        background: #eef5ff;
        color: var(--primary-blue);
        padding: 6px 18px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .quick-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 25px;
    }

    .info-item { display: flex; align-items: center; }
    .icon-box {
        width: 48px; height: 48px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 15px;
        color: var(--primary-blue);
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }
    .info-item .label { font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0; font-weight: 600; }
    .info-item .value { font-weight: 700; margin-bottom: 0; }

    .custom-divider { height: 1px; background: linear-gradient(to right, #e2e8f0, transparent); }

    .content-text { font-size: 1.05rem; line-height: 1.8; }
    .finance-footer-card { background: #f8fafc; border-radius: 18px; border: 1px solid #edf2f7; }

    /* SIDEBAR */
    .action-card-blue {
        background: linear-gradient(135deg, #0061f2 0%, #0037a5 100%);
        border-radius: 24px;
    }
    .budget-display { font-weight: 800; font-size: 2.8rem; }
    .budget-display small { font-size: 1.1rem; opacity: 0.8; }

    .btn-white-cta {
        background: white;
        color: var(--primary-blue);
        border: none;
        border-radius: 14px;
        font-weight: 800;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-white-cta:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.2) !important; }

    .btn-applied {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.4);
        color: white;
        border-radius: 14px;
        font-weight: 700;
    }

    .sidebar-title { font-weight: 800; color: var(--text-muted); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }

    /* AVATAR */
    .avatar-box { width: 55px; height: 55px; }
    .avatar-box img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-letter {
        width: 100%; height: 100%;
        background: var(--primary-blue);
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1.2rem;
    }

    .profile-card { border-radius: 20px; }
    .locked-info { background-color: #f9fafb; border-style: dashed !important; }

    /* UTILS */
    .btn-back { color: var(--text-muted); font-weight: 700; text-decoration: none; transition: 0.3s; }
    .btn-back:hover { color: var(--primary-blue); transform: translateX(-5px); }

    @media (min-width: 768px) {
        .border-md-right { border-right: 1px solid #e2e8f0; }
    }
</style>
@endpush
@endsection
