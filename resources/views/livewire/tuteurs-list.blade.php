<div class="container py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 text-center text-dark mb-3">Trouvez le tuteur parfait</h1>
            <p class="text-center text-muted mb-4">Des milliers de tuteurs disponibles pour vous accompagner</p>

            <!-- Compteur et reset -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary me-2">{{ $tuteurs->total() }}</span>
                    <span class="text-muted">tuteurs disponibles</span>
                </div>
                @if($subject || $city || $learning_preference)
                    <button wire:click="resetFilters" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-times me-1"></i>Réinitialiser les filtres
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="filter-group">
                <label class="form-label small text-muted mb-1">Matière</label>
                <div class="position-relative">
                    <input
                        wire:model.live.500ms="subject"
                        class="form-control form-control-lg"
                        placeholder="Maths, Physique, Anglais..."
                    >
                    <div wire:loading wire:target="subject" class="position-absolute end-0 top-50 translate-middle-y me-3">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="filter-group">
                <label class="form-label small text-muted mb-1">Ville</label>
                <div class="position-relative">
                    <input
                        wire:model.live.500ms="city"
                        class="form-control form-control-lg"
                        placeholder="Cotonou, Porto-Novo..."
                    >
                    <div wire:loading wire:target="city" class="position-absolute end-0 top-50 translate-middle-y me-3">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="filter-group">
                <label class="form-label small text-muted mb-1">Type de cours</label>
                <select wire:model.live="learning_preference" class="form-control form-control-lg">
                    <option value="">Tous les types</option>
                    <option value="online">En ligne</option>
                    <option value="in_person">En présentiel</option>
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-2">
            <div class="filter-group">
                <label class="form-label small text-muted mb-1">&nbsp;</label>
                <button wire:click="resetFilters" class="btn btn-outline-secondary w-100 btn-lg h-100">
                    <i class="fas fa-refresh me-2"></i>Effacer
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Skeleton Professionnel -->
    <div wire:loading.delay class="loading-skeleton">
        <div class="row">
            @for($i = 0; $i < 6; $i++)
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card tutor-card-skeleton">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="skeleton-avatar me-3"></div>
                                <div class="flex-grow-1">
                                    <div class="skeleton-line w-75 mb-2"></div>
                                    <div class="skeleton-line w-50 mb-3"></div>
                                    <div class="skeleton-line w-100 mb-1"></div>
                                    <div class="skeleton-line w-100 mb-1"></div>
                                    <div class="skeleton-line w-60"></div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="skeleton-badge"></div>
                                <div class="skeleton-badge"></div>
                                <div class="skeleton-badge"></div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <div class="skeleton-line w-40"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <!-- Liste des tuteurs -->
    <div wire:loading.remove class="tutors-grid">
        @if($tuteurs->count() > 0)
            <div class="row">
                @foreach($tuteurs as $tuteur)
                    <div class="col-xl-4 col-lg-6 mb-4">
                        <div class="card tutor-card h-100">
                            <div class="card-body">
                                <!-- En-tête du profil -->
                                <div class="d-flex align-items-start mb-3">
                                    <div class="tutor-avatar me-3">
                                        @if($tuteur->photo_path)
                                            <img src="{{ asset('storage/' . $tuteur->photo_path) }}"
                                                 alt="{{ $tuteur->firstname }}"
                                                 class="rounded-circle">
                                        @else
                                            <img src="{{ asset('images/profill_default.webp') }}"
                                                 alt="Avatar"
                                                 class="rounded-circle">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="tutor-name mb-1">{{ $tuteur->firstname }} {{ $tuteur->lastname }}</h5>
                                        <div class="tutor-rating mb-1">
                                            <span class="text-warning">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </span>
                                            <span class="text-muted small">(4.8)</span>
                                        </div>
                                        <div class="tutor-location text-muted small">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $tuteur->city ?? 'Ville non spécifiée' }}
                                        </div>
                                    </div>
                                    <div class="tutor-status">
                                        @if($tuteur->learning_preference == 'online')
                                            <span class="badge bg-success">En ligne</span>
                                        @elseif($tuteur->learning_preference == 'in_person')
                                            <span class="badge bg-info">Présentiel</span>
                                        @else
                                            <span class="badge bg-secondary">Flexible</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="tutor-bio text-muted small mb-3">
                                    {{ Str::limit($tuteur->bio, 120) }}
                                </p>

                                <!-- Matières -->
                                <div class="tutor-subjects mb-3">
                                    <div class="subject-tags">
                                        @foreach(array_slice($tuteur->formatted_subjects, 0, 3) as $subject)
                                            <span class="subject-tag">{{ $subject }}</span>
                                        @endforeach
                                        @if(count($tuteur->formatted_subjects) > 3)
                                            <span class="subject-tag-more">+{{ count($tuteur->formatted_subjects) - 3 }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Footer avec prix et action -->
                                <div class="tutor-footer border-top pt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="tutor-price">
                                            <span class="h5 text-primary mb-0">{{ $tuteur->rate_per_hour ?? '0' }} FCFA</span>
                                            <span class="text-muted small d-block">par heure</span>
                                        </div>
                                        <div class="tutor-actions">
                                            <button class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>Voir profil
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- État vide -->
            <div class="empty-state text-center py-5">
                <div class="empty-state-icon mb-4">
                    <i class="fas fa-search fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">Aucun tuteur trouvé</h3>
                <p class="text-muted mb-4">Essayez de modifier vos critères de recherche ou élargissez votre recherche</p>
                @if($subject || $city || $learning_preference)
                    <button wire:click="resetFilters" class="btn btn-primary btn-lg">
                        <i class="fas fa-refresh me-2"></i>Voir tous les tuteurs
                    </button>
                @endif
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($tuteurs->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $tuteurs->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
    <style>
        /* Styles généraux */
        .filter-group {
            margin-bottom: 1rem;
        }

        /* Cartes de tuteurs */
        .tutor-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .tutor-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .tutor-avatar img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 3px solid #f8f9fa;
        }

        .tutor-name {
            font-weight: 600;
            color: #2c3e50;
        }

        .tutor-rating {
            font-size: 0.9rem;
        }

        /* Tags de matières */
        .subject-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .subject-tag {
            background: #e3f2fd;
            color: #1976d2;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .subject-tag-more {
            background: #f5f5f5;
            color: #666;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        /* Loading Skeleton */
        .loading-skeleton {
            animation: pulse 1.5s ease-in-out infinite;
        }

        .tutor-card-skeleton {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }

        .skeleton-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #e0e0e0;
        }

        .skeleton-line {
            height: 12px;
            background: #e0e0e0;
            border-radius: 6px;
            margin-bottom: 0.5rem;
        }

        .skeleton-badge {
            display: inline-block;
            width: 60px;
            height: 24px;
            background: #e0e0e0;
            border-radius: 12px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        /* Animations */
        @keyframes pulse {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
            100% {
                opacity: 1;
            }
        }

        /* État vide */
        .empty-state {
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tutor-card {
                margin-bottom: 1rem;
            }

            .tutor-avatar img {
                width: 50px;
                height: 50px;
            }

            .filter-group .form-control-lg {
                font-size: 0.9rem;
            }
        }

        /* Amélioration de la pagination */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: none;
            color: #666;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
@endpush
