@extends('layouts.welcomeLayout')

@section('content')
    <div class="demandes-page py-5">
        <div class="container">
            <!-- En-tête -->
            <div class="text-center mb-5" data-aos="fade-up">
                <h1 class="display-5 fw-bold" style="color: #0000FF;">Demandes des étudiants</h1>
                <p class="lead text-muted">Trouvez la mission qui correspond à vos compétences</p>
                <div class="divider mx-auto" style="width: 80px; height: 4px; background: #0000FF; border-radius: 2px;"></div>
            </div>

            <!-- Barre de recherche avec live search -->
            <div class="row justify-content-center mb-4" data-aos="fade-up">
                <div class="col-lg-8">
                    <form action="{{ route('demandesliste.liste') }}" method="GET" id="searchForm">
                        <div class="search-wrapper bg-white rounded-pill shadow-sm p-2">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="bi bi-search" style="color: #0000FF; font-size: 1.2rem;"></i>
                                </span>
                                <input type="text" name="search" id="liveSearch"
                                    class="form-control border-0 bg-transparent"
                                    placeholder="Rechercher par domaine ou mot-clé..." value="{{ request('search') }}"
                                    autocomplete="off" style="box-shadow: none; outline: none; padding: 12px 5px;">
                                @if (request('search') || request('domaine'))
                                    <a href="{{ route('demandesliste.liste') }}" class="btn btn-link text-decoration-none"
                                        id="clearSearch">
                                        <i class="bi bi-x-circle" style="color: #999;"></i>
                                    </a>
                                @endif
                                <!-- Le bouton Rechercher est caché car recherche automatique -->
                                <button type="submit" class="btn rounded-pill px-4"
                                    style="background: #0000FF; color: white; border: none; display: none;">
                                    Rechercher
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Résultats de recherche en temps réel -->
            @if (request('search'))
                <div class="text-center mb-4">
                    <p class="text-muted">
                        Résultats pour "<strong>{{ request('search') }}</strong>" :
                        {{ $demandes->total() }} demande(s) trouvée(s)
                    </p>
                </div>
            @endif

            <div class="row g-4">
                <!-- Colonne de gauche : Filtres -->
                <div class="col-lg-3" data-aos="fade-right">
                    <div class="filters-card bg-white rounded-4 shadow-sm p-4 sticky-top" style="top: 100px;">
                        <h5 class="fw-bold mb-4" style="color: #0000FF;">
                            <i class="bi bi-funnel me-2"></i>Filtrer par
                        </h5>

                        <form action="{{ route('demandesliste.liste') }}" method="GET" id="filterForm">
                            <!-- Garder la recherche dans le filtre -->
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}" id="filterSearchInput">
                            @endif

                            <!-- Filtre par domaine -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-3" style="color: #333;">
                                    <i class="bi bi-book me-2" style="color: #0000FF;"></i>Domaine
                                </label>
                                <div class="domaines-list" style="max-height: 400px; overflow-y: auto;">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="domaine" id="domaineTous"
                                            value="" {{ !request('domaine') ? 'checked' : '' }}
                                            onchange="document.getElementById('filterForm').submit()">
                                        <label class="form-check-label" for="domaineTous">
                                            Tous les domaines
                                        </label>
                                    </div>
                                    @foreach ($domaines as $domaine)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="domaine"
                                                id="domaine{{ $loop->index }}" value="{{ $domaine }}"
                                                {{ request('domaine') == $domaine ? 'checked' : '' }}
                                                onchange="document.getElementById('filterForm').submit()">
                                            <label class="form-check-label" for="domaine{{ $loop->index }}">
                                                {{ $domaine }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Bouton de réinitialisation -->
                            @if (request('domaine') || request('search'))
                                <a href="{{ route('demandesliste.liste') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-x-circle me-2"></i>Effacer tous les filtres
                                </a>
                            @endif
                        </form>

                        <!-- Statistiques -->
                        <div class="stats-box mt-4 p-3 rounded-3" style="background: #f8f9fa;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-megaphone" style="color: #0000FF;"></i>
                                <span class="fw-bold">{{ $demandes->total() }} demande(s)</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-tags" style="color: #0000FF;"></i>
                                <span>{{ count($domaines) }} domaine(s)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne de droite : Liste des demandes -->
                <div class="col-lg-9" data-aos="fade-left" id="demandesList">
                    @if ($demandes->count() > 0)
                        <div class="demandes-grid">
                            @foreach ($demandes as $demande)
                                <div class="demande-card bg-white rounded-4 shadow-sm mb-4 overflow-hidden">
                                    <div class="row g-0">
                                        <!-- Badge de format -->
                                        <div class="col-1 d-flex align-items-start p-3">
                                            <span
                                                class="badge rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; background: {{ $demande->format == 'presentiel' ? '#0000FF' : ($demande->format == 'en_ligne' ? '#00a36c' : '#ff6b6b') }};">
                                                @if ($demande->format == 'presentiel')
                                                    <i class="bi bi-person-workspace text-white"></i>
                                                @elseif($demande->format == 'en_ligne')
                                                    <i class="bi bi-laptop text-white"></i>
                                                @else
                                                    <i class="bi bi-arrow-left-right text-white"></i>
                                                @endif
                                            </span>
                                        </div>

                                        <!-- Contenu principal -->
                                        <div class="col-11">
                                            <div class="card-body p-3">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <h4 class="fw-bold mb-2" style="color: #333;">
                                                            {{ $demande->domaine }}
                                                            @if (request('search'))
                                                                @php
                                                                    $search = request('search');
                                                                    $position =
                                                                        stripos($demande->description, $search) !==
                                                                            false ||
                                                                        stripos($demande->domaine, $search) !== false;
                                                                @endphp
                                                                @if ($position)
                                                                    <span class="badge ms-2"
                                                                        style="background: #ffc107; color: #333; font-size: 0.7rem;">
                                                                        <i class="bi bi-search"></i> Correspondance
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        </h4>
                                                        <p class="text-muted mb-2" style="line-height: 1.5;">
                                                            @if (request('search'))
                                                                @php
                                                                    $search = request('search');
                                                                    $description = $demande->description;
                                                                    $position = stripos($description, $search);
                                                                    if ($position !== false) {
                                                                        $start = max(0, $position - 30);
                                                                        $end = min(
                                                                            strlen($description),
                                                                            $position + strlen($search) + 30,
                                                                        );
                                                                        $extract = substr(
                                                                            $description,
                                                                            $start,
                                                                            $end - $start,
                                                                        );
                                                                        if ($start > 0) {
                                                                            $extract = '...' . $extract;
                                                                        }
                                                                        if ($end < strlen($description)) {
                                                                            $extract .= '...';
                                                                        }
                                                                        $extract = preg_replace(
                                                                            '/(' . preg_quote($search, '/') . ')/i',
                                                                            '<mark style="background: #ffc107; color: #333;">$1</mark>',
                                                                            $extract,
                                                                        );
                                                                        echo $extract;
                                                                    } else {
                                                                        echo Str::limit($demande->description, 150);
                                                                    }
                                                                @endphp
                                                            @else
                                                                {{ Str::limit($demande->description, 150) }}
                                                            @endif
                                                        </p>
                                                        <div class="d-flex flex-wrap gap-3 mt-2">
                                                            <small class="text-muted">
                                                                <i class="bi bi-calendar me-1"
                                                                    style="color: #0000FF;"></i>
                                                                {{ $demande->created_at->format('d/m/Y') }}
                                                            </small>
                                                            <small class="text-muted">
                                                                <i class="bi bi-person me-1" style="color: #0000FF;"></i>
                                                                {{ $demande->student->firstname }}
                                                                {{ $demande->student->lastname }}
                                                            </small>
                                                            <small class="text-muted">
                                                                <i class="bi bi-clock me-1" style="color: #0000FF;"></i>
                                                                {{ substr_count($demande->disponibilite, "\n") + 1 }}
                                                                créneau(x)
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                                        <div class="budget-box p-2 rounded-3 d-inline-block mb-2"
                                                            style="background: rgba(0,0,255,0.05);">
                                                            <span class="fw-bold"
                                                                style="color: #0000FF; font-size: 1.2rem;">
                                                                {{ number_format($demande->budget, 0, ',', ' ') }}
                                                            </span>
                                                            <small class="text-muted">FCFA</small>
                                                        </div>
                                                        <br>
                                                        <a href="{{ route('annoncesListe.publique.detail', $demande->id) }}"
                                                            class="btn btn-sm px-3 py-1 rounded-pill"
                                                            style="background: #0000FF; color: white; border: none;">
                                                            Voir détails <i class="bi bi-arrow-right ms-1"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-5">
                            {{ $demandes->links() }}
                        </div>
                    @else
                        <div class="no-results text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                            <h4 class="mt-3" style="color: #333;">Aucune demande trouvée</h4>
                            <p class="text-muted">
                                @if (request('search') || request('domaine'))
                                    Aucun résultat ne correspond à votre recherche.
                                    <br><br>
                                    <a href="{{ route('demandesliste.liste') }}"
                                        style="
        display:inline-block;
        background:linear-gradient(135deg,#0d6efd,#0047ff);
        color:#ffffff;
        padding:10px 22px;
        font-weight:600;
        text-decoration:none;
        border-radius:50px;
        box-shadow:0 8px 20px rgba(13,110,253,0.3);
        transition:all 0.3s ease;
   "
                                        onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 25px rgba(13,110,253,0.5)';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(13,110,253,0.3)';">
                                        Voir toutes les demandes
                                    </a>
                                @else
                                    Aucune demande disponible pour le moment.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .demandes-page {
            background: #f8f9fa;
            min-height: 100vh;
        }

        /* Style de la barre de recherche */
        .search-wrapper {
            border: 2px solid rgba(0, 0, 255, 0.1);
            transition: all 0.3s ease;
        }

        .search-wrapper:hover {
            border-color: rgba(0, 0, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 255, 0.1) !important;
        }

        .search-wrapper:focus-within {
            border-color: #0000FF;
            box-shadow: 0 10px 30px rgba(0, 0, 255, 0.15) !important;
        }

        .search-wrapper input:focus {
            background: transparent;
        }

        .filters-card {
            border: 1px solid rgba(0, 0, 255, 0.1);
            transition: all 0.3s ease;
        }

        .filters-card:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 255, 0.1) !important;
        }

        .form-check-input:checked {
            background-color: #0000FF;
            border-color: #0000FF;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 255, 0.1);
            border-color: #0000FF;
        }

        .demande-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .demande-card:hover {
            transform: translateX(5px) translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 0, 255, 0.1) !important;
            border-color: rgba(0, 0, 255, 0.2);
        }

        .badge {
            transition: all 0.3s ease;
        }

        .demande-card:hover .badge {
            transform: scale(1.1);
        }

        .budget-box {
            transition: all 0.3s ease;
        }

        .demande-card:hover .budget-box {
            background: rgba(0, 0, 255, 0.1) !important;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 255, 0.3);
        }

        .stats-box {
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stats-box:hover {
            background: #f0f0f0 !important;
        }

        mark {
            padding: 2px 4px;
            border-radius: 4px;
            background: #ffc107;
            color: #333;
        }

        /* Pagination */
        .pagination {
            gap: 5px;
        }

        .pagination .page-link {
            border: none;
            border-radius: 10px;
            color: #333;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: #0000FF;
            color: white;
        }

        .pagination .active .page-link {
            background: #0000FF;
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .filters-card {
                position: relative !important;
                top: 0 !important;
                margin-bottom: 20px;
            }

            .demande-card .badge {
                width: 30px !important;
                height: 30px !important;
            }

            .demande-card .badge i {
                font-size: 0.8rem !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('liveSearch');
            const searchForm = document.getElementById('searchForm');
            const filterForm = document.getElementById('filterForm');
            const filterSearchInput = document.getElementById('filterSearchInput');

            let timeoutId = null;

            // Recherche en temps réel
            searchInput.addEventListener('input', function() {
                // Annuler le timeout précédent
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }

                // Mettre à jour aussi le champ caché du formulaire de filtre
                if (filterSearchInput) {
                    filterSearchInput.value = this.value;
                }

                // Définir un nouveau timeout (300ms après la dernière frappe)
                timeoutId = setTimeout(() => {
                    searchForm.submit();
                }, 300);
            });

            // Empêcher la soumission du formulaire si on appuie sur Entrée (pour éviter double soumission)
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchForm.submit();
                }
            });
        });
    </script>
@endsection
