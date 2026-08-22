<footer id="footer" class="footer position-relative text-white"
    style="background: linear-gradient(135deg, var(--kp-blue), var(--kp-blue-dark)); padding-top: 60px;">

    <div class="container footer-top pb-5 border-bottom border-light">
        <div class="row gy-4">

            <!-- Bloc logo et contact -->
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="{{ url('/') }}" class="logo d-flex align-items-center mb-3 text-white text-decoration-none">
                    <span class="sitename fw-bold fs-4 text-light">Kopiao</span>
                </a>
                <p class="text-white-50 mt-3">Votre plateforme de mise en relation pour les cours particuliers et le soutien scolaire.</p>

                <div class="social-links d-flex mt-4">
                    <a href="https://www.facebook.com/share/1EEgM4RwCR/" target="_blank" class="me-3 text-white fs-4" title="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/kopiaoofficiel?igsh=MW1weGNhcW91ZzRzZg==" target="_blank" class="me-3 text-white fs-4" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/kopiao/" target="_blank" class="me-3 text-white fs-4" title="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://x.com/kopiaoofficiel?t=zD2MHk2cCpuwQ2m6fQl3Pg&s=09" target="_blank" class="text-white fs-4" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>

            <!-- Liens utiles -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4 class="footer-title">Liens utiles</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">
                        <i class="fas fa-chevron-right me-1"></i> Accueil
                    </a></li>
                    <li class="mb-2"><a href="{{ route('annoncesListe.liste') }}" class="text-white-50 text-decoration-none">
                        <i class="fas fa-chevron-right me-1"></i> Annonces
                    </a></li>
                    <li class="mb-2"><a href="{{ route('demandesliste.liste') }}" class="text-white-50 text-decoration-none">
                        <i class="fas fa-chevron-right me-1"></i> Demandes
                    </a></li>
                    <li class="mb-2"><a href="#" id="contactFooterLink" class="text-white-50 text-decoration-none">
                        <i class="fas fa-chevron-right me-1"></i> Contact
                    </a></li>
                    <li class="mb-2"><a href="{{ route('faq') }}" class="text-white-50 text-decoration-none">
                        <i class="fas fa-chevron-right me-1"></i> Comment ça marche ?
                    </a></li>
                    <li class="mb-2"><a href="{{ route('blog.index') }}" class="text-white-50 text-decoration-none">
                        <i class="fas fa-chevron-right me-1"></i> Blog
                    </a></li>
                    @auth
                    <li class="mb-2"><a href="{{ route('dashboardUser') }}" class="text-white-50 text-decoration-none">
                        <i class="fas fa-chevron-right me-1"></i> Tableau de bord
                    </a></li>
                    @endauth
                </ul>
            </div>

            <!-- Devenir membre -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4 class="footer-title">Devenir membre</h4>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('register.tuteur') }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-chevron-right me-1"></i> Devenir tuteur
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('register') }}" class="text-white-50 text-decoration-none">
                            <i class="fas fa-chevron-right me-1"></i> Devenir apprenant
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Nos Services avec popups -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4 class="footer-title">Nos Services</h4>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="text-white-50 text-decoration-none service-link" data-service="cours-particuliers">
                            <i class="fas fa-chevron-right me-1"></i> Cours particuliers
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white-50 text-decoration-none service-link" data-service="soutien-scolaire">
                            <i class="fas fa-chevron-right me-1"></i> Soutien scolaire
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white-50 text-decoration-none service-link" data-service="preparation-examens">
                            <i class="fas fa-chevron-right me-1"></i> Préparation examens
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white-50 text-decoration-none service-link" data-service="cours-en-ligne">
                            <i class="fas fa-chevron-right me-1"></i> Cours en ligne
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-2 col-md-6 footer-newsletter">
                <h4 class="footer-title">Restez informé</h4>
                <p class="text-white-50">Abonnez-vous pour recevoir nos dernières actualités et offres spéciales.</p>

                <form id="newsletterForm" class="mt-3" method="POST" action="{{ route('newsletter.subscribe') }}">
                    @csrf
                    <div class="footer-newsletter-group">
                        <input type="email" id="newsletterEmail" name="email" class="kp-field"
                            placeholder="Votre e-mail" required autocomplete="off">
                        <button type="submit" class="kp-btn kp-btn--accent" id="newsletterSubmitBtn">
                            <span id="newsletterBtnText">S'abonner</span>
                            <span id="newsletterBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div id="newsletterMessage" class="mt-2 small"></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bas du footer -->
    <div class="container py-3">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center gap-2 text-center text-md-start">
            <p class="mb-0 text-white-50">© <strong>Kopiao</strong> — Tous droits réservés.</p>
            <p class="mb-0 small text-white-50">
                <a href="#" class="text-white-50 text-decoration-none">Mentions légales</a> |
                <a href="#" class="text-white-50 text-decoration-none">Politique de confidentialité</a> |
                <a href="#" class="text-white-50 text-decoration-none">CGU</a>
            </p>
        </div>
    </div>
</footer>

<!-- Popups pour les services -->
<style>
/* Overlay */
.service-popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.3s ease;
}

.service-popup-overlay.active {
    display: flex;
}

/* Popup */
.service-popup {
    background: #ffffff;
    border-radius: 16px;
    max-width: 520px;
    width: 90%;
    padding: 40px 36px 32px;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
    color: #1a1a2e;
}

/* Bouton fermeture */
.service-popup-close {
    position: absolute;
    top: 16px;
    right: 20px;
    background: none;
    border: none;
    font-size: 24px;
    color: #6c757d;
    cursor: pointer;
    transition: color 0.2s ease;
    padding: 4px 8px;
    border-radius: 8px;
}

.service-popup-close:hover {
    color: #dc3545;
    background: rgba(220, 53, 69, 0.08);
}

/* Icône du popup */
.service-popup-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: #e8f0fe;
    color: #0d6efd;
    font-size: 28px;
    margin-bottom: 16px;
}

.service-popup h3 {
    font-family: var(--kp-font-title, 'Segoe UI', sans-serif);
    font-weight: 700;
    font-size: 1.4rem;
    color: #1a1a2e;
    margin: 0 0 8px;
}

.service-popup .service-subtitle {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 16px;
}

.service-popup .service-description {
    color: #343a40;
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 20px;
}

.service-popup .service-features {
    list-style: none;
    padding: 0;
    margin: 0 0 24px;
}

.service-popup .service-features li {
    padding: 6px 0;
    color: #495057;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.service-popup .service-features li i {
    color: #0d6efd;
    font-size: 14px;
    width: 20px;
    text-align: center;
}

.service-popup .service-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #0d6efd;
    color: #fff;
    padding: 12px 32px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: background 0.2s ease, transform 0.2s ease;
    width: 100%;
    text-align: center;
}

.service-popup .service-action:hover {
    background: #0b5ed7;
    color: #fff;
    transform: translateY(-2px);
}

.service-popup .service-action i {
    margin-right: 10px;
}

/* Conteneur du bouton centré */
.service-popup .action-wrapper {
    display: flex;
    justify-content: center;
    width: 100%;
}

/* Newsletter - styles */
#newsletterMessage {
    font-size: 0.85rem;
}

#newsletterMessage .alert {
    padding: 6px 12px;
    border-radius: 6px;
    margin: 0;
}

#newsletterMessage .alert-success {
    background: rgba(40, 167, 69, 0.2);
    color: #d4edda;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

#newsletterMessage .alert-danger {
    background: rgba(220, 53, 69, 0.2);
    color: #f8d7da;
    border: 1px solid rgba(220, 53, 69, 0.3);
}

#newsletterMessage .alert-warning {
    background: rgba(255, 193, 7, 0.2);
    color: #fff3cd;
    border: 1px solid rgba(255, 193, 7, 0.3);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.96);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Responsive */
@media (max-width: 576px) {
    .service-popup {
        padding: 28px 20px 24px;
    }
    .service-popup h3 {
        font-size: 1.2rem;
    }
}
</style>

<!-- Popups HTML -->
<div class="service-popup-overlay" id="servicePopupOverlay">
    <div class="service-popup">
        <button class="service-popup-close" id="servicePopupClose">
            <i class="fas fa-times"></i>
        </button>

        <div class="service-popup-icon" id="servicePopupIcon">
            <i class="fas fa-graduation-cap"></i>
        </div>

        <h3 id="servicePopupTitle">Cours particuliers</h3>
        <p class="service-subtitle" id="servicePopupSubtitle">Un accompagnement personnalisé pour chaque élève</p>

        <p class="service-description" id="servicePopupDescription">
            Des cours particuliers adaptés à vos besoins, dispensés par des tuteurs qualifiés dans toutes les matières.
        </p>

        <ul class="service-features" id="servicePopupFeatures">
            <li><i class="fas fa-check-circle"></i> Professeurs expérimentés et passionnés</li>
            <li><i class="fas fa-check-circle"></i> Suivi personnalisé et progressif</li>
            <li><i class="fas fa-check-circle"></i> Flexibilité des horaires et des lieux</li>
        </ul>

        <div class="action-wrapper">
            <a href="{{ route('register') }}" class="service-action">
                <i class="fas fa-rocket"></i>Voulez-vous commencer ?
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== GESTION DES POPUPS SERVICES ==========
    const overlay = document.getElementById('servicePopupOverlay');
    const closeBtn = document.getElementById('servicePopupClose');

    const servicesData = {
        'cours-particuliers': {
            icon: 'fas fa-user-graduate',
            title: 'Cours particuliers',
            subtitle: 'Trouvez le tuteur idéal pour vos besoins',
            description: 'Publiez gratuitement votre annonce et recevez des candidatures de tuteurs qualifiés. Ne payez qu\'un acompte de 30% pour lancer votre recherche et choisissez le profil qui vous correspond le mieux.',
            features: [
                'Publiez votre annonce gratuitement',
                'Recevez des candidatures de tuteurs vérifiés',
                'Acompte de 30% seulement pour lancer la recherche',
                'Choisissez le tuteur qui vous convient'
            ]
        },
        'soutien-scolaire': {
            icon: 'fas fa-book-open',
            title: 'Soutien scolaire',
            subtitle: 'Aidez votre enfant à réussir sa scolarité',
            description: 'Créez une demande de soutien scolaire pour votre enfant et trouvez le tuteur parfait pour l\'accompagner. Paiement sécurisé en plusieurs étapes pour vous protéger.',
            features: [
                'Demande personnalisée pour votre enfant',
                'Tuteurs spécialisés dans toutes les matières',
                'Suivi des progrès et évaluations régulières',
                'Paiement sécurisé en plusieurs étapes'
            ]
        },
        'preparation-examens': {
            icon: 'fas fa-trophy',
            title: 'Préparation aux examens',
            subtitle: 'Maximisez vos chances de réussite',
            description: 'Préparez vos examens avec des tuteurs spécialisés. Déposez votre demande avec votre budget et recevez des propositions adaptées à vos objectifs et votre niveau.',
            features: [
                'Programme de révision personnalisé',
                'Entraînement sur sujets d\'examen types',
                'Tuteurs expérimentés dans votre matière',
                'Gestion du stress et confiance en soi'
            ]
        },
        'cours-en-ligne': {
            icon: 'fas fa-laptop',
            title: 'Cours en ligne',
            subtitle: 'Apprenez où que vous soyez',
            description: 'Profitez de cours à distance interactifs avec des tuteurs expérimentés. Publiez votre annonce et recevez des candidatures de tuteurs disponibles pour des cours en visioconférence.',
            features: [
                'Cours en visioconférence interactifs',
                'Partage d\'écran et tableau blanc digital',
                'Enregistrement des séances pour révision',
                'Flexibilité totale des horaires'
            ]
        }
    };

    function openPopup(serviceKey) {
        const data = servicesData[serviceKey];
        if (!data) return;

        document.getElementById('servicePopupIcon').innerHTML = `<i class="${data.icon}"></i>`;
        document.getElementById('servicePopupTitle').textContent = data.title;
        document.getElementById('servicePopupSubtitle').textContent = data.subtitle;
        document.getElementById('servicePopupDescription').textContent = data.description;

        const featuresList = document.getElementById('servicePopupFeatures');
        featuresList.innerHTML = data.features.map(f =>
            `<li><i class="fas fa-check-circle"></i> ${f}</li>`
        ).join('');

        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closePopup() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.service-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const service = this.getAttribute('data-service');
            openPopup(service);
        });
    });

    closeBtn.addEventListener('click', closePopup);
    overlay.addEventListener('click', function(e) {
        if (e.target === this) closePopup();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && overlay.classList.contains('active')) closePopup();
    });

    // ========== GESTION DE LA NEWSLETTER ==========
    const newsletterForm = document.getElementById('newsletterForm');
    const newsletterEmail = document.getElementById('newsletterEmail');
    const newsletterMessage = document.getElementById('newsletterMessage');
    const submitBtn = document.getElementById('newsletterSubmitBtn');
    const btnText = document.getElementById('newsletterBtnText');
    const btnSpinner = document.getElementById('newsletterBtnSpinner');

    function showMessage(message, type = 'success') {
        newsletterMessage.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        newsletterMessage.style.display = 'block';
    }

    function hideMessage() {
        newsletterMessage.style.display = 'none';
        newsletterMessage.innerHTML = '';
    }

    function setLoading(loading) {
        if (loading) {
            submitBtn.disabled = true;
            btnText.textContent = 'En cours...';
            btnSpinner.classList.remove('d-none');
        } else {
            submitBtn.disabled = false;
            btnText.textContent = "S'abonner";
            btnSpinner.classList.add('d-none');
        }
    }

    if (newsletterForm) {
        // Nettoyer le cache du navigateur pour l'input email
        newsletterEmail.setAttribute('autocomplete', 'off');
        newsletterEmail.setAttribute('autocorrect', 'off');
        newsletterEmail.setAttribute('autocapitalize', 'off');
        newsletterEmail.setAttribute('spellcheck', 'false');

        newsletterForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            hideMessage();

            const email = newsletterEmail.value.trim().toLowerCase();

            // Validation basique
            if (!email) {
                showMessage('Veuillez saisir votre adresse email.', 'warning');
                newsletterEmail.focus();
                return;
            }

            if (!email.includes('@') || !email.includes('.')) {
                showMessage('Veuillez saisir une adresse email valide (exemple@domaine.com).', 'warning');
                newsletterEmail.focus();
                return;
            }

            setLoading(true);

            try {
                const formData = new FormData(this);
                // Remplacer l'email par la version en minuscules
                formData.set('email', email);

                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    showMessage((data.message || 'Inscription réussie ! Vous recevrez nos actualités.'), 'success');
                    newsletterEmail.value = '';
                    // Nettoyer le cache du navigateur
                    setTimeout(() => {
                        newsletterEmail.value = '';
                    }, 100);
                } else if (response.status === 409) {
                    showMessage( data.message, 'warning');
                    // Vider le champ pour éviter la confusion
                    newsletterEmail.value = '';
                } else {
                    const errorMsg = data.message || data.errors?.email?.[0] || 'Une erreur est survenue. Veuillez réessayer.';
                    showMessage( errorMsg, 'danger');
                }
            } catch (error) {
                console.error('Erreur newsletter:', error);
                showMessage('Une erreur technique est survenue. Veuillez réessayer plus tard.', 'danger');
            } finally {
                setLoading(false);
            }
        });

        // Masquer le message quand l'utilisateur commence à taper
        newsletterEmail.addEventListener('input', function() {
            hideMessage();
        });

        // Nettoyer le champ au focus
        newsletterEmail.addEventListener('focus', function() {
            // Si le champ contient une valeur qui était en erreur, on le vide
            if (this.value && newsletterMessage.querySelector('.alert-warning')) {
                this.value = '';
            }
        });
    }
});
</script>
