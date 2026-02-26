@extends('layouts.dashboard')

@section('title', 'Historique des abonnements')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <!-- En-tête sobre avec bleu -->
                <div class="mb-4">
                    <h1 class="h3 fw-bold text-primary mb-2">Historique des abonnements</h1>
                    <p class="text-muted mb-0">Consultez l'ensemble de vos abonnements et leur statut</p>
                </div>

                <!-- Messages flash -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Tableau des abonnements -->
                @if($subscriptions->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-semibold text-primary">Liste des abonnements</h5>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                    {{ $subscriptions->total() }} abonnement(s)
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-primary table-primary-custom">
                                    <tr>
                                        <th class="px-4 py-3 fw-semibold">Référence</th>
                                        <th class="px-4 py-3 fw-semibold">Date début</th>
                                        <th class="px-4 py-3 fw-semibold">Date fin</th>
                                        <th class="px-4 py-3 fw-semibold">Jours restants</th>
                                        <th class="px-4 py-3 fw-semibold">Statut</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subscriptions as $subscription)
                                        <tr class="border-bottom">
                                            <td class="px-4 py-3">
                                                <span class="text-primary fw-medium">AB-{{ str_pad($loop->iteration + ($subscriptions->currentPage() - 1) * $subscriptions->perPage(), 4, '0', STR_PAD_LEFT) }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-dark">{{ $subscription->date_debut->format('d/m/Y') }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-dark">{{ $subscription->date_fin->format('d/m/Y') }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                @php
                                                    $joursRestants = now()->startOfDay()->diffInDays($subscription->date_fin->startOfDay(), false);
                                                    $joursRestantsAbs = max(0, $joursRestants);
                                                @endphp

                                                @if($subscription->date_fin->isFuture())
                                                    @php
                                                        $totalJours = $subscription->date_debut->diffInDays($subscription->date_fin);
                                                        $pourcentage = $totalJours > 0 ? ($joursRestantsAbs / $totalJours) * 100 : 0;
                                                    @endphp
                                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2">
                                                        {{ $joursRestantsAbs }} jour(s)
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($subscription->statut === 'active' && $subscription->date_fin->isFuture())
                                                    <span class="badge bg-success-subtle text-success px-3 py-2 fw-medium">Actif</span>
                                                @elseif($subscription->statut === 'active' && $subscription->date_fin->isPast())
                                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 fw-medium">Expiré</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 fw-medium">{{ ucfirst($subscription->statut) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if($subscriptions->hasPages())
                            <div class="card-body border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                        Affichage de {{ $subscriptions->firstItem() }} à {{ $subscriptions->lastItem() }} sur {{ $subscriptions->total() }} résultats
                                    </div>
                                    <div>
                                        {{ $subscriptions->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Statistiques -->
                        <div class="card-footer bg-light border-top">
                            <div class="row text-center g-0">
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <div class="h5 mb-1 fw-bold text-success">
                                            {{ $subscriptions->where('statut', 'active')->where('date_fin', '>', now())->count() }}
                                        </div>
                                        <small class="text-muted">Actif(s)</small>
                                    </div>
                                </div>
                                <div class="col-md-4 border-start border-end">
                                    <div class="p-3">
                                        <div class="h5 mb-1 fw-bold text-primary">{{ $subscriptions->total() }}</div>
                                        <small class="text-muted">Total</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <div class="h5 mb-1 fw-bold text-secondary">
                                            {{ $subscriptions->where('date_fin', '<', now())->count() }}
                                        </div>
                                        <small class="text-muted">Expiré(s)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-4 mb-3">
                                    <i class="fas fa-inbox fa-3x text-primary opacity-50"></i>
                                </div>
                            </div>
                            <h5 class="mb-2 fw-semibold text-dark">Aucun abonnement trouvé</h5>
                            <p class="text-muted mb-4">Vous n'avez pas encore d'historique d'abonnements</p>
                            <a href="{{ route('subscription.user') }}" class="btn btn-primary">
                                Souscrire maintenant
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .table-primary-custom {
            background-color: rgba(13, 110, 253, 0.08) !important;
            color: #0d6efd;
        }

        .badge {
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 6px;
        }

        /* Bootstrap 5.3+ subtle backgrounds */
        .bg-success-subtle {
            background-color: #d1e7dd !important;
        }

        .bg-secondary-subtle {
            background-color: #e2e3e5 !important;
        }

        .bg-warning-subtle {
            background-color: #fff3cd !important;
        }

        .text-success {
            color: #198754 !important;
        }

        .text-secondary {
            color: #6c757d !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        /* Style de pagination personnalisé */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: #0d6efd;
            border-color: #dee2e6;
        }

        .page-link:hover {
            background-color: rgba(13, 110, 253, 0.08);
            border-color: #0d6efd;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endsection
