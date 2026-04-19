@extends('layouts.welcomeLayout')

@section('content')
<div class="faq-page py-5">
    <div class="container">
        <!-- En-tête -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="display-4 fw-bold" style="color: #0B69F1;">Foire Aux Questions</h1>
            <p class="lead text-muted">Trouvez rapidement des réponses à vos questions</p>
            <div class="divider mx-auto" style="width: 80px; height: 4px; background: #0B69F1; border-radius: 2px;"></div>
        </div>

        <!-- Navigation des catégories -->
        <div class="category-nav mb-5" data-aos="fade-up">
            <div class="row justify-content-center g-3">
                <div class="col-md-3 col-6">
                    <a href="#etudiants" class="category-link text-decoration-none">
                        <div class="category-card bg-white rounded-4 shadow-sm p-3 text-center">
                            <div class="category-icon mb-2">
                                <i class="bi bi-mortarboard" style="font-size: 2rem; color: #0B69F1;"></i>
                            </div>
                            <span class="fw-semibold" style="color: #333;">Apprenants</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="#tuteurs" class="category-link text-decoration-none">
                        <div class="category-card bg-white rounded-4 shadow-sm p-3 text-center">
                            <div class="category-icon mb-2">
                                <i class="bi bi-person-workspace" style="font-size: 2rem; color: #00a36c;"></i>
                            </div>
                            <span class="fw-semibold" style="color: #333;">Tuteurs</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Section Apprenants -->
        <section id="etudiants" class="mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-4 pb-2" style="color: #0B69F1; border-bottom: 3px solid #0B69F1;">
                <i class="bi bi-mortarboard me-2"></i>Questions des Apprenants
            </h2>

            <!-- A. Création et publication d'une annonce -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Création et publication d'une annonce
                </h3>
                <div class="accordion" id="accordionEtudiantA">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE1">
                                Comment créer une annonce ?
                            </button>
                        </h2>
                        <div id="collapseE1" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantA">
                            <div class="accordion-body bg-light">
                                <p>Pour créer une annonce :</p>
                                <ol>
                                    <li>Connectez-vous à votre compte étudiant</li>
                                    <li>Cliquez sur "Publier une annonce" dans votre tableau de bord</li>
                                    <li>Sélectionnez le domaine/matière souhaité</li>
                                    <li>Décrivez précisément votre besoin (niveau, objectifs, difficultés)</li>
                                    <li>Indiquez votre budget total (ex: 50 000 FCFA)</li>
                                    <li>Précisez vos disponibilités (jours et heures)</li>
                                    <li>Soumettez votre annonce</li>
                                </ol>
                                <p class="mb-0"><strong>Important :</strong> Votre annonce ne sera pas visible immédiatement. Elle le deviendra seulement après paiement de l'acompte.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE2">
                                Quand mon annonce devient-elle visible pour les tuteurs ?
                            </button>
                        </h2>
                        <div id="collapseE2" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantA">
                            <div class="accordion-body bg-light">
                                <p>Votre annonce devient visible uniquement après le <strong>paiement d'un acompte de 30%</strong> de votre budget total.</p>
                                <p>Exemple : Si votre budget total est de 50 000 FCFA, vous devrez payer 15 000 FCFA d'acompte pour que votre annonce soit publiée.</p>
                                <p class="mb-0">Cet acompte garantit votre sérieux et sera déduit du montant final à payer au tuteur.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE3">
                                Puis-je modifier mon annonce après publication ?
                            </button>
                        </h2>
                        <div id="collapseE3" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantA">
                            <div class="accordion-body bg-light">
                                <p>Oui, vous pouvez modifier votre annonce tant qu'elle n'a pas été attribuée à un tuteur. Une fois qu'un tuteur est sélectionné, l'annonce est verrouillée.</p>
                                <p>Pour modifier : allez dans "Mes annonces" et cliquez sur le bouton modifier.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE4">
                                Combien de temps mon annonce reste visible ?
                            </button>
                        </h2>
                        <div id="collapseE4" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantA">
                            <div class="accordion-body bg-light">
                                <p>Votre annonce reste visible <strong>30 jours</strong> après sa publication. Passé ce délai, si aucun tuteur n'a été choisi, elle sera automatiquement archivée.</p>
                                <p>Vous pouvez à tout moment la republier pour 30 jours supplémentaires (sans frais supplémentaires).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- B. Paiement et acompte -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Paiement et acompte
                </h3>
                <div class="accordion" id="accordionEtudiantB">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE5">
                                Pourquoi dois-je payer un acompte ?
                            </button>
                        </h2>
                        <div id="collapseE5" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantB">
                            <div class="accordion-body bg-light">
                                <p>L'acompte de 30% est obligatoire pour :</p>
                                <ul>
                                    <li><strong>Garantir votre sérieux</strong> : Évite les annonces fictives</li>
                                    <li><strong>Protéger les tuteurs</strong> : Ils savent que vous êtes réellement intéressé</li>
                                    <li><strong>Déduire du paiement final</strong> : Cette somme sera déduite du montant total à payer au tuteur</li>
                                    <li><strong>Frais de plateforme</strong> : Une petite partie couvre les frais de fonctionnement</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE6">
                                Quand l'acompte est-il reversé au tuteur ?
                            </button>
                        </h2>
                        <div id="collapseE6" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantB">
                            <div class="accordion-body bg-light">
                                <p>L'acompte est reversé au tuteur <strong>après la première séance de cours</strong>, une fois que vous avez confirmé que la séance a bien eu lieu.</p>
                                <p>Si vous ne confirmez pas dans les 48h, l'acompte est automatiquement reversé au tuteur.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE7">
                                Que se passe-t-il si j'annule ma demande ?
                            </button>
                        </h2>
                        <div id="collapseE7" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantB">
                            <div class="accordion-body bg-light">
                                <p>Si vous annulez :</p>
                                <ul>
                                    <li><strong>Avant d'avoir choisi un tuteur</strong> : L'acompte vous est remboursé intégralement (sous 5-7 jours ouvrés)</li>
                                    <li><strong>Après avoir choisi un tuteur mais avant le cours</strong> : L'acompte est reversé au tuteur pour compenser sa disponibilité</li>
                                    <li><strong>Moins de 24h avant le cours</strong> : L'acompte est intégralement reversé au tuteur</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE8">
                                Que se passe-t-il si le tuteur annule ?
                            </button>
                        </h2>
                        <div id="collapseE8" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantB">
                            <div class="accordion-body bg-light">
                                <p>Dans ce cas :</p>
                                <ol>
                                    <li>Vous recevez une notification immédiate</li>
                                    <li>L'acompte vous est intégralement remboursé</li>
                                    <li>Le tuteur peut être sanctionné (avertissement, suspension)</li>
                                    <li>Vous pouvez republier votre annonce gratuitement</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- C. Sélection d'un tuteur -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Sélection d'un tuteur
                </h3>
                <div class="accordion" id="accordionEtudiantC">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE9">
                                Comment choisir un tuteur ?
                            </button>
                        </h2>
                        <div id="collapseE9" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantC">
                            <div class="accordion-body bg-light">
                                <p>Pour choisir un tuteur :</p>
                                <ol>
                                    <li>Consultez les candidatures reçues sur votre annonce</li>
                                    <li>Vérifiez leur profil (qualifications, expérience)</li>
                                    <li>Lisez les avis des anciens étudiants</li>
                                    <li>Comparez leurs propositions</li>
                                    <li>Cliquez sur "Accepter" pour la candidature qui vous convient</li>
                                </ol>
                                <p>Une fois le tuteur sélectionné, ses coordonnées vous seront dévoilées pour organiser le cours.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE10">
                                Comment savoir si un tuteur est fiable ?
                            </button>
                        </h2>
                        <div id="collapseE10" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantC">
                            <div class="accordion-body bg-light">
                                <p>Plusieurs indicateurs de fiabilité :</p>
                                <ul>
                                    <li><strong>Badge "Tuteur vérifié"</strong> : identité vérifiée par nos soins</li>
                                    <li><strong>Avis et notations</strong> : lisez les retours des autres étudiants</li>
                                    <li><strong>Profil complet</strong> : photo, diplômes, expérience détaillée</li>
                                    <li><strong>Nombre de cours donnés</strong> : un tuteur expérimenté inspire confiance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Tuteurs -->
        <section id="tuteurs" class="mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-4 pb-2" style="color: #00a36c; border-bottom: 3px solid #00a36c;">
                <i class="bi bi-person-workspace me-2"></i>Espace Tuteurs
            </h2>

            <!-- A. Abonnement et accès aux annonces -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Abonnement et accès aux annonces
                </h3>
                <div class="accordion" id="accordionTuteurA">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT1">
                                Comment fonctionne l'abonnement pour postuler ?
                            </button>
                        </h2>
                        <div id="collapseT1" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurA">
                            <div class="accordion-body bg-light">
                                <p><strong>Un abonnement est obligatoire pour postuler aux annonces.</strong></p>
                                <p>L'abonnement mensuel de <strong>6 500 FCFA</strong> vous donne :</p>
                                <ul>
                                    <li>Accès illimité aux annonces dans vos domaines</li>
                                    <li>Possibilité de postuler sans limitation</li>
                                    <li>Notifications en temps réel des nouvelles annonces</li>
                                    <li>Déblocage des contacts étudiants après sélection</li>
                                    <li>Visibilité accrue de votre profil</li>
                                </ul>
                                <p>Sans abonnement, vous pouvez consulter les annonces mais pas postuler.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT2">
                                Quelles annonces puis-je voir ?
                            </button>
                        </h2>
                        <div id="collapseT2" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurA">
                            <div class="accordion-body bg-light">
                                <p>Vous ne voyez que les annonces correspondant à vos <strong>domaines d'expertise</strong> déclarés dans votre profil.</p>
                                <p>Exemple : Si vous avez choisi "Mathématiques" et "Physique", vous verrez uniquement les annonces dans ces matières, pas celles en Français ou en Histoire.</p>
                                <p>Pour voir plus d'annonces, vous pouvez enrichir vos domaines d'expertise dans votre profil.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT3">
                                Puis-je voir le budget de l'étudiant avant de postuler ?
                            </button>
                        </h2>
                        <div id="collapseT3" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurA">
                            <div class="accordion-body bg-light">
                                <p><strong>Oui, le budget total est visible sur chaque annonce.</strong></p>
                                <p>Cela vous permet de savoir si la mission correspond à vos attentes avant même de postuler. L'acompte de 30% que l'étudiant a payé n'est pas visible, seul le budget total est affiché.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- B. Postuler aux annonces -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Postuler aux annonces
                </h3>
                <div class="accordion" id="accordionTuteurB">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT4">
                                Comment postuler à une annonce ?
                            </button>
                        </h2>
                        <div id="collapseT4" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurB">
                            <div class="accordion-body bg-light">
                                <ol>
                                    <li>Connectez-vous avec un abonnement actif</li>
                                    <li>Parcourez les annonces dans votre domaine</li>
                                    <li>Cliquez sur "Voir les détails" de l'annonce qui vous intéresse</li>
                                    <li>Vérifiez les informations (budget, disponibilités, description)</li>
                                    <li>Cliquez sur "Postuler"</li>
                                    <li>Attendez que l'étudiant examine votre candidature</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT5">
                                Combien de candidatures puis-je envoyer ?
                            </button>
                        </h2>
                        <div id="collapseT5" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurB">
                            <div class="accordion-body bg-light">
                                <p><strong>Avec un abonnement, vous pouvez postuler sans limitation</strong> - aucune limite de candidatures !</p>
                                <p>Nous encourageons même à postuler régulièrement pour augmenter vos chances de trouver des missions.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT6">
                                Comment savoir si ma candidature est retenue ?
                            </button>
                        </h2>
                        <div id="collapseT6" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurB">
                            <div class="accordion-body bg-light">
                                <p>Vous recevrez une notification dans les cas suivants :</p>
                                <ul>
                                    <li><strong>Acceptée</strong> : L'étudiant vous a choisi, ses coordonnées vous sont dévoilées</li>
                                    <li><strong>Refusée</strong> : L'étudiant a choisi un autre tuteur</li>
                                    <li><strong>Expirée</strong> : L'annonce a expiré sans choix</li>
                                </ul>
                                <p>Vous pouvez aussi suivre l'état de vos candidatures dans votre tableau de bord.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- C. Contacts et suivi -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Contacts et suivi
                </h3>
                <div class="accordion" id="accordionTuteurC">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT7">
                                Quand puis-je voir les coordonnées de l'étudiant ?
                            </button>
                        </h2>
                        <div id="collapseT7" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurC">
                            <div class="accordion-body bg-light">
                                <p>Les coordonnées de l'étudiant (téléphone, email) ne sont dévoilées qu'<strong>après que l'étudiant vous ait sélectionné</strong>.</p>
                                <p>Cette mesure protège la vie privée des étudiants et évite les contacts non sollicités.</p>
                                <p>Une fois sélectionné, vous pourrez le contacter directement pour organiser les cours.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT8">
                                Comment recevoir les paiements ?
                            </button>
                        </h2>
                        <div id="collapseT8" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurC">
                            <div class="accordion-body bg-light">
                                <p>Le paiement se fait en deux temps :</p>
                                <ol>
                                    <li><strong>L'acompte (30%)</strong> : Versé par l'étudiant à la création de l'annonce, il vous est reversé après la première séance</li>
                                    <li><strong>Le solde (70%)</strong> : À organiser directement avec l'étudiant selon vos modalités (espèces, virement, mobile money)</li>
                                </ol>
                                <p>L'acompte vous est versé sur votre compte bancaire ou mobile money (selon vos préférences).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Support avec Modal -->
        <div class="support-cta text-center mt-5 p-5 bg-white rounded-4 shadow-sm" data-aos="fade-up">
            <i class="bi bi-headset" style="font-size: 3rem; color: #0B69F1;"></i>
            <h3 class="fw-bold mt-3 mb-3">Vous n'avez pas trouvé votre réponse ?</h3>
            <p class="text-muted mb-4">Notre équipe est là pour vous aider</p>
            <button type="button" class="btn btn-primary px-5 py-3 rounded-pill" id="openSupportModalBtn"
               style="background: #0B69F1; border: none;">
                <i class="bi bi-envelope me-2"></i>Contacter le support
            </button>
        </div>
    </div>
</div>

<!-- Modal Support - Formulaire de contact -->
<div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #0B69F1; color: white;">
                <h5 class="modal-title" id="supportModalLabel">
                    <i class="bi bi-headset me-2"></i> Contacter le support
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-4">Veuillez remplir ce formulaire. Votre client email s'ouvrira avec les informations pré-remplies.</p>

                <form id="supportForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="supportName" class="form-label fw-semibold">
                                <i class="bi bi-person me-1" style="color: #0B69F1;"></i> Nom complet <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="supportName" placeholder="Jean Dupont" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supportEmail" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1" style="color: #0B69F1;"></i> Votre email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="supportEmail" placeholder="jean@example.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="supportSubject" class="form-label fw-semibold">
                            <i class="bi bi-tag me-1" style="color: #0B69F1;"></i> Sujet <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="supportSubject" required>
                            <option value="">Choisissez un sujet</option>
                            <option value="Problème technique">Problème technique</option>
                            <option value="Question sur une annonce">Question sur une annonce</option>
                            <option value="Problème de paiement">Problème de paiement</option>
                            <option value="Compte et connexion">Compte et connexion</option>
                            <option value="Signalement d'un utilisateur">Signalement d'un utilisateur</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="supportMessage" class="form-label fw-semibold">
                            <i class="bi bi-chat-dots me-1" style="color: #0B69F1;"></i> Votre message <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="supportMessage" rows="5" placeholder="Décrivez votre demande en détail..." required></textarea>
                        <div class="form-text text-muted">Minimum 10 caractères. Soyez précis pour une réponse plus rapide.</div>
                    </div>

                    <div id="supportFormMessage" class="alert d-none"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Annuler
                </button>
                <button type="button" class="btn btn-primary" id="sendSupportBtn" style="background: #0B69F1;">
                    <i class="bi bi-envelope-paper me-2"></i> Envoyer la demande
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.faq-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.category-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,255,0.1) !important;
    border-color: #0B69F1;
}

.category-link:hover .category-card {
    border-color: #0B69F1;
}

.accordion-item {
    transition: all 0.3s ease;
}

.accordion-item:hover {
    box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
}

.accordion-button {
    font-weight: 600;
    color: #333;
    background-color: white;
    border-radius: 10px !important;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #0B69F1, #0066ff);
    color: white;
}

.accordion-button:not(.collapsed)::after {
    filter: brightness(0) invert(1);
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,0,255,0.1);
}

.support-cta {
    border: 1px solid rgba(0,0,255,0.1);
    transition: all 0.3s ease;
}

.support-cta:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,255,0.1) !important;
    border-color: #0B69F1;
}

.btn-primary {
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,255,0.3) !important;
}

/* Style pour les champs de formulaire */
.form-control:focus, .form-select:focus {
    border-color: #0B69F1;
    box-shadow: 0 0 0 0.2rem rgba(11, 105, 241, 0.25);
}

/* Responsive */
@media (max-width: 768px) {
    .faq-page {
        padding: 2rem 0;
    }

    .accordion-button {
        font-size: 0.9rem;
    }

    .support-cta {
        padding: 2rem !important;
    }

    .modal-body {
        padding: 1.5rem;
    }
}
</style>

<!-- Bootstrap JS (si pas déjà inclus) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Initialisation du modal
let supportModal = null;

document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('supportModal');
    if (modalElement) {
        supportModal = new bootstrap.Modal(modalElement);
    }
});

// Ouvrir le modal
document.getElementById('openSupportModalBtn')?.addEventListener('click', function() {
    if (supportModal) {
        supportModal.show();
    } else {
        const modalElement = document.getElementById('supportModal');
        if (modalElement) {
            supportModal = new bootstrap.Modal(modalElement);
            supportModal.show();
        }
    }
});

// Envoi du formulaire de support
document.getElementById('sendSupportBtn')?.addEventListener('click', function() {
    const name = document.getElementById('supportName')?.value.trim();
    const email = document.getElementById('supportEmail')?.value.trim();
    const subject = document.getElementById('supportSubject')?.value;
    const message = document.getElementById('supportMessage')?.value.trim();
    const messageDiv = document.getElementById('supportFormMessage');

    // Réinitialiser le message
    messageDiv.classList.add('d-none');
    messageDiv.innerHTML = '';

    // Validation
    if (!name) {
        messageDiv.classList.remove('d-none');
        messageDiv.classList.add('alert-danger');
        messageDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i> Veuillez entrer votre nom complet';
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        return;
    }

    if (!email) {
        messageDiv.classList.remove('d-none');
        messageDiv.classList.add('alert-danger');
        messageDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i> Veuillez entrer votre email';
        return;
    }

    if (!email.includes('@') || !email.includes('.')) {
        messageDiv.classList.remove('d-none');
        messageDiv.classList.add('alert-danger');
        messageDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i> Veuillez entrer un email valide (exemple@domaine.com)';
        return;
    }

    if (!subject) {
        messageDiv.classList.remove('d-none');
        messageDiv.classList.add('alert-danger');
        messageDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i> Veuillez sélectionner un sujet';
        return;
    }

    if (!message) {
        messageDiv.classList.remove('d-none');
        messageDiv.classList.add('alert-danger');
        messageDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i> Veuillez écrire votre message';
        return;
    }

    if (message.length < 10) {
        messageDiv.classList.remove('d-none');
        messageDiv.classList.add('alert-danger');
        messageDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i> Votre message est trop court (minimum 10 caractères)';
        return;
    }

    // Construire le corps de l'email
    const emailSubject = encodeURIComponent(`[Support Kopiao] ${subject} - ${name}`);
    const emailBody = encodeURIComponent(
        `Bonjour l'équipe Kopiao,\n\n` +
        `--- INFORMATIONS CONTACT ---\n` +
        `Nom complet : ${name}\n` +
        `Email : ${email}\n` +
        `Sujet : ${subject}\n\n` +
        `--- MESSAGE ---\n` +
        `${message}\n\n` +
        `---\n` +
        `Message envoyé depuis le formulaire d'aide de la page FAQ.\n` +
        `Merci de me répondre à cette adresse : ${email}`
    );

    // Ouvrir le client email
    window.location.href = `mailto:support@kopiao.com?subject=${emailSubject}&body=${emailBody}`;

    // Afficher le message de succès
    messageDiv.classList.remove('d-none', 'alert-danger');
    messageDiv.classList.add('alert-success');
    messageDiv.innerHTML = '<i class="bi bi-check-circle me-2"></i> Votre client email va s\'ouvrir. Il ne vous reste plus qu\'à envoyer le message.';

    // Réinitialiser le formulaire après 1 seconde
    setTimeout(() => {
        document.getElementById('supportName').value = '';
        document.getElementById('supportEmail').value = '';
        document.getElementById('supportSubject').value = '';
        document.getElementById('supportMessage').value = '';

        // Fermer le modal après 2 secondes
        setTimeout(() => {
            if (supportModal) {
                supportModal.hide();
            }
            messageDiv.classList.add('d-none');
        }, 2000);
    }, 1000);
});

// Réinitialiser le message d'erreur quand on modifie les champs
const supportInputs = ['supportName', 'supportEmail', 'supportSubject', 'supportMessage'];
supportInputs.forEach(id => {
    document.getElementById(id)?.addEventListener('input', function() {
        const messageDiv = document.getElementById('supportFormMessage');
        messageDiv.classList.add('d-none');
    });
});
</script>

@stack('scripts')

@endsection
