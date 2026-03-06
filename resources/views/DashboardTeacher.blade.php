@extends('layouts.dashboard')

@section('title', 'Kopiao - Dashboard Tuteur')
@section('page-title', 'Tableau de bord')

@section('content')
    <!-- Profile Completion Banner -->
    @include('dashboard.partials.profile-banner')

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Annonces dans mon domaine -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Annonces disponibles</p>
                            <h2 class="mb-0 fw-bold text-primary">{{ $stats['annoncesInDomain'] }}</h2>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0 small">Dans votre domaine</p>
                </div>
                <div class="card-footer bg-primary bg-opacity-10 border-0">
                    <a href="{{ route('annonces') }}" class="text-primary text-decoration-none small fw-semibold">
                        Voir les annonces <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Candidatures validées -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Candidatures validées</p>
                            <h2 class="mb-0 fw-bold text-success">{{ $stats['candidaturesValidees'] }}</h2>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0 small">
                        Sur {{ $stats['totalCandidatures'] }} candidature{{ $stats['totalCandidatures'] > 1 ? 's' : '' }}
                    </p>
                </div>
{{--                <div class="card-footer bg-success bg-opacity-10 border-0">--}}
{{--                    <a href="#" class="text-success text-decoration-none small fw-semibold">--}}
{{--                        Mes candidatures <i class="bi bi-arrow-right ms-1"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
        </div>

        <!-- Candidatures en attente -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">En attente</p>
                            <h2 class="mb-0 fw-bold text-warning">{{ $stats['candidaturesEnAttente'] }}</h2>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-clock-history text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0 small">Réponse en attente</p>
                </div>

            </div>
        </div>

        <!-- Acompte total -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Acompte total</p>
                            <h2 class="mb-0 fw-bold text-info">{{ number_format($stats['acompteTotal'], 0, ',', ' ') }} <small class="fs-6">FCFA</small></h2>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-cash-coin text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0 small">Missions acceptées</p>
                </div>
{{--                <div class="card-footer bg-info bg-opacity-10 border-0">--}}
{{--                    <a href="#" class="text-info text-decoration-none small fw-semibold">--}}
{{--                        Historique <i class="bi bi-arrow-right ms-1"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Annonces récentes dans mon domaine -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-megaphone text-primary me-2"></i>
                            Annonces récentes pour vous
                        </h5>
                        <span class="badge bg-primary rounded-pill">
                            {{ count($stats['recentAnnonces']) }} disponible{{ count($stats['recentAnnonces']) > 1 ? 's' : '' }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-0">
                    @forelse($stats['recentAnnonces'] as $annonce)
                        <div class="border-bottom p-3 hover-bg-light">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">{{ $annonce->domaine }}</h6>
                                    <p class="text-muted small mb-2">{{ Str::limit($annonce->description, 100) }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-3 small text-muted">
                                    <span>
                                        <i class="bi bi-person me-1"></i>
                                        {{ $annonce->student->firstname }}
                                    </span>
                                    <span>
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $annonce->student->city ?? 'Non spécifié' }}
                                    </span>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold text-primary">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span>
                                    <a href="{{ route('annonces.dashboard.detail', $annonce->hashid) }}"
                                       class="btn btn-sm btn-primary">
                                        Voir <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>

                            @if($annonce->format)
                                <div class="mt-2">
                                    @if($annonce->format == 'online')
                                        <span class="badge bg-purple-subtle text-purple">
                                            <i class="bi bi-globe me-1"></i>En ligne
                                        </span>
                                    @elseif($annonce->format == 'in_person')
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="bi bi-people me-1"></i>Présentiel
                                        </span>
                                    @else
                                        <span class="badge bg-info-subtle text-info">
                                            <i class="bi bi-arrows-collapse me-1"></i>Hybride
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-file-earmark-x text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted fw-semibold mt-3 mb-2">Aucune annonce disponible</p>
                            <p class="text-muted small">Les nouvelles annonces dans votre domaine apparaîtront ici</p>
                        </div>
                    @endforelse
                </div>

                @if(count($stats['recentAnnonces']) > 0)
                    <div class="card-footer bg-light border-top">
                        <a href="{{ route('annonces') }}" class="btn btn-link text-primary text-decoration-none d-block text-center small fw-semibold">
                            Voir toutes les annonces <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Mes candidatures récentes -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-clipboard-check text-primary me-2"></i>
                            Mes candidatures récentes
                        </h5>
                        <span class="badge bg-primary rounded-pill">
                            {{ count($stats['dernieresCandidatures']) }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-0">
                    @forelse($stats['dernieresCandidatures'] as $candidature)
                        <div class="border-bottom p-3 hover-bg-light">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1 flex-wrap gap-2">
                                        <h6 class="mb-0 fw-semibold">{{ $candidature->annonce->domaine }}</h6>
                                        @if($candidature->statut == 'acceptee')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Acceptée
                                            </span>
                                        @elseif($candidature->statut == 'en_attente')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-clock me-1"></i>En attente
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>Refusée
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-muted small mb-0">
                                        Candidature envoyée le {{ $candidature->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-3 small">
                                    <span class="text-muted">
                                        <i class="bi bi-person me-1"></i>
                                        {{ $candidature->annonce->student->firstname }}
                                    </span>
                                    @if($candidature->statut == 'acceptee')
                                        <span class="text-success fw-semibold">
                                            <i class="bi bi-cash-coin me-1"></i>
                                            {{ number_format($candidature->annonce->acompte, 0, ',', ' ') }} FCFA
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('annonces.dashboard.detail', $candidature->annonce->hashid) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    Détails <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-clipboard-x text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted fw-semibold mt-3 mb-2">Aucune candidature</p>
                            <p class="text-muted small">Commencez à postuler aux annonces qui vous intéressent</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Domaines d'expertise -->
    @if(!empty($stats['tutorSubjects']) && count($stats['tutorSubjects']) > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3 fw-semibold">
                            <i class="bi bi-book text-primary me-2"></i>
                            Vos domaines d'expertise
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($stats['tutorSubjects'] as $subject)
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fs-6 fw-semibold">
                                    {{ $subject }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }
        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-2px);
        }
        .hover-bg-light:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
        .bg-purple-subtle {
            background-color: rgba(111, 66, 193, 0.1);
        }
        .text-purple {
            color: #6f42c1;
        }
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1);
        }
        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1);
        }
    </style>
@endsection
