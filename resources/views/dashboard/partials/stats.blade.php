@extends('layouts.dashboard')

@section('title', 'Conseils et Bonnes Pratiques - KOPIAO')

@section('content')
<div class="content-wrapper">
    {{-- En-tête de la page --}}
    <div class="page-header mb-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3 mb-2 font-weight-bold text-gray-900">
                        <i class="fas fa-lightbulb text-warning mr-2"></i>
                        Conseils et Bonnes Pratiques
                    </h1>
                    <p class="text-muted mb-0">Tout ce que vous devez savoir pour réussir sur KOPIAO</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Contenu principal --}}
    <div class="container-fluid">
        <div class="stats-container">
            <div class="row g-4">
                {{-- Conseil 1: Création d'annonce efficace --}}
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-gradient-to-br from-purple-50 to-white hover-lift">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h5 font-weight-bold text-gray-800 d-flex align-items-center gap-2 mb-0">
                                <i class="fas fa-bullhorn text-purple-600"></i>
                                Créer une Annonce Efficace
                            </h3>
                            <div class="icon-circle bg-purple-100">
                                <i class="fas fa-lightbulb text-purple-700"></i>
                            </div>
                        </div>

                        <div class="conseil-content">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                                    <span class="small"><strong>Soyez précis</strong> sur vos besoins de formation</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                                    <span class="small"><strong>Indiquez votre budget</strong> réaliste (acompte 20-30%)</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                                    <span class="small"><strong>Précisez vos disponibilités</strong> (date/heure)</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                                    <span class="small"><strong>Choisissez le format</strong> : présentiel ou en ligne</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-3 p-2 bg-purple-100 rounded text-center">
                            <small class="text-purple-800">
                                <i class="fas fa-info-circle"></i>
                                Plus votre annonce est détaillée, plus vous recevrez de candidatures qualifiées
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 2: Sécurité du paiement --}}
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-gradient-to-br from-green-50 to-white hover-lift">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h5 font-weight-bold text-gray-800 d-flex align-items-center gap-2 mb-0">
                                <i class="fas fa-shield-alt text-green-600"></i>
                                Paiement Sécurisé
                            </h3>
                            <div class="icon-circle bg-green-100">
                                <i class="fas fa-lock text-green-700"></i>
                            </div>
                        </div>

                        <div class="conseil-content">
                            <div class="alert alert-success mb-3 py-2">
                                <strong class="d-flex align-items-center gap-2">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Comment ça marche ?
                                </strong>
                            </div>
                            <ol class="mb-0 pl-3">
                                <li class="small mb-2">
                                    <strong>Acompte sécurisé</strong> : Payez 20-30% de votre budget
                                </li>
                                <li class="small mb-2">
                                    <strong>Protection garantie</strong> : Remboursé si cours non délivré
                                </li>
                                <li class="small mb-2">
                                    <strong>Déblocage automatique</strong> : Quand vous confirmez le début
                                </li>
                                <li class="small mb-2">
                                    <strong>Solde restant</strong> : Payez directement au tuteur
                                </li>
                            </ol>
                        </div>

                        <div class="mt-3 p-2 bg-green-100 rounded text-center">
                            <small class="text-green-800">
                                <i class="fas fa-check-double"></i>
                                Votre argent est protégé jusqu'au début du cours
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 3: Sélection du tuteur --}}
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-gradient-to-br from-blue-50 to-white hover-lift">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h5 font-weight-bold text-gray-800 d-flex align-items-center gap-2 mb-0">
                                <i class="fas fa-user-check text-blue-600"></i>
                                Choisir le Bon Tuteur
                            </h3>
                            <div class="icon-circle bg-blue-100">
                                <i class="fas fa-graduation-cap text-blue-700"></i>
                            </div>
                        </div>

                        <div class="conseil-content">
                            <p class="small mb-2"><strong>Critères importants :</strong></p>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-star text-warning mr-2 mt-1"></i>
                                    <span class="small">Consultez les <strong>avis et notes</strong> des autres étudiants</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-certificate text-primary mr-2 mt-1"></i>
                                    <span class="small">Vérifiez les <strong>compétences</strong> et expérience</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-comments text-info mr-2 mt-1"></i>
                                    <span class="small">Lisez les <strong>messages de candidature</strong> personnalisés</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-badge-check text-success mr-2 mt-1"></i>
                                    <span class="small">Badge <strong>"Premium"</strong> = tuteur sérieux et engagé</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-3 p-2 bg-blue-100 rounded text-center">
                            <small class="text-blue-800">
                                <i class="fas fa-eye"></i>
                                Contacts débloqués uniquement après votre choix
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 4: Sécurité du compte --}}
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-gradient-to-br from-red-50 to-white hover-lift">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h5 font-weight-bold text-gray-800 d-flex align-items-center gap-2 mb-0">
                                <i class="fas fa-key text-red-600"></i>
                                Sécurité du Compte
                            </h3>
                            <div class="icon-circle bg-red-100">
                                <i class="fas fa-user-shield text-red-700"></i>
                            </div>
                        </div>

                        <div class="conseil-content">
                            <div class="alert alert-danger mb-3 py-2">
                                <strong class="d-flex align-items-center gap-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Protection Essentielle
                                </strong>
                            </div>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-lock text-danger mr-2 mt-1"></i>
                                    <span class="small"><strong>Mot de passe fort</strong> : min. 8 caractères, symboles</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-ban text-danger mr-2 mt-1"></i>
                                    <span class="small"><strong>Ne partagez jamais</strong> vos identifiants</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-eye-slash text-danger mr-2 mt-1"></i>
                                    <span class="small"><strong>Infos personnelles</strong> masquées jusqu'à sélection</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-flag text-danger mr-2 mt-1"></i>
                                    <span class="small"><strong>Signalez</strong> tout comportement abusif</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-3 p-2 bg-red-100 rounded text-center">
                            <small class="text-red-800">
                                <i class="fas fa-shield-virus"></i>
                                Vos données sont cryptées et protégées
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 5: Compléter son profil --}}
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-gradient-to-br from-yellow-50 to-white hover-lift">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h5 font-weight-bold text-gray-800 d-flex align-items-center gap-2 mb-0">
                                <i class="fas fa-user-edit text-yellow-600"></i>
                                Profil à 100%
                            </h3>
                            <div class="icon-circle bg-yellow-100">
                                <i class="fas fa-percent text-yellow-700"></i>
                            </div>
                        </div>

                        <div class="conseil-content">
                            <div class="progress mb-3" style="height: 25px;">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                     role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                    <strong>100% Complet</strong>
                                </div>
                            </div>

                            <p class="small mb-2"><strong>Éléments à compléter :</strong></p>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-camera text-warning mr-2 mt-1"></i>
                                    <span class="small"><strong>Photo de profil</strong> professionnelle</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-file-alt text-warning mr-2 mt-1"></i>
                                    <span class="small"><strong>Description</strong> de vos objectifs d'apprentissage</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-calendar-check text-warning mr-2 mt-1"></i>
                                    <span class="small"><strong>Disponibilités</strong> régulières</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-tag text-warning mr-2 mt-1"></i>
                                    <span class="small"><strong>Domaines d'intérêt</strong> précis</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-3 p-2 bg-yellow-100 rounded text-center">
                            <small class="text-yellow-800">
                                <i class="fas fa-thumbs-up"></i>
                                Un profil complet = plus de tuteurs intéressés
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 6: Système de notation --}}
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-gradient-to-br from-indigo-50 to-white hover-lift">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h5 font-weight-bold text-gray-800 d-flex align-items-center gap-2 mb-0">
                                <i class="fas fa-star-half-alt text-indigo-600"></i>
                                Avis & Réputation
                            </h3>
                            <div class="icon-circle bg-indigo-100">
                                <i class="fas fa-award text-indigo-700"></i>
                            </div>
                        </div>

                        <div class="conseil-content">
                            <div class="text-center mb-3">
                                <div class="display-4 mb-2">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="small text-muted mb-0">Notation obligatoire après le cours</p>
                            </div>

                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-exchange-alt text-indigo-600 mr-2 mt-1"></i>
                                    <span class="small"><strong>Avis croisés</strong> : vous notez le tuteur, il vous note</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-history text-indigo-600 mr-2 mt-1"></i>
                                    <span class="small"><strong>Historique public</strong> pour la transparence</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-shield-alt text-indigo-600 mr-2 mt-1"></i>
                                    <span class="small"><strong>Protection</strong> : 2 incidents = blocage automatique</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-3 p-2 bg-indigo-100 rounded text-center">
                            <small class="text-indigo-800">
                                <i class="fas fa-handshake"></i>
                                Votre réputation aide les futurs tuteurs
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 7: Délais et rappels --}}
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-gradient-to-br from-teal-50 to-white hover-lift">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h5 font-weight-bold text-gray-800 d-flex align-items-center gap-2 mb-0">
                                <i class="fas fa-clock text-teal-600"></i>
                                Délais Importants
                            </h3>
                            <div class="icon-circle bg-teal-100">
                                <i class="fas fa-bell text-teal-700"></i>
                            </div>
                        </div>

                        <div class="conseil-content">
                            <div class="timeline-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="timeline-marker bg-success">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="ml-3">
                                        <strong class="small d-block">Confirmation début de cours</strong>
                                        <small class="text-muted">Cliquez dès que le cours commence</small>
                                    </div>
                                </div>
                            </div>

                            <div class="timeline-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="timeline-marker bg-warning">
                                        <i class="fas fa-exclamation"></i>
                                    </div>
                                    <div class="ml-3">
                                        <strong class="small d-block">Délai de 7 jours</strong>
                                        <small class="text-muted">Rappel automatique si pas de confirmation</small>
                                    </div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="d-flex align-items-start">
                                    <div class="timeline-marker bg-danger">
                                        <i class="fas fa-undo"></i>
                                    </div>
                                    <div class="ml-3">
                                        <strong class="small d-block">Remboursement automatique</strong>
                                        <small class="text-muted">Après 7 jours sans confirmation</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 p-2 bg-teal-100 rounded text-center">
                            <small class="text-teal-800">
                                <i class="fas fa-info-circle"></i>
                                Confirmez rapidement pour libérer l'acompte au tuteur
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 8: Support et aide --}}
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-gradient-to-br from-pink-50 to-white hover-lift">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h5 font-weight-bold text-gray-800 d-flex align-items-center gap-2 mb-0">
                                <i class="fas fa-headset text-pink-600"></i>
                                Besoin d'Aide ?
                            </h3>
                            <div class="icon-circle bg-pink-100">
                                <i class="fas fa-question-circle text-pink-700"></i>
                            </div>
                        </div>

                        <div class="conseil-content">
                            <p class="small mb-3"><strong>Ressources disponibles :</strong></p>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none d-flex align-items-center gap-2 small hover-link">
                                        <i class="fas fa-book text-pink-600"></i>
                                        <span><strong>FAQ Étudiants</strong> - Réponses rapides</span>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none d-flex align-items-center gap-2 small hover-link">
                                        <i class="fas fa-play-circle text-pink-600"></i>
                                        <span><strong>Tutoriels Vidéo</strong> - Guides pas à pas</span>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none d-flex align-items-center gap-2 small hover-link">
                                        <i class="fas fa-envelope text-pink-600"></i>
                                        <span><strong>Support Email</strong> - support@kopiao.com</span>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none d-flex align-items-center gap-2 small hover-link">
                                        <i class="fab fa-whatsapp text-pink-600"></i>
                                        <span><strong>WhatsApp</strong> - Assistance rapide</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-3 p-2 bg-pink-100 rounded text-center">
                            <small class="text-pink-800">
                                <i class="fas fa-comments"></i>
                                Notre équipe répond en moins de 2h
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 9: Avantages plateforme --}}
                <div class="col-md-6 col-lg-4">
                    <div class="stat-card enhanced-card p-4 rounded-4 shadow-lg bg-gradient-to-br from-cyan-50 to-white hover-lift">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="h5 font-weight-bold text-gray-800 d-flex align-items-center gap-2 mb-0">
                                <i class="fas fa-rocket text-cyan-600"></i>
                                Pourquoi KOPIAO ?
                            </h3>
                            <div class="icon-circle bg-cyan-100">
                                <i class="fas fa-heart text-cyan-700"></i>
                            </div>
                        </div>

                        <div class="conseil-content">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-bolt text-warning mr-2 mt-1"></i>
                                    <div>
                                        <strong class="small d-block">Apprentissage Rapide</strong>
                                        <small class="text-muted">Trouvez un tuteur en 24-48h</small>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-shield-check text-success mr-2 mt-1"></i>
                                    <div>
                                        <strong class="small d-block">100% Sécurisé</strong>
                                        <small class="text-muted">Acompte protégé, paiement garanti</small>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-users text-primary mr-2 mt-1"></i>
                                    <div>
                                        <strong class="small d-block">Tuteurs Qualifiés</strong>
                                        <small class="text-muted">Professionnels vérifiés et notés</small>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-calendar-alt text-info mr-2 mt-1"></i>
                                    <div>
                                        <strong class="small d-block">À Votre Rythme</strong>
                                        <small class="text-muted">Choisissez vos horaires et format</small>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-3 p-2 bg-cyan-100 rounded text-center">
                            <small class="text-cyan-800">
                                <i class="fas fa-graduation-cap"></i>
                                "Publiez, choisissez, apprenez !"
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Content wrapper pour éviter le collage à gauche */
.content-wrapper {
    width: 100%;
    padding: 20px;
    margin-left: 0;
}

/* Page header */
.page-header {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

/* Gradients */
.bg-gradient-to-br {
    background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}

.from-purple-50 { --tw-gradient-from: #faf5ff; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(250, 245, 255, 0)); }
.from-green-50 { --tw-gradient-from: #f0fdf4; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(240, 253, 244, 0)); }
.from-blue-50 { --tw-gradient-from: #eff6ff; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(239, 246, 255, 0)); }
.from-red-50 { --tw-gradient-from: #fef2f2; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(254, 242, 242, 0)); }
.from-yellow-50 { --tw-gradient-from: #fefce8; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(254, 252, 232, 0)); }
.from-indigo-50 { --tw-gradient-from: #eef2ff; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(238, 242, 255, 0)); }
.from-teal-50 { --tw-gradient-from: #f0fdfa; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(240, 253, 250, 0)); }
.from-pink-50 { --tw-gradient-from: #fdf2f8; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(253, 242, 248, 0)); }
.from-cyan-50 { --tw-gradient-from: #ecfeff; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(236, 254, 255, 0)); }

.to-white { --tw-gradient-to: #ffffff; }

/* Cards spacing */
.row.g-4 {
    margin-right: -0.75rem;
    margin-left: -0.75rem;
}

.row.g-4 > [class*='col-'] {
    padding-right: 0.75rem;
    padding-left: 0.75rem;
    margin-bottom: 1.5rem;
}

/* Hover effect */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

/* Icon circle */
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.bg-purple-100 { background-color: #f3e8ff; }
.bg-green-100 { background-color: #dcfce7; }
.bg-blue-100 { background-color: #dbeafe; }
.bg-red-100 { background-color: #fee2e2; }
.bg-yellow-100 { background-color: #fef9c3; }
.bg-indigo-100 { background-color: #e0e7ff; }
.bg-teal-100 { background-color: #ccfbf1; }
.bg-pink-100 { background-color: #fce7f3; }
.bg-cyan-100 { background-color: #cffafe; }

.text-purple-600 { color: #9333ea; }
.text-purple-700 { color: #7e22ce; }
.text-purple-800 { color: #6b21a8; }
.text-green-600 { color: #16a34a; }
.text-green-700 { color: #15803d; }
.text-green-800 { color: #166534; }
.text-blue-600 { color: #2563eb; }
.text-blue-700 { color: #1d4ed8; }
.text-blue-800 { color: #1e40af; }
.text-red-600 { color: #dc2626; }
.text-red-700 { color: #b91c1c; }
.text-red-800 { color: #991b1b; }
.text-yellow-600 { color: #ca8a04; }
.text-yellow-700 { color: #a16207; }
.text-yellow-800 { color: #854d0e; }
.text-indigo-600 { color: #4f46e5; }
.text-indigo-700 { color: #4338ca; }
.text-indigo-800 { color: #3730a3; }
.text-teal-600 { color: #0d9488; }
.text-teal-700 { color: #0f766e; }
.text-teal-800 { color: #115e59; }
.text-pink-600 { color: #db2777; }
.text-pink-700 { color: #be185d; }
.text-pink-800 { color: #9f1239; }
.text-cyan-600 { color: #0891b2; }
.text-cyan-700 { color: #0e7490; }
.text-cyan-800 { color: #155e75; }

/* Timeline */
.timeline-item {
    position: relative;
}

.timeline-marker {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    flex-shrink: 0;
}

/* Hover link */
.hover-link {
    transition: all 0.2s ease;
    color: #6c757d;
}

.hover-link:hover {
    transform: translateX(5px);
    color: #db2777 !important;
}

/* Rounded */
.rounded-4 {
    border-radius: 1rem;
}

/* Conseil content */
.conseil-content {
    font-size: 0.9rem;
}

/* Gap utility */
.gap-2 {
    gap: 0.5rem;
}

/* Enhanced card */
.enhanced-card {
    height: 100%;
    border: none;
}

/* Responsive */
@media (max-width: 768px) {
    .content-wrapper {
        padding: 10px;
    }

    .row.g-4 > [class*='col-'] {
        margin-bottom: 1rem;
    }
}
</style>
@endpush
@endsection
