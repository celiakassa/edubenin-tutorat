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
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/kopiaoofficiel?igsh=MW1weGNhcW91ZzRzZg==" target="_blank" class="me-3 text-white fs-4" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/kopiao/" target="_blank" class="me-3 text-white fs-4" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="https://x.com/kopiaoofficiel?t=zD2MHk2cCpuwQ2m6fQl3Pg&s=09" target="_blank" class="text-white fs-4" title="Twitter">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                </div>
            </div>

            <!-- Liens rapides - Augmentés -->
            <div class="col-lg-2 col-md-3 footer-links">
                <h4 class="footer-title">Liens utiles</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Accueil
                    </a></li>
                    <li class="mb-2"><a href="{{ route('annoncesListe.liste') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Annonces
                    </a></li>
                    <li class="mb-2"><a href="{{ route('demandesliste.liste') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Demandes
                    </a></li>
                    <li class="mb-2"><a href="#" id="contactFooterLink" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Contact
                    </a></li>
                    <li class="mb-2"><a href="{{ route('faq') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Comment ça marche ?
                    </a></li>
                    @auth
                    <li class="mb-2"><a href="{{ route('dashboardUser') }}" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Tableau de bord
                    </a></li>
                    @endauth
                </ul>
            </div>

            <!-- Nos Services -->
            <div class="col-lg-3 col-md-3 footer-links">
                <h4 class="footer-title">Nos Services</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Cours particuliers
                    </a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Soutien scolaire
                    </a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Préparation examens
                    </a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">
                        <i class="bi bi-chevron-right me-1"></i> Cours en ligne
                    </a></li>
                </ul>
            </div>

            <!-- Newsletter - Version mailto simple -->
            <div class="col-lg-3 col-md-6 footer-newsletter">
                <h4 class="footer-title">Restez informé</h4>
                <p class="text-white-50">Abonnez-vous pour recevoir nos dernières actualités et offres spéciales.</p>

                <form id="newsletterForm" class="mt-3">
                    <div class="footer-newsletter-group">
                        <input type="email" id="newsletterEmail" name="email" class="kp-field"
                            placeholder="Votre e-mail" required>
                        <button type="submit" class="kp-btn kp-btn--accent">S'abonner</button>
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
