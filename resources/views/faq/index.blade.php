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

        <!-- Section Étudiants -->
        <section id="etudiants" class="mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-4 pb-2" style="color: #0B69F1; border-bottom: 3px solid #0B69F1;">
                <i class="bi bi-mortarboard me-2"></i>Questions des Apprenants
            </h2>

            <!-- A. Inscription et création de compte -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Inscription et création de compte
                </h3>
                <div class="accordion" id="accordionEtudiantA">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE1">
                                Comment créer un compte Apprenants ?
                            </button>
                        </h2>
                        <div id="collapseE1" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantA">
                            <div class="accordion-body bg-light">
                                <p>Pour créer un compte Apprenants :</p>
                                <ol>
                                    <li>Cliquez sur "S'inscrire" dans le menu supérieur</li>
                                    <li>Sélectionnez "Étudiant" comme type de compte</li>
                                    <li>Remplissez le formulaire avec vos informations</li>
                                    <li>Confirmez votre email via le lien reçu</li>
                                    <li>Complétez votre profil pour augmenter votre crédibilité</li>
                                </ol>
                                <p class="mb-0">C'est gratuit et ne prend que 2 minutes !</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE2">
                                Dois-je payer pour publier une annonce ?
                            </button>
                        </h2>
                        <div id="collapseE2" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantA">
                            <div class="accordion-body bg-light">
                                <p>La publication d'une annonce est <strong>totalement gratuite</strong> !</p>
                                <p>Vous ne payez que si vous choisissez un tuteur. À ce moment-là, un dépôt de garantie équivalent à 20-30% du montant total vous sera demandé. Ce montant est sécurisé et reversé au tuteur à la fin de la première séance.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE3">
                                Puis-je modifier mon profil ou mes annonces ?
                            </button>
                        </h2>
                        <div id="collapseE3" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantA">
                            <div class="accordion-body bg-light">
                                <p>Oui, à tout moment !</p>
                                <ul>
                                    <li><strong>Profil :</strong> Rendez-vous dans votre espace "Mon profil" pour modifier vos informations, photo, etc.</li>
                                    <li><strong>Annonces :</strong> Vous pouvez modifier une annonce tant qu'elle n'a pas été attribuée. Une fois qu'un tuteur est sélectionné, l'annonce est verrouillée.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- B. Publication d'une annonce -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Publication d'une annonce
                </h3>
                <div class="accordion" id="accordionEtudiantB">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE4">
                                Comment publier une annonce ?
                            </button>
                        </h2>
                        <div id="collapseE4" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantB">
                            <div class="accordion-body bg-light">
                                <p>Pour publier une annonce :</p>
                                <ol>
                                    <li>Connectez-vous à votre compte étudiant</li>
                                    <li>Cliquez sur "Publier une annonce"</li>
                                    <li>Remplissez le formulaire : domaine, description, budget, disponibilités</li>
                                    <li>Soumettez votre annonce (gratuit)</li>
                                    <li>Patientez les candidatures des tuteurs</li>
                                </ol>
                                <p>Plus votre description est détaillée, plus vous aurez de candidatures de qualité !</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE5">
                                Comment définir le budget et le dépôt de garantie ?
                            </button>
                        </h2>
                        <div id="collapseE5" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantB">
                            <div class="accordion-body bg-light">
                                <p><strong>Budget :</strong> Indiquez le montant total que vous êtes prêt à payer pour l'ensemble des cours.</p>
                                <p><strong>Dépôt de garantie :</strong> Calculé automatiquement (20-30% du budget total). Ce montant est bloqué mais pas débité tant que vous n'avez pas choisi un tuteur. Il garantit votre sérieux et sera reversé au tuteur après la première séance.</p>
                                <p>Le reste du paiement se fait directement avec le tuteur selon vos modalités convenues.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE6">
                                Combien de temps mon annonce reste visible ?
                            </button>
                        </h2>
                        <div id="collapseE6" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantB">
                            <div class="accordion-body bg-light">
                                <p>Votre annonce reste visible <strong>30 jours</strong> après sa publication. Passé ce délai, si aucun tuteur n'a été choisi, elle sera automatiquement archivée.</p>
                                <p>Vous pouvez à tout moment la republier pour 30 jours supplémentaires.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE7">
                                Que se passe-t-il si je ne choisis pas de tuteur ?
                            </button>
                        </h2>
                        <div id="collapseE7" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantB">
                            <div class="accordion-body bg-light">
                                <p>Si vous ne choisissez aucun tuteur dans les 30 jours :</p>
                                <ul>
                                    <li>Votre annonce est automatiquement archivée</li>
                                    <li>Aucun montant n'est prélevé</li>
                                    <li>Vous pouvez créer une nouvelle annonce à tout moment</li>
                                </ul>
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
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE8">
                                Comment savoir si un tuteur est fiable ?
                            </button>
                        </h2>
                        <div id="collapseE8" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantC">
                            <div class="accordion-body bg-light">
                                <p>Plusieurs indicateurs de fiabilité :</p>
                                <ul>
                                    <li><strong>Badge "Tuteur vérifié"</strong> : indique que l'identité a été vérifiée</li>
                                    <li><strong>Avis et notations</strong> : lisez les retours des autres étudiants</li>
                                    <li><strong>Profil complet</strong> : photo, description, diplômes</li>
                                    <li><strong>Taux de réponse</strong> : un tuteur qui répond rapidement</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE9">
                                Puis-je contacter directement un tuteur avant de le choisir ?
                            </button>
                        </h2>
                        <div id="collapseE9" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantC">
                            <div class="accordion-body bg-light">
                                <p><strong>Non</strong>, pour protéger la vie privée de tous, les coordonnées ne sont échangées qu'après sélection du tuteur. Vous pouvez cependant :</p>
                                <ul>
                                    <li>Voir les candidatures détaillées des tuteurs</li>
                                    <li>Poser des questions via le système de messagerie interne</li>
                                    <li>Organiser une séance d'essai (payante selon accord)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE10">
                                Que signifie "contacts débloqués après sélection" ?
                            </button>
                        </h2>
                        <div id="collapseE10" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantC">
                            <div class="accordion-body bg-light">
                                <p>Cela signifie que les informations de contact (téléphone, email) ne sont visibles qu'après que vous ayez officiellement sélectionné un tuteur pour votre annonce.</p>
                                <p>Cette mesure de sécurité évite les contacts non sollicités et garantit que les tuteurs sont sérieux.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- D. Paiement / dépôt de garantie -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Paiement / Dépôt de garantie
                </h3>
                <div class="accordion" id="accordionEtudiantD">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE11">
                                Qu'est-ce que le dépôt de garantie et pourquoi est-il requis ?
                            </button>
                        </h2>
                        <div id="collapseE11" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantD">
                            <div class="accordion-body bg-light">
                                <p>Le dépôt de garantie est un montant (20-30% du budget total) qui est bloqué mais pas débité. Il sert à :</p>
                                <ul>
                                    <li>Garantir votre sérieux en tant qu'étudiant</li>
                                    <li>Assurer le tuteur que vous vous engagerez</li>
                                    <li>Éviter les annulations de dernière minute</li>
                                    <li>Protéger les deux parties en cas de litige</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE12">
                                Quand le dépôt est-il reversé au tuteur ?
                            </button>
                        </h2>
                        <div id="collapseE12" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantD">
                            <div class="accordion-body bg-light">
                                <p>Le dépôt de garantie est reversé au tuteur <strong>après la première séance de cours</strong>, une fois que vous avez confirmé que la séance a bien eu lieu.</p>
                                <p>Si vous ne confirmez pas dans les 48h, le dépôt est automatiquement reversé au tuteur.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE13">
                                Que se passe-t-il si le tuteur ne fait pas cours ?
                            </button>
                        </h2>
                        <div id="collapseE13" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantD">
                            <div class="accordion-body bg-light">
                                <p>Dans ce cas :</p>
                                <ol>
                                    <li>Vous devez signaler le problème via l'option "Signaler un problème"</li>
                                    <li>Notre équipe examine la situation dans les 24h</li>
                                    <li>Le dépôt de garantie vous est intégralement remboursé</li>
                                    <li>Le tuteur peut être sanctionné (avertissement, suspension)</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE14">
                                Que se passe-t-il si je change d'avis ou annule le cours ?
                            </button>
                        </h2>
                        <div id="collapseE14" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantD">
                            <div class="accordion-body bg-light">
                                <p>Si vous annulez :</p>
                                <ul>
                                    <li><strong>Plus de 48h avant le cours</strong> : remboursement intégral du dépôt</li>
                                    <li><strong>Moins de 48h avant le cours</strong> : le dépôt est reversé au tuteur pour compenser sa disponibilité</li>
                                </ul>
                                <p>Les annulations répétées peuvent affecter votre crédibilité sur la plateforme.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- E. Avis et notation -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Avis et notation
                </h3>
                <div class="accordion" id="accordionEtudiantE">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE15">
                                Comment fonctionne le système de notation ?
                            </button>
                        </h2>
                        <div id="collapseE15" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantE">
                            <div class="accordion-body bg-light">
                                <p>Après chaque cours, vous pouvez noter le tuteur de 1 à 5 étoiles sur plusieurs critères :</p>
                                <ul>
                                    <li>Qualité pédagogique</li>
                                    <li>Ponctualité</li>
                                    <li>Communication</li>
                                </ul>
                                <p>La note moyenne est affichée sur le profil du tuteur.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE16">
                                Puis-je voir les avis d'un tuteur avant de le choisir ?
                            </button>
                        </h2>
                        <div id="collapseE16" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantE">
                            <div class="accordion-body bg-light">
                                <p><strong>Oui, absolument !</strong> Tous les avis et notes des tuteurs sont visibles publiquement sur leur profil. Vous pouvez ainsi vous faire une idée précise de la qualité de leurs cours avant de les sélectionner.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE17">
                                Pourquoi la notation est-elle obligatoire ?
                            </button>
                        </h2>
                        <div id="collapseE17" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantE">
                            <div class="accordion-body bg-light">
                                <p>La notation est obligatoire pour :</p>
                                <ul>
                                    <li>Maintenir la qualité des services</li>
                                    <li>Aider les futurs étudiants dans leur choix</li>
                                    <li>Encourager les tuteurs à donner le meilleur d'eux-mêmes</li>
                                    <li>Créer une communauté de confiance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- F. Sécurité et support -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Sécurité et support
                </h3>
                <div class="accordion" id="accordionEtudiantF">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE18">
                                Mes informations personnelles sont-elles protégées ?
                            </button>
                        </h2>
                        <div id="collapseE18" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantF">
                            <div class="accordion-body bg-light">
                                <p>Oui, nous prenons la protection des données très au sérieux :</p>
                                <ul>
                                    <li>Chiffrement des données sensibles</li>
                                    <li>Non-divulgation des coordonnées sans consentement</li>
                                    <li>Conformité RGPD</li>
                                    <li>Vous pouvez demander la suppression de vos données à tout moment</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE19">
                                Comment signaler un problème avec un tuteur ?
                            </button>
                        </h2>
                        <div id="collapseE19" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantF">
                            <div class="accordion-body bg-light">
                                <p>Pour signaler un problème :</p>
                                <ol>
                                    <li>Allez sur le profil du tuteur</li>
                                    <li>Cliquez sur "Signaler"</li>
                                    <li>Choisissez le motif (comportement inapproprié, absence, etc.)</li>
                                    <li>Notre équipe traite votre signalement sous 24h</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseE20">
                                Qui dois-je contacter si j'ai un problème avec le dépôt ou le paiement ?
                            </button>
                        </h2>
                        <div id="collapseE20" class="accordion-collapse collapse" data-bs-parent="#accordionEtudiantF">
                            <div class="accordion-body bg-light">
                                <p>En cas de problème de paiement :</p>
                                <ul>
                                    <li>Email : <a href="mailto:support@kopiao.com">support@kopiao.com</a></li>
                                    <li>Formulaire de contact dans votre espace "Aide"</li>
                                    <li>Chat en direct (disponible 9h-18h en semaine)</li>
                                </ul>
                                <p>Nous répondons à toutes les demandes sous 24h maximum.</p>
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

            <!-- A. Optimiser son profil -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Optimiser son profil
                </h3>
                <div class="accordion" id="accordionTuteurA">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT1">
                                Comment optimiser mon profil ?
                            </button>
                        </h2>
                        <div id="collapseT1" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurA">
                            <div class="accordion-body bg-light">
                                <p><strong>Complétez TOUS les champs :</strong></p>
                                <ul>
                                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Photo professionnelle de qualité</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Description détaillée (parcours, méthodes)</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Domaines précis (évitez les listes trop larges)</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Disponibilités à jour</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-1"></i> Diplômes et certifications</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT2">
                                Comment choisir des domaines précis ?
                            </button>
                        </h2>
                        <div id="collapseT2" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurA">
                            <div class="accordion-body bg-light">
                                <p>Au lieu de mettre "Mathématiques", précisez :</p>
                                <ul>
                                    <li>Algèbre linéaire (niveau universitaire)</li>
                                    <li>Analyse (prépa BCPST)</li>
                                    <li>Probabilités (licence économie)</li>
                                </ul>
                                <p>Les étudiants recherchent souvent des profils très spécifiques. Soyez précis pour être trouvé !</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- B. Rédiger des candidatures efficaces -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Rédiger des candidatures efficaces
                </h3>
                <div class="accordion" id="accordionTuteurB">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT3">
                                Comment rédiger une candidature qui attire l'attention ?
                            </button>
                        </h2>
                        <div id="collapseT3" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurB">
                            <div class="accordion-body bg-light">
                                <p><strong>Exemple de structure gagnante :</strong></p>
                                <div class="bg-white p-3 rounded-3 border">
                                    <p><em>"Bonjour [Prénom],</em></p>
                                    <p><em>J'ai vu votre annonce pour des cours de [domaine]. Avec mon expérience de [X ans] dans ce domaine et ma méthode basée sur [approche spécifique], je pourrais vous aider à [objectif spécifique de l'étudiant].</em></p>
                                    <p><em>Je suis disponible [disponibilités]. N'hésitez pas à consulter mon profil pour voir les avis de mes précédents étudiants.</em></p>
                                    <p><em>Cordialement, [Votre prénom]"</em></p>
                                </div>
                                <p class="mt-2">Personnalisez chaque candidature en fonction de l'annonce !</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- C. Gestion de la réputation -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Gestion de la réputation
                </h3>
                <div class="accordion" id="accordionTuteurC">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT4">
                                Comment obtenir de bons avis ?
                            </button>
                        </h2>
                        <div id="collapseT4" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurC">
                            <div class="accordion-body bg-light">
                                <ul>
                                    <li>Soyez ponctuel et préparé</li>
                                    <li>Communiquez clairement les objectifs du cours</li>
                                    <li>Demandez poliment un avis en fin de séance</li>
                                    <li>Répondez rapidement aux messages</li>
                                    <li>Ne jamais annuler à la dernière minute</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- D. Maximiser la visibilité -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Maximiser la visibilité
                </h3>
                <div class="accordion" id="accordionTuteurD">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT5">
                                Comment profiter des fonctionnalités premium ?
                            </button>
                        </h2>
                        <div id="collapseT5" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurD">
                            <div class="accordion-body bg-light">
                                <p>L'abonnement premium vous donne accès à :</p>
                                <ul>
                                    <li><strong>Boost</strong> : Votre profil apparaît en tête des recherches</li>
                                    <li><strong>Badge "Premium"</strong> : Gagnez en crédibilité</li>
                                    <li><strong>Mise en avant</strong> : Dans les newsletters et recommandations</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- E. Conseils pédagogiques -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Conseils pédagogiques
                </h3>
                <div class="accordion" id="accordionTuteurE">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT6">
                                Comment préparer un cours efficace ?
                            </button>
                        </h2>
                        <div id="collapseT6" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurE">
                            <div class="accordion-body bg-light">
                                <ul>
                                    <li>Demandez à l'avance les difficultés de l'étudiant</li>
                                    <li>Préparez des exercices adaptés à son niveau</li>
                                    <li>Ayez un plan de cours structuré</li>
                                    <li>Prévoyez du temps pour les questions</li>
                                    <li>Envoyez un résumé après le cours</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- F. Fonctionnement -->
            <div class="faq-category mb-4">
                <h3 class="h5 fw-bold mb-3" style="color: #333; background: #f0f0f0; padding: 10px 15px; border-radius: 10px;">
                    Fonctionnement
                </h3>
                <div class="accordion" id="accordionTuteurF">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT7">
                                Comment fonctionne l'abonnement ?
                            </button>
                        </h2>
                        <div id="collapseT7" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurF">
                            <div class="accordion-body bg-light">
                                <p>L'abonnement est mensuel et sans engagement. Il vous donne accès à :</p>
                                <ul>
                                    <li>Postuler aux annonces</li>
                                    <li>Fonctionnalités premium (boost, badge)</li>
                                    <li>Statistiques détaillées</li>
                                </ul>
                                <p>Vous pouvez résilier à tout moment depuis votre espace.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseT8">
                                Comment signaler un étudiant problématique ?
                            </button>
                        </h2>
                        <div id="collapseT8" class="accordion-collapse collapse" data-bs-parent="#accordionTuteurF">
                            <div class="accordion-body bg-light">
                                <p>En cas de problème :</p>
                                <ol>
                                    <li>Rassemblez les preuves (messages, etc.)</li>
                                    <li>Cliquez sur "Signaler" dans la conversation</li>
                                    <li>Notre équipe examine et prend les mesures nécessaires</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Support -->
        <div class="support-cta text-center mt-5 p-5 bg-white rounded-4 shadow-sm" data-aos="fade-up">
            <i class="bi bi-headset" style="font-size: 3rem; color: #0B69F1;"></i>
            <h3 class="fw-bold mt-3 mb-3">Vous n'avez pas trouvé votre réponse ?</h3>
            <p class="text-muted mb-4">Notre équipe est là pour vous aider</p>
            <a href="mailto:support@kopiao.com" class="btn btn-primary px-5 py-3 rounded-pill"
               style="background: #0B69F1; border: none;">
                <i class="bi bi-envelope me-2"></i>Contacter le support
            </a>
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
}
</style>
@endsection
