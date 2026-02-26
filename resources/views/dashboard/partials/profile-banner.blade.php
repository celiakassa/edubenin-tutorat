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

{{-- Section Conseils et Bonnes Pratiques - UNIQUEMENT POUR LES ÉTUDIANTS --}}
@if (auth()->user()->isEtudiant())
    <div class="profile-banner mt-4" style="padding: 30px;">

        {{-- Grille de conseils avec container-fluid pour prendre toute la largeur --}}
        <div class="container-fluid p-0">
            <div class="row" style="margin-left: -15px; margin-right: -15px;">
                {{-- Conseil 1: Création d'annonce efficace --}}
                <div class="col-md-6 col-lg-4 mb-4" style="padding-left: 15px; padding-right: 15px;">
                    <div class="conseil-card p-4 h-100"
                        style="background: linear-gradient(to bottom right, #faf5ff, #ffffff); border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="h6 font-weight-bold mb-0"
                                style="color: #2c3e50; display: flex; align-items: center;">
                                <i class="fas fa-bullhorn mr-2" style="color: #9333ea;"></i>
                                Créer une Annonce Efficace
                            </h4>
                            <div
                                style="width: 40px; height: 40px; background: #f3e8ff; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-lightbulb" style="color: #7e22ce;"></i>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-3" style="font-size: 0.9rem;">
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                                <span><strong>Soyez précis</strong> sur vos besoins de formation</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                                <span><strong>Indiquez votre budget</strong> réaliste (acompte 20-30%)</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                                <span><strong>Précisez vos disponibilités</strong> (date/heure)</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-check-circle text-success mr-2 mt-1"></i>
                                <span><strong>Choisissez le format</strong> : présentiel ou en ligne</span>
                            </li>
                        </ul>

                        <div class="p-2 text-center" style="background: #f3e8ff; border-radius: 8px;">
                            <small style="color: #6b21a8;">
                                <i class="fas fa-info-circle"></i>
                                Plus votre annonce est détaillée, plus vous recevrez de candidatures qualifiées
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 2: Sécurité du paiement --}}
                <div class="col-md-6 col-lg-4 mb-4" style="padding-left: 15px; padding-right: 15px;">
                    <div class="conseil-card p-4 h-100"
                        style="background: linear-gradient(to bottom right, #f0fdf4, #ffffff); border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="h6 font-weight-bold mb-0"
                                style="color: #2c3e50; display: flex; align-items: center;">
                                <i class="fas fa-shield-alt mr-2" style="color: #16a34a;"></i>
                                Paiement Sécurisé
                            </h4>
                            <div
                                style="width: 40px; height: 40px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-lock" style="color: #15803d;"></i>
                            </div>
                        </div>

                        <div class="alert alert-success mb-3 py-2">
                            <strong style="display: flex; align-items: center;">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                Comment ça marche ?
                            </strong>
                        </div>
                        <ol class="mb-3 pl-3" style="font-size: 0.9rem;">
                            <li class="mb-2"><strong>Acompte sécurisé</strong> : Payez 20-30% de votre budget</li>
                            <li class="mb-2"><strong>Protection garantie</strong> : Remboursé si cours non délivré
                            </li>
                            <li class="mb-2"><strong>Déblocage automatique</strong> : Quand vous confirmez le début
                            </li>
                            <li class="mb-2"><strong>Solde restant</strong> : Payez directement au tuteur</li>
                        </ol>

                        <div class="p-2 text-center" style="background: #dcfce7; border-radius: 8px;">
                            <small style="color: #166534;">
                                <i class="fas fa-check-double"></i>
                                Votre argent est protégé jusqu'au début du cours
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 4: Sécurité du compte --}}
                <div class="col-md-6 col-lg-4 mb-4" style="padding-left: 15px; padding-right: 15px;">
                    <div class="conseil-card p-4 h-100"
                        style="background: linear-gradient(to bottom right, #fef2f2, #ffffff); border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="h6 font-weight-bold mb-0"
                                style="color: #2c3e50; display: flex; align-items: center;">
                                <i class="fas fa-key mr-2" style="color: #dc2626;"></i>
                                Sécurité du Compte
                            </h4>
                            <div
                                style="width: 40px; height: 40px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-shield" style="color: #b91c1c;"></i>
                            </div>
                        </div>

                        <div class="alert alert-danger mb-3 py-2">
                            <strong style="display: flex; align-items: center;">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Protection Essentielle
                            </strong>
                        </div>
                        <ul class="list-unstyled mb-3" style="font-size: 0.9rem;">
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-lock text-danger mr-2 mt-1"></i>
                                <span><strong>Mot de passe fort</strong> : min. 8 caractères, symboles</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-ban text-danger mr-2 mt-1"></i>
                                <span><strong>Ne partagez jamais</strong> vos identifiants</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-eye-slash text-danger mr-2 mt-1"></i>
                                <span><strong>Infos personnelles</strong> masquées jusqu'à sélection</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-flag text-danger mr-2 mt-1"></i>
                                <span><strong>Signalez</strong> tout comportement abusif</span>
                            </li>
                        </ul>

                        <div class="p-2 text-center" style="background: #fee2e2; border-radius: 8px;">
                            <small style="color: #991b1b;">
                                <i class="fas fa-shield-virus"></i>
                                Vos données sont cryptées et protégées
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 5: Compléter son profil --}}
                <div class="col-md-6 col-lg-4 mb-4" style="padding-left: 15px; padding-right: 15px;">
                    <div class="conseil-card p-4 h-100"
                        style="background: linear-gradient(to bottom right, #fefce8, #ffffff); border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="h6 font-weight-bold mb-0"
                                style="color: #2c3e50; display: flex; align-items: center;">
                                <i class="fas fa-user-edit mr-2" style="color: #ca8a04;"></i>
                                Profil à 100%
                            </h4>
                            <div
                                style="width: 40px; height: 40px; background: #fef9c3; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-percent" style="color: #a16207;"></i>
                            </div>
                        </div>

                        <div class="progress mb-3" style="height: 25px; background: #e0e0e0; border-radius: 5px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                style="width: 100%;">
                                <strong>100% Complet</strong>
                            </div>
                        </div>

                        <p class="mb-2" style="font-size: 0.9rem;"><strong>Éléments à compléter :</strong></p>
                        <ul class="list-unstyled mb-3" style="font-size: 0.9rem;">
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-camera text-warning mr-2 mt-1"></i>
                                <span><strong>Photo de profil</strong> professionnelle</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-file-alt text-warning mr-2 mt-1"></i>
                                <span><strong>Description</strong> de vos objectifs d'apprentissage</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-calendar-check text-warning mr-2 mt-1"></i>
                                <span><strong>Disponibilités</strong> régulières</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-tag text-warning mr-2 mt-1"></i>
                                <span><strong>Domaines d'intérêt</strong> précis</span>
                            </li>
                        </ul>

                        <div class="p-2 text-center" style="background: #fef9c3; border-radius: 8px;">
                            <small style="color: #854d0e;">
                                <i class="fas fa-thumbs-up"></i>
                                Un profil complet = plus de tuteurs intéressés
                            </small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Effet hover sur les cartes */
        .conseil-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-banner {
                padding: 20px !important;
            }
        }
    </style>
@endif


@if(auth()->user()->isTuteur())

    <div class="profile-banner mt-4" style="padding: 30px;">

        {{-- Grille de conseils avec container-fluid pour prendre toute la largeur --}}
        <div class="container-fluid p-0">
            <div class="row" style="margin-left: -15px; margin-right: -15px;">




                {{-- Conseil 4: Sécurité du compte --}}
                <div class="col-md-6 col-lg-4 mb-4" style="padding-left: 15px; padding-right: 15px;">
                    <div class="conseil-card p-4 h-100"
                        style="background: linear-gradient(to bottom right, #fef2f2, #ffffff); border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="h6 font-weight-bold mb-0"
                                style="color: #2c3e50; display: flex; align-items: center;">
                                <i class="fas fa-key mr-2" style="color: #dc2626;"></i>
                                Sécurité du Compte
                            </h4>
                            <div
                                style="width: 40px; height: 40px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-shield" style="color: #b91c1c;"></i>
                            </div>
                        </div>

                        <div class="alert alert-danger mb-3 py-2">
                            <strong style="display: flex; align-items: center;">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Protection Essentielle
                            </strong>
                        </div>
                        <ul class="list-unstyled mb-3" style="font-size: 0.9rem;">
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-lock text-danger mr-2 mt-1"></i>
                                <span><strong>Mot de passe fort</strong> : min. 8 caractères, symboles</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-ban text-danger mr-2 mt-1"></i>
                                <span><strong>Ne partagez jamais</strong> vos identifiants</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-eye-slash text-danger mr-2 mt-1"></i>
                                <span><strong>Infos personnelles</strong> masquées jusqu'à sélection</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-flag text-danger mr-2 mt-1"></i>
                                <span><strong>Signalez</strong> tout comportement abusif</span>
                            </li>
                        </ul>

                        <div class="p-2 text-center" style="background: #fee2e2; border-radius: 8px;">
                            <small style="color: #991b1b;">
                                <i class="fas fa-shield-virus"></i>
                                Vos données sont cryptées et protégées
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Conseil 5: Compléter son profil --}}
                <div class="col-md-6 col-lg-4 mb-4" style="padding-left: 15px; padding-right: 15px;">
                    <div class="conseil-card p-4 h-100"
                        style="background: linear-gradient(to bottom right, #fefce8, #ffffff); border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="h6 font-weight-bold mb-0"
                                style="color: #2c3e50; display: flex; align-items: center;">
                                <i class="fas fa-user-edit mr-2" style="color: #ca8a04;"></i>
                                Profil à 100%
                            </h4>
                            <div
                                style="width: 40px; height: 40px; background: #fef9c3; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-percent" style="color: #a16207;"></i>
                            </div>
                        </div>

                        <div class="progress mb-3" style="height: 25px; background: #e0e0e0; border-radius: 5px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                style="width: 100%;">
                                <strong>100% Complet</strong>
                            </div>
                        </div>

                        <p class="mb-2" style="font-size: 0.9rem;"><strong>Éléments à compléter :</strong></p>
                        <ul class="list-unstyled mb-3" style="font-size: 0.9rem;">
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-camera text-warning mr-2 mt-1"></i>
                                <span><strong>Photo de profil</strong> professionnelle</span>
                            </li>
                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-file-alt text-warning mr-2 mt-1"></i>
                                <span><strong>Description</strong> de vos objectifs</span>
                            </li>

                            <li class="mb-2 d-flex align-items-start">
                                <i class="fas fa-tag text-warning mr-2 mt-1"></i>
                                <span><strong>Domaines d'intérêt</strong> précis</span>
                            </li>
                        </ul>

                        <div class="p-2 text-center" style="background: #fef9c3; border-radius: 8px;">
                            <small style="color: #854d0e;">
                                <i class="fas fa-thumbs-up"></i>
                                Un profil complet
                            </small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Effet hover sur les cartes */
        .conseil-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-banner {
                padding: 20px !important;
            }
        }
    </style>

@endif
