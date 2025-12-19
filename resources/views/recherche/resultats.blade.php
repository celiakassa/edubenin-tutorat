@extends('layouts.welcomeLayout')

@section('content')
    <div class="container-fluid py-5"
        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
        <div class="container">
            <!-- Barre de recherche répétée -->
            <div class="cta-section py-4" data-aos="fade-up" data-aos-delay="100">
                <div class="container">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold" style="color:#0d6efd;">Nouvelle Recherche</h2>
                        <p class="text-muted">Affinez votre recherche ou lancez une nouvelle</p>
                    </div>

                    <form action="{{ route('recherche.tuteur') }}" method="GET"
                        class="search-bar p-4 p-lg-5 rounded-4 shadow-lg"
                        style="background: linear-gradient(135deg, #e8f1ff 0%, #f0f7ff 100%); border-left: 6px solid #0d6efd;">

                        <div class="row g-3 align-items-end">
                            <!-- Matière -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="color:#0d6efd;">Matière</label>
                                <input type="text" name="subject"
                                    class="form-control form-control-lg border-primary-subtle"
                                    placeholder="Ex : Mathématiques, Anglais..." id="subjectInputResults"
                                    value="{{ request('subject') }}">
                            </div>

                            <!-- Ville -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold" style="color:#0d6efd;">Ville</label>
                                <input type="text" name="city"
                                    class="form-control form-control-lg border-primary-subtle"
                                    placeholder="Entrez une ville" id="cityInputResults" value="{{ request('city') }}">
                            </div>

                            <!-- Préférence d'apprentissage -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold" style="color:#0d6efd;">Mode d'apprentissage</label>
                                <select name="learning_preference"
                                    class="form-control form-control-lg border-primary-subtle">
                                    <option value="">Tous les modes</option>
                                    <option value="online"
                                        {{ request('learning_preference') == 'online' ? 'selected' : '' }}>En Ligne</option>
                                    <option value="in_person"
                                        {{ request('learning_preference') == 'in_person' ? 'selected' : '' }}>Présentiel
                                    </option>
                                    <option value="both" {{ request('learning_preference') == 'both' ? 'selected' : '' }}>
                                        Les deux</option>
                                </select>
                            </div>

                            <!-- Bouton Rechercher -->
                            <div class="col-md-2 d-grid">
                                <button type="submit" class="btn btn-primary btn-lg px-4" style="height: 56px;">
                                    <i class="bi bi-search me-2"></i>Rechercher
                                </button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>

            <!-- Résultats de la recherche -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold text-primary">
                            <i class="bi bi-people-fill me-2"></i>
                            Résultats de votre recherche
                            <span class="badge bg-primary ms-2">{{ $tuteurs->total() }}</span>
                        </h2>

                        <!-- Filtres actifs -->
                        <div class="d-flex gap-2">
                            @if (request('subject'))
                                <span
                                    class="badge bg-primary bg-opacity-10 text-primary p-2 rounded-pill d-flex align-items-center">
                                    <i class="bi bi-book me-1"></i> {{ request('subject') }}
                                    <a href="{{ request()->fullUrlWithoutQuery('subject') }}" class="text-danger ms-2">
                                        <i class="bi bi-x"></i>
                                    </a>
                                </span>
                            @endif

                            @if (request('city'))
                                <span
                                    class="badge bg-danger bg-opacity-10 text-danger p-2 rounded-pill d-flex align-items-center">
                                    <i class="bi bi-geo-alt me-1"></i> {{ request('city') }}
                                    <a href="{{ request()->fullUrlWithoutQuery('city') }}" class="text-danger ms-2">
                                        <i class="bi bi-x"></i>
                                    </a>
                                </span>
                            @endif

                            @if (request('learning_preference'))
                                <span
                                    class="badge bg-success bg-opacity-10 text-success p-2 rounded-pill d-flex align-items-center">
                                    <i class="bi bi-laptop me-1"></i>
                                    @if (request('learning_preference') == 'online')
                                        En ligne
                                    @elseif(request('learning_preference') == 'in_person')
                                        Présentiel
                                    @else
                                        Les deux
                                    @endif
                                    <a href="{{ request()->fullUrlWithoutQuery('learning_preference') }}"
                                        class="text-danger ms-2">
                                        <i class="bi bi-x"></i>
                                    </a>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ($tuteurs->count() == 0)
                <!-- Aucun résultat -->
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="card-body p-5 text-center">
                                <div class="mb-4">
                                    <i class="bi bi-search display-1 text-muted opacity-25"></i>
                                </div>
                                <h3 class="fw-bold text-secondary mb-3">Aucun tuteur trouvé</h3>
                                <p class="text-muted mb-4">Essayez d'élargir vos critères de recherche ou consultez nos
                                    suggestions ci-dessus.</p>
                                <div class="d-flex gap-3 justify-content-center">
                                    <a href="{{ request()->fullUrlWithoutQuery(['subject', 'city', 'learning_preference']) }}"
                                        class="btn btn-outline-primary btn-lg">
                                        <i class="bi bi-arrow-counterclockwise me-2"></i>Réinitialiser
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Liste des tuteurs -->
                <div class="row g-4">
                    @foreach ($tuteurs as $tuteur)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card tutor-card h-100 border-0 shadow-lg rounded-4 overflow-hidden"
                                data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">

                                <!-- Badge de statut -->
                                <div class="position-absolute top-0 end-0 m-3 z-2">
                                    @if ($tuteur->learning_preference == 'online')
                                        <span class="badge bg-success bg-opacity-90 text-white p-2">
                                            <i class="bi bi-wifi"></i> En ligne
                                        </span>
                                    @elseif($tuteur->learning_preference == 'in_person')
                                        <span class="badge bg-primary bg-opacity-90 text-white p-2">
                                            <i class="bi bi-geo-alt"></i> Présentiel
                                        </span>
                                    @else
                                        <span class="badge bg-info bg-opacity-90 text-white p-2">
                                            <i class="bi bi-check2-circle"></i> Flexible
                                        </span>
                                    @endif
                                </div>

                                {{-- Le badge vérifié --}}

                                <style>
                                    /* Badge Tuteur Vérifié */
                                    .verified-badge {
                                        display: inline-flex;
                                        align-items: center;
                                        background: linear-gradient(135deg, #FFD700, #FFA500);
                                        color: #8B6914;
                                        padding: 5px 15px;
                                        border-radius: 20px;
                                        font-size: 0.9rem;
                                        font-weight: 600;
                                        margin-left: 10px;
                                        box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3);
                                        animation: pulse 2s infinite;
                                    }

                                    @keyframes pulse {
                                        0% {
                                            box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3);
                                        }

                                        50% {
                                            box-shadow: 0 3px 15px rgba(255, 215, 0, 0.5);
                                        }

                                        100% {
                                            box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3);
                                        }
                                    }

                                    .verified-badge i {
                                        margin-right: 5px;
                                        font-size: 0.9rem;
                                    }
                                </style>

                                @if ($tuteur->role_id == 3 && $tuteur->is_valid == 1)
                                    <div class="tutor-verified mb-2">
                                        <span class="verified-badge">
                                            <i class="fas fa-check-circle"></i> Tuteur vérifié
                                        </span>
                                    </div>
                                @endif


                                <!-- Photo du tuteur -->
                                <div class="tutor-image-container position-relative" style="height: 200px;">
                                    <img src="{{ $tuteur->photo_path ? Storage::url($tuteur->photo_path) : asset('images/default-avatar.jpg') }}"
                                        class="w-100 h-100 object-fit-cover"
                                        alt="{{ $tuteur->firstname }} {{ $tuteur->lastname }}"
                                        onerror="this.src='{{ asset('images/profill_default.webp') }}'">
                                    <div class="image-overlay"></div>

                                </div>

                                <div class="card-body p-4">
                                    <!-- Nom et titre -->
                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-1">{{ $tuteur->firstname }} {{ $tuteur->lastname }}</h5>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-mortarboard-fill me-1"></i>
                                            Professeur de
                                            @php
                                                $subjects = json_decode($tuteur->subjects, true);
                                                echo $subjects[0] ?? 'matières';
                                            @endphp
                                        </p>
                                    </div>


                                    <!-- Matières -->
                                    <div class="mb-3">
                                        <p class="small text-muted mb-1">
                                            <i class="bi bi-book me-1"></i> <strong>Matières :</strong>
                                        </p>

                                        @php
                                            $subjects = json_decode($tuteur->subjects, true) ?? [];
                                        @endphp

                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach (array_slice($subjects, 0, 3) as $subject)
                                                <span class="badge bg-light text-dark border p-1 rounded">
                                                    {{ $subject }}
                                                </span>
                                            @endforeach

                                            @if (count($subjects) > 3)
                                                <span class="badge bg-light text-dark border p-1 rounded">
                                                    +{{ count($subjects) - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Localisation et tarif -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                                <span
                                                    class="text-muted small">{{ $tuteur->city ?? 'Non spécifiée' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-cash-coin text-success me-2"></i>
                                                <span class="text-muted small">
                                                    À partir de
                                                    {{ $tuteur->rate_per_hour ? number_format($tuteur->rate_per_hour, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Actions -->

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($tuteurs->hasPages())
                    <div class="row mt-5">
                        <div class="col-12">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    {{ $tuteurs->links('pagination::bootstrap-5') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Scripts pour la page de résultats -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation AOS
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });

            // Défilement horizontal pour les résultats
            function setupHorizontalScroll(containerClass, prevBtnClass, nextBtnClass) {
                const container = document.querySelector(containerClass);
                const prevBtn = document.querySelector(prevBtnClass);
                const nextBtn = document.querySelector(nextBtnClass);

                if (!container || !prevBtn || !nextBtn) return;

                const scrollAmount = 300;

                prevBtn.addEventListener('click', () => {
                    container.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                });

                nextBtn.addEventListener('click', () => {
                    container.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                });

                // Auto scroll pour les résultats
                let autoScroll = true;
                let direction = 1;

                function autoScrollContent() {
                    if (autoScroll && container.scrollWidth > container.clientWidth) {
                        container.scrollBy({
                            left: direction * 1,
                            behavior: 'auto'
                        });

                        if (container.scrollLeft >= container.scrollWidth - container.clientWidth) {
                            direction = -1;
                        } else if (container.scrollLeft <= 0) {
                            direction = 1;
                        }
                    }
                    requestAnimationFrame(autoScrollContent);
                }

                // Pause au survol
                container.addEventListener('mouseenter', () => autoScroll = false);
                container.addEventListener('mouseleave', () => autoScroll = true);

                autoScrollContent();
            }

            // Appliquer aux deux containers
            setupHorizontalScroll('.matieres-scroll', '.btn-scroll-prev-results', '.btn-scroll-next-results');
            setupHorizontalScroll('.villes-scroll', '.btn-scroll-prev-villes-results',
                '.btn-scroll-next-villes-results');

            // Animation des cartes
            const cards = document.querySelectorAll('.tutor-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px)';
                    this.style.zIndex = '10';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.zIndex = '1';
                });
            });
        });
    </script>

    <style>
        /* Styles spécifiques pour la page de résultats */
        .tutor-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .tutor-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .tutor-image-container {
            overflow: hidden;
        }

        .tutor-image-container img {
            transition: transform 0.6s ease;
        }

        .tutor-card:hover .tutor-image-container img {
            transform: scale(1.1);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(0, 0, 0, 0.1));
        }

        /* Styles pour les badges dans les résultats */
        .matiere-badge-results,
        .ville-badge-results {
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .matiere-badge-results:hover {
            background-color: #0d6efd !important;
            color: white !important;
            transform: translateY(-2px);
        }

        .ville-badge-results:hover {
            background-color: #dc3545 !important;
            color: white !important;
            transform: translateY(-2px);
        }

        /* Pagination personnalisée */
        .pagination .page-link {
            border-radius: 8px;
            margin: 0 3px;
            border: none;
            color: #0d6efd;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tutor-card {
                margin-bottom: 1.5rem;
            }

            .tutor-image-container {
                height: 180px;
            }
        }

        @media (max-width: 576px) {
            .tutor-image-container {
                height: 160px;
            }

            .card-body {
                padding: 1rem !important;
            }
        }
    </style>
@endsection
