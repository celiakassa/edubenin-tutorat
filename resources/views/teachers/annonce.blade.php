@extends('layouts.dashboard')

@section('title', 'Kopiao - Annonces')

@section('page-title', 'Annonces disponibles')

@section('content')

    <!-- Section d'en-tête avec filtres -->
    <div class="annonces-header">
        <div class="header-content">
            <div class="header-text">
                <h2 class="header-title">Trouvez votre prochaine mission</h2>
                <p class="header-subtitle">{{ $annonces->total() }} annonce(s) disponible(s)</p>
            </div>

        </div>
    </div>

    <!-- Liste des annonces -->
    <div class="annonces-container">
        @forelse($annonces as $annonce)
            <div class="annonce-card" data-domaine="{{ $annonce->domaine }}">
                <!-- Badge de statut -->
                <div class="annonce-badges">

                    <span class="badge badge-format">
                        <i
                            class="fas fa-{{ $annonce->format === 'en_ligne' ? 'laptop' : ($annonce->format === 'presentiel' ? 'user-friends' : 'globe') }}"></i>
                        {{ ucfirst(str_replace('_', ' ', $annonce->format)) }}
                    </span>
                </div>

                <!-- En-tête de la carte -->
                <div class="annonce-header">
                    <div class="student-info">
                        <div class="student-avatar">
                            @if ($annonce->student->photo_path && Storage::disk('public')->exists($annonce->student->photo_path))
                                <img src="{{ asset('storage/' . $annonce->student->photo_path) }}"
                                     alt="Photo de {{ $annonce->student->firstname }}">
                            @else
                                {{ strtoupper(substr($annonce->student->firstname, 0, 1) . substr($annonce->student->lastname, 0, 1)) }}
                            @endif
                        </div>
                        <div class="student-details">
                            <h3 class="student-name">{{ $annonce->student->firstname }} {{ $annonce->student->lastname }}
                            </h3>
                            <p class="student-meta">
                                <i class="fas fa-clock"></i>
                                Publié
                                {{ $annonce->published_at ? $annonce->published_at->diffForHumans() : $annonce->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="annonce-domain">
                        <span class="domain-tag">
                            <i class="fas fa-book"></i>
                            {{ ucfirst($annonce->domaine) }}
                        </span>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="annonce-body">
                    <h4 class="annonce-title">Mission de tutorat en {{ ucfirst($annonce->domaine) }}</h4>
                    <p class="annonce-description">{{ Str::limit($annonce->description, 200) }}</p>

                    <div class="annonce-details">
                        <div class="detail-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <div class="detail-content">
                                <span class="detail-label">Budget</span>
                                <span class="detail-value">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div class="detail-content">
                                <span class="detail-label">Disponibilité</span>
                                <span
                                    class="detail-value">{{ $annonce->disponibilite ? $annonce->disponibilite->format('d/m/Y') : 'Non spécifiée' }}</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-hand-holding-usd"></i>
                            <div class="detail-content">
                                <span class="detail-label">Acompte</span>
                                <span class="detail-value">{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pied de la carte -->
                <div class="annonce-footer">
                    @php
                        $hasApplied = \App\Models\Candidature::where('annonce_id', $annonce->id)
                            ->where('user_id', auth()->id())
                            ->exists();
                    @endphp
                    @if ($hasApplied)
                        <button class="btn-action btn-disabled" disabled>
                            <i class="fas fa-check-circle"></i>
                            Déjà postulé
                        </button>
                    @else
                        <form action="{{ route('annonce.postuler', $annonce->id) }}" method="POST"
                              style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-action btn-primary">
                                <i class="fas fa-paper-plane"></i>
                                Postuler maintenant
                            </button>
                        </form>
                    @endif

                    <button class="btn-action btn-secondary" onclick="voirDetails('{{ $annonce->hashid }}')">
                        <i class="fas fa-eye"></i>
                        Voir les détails
                    </button>

                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="empty-title">Aucune annonce disponible</h3>
                <p class="empty-text">Il n'y a pas d'annonces disponibles pour le moment. Revenez plus tard !</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($annonces->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                Affichage de {{ $annonces->firstItem() }} à {{ $annonces->lastItem() }} sur {{ $annonces->total() }}
                annonces
            </div>
            <div class="pagination-links">
                {{ $annonces->links() }}
            </div>
        </div>
    @endif

@endsection

@push('styles')
    <style>
        /* En-tête des annonces */
        .annonces-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 32px;
            box-shadow: 0 10px 30px rgba(3, 81, 188, 0.2);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .header-text {
            color: var(--white);
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--white);
        }

        .header-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .header-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-box i {
            position: absolute;
            left: 16px;
            color: var(--dark-gray);
        }

        .search-box input {
            padding: 12px 16px 12px 44px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            min-width: 280px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-select {
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            background-color: var(--white);
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Container des annonces */
        .annonces-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        /* Carte d'annonce */
        .annonce-card {
            background-color: var(--white);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .annonce-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary-color), var(--primary-light));
        }

        .annonce-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(3, 81, 188, 0.15);
            border-color: var(--primary-light);
        }

        /* Badges */
        .annonce-badges {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-publiee {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-en_paiement {
            background-color: #fed7aa;
            color: #92400e;
        }

        .badge-format {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge i {
            font-size: 8px;
        }

        /* En-tête de la carte */
        .annonce-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 16px;
        }

        .student-info {
            display: flex;
            gap: 12px;
            flex: 1;
        }

        .student-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-details {
            flex: 1;
        }

        .student-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .student-meta {
            font-size: 13px;
            color: var(--dark-gray);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .annonce-domain {
            flex-shrink: 0;
        }

        .domain-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: var(--white);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Corps de la carte */
        .annonce-body {
            margin-bottom: 20px;
        }

        .annonce-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .annonce-description {
            font-size: 14px;
            color: var(--dark-gray);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .annonce-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px;
            background-color: var(--light-gray);
            border-radius: 8px;
        }

        .detail-item i {
            color: var(--primary-color);
            font-size: 20px;
            margin-top: 2px;
        }

        .detail-content {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .detail-label {
            font-size: 12px;
            color: var(--dark-gray);
            font-weight: 500;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Pied de la carte */
        .annonce-footer {
            display: flex;
            gap: 12px;
            padding-top: 20px;
            border-top: 1px solid var(--medium-gray);
        }

        .btn-apply,
        .btn-details {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: var(--white);
            box-shadow: 0 4px 12px rgba(3, 81, 188, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(3, 81, 188, 0.4);
        }

        .btn-disabled {
            background-color: var(--medium-gray);
            color: var(--dark-gray);
            cursor: not-allowed;
            opacity: 0.7;
        }

        .btn-details {
            background-color: var(--white);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-details:hover {
            background-color: var(--primary-color);
            color: var(--white);
        }

        /* État vide */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background-color: var(--white);
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .empty-icon {
            font-size: 80px;
            color: var(--medium-gray);
            margin-bottom: 24px;
        }

        .empty-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .empty-text {
            font-size: 16px;
            color: var(--dark-gray);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            flex-wrap: wrap;
            gap: 16px;
        }

        .pagination-info {
            font-size: 14px;
            color: var(--dark-gray);
        }

        .pagination-links {
            display: flex;
            gap: 8px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .annonces-container {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .search-box input {
                width: 100%;
                min-width: auto;
            }

            .filter-select {
                width: 100%;
            }

            .annonces-container {
                grid-template-columns: 1fr;
            }

            .annonce-details {
                grid-template-columns: 1fr;
            }

            .annonce-footer {
                flex-direction: column;
            }

            .pagination-container {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .annonces-header {
                padding: 20px;
            }

            .header-title {
                font-size: 22px;
            }

            .annonce-card {
                padding: 16px;
            }

            .annonce-header {
                flex-direction: column;
            }

            .domain-tag {
                align-self: flex-start;
            }
        }

        .btn-action {
            padding: 10px 16px;
            min-width: 170px;
            /* garantit même largeur */
            font-size: 14px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-primary {
            background-color: #0d6efd;
            color: #fff;
            border: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }

        .btn-disabled {
            background-color: #adb5bd;
            color: #fff;
            border: none;
            cursor: not-allowed;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Fonction pour postuler à une annonce
        function postuler(annonceId) {
            if (confirm('Êtes-vous sûr de vouloir postuler à cette annonce ?')) {
                fetch(`/candidatures/${annonceId}/postuler`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Votre candidature a été envoyée avec succès !');
                            location.reload();
                        } else {
                            alert(data.message || 'Une erreur est survenue');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de l\'envoi de votre candidature');
                    });
            }
        }

        // Fonction pour voir les détails
        function voirDetails(annonceId) {
            window.location.href = `/dashboardUsers/annonces/${annonceId}`;
        }

        // Recherche en temps réel
        document.getElementById('searchAnnonce')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const annonces = document.querySelectorAll('.annonce-card');

            annonces.forEach(annonce => {
                const text = annonce.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    annonce.style.display = '';
                } else {
                    annonce.style.display = 'none';
                }
            });
        });

        // Filtre par domaine
        document.getElementById('filterDomaine')?.addEventListener('change', function(e) {
            const selectedDomain = e.target.value.toLowerCase();
            const annonces = document.querySelectorAll('.annonce-card');

            annonces.forEach(annonce => {
                const domain = annonce.getAttribute('data-domaine').toLowerCase();
                if (selectedDomain === '' || domain === selectedDomain) {
                    annonce.style.display = '';
                } else {
                    annonce.style.display = 'none';
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========================================
            // SWEETALERT2 - Messages de succès/erreur
            // ========================================

            @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                background: '#008751', // Fond vert
                color: '#fff', // Texte blanc
                iconColor: '#fff', // Icône blanche
            });
            @endif


            @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '{{ session('error') }}',
                confirmButtonText: 'Compris',
                confirmButtonColor: '#e53e3e',
            });
            @endif

            @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                html: '<ul style="text-align:left; padding-left:20px;">' +
                    @foreach ($errors->all() as $error)
                        '<li>{{ $error }}</li>' +
                    @endforeach
                        '</ul>',
                confirmButtonText: 'Compris',
                confirmButtonColor: '#e53e3e',
            });
            @endif
        });
    </script>
@endpush
