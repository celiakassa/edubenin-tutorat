@extends('layouts.dashboard')

@section('title', 'Détail Mission')

@section('content')
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-link text-primary-dark p-0 shadow-none font-weight-bold">
            <i class="fas fa-chevron-left mr-2"></i>Retour aux offres
        </a>
        @if($hasApplied)
            <span class="badge badge-soft-success py-2 px-3">
                <i class="fas fa-check-circle mr-1"></i> Candidature envoyée
            </span>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4 card-main-layout">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="mb-4">
                        <span class="badge badge-soft-blue text-uppercase mb-2 px-3 py-2">
                            {{ $annonce->domaine }}
                        </span>
                        <h1 class="font-weight-bold text-navy h2 mb-3">{{ $annonce->title ?? 'Mission en ' . $annonce->domaine }}</h1>
                        
                        <div class="d-flex flex-wrap mt-3">
                            <div class="mr-4 mb-2 info-icon-text">
                                <i class="far fa-calendar-check mr-2"></i>
                                <span>Début : {{ $annonce->disponibilite ? $annonce->disponibilite->translatedFormat('d M Y') : 'Dès que possible' }}</span>
                            </div>
                            <div class="mr-4 mb-2 info-icon-text">
                                <i class="fas fa-video mr-2"></i>
                                <span>{{ ucfirst(str_replace('_', ' ', $annonce->format)) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="divider-blue my-4"></div>

                    <div class="mb-5">
                        <h5 class="text-navy font-weight-bold mb-3">Description de la mission</h5>
                        <div class="text-muted-dark" style="line-height: 1.8; font-size: 1.05rem;">
                            {!! nl2br(e($annonce->description)) !!}
                        </div>
                    </div>

                    <div class="bg-soft-blue p-4 rounded-lg">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0 border-right-blue">
                                <small class="text-primary-dark text-uppercase d-block font-weight-bold mb-1" style="letter-spacing: 0.5px;">Acompte requis</small>
                                <span class="h5 font-weight-bold mb-0 text-navy">{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="col-md-6 pl-md-4">
                                <small class="text-primary-dark text-uppercase d-block font-weight-bold mb-1" style="letter-spacing: 0.5px;">Date de publication</small>
                                <span class="h6 font-weight-bold mb-0 text-navy">{{ $annonce->created_at->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px;">
                
                <div class="card border-0 shadow-lg mb-4 action-card-blue">
                    <div class="card-body p-4 text-center text-white">
                        <p class="opacity-8 mb-1 font-weight-bold">Budget de la mission</p>
                        <h2 class="display-4 font-weight-bold mb-4">
                            {{ number_format($annonce->budget, 0, ',', ' ') }} <small class="h6">FCFA</small>
                        </h2>

                        @auth
                            @if(auth()->user()->isTuteur())
                                @if($hasApplied)
                                    <button class="btn btn-applied-white btn-block py-3 font-weight-bold" disabled>
                                        Candidature envoyée
                                    </button>
                                @else
                                    <button class="btn btn-white-action btn-block py-3 font-weight-bold btn-apply-trigger shadow-sm" data-id="{{ $annonce->id }}">
                                        Postuler maintenant
                                    </button>
                                    <p class="small mt-3 mb-0 opacity-8">
                                        <i class="fas fa-shield-alt mr-1"></i> Garanti par Kopiao
                                    </p>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="card-body p-4">
                        <h6 class="text-navy font-weight-bold mb-3">Profil de l'étudiant</h6>
                        <div class="d-flex align-items-center">
                            <div class="avatar-blue mr-3">
                                @if($annonce->student->photo_path)
                                    <img src="{{ asset('storage/' . $annonce->student->photo_path) }}" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                                @else
                                    {{ strtoupper(substr($annonce->student->firstname, 0, 1) . substr($annonce->student->lastname, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0 font-weight-bold text-navy">{{ $annonce->student->firstname }} {{ $annonce->student->lastname }}</h6>
                                <span class="badge badge-pill badge-light text-success"><i class="fas fa-check-circle mr-1"></i>Vérifié</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Palette de Couleurs Frontend */
    :root {
        --navy: #1a2b4b;        /* Bleu Marine pour les textes */
        --primary-blue: #0061f2; /* Bleu Action */
        --light-blue: #f0f7ff;   /* Bleu très clair pour les fonds */
        --soft-blue: #e0ebf9;    /* Bleu doux pour les badges */
    }

    body { background-color: #f4f7fa; font-family: 'Poppins', sans-serif; }
    
    .text-navy { color: var(--navy) !important; }
    .text-primary-dark { color: #004db3 !important; }
    .text-muted-dark { color: #4e5e7a; }

    /* Card Layout */
    .card-main-layout { border-radius: 20px; }
    .rounded-lg { border-radius: 15px !important; }

    /* Badges & Backgrounds */
    .badge-soft-blue { background-color: var(--soft-blue); color: var(--primary-blue); font-weight: 700; border-radius: 8px; }
    .badge-soft-success { background-color: #d1fae5; color: #065f46; font-weight: 700; border-radius: 8px; }
    .bg-soft-blue { background-color: var(--light-blue); }

    /* Icons */
    .info-icon-text i { color: var(--primary-blue); font-size: 1.1rem; }
    .info-icon-text span { color: var(--navy); font-weight: 500; }

    /* Dividers */
    .divider-blue { height: 1px; background: linear-gradient(to right, var(--soft-blue), transparent); }
    .border-right-blue { border-right: 1px solid #d0ddec; }

    /* Sidebar Action Card */
    .action-card-blue { 
        background: linear-gradient(135deg, #0061f2 0%, #002d72 100%); 
        border-radius: 20px;
    }
    .btn-white-action { 
        background-color: white; 
        color: var(--primary-blue); 
        border: none; 
        border-radius: 12px; 
        transition: 0.3s;
    }
    .btn-white-action:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); color: #004db3; }
    
    .btn-applied-white { background-color: rgba(255,255,255,0.2); border: 1px solid white; color: white; border-radius: 12px; }

    /* Avatar */
    .avatar-blue {
        width: 50px; height: 50px; 
        background-color: var(--soft-blue); 
        color: var(--primary-blue); 
        border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; 
        font-weight: bold; border: 2px solid white; box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .opacity-8 { opacity: 0.8; }
</style>
@endpush