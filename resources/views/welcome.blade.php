@extends('layouts.welcomeLayout')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">
                <!-- Texte principal -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                    <h1 class="hero-title">EduBenin Tutorat</h1>


                    <p class="hero-subtitle">Apprendre. Enseigner. Réussir au Bénin.</p>
                    <p class="hero-description">
                        EduBenin Tutorat est une plateforme béninoise qui connecte les apprenants et les tuteurs qualifiés
                        pour des cours particuliers en ligne ou en présentiel. Accédez à une éducation de qualité,
                        adaptée à vos besoins et à votre rythme, partout au Bénin.
                    </p>

                    <div class="platform-details mb-4">
                        <div class="detail-item" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-geo-alt"></i>
                            <span>Disponible dans tout le Bénin (Cotonou, Porto-Novo, Parakou...)</span>
                        </div>
                        <div class="detail-item" data-aos="fade-up" data-aos-delay="350">
                            <i class="bi bi-people"></i>
                            <span>+100 tuteurs vérifiés</span>
                        </div>
                        <div class="detail-item" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-cash-stack"></i>
                            <span>Paiements faciles via MTN MoMo & Moov Money</span>
                        </div>
                    </div>

                    <div class="hero-actions" data-aos="fade-up" data-aos-delay="450">
                        <a href="#" class="btn btn-primary btn-lg me-3">Trouver un Tuteur</a>
                        <a href="#" class="btn btn-outline-primary btn-lg">Devenir Tuteur</a>
                    </div>

                    <div class="countdown-wrapper mt-4" data-aos="fade-up" data-aos-delay="500">
                        <h5 class="countdown-title">Lancement Officiel Dans :</h5>
                        <div class="countdown d-flex justify-content-start" data-count="2025/12/15">
                            <div>
                                <h3 class="count-days"></h3>
                                <h4>Jours</h4>
                            </div>
                            <div>
                                <h3 class="count-hours"></h3>
                                <h4>Heures</h4>
                            </div>
                            <div>
                                <h3 class="count-minutes"></h3>
                                <h4>Minutes</h4>
                            </div>
                            <div>
                                <h3 class="count-seconds"></h3>
                                <h4>Secondes</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image principale -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="hero-image-wrapper">
                        <img src="{{ asset('images/image_1.webp') }}" alt="EduBenin Tutorat" class="img-fluid hero-image">

                        <div class="floating-badges">
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="600">
                                <i class="bi bi-person-check"></i>
                                <span>Tuteurs Vérifiés</span>
                            </div>
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="650">
                                <i class="bi bi-laptop"></i>
                                <span>Cours en Ligne & Présentiel</span>
                            </div>
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="700">
                                <i class="bi bi-shield-lock"></i>
                                <span>Paiement Sécurisé</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /Hero Section -->


    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">
                <!-- Colonne gauche : cartes d'informations -->
                <div class="col-lg-6 mb-4 mb-lg-0">

                    <div class="features-grid">
                        <div class="row g-4">
                            <!-- Carte 1 : Inscription -->
                            <div class="col-lg-6 col-md-7" data-aos="fade-up" data-aos-delay="200">
                                <a href="{{ route('register') }}" class="text-decoration-none text-dark">
                                    <div class="feature-card h-100">
                                        <div class="feature-icon">
                                            <i class="bi bi-person-plus"></i>
                                        </div>
                                        <h4>Inscription Simple</h4>
                                        <p>
                                            Créez votre compte en quelques clics via votre email, numéro de téléphone ou
                                            réseaux
                                            sociaux. Rejoignez une communauté d’apprenants et de tuteurs au Bénin.
                                        </p>
                                        <p class="fw-semibold mt-2 text-primary">Cliquez ici pour vous inscrire</p>
                                    </div>
                                </a>
                            </div>

                            <!-- Carte 2 : Connexion -->
                            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
                                <a href="{{ route('login') }}" class="text-decoration-none text-dark">
                                    <div class="feature-card h-100">
                                        <div class="feature-icon">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                        </div>
                                        <h4>Connexion Rapide</h4>
                                        <p>
                                            Accédez à votre espace personnel pour suivre vos cours, gérer vos réservations
                                            et échanger directement avec vos tuteurs ou apprenants.
                                        </p>
                                        <p class="fw-semibold mt-2 text-primary">Cliquez ici pour vous connecter</p>
                                    </div>
                                </a>
                            </div>



                        </div>
                    </div>
                </div>

                <!-- Colonne droite : image -->
                <div class="col-lg-6">
                    <div class="image-wrapper" data-aos="zoom-in" data-aos-delay="300">
                        <img src="{{ asset('images/image_2.webp') }}" alt="EduBenin Tutorat showcase" class="img-fluid">
                        <div class="floating-card" data-aos="fade-up" data-aos-delay="600">
                            <div class="card-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="card-content">
                                <h4>Communauté Active</h4>
                                <p>Des centaines d’apprenants et de tuteurs déjà connectés au Bénin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Appel à l’action -->
        <div class="cta-section" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center">
                <h3>Rejoignez EduBenin Tutorat dès aujourd’hui</h3>
                <p>Inscrivez-vous gratuitement et commencez à apprendre ou à enseigner selon vos disponibilités.</p>
                <div class="cta-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary">S’inscrire</a>
                    <a href="{{ route('login') }}" class="btn btn-outline">Se Connecter</a>
                </div>
            </div>
        </div>

    </section><!-- /About Section -->




    <!-- Top Tutors Section -->
    <section id="tutors" class="speakers section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Tuteurs Mieux Notés</h2>
            <p>Découvrez les professeurs les plus recommandés sur EduBenin Tutorat</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-4">

                <!-- Tuteur 1 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="speaker-card">
                        <div class="speaker-image">
                            <img src="{{ asset('images/prof_1.webp ') }}" alt="Tuteur" class="img-fluid">
                            <div class="speaker-overlay">
                                <div class="social-links">
                                    <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="speaker-content">
                            <div class="speaker-badge">★★★★★ 4.9</div>
                            <h4>Jean Agossa</h4>
                            <p class="speaker-title">Professeur de Mathématiques</p>
                            <p class="speaker-company">Cotonou</p>
                            <p class="speaker-bio">
                                Enseignant passionné avec plus de 8 ans d’expérience dans le soutien scolaire
                                et la préparation aux examens BEPC et BAC. Méthode claire et résultats garantis.
                            </p>
                            <div class="speaker-session">
                                <span class="session-topic">10 000 FCFA / heure</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Tutor Card -->

                <!-- Tuteur 2 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                    <div class="speaker-card">
                        <div class="speaker-image">
                            <img src="{{ asset('images/prof_3.webp ') }}" alt="Tuteur" class="img-fluid">
                            <div class="speaker-overlay">
                                <div class="social-links">
                                    <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="speaker-content">
                            <div class="speaker-badge">★★★★★ 4.8</div>
                            <h4>Marie Dossou</h4>
                            <p class="speaker-title">Tutrices d’Anglais</p>
                            <p class="speaker-company">Porto-Novo</p>
                            <p class="speaker-bio">
                                Spécialiste en expression orale et compréhension, Marie aide ses élèves à
                                gagner en confiance et fluidité grâce à une approche interactive et ludique.
                            </p>
                            <div class="speaker-session">
                                <span class="session-topic">8 000 FCFA / heure</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Tutor Card -->

                <!-- Tuteur 3 -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="450">
                    <div class="speaker-card">
                        <div class="speaker-image">
                            <img src="{{ asset('images/prof_2.webp ') }}" alt="Tuteur" class="img-fluid">
                            <div class="speaker-overlay">
                                <div class="social-links">
                                    <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="speaker-content">
                            <div class="speaker-badge">★★★★★ 4.7</div>
                            <h4>Rachid Olo</h4>
                            <p class="speaker-title">Formateur en Informatique</p>
                            <p class="speaker-company">Parakou</p>
                            <p class="speaker-bio">
                                Développeur et formateur certifié, Rachid accompagne les étudiants et
                                professionnels dans la maîtrise de la bureautique, du code et des outils numériques.
                            </p>
                            <div class="speaker-session">
                                <span class="session-topic">12 000 FCFA / heure</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Tutor Card -->

            </div>
        </div>

    </section><!-- /Top Tutors Section -->


    <!-- Paid Services Section -->
    <section id="services-paid" class="tickets section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Services Payants</h2>
            <p>Découvrez les options premium pour améliorer votre expérience sur EduBenin Tutorat</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">

                <!-- Service 1 : Abonnement Étudiant -->
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-icon">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <h4 class="ticket-title">Abonnement Étudiant</h4>
                            <p class="ticket-subtitle">Accédez à plus de tuteurs et réservez sans limite</p>
                        </div>
                        <div class="ticket-body">
                            <ul class="benefits-list">
                                <li><i class="bi bi-check2"></i> Réservations illimitées</li>
                                <li><i class="bi bi-check2"></i> Accès prioritaire aux tuteurs notés 5★</li>
                                <li><i class="bi bi-check2"></i> Rappels SMS gratuits</li>
                                <li><i class="bi bi-check2"></i> Historique de paiements détaillé</li>
                            </ul>
                            <a href="#" class="ticket-btn">Souscrire</a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

                <!-- Service 2 : Pack Tuteur Premium -->
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="ticket-card premium">
                        <div class="ticket-header">
                            <div class="ticket-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <h4 class="ticket-title">Pack Tuteur Premium</h4>
                            <p class="ticket-subtitle">Boostez votre visibilité et vos revenus</p>
                        </div>
                        <div class="ticket-body">
                            <ul class="benefits-list">
                                <li><i class="bi bi-check2"></i> Profil mis en avant sur la plateforme</li>
                                <li><i class="bi bi-check2"></i> Accès à la messagerie prioritaire</li>
                                <li><i class="bi bi-check2"></i> Statistiques avancées sur les élèves</li>
                                <li><i class="bi bi-check2"></i> Badge “Tuteur Premium”</li>
                            </ul>
                            <a href="#" class="ticket-btn">Activer</a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

                <!-- Service 3 : Cours Enregistrés -->
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-icon">
                                <i class="bi bi-play-circle"></i>
                            </div>
                            <h4 class="ticket-title">Cours Enregistrés</h4>
                            <p class="ticket-subtitle">Apprenez à votre rythme, où que vous soyez</p>
                        </div>
                        <div class="ticket-body">
                            <ul class="benefits-list">
                                <li><i class="bi bi-check2"></i> Accès illimité aux vidéos des tuteurs</li>
                                <li><i class="bi bi-check2"></i> Téléchargement possible (offline)</li>
                                <li><i class="bi bi-check2"></i> Suivi de progression personnalisé</li>
                                <li><i class="bi bi-check2"></i> Évaluations automatiques intégrées</li>
                            </ul>
                            <a href="#" class="ticket-btn">Découvrir</a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

                <!-- Service 4 : Coaching & Suivi Personnalisé -->
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-icon">
                                <i class="bi bi-person-lines-fill"></i>
                            </div>
                            <h4 class="ticket-title">Coaching Personnalisé</h4>
                            <p class="ticket-subtitle">Un accompagnement dédié selon vos objectifs</p>
                        </div>
                        <div class="ticket-body">
                            <ul class="benefits-list">
                                <li><i class="bi bi-check2"></i> Plan d’apprentissage sur mesure</li>
                                <li><i class="bi bi-check2"></i> Séances individuelles de coaching</li>
                                <li><i class="bi bi-check2"></i> Suivi des progrès avec le tuteur</li>
                                <li><i class="bi bi-check2"></i> Rapport mensuel d’évolution</li>
                            </ul>
                            <a href="#" class="ticket-btn">Demander un devis</a>
                        </div>
                    </div>
                </div><!-- End Service Card -->

            </div>
        </div>

    </section><!-- /Paid Services Section -->



    <!-- Témoignages Section -->
    <section id="testimonials" class="testimonials section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Témoignages</h2>
            <p>Ce que nos utilisateurs disent de leur expérience sur EduBenin Tutorat</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="testimonials-slider swiper init-swiper">
                <script type="application/json" class="swiper-config">
            {
              "slidesPerView": 1,
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              }
            }
            </script>

                <div class="swiper-wrapper">

                    <!-- Témoignage 1 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Une plateforme qui m’a vraiment aidée à progresser !</h2>
                                    <p>
                                        Grâce à EduBenin Tutorat, j’ai pu trouver un tuteur disponible et patient pour
                                        m’aider à mieux comprendre les mathématiques.
                                        En quelques semaines, mes notes ont nettement augmenté.
                                    </p>
                                    <p>
                                        Le système de réservation est très simple à utiliser, et j’apprécie surtout la
                                        possibilité de noter les tuteurs après chaque séance.
                                        C’est une expérience très positive que je recommande à tous les étudiants.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('images/person-f-10.webp') }}" class="profile-img"
                                            alt="">
                                        <div class="profile-info">
                                            <h3>Saul Goodman</h3>
                                            <span>Étudiante en 3e</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('images/person-f-10.webp') }}" class="featured-img"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Testimonial Item -->

                    <!-- Témoignage 2 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Un excellent outil pour les tuteurs comme moi</h2>
                                    <p>
                                        EduBenin Tutorat m’a permis de rencontrer de nombreux élèves motivés sans avoir à
                                        chercher moi-même des cours.
                                        Tout est automatisé, du paiement à la planification des séances.
                                    </p>
                                    <p>
                                        J’apprécie particulièrement la transparence du système et les retours des étudiants,
                                        qui m’aident à m’améliorer constamment.
                                        Je recommande vivement la plateforme à tous les enseignants indépendants.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('images/person-m-6.webp') }}" class="profile-img"
                                            alt="">
                                        <div class="profile-info">
                                            <h3>Sara Wilsson</h3>
                                            <span>Tutrice en Physique-Chimie</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('images/person-m-6.webp') }}" class="featured-img"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Testimonial Item -->

                    <!-- Témoignage 3 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Un accompagnement personnalisé et efficace</h2>
                                    <p>
                                        Ce que j’aime avec EduBenin Tutorat, c’est la possibilité de choisir un tuteur en
                                        fonction de mon emploi du temps et de mon niveau.
                                        Mon tuteur a adapté chaque séance à mes besoins spécifiques.
                                    </p>
                                    <p>
                                        En peu de temps, j’ai repris confiance en moi et j’ai compris des notions que je
                                        croyais impossibles à maîtriser.
                                        Merci à toute l’équipe pour cette belle initiative.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('images/person-f-8.webp') }}" class="profile-img"
                                            alt="">
                                        <div class="profile-info">
                                            <h3>Matt Brandon</h3>
                                            <span>Étudiant en Terminale</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('images/person-f-8.webp') }}" class="featured-img"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Testimonial Item -->

                    <!-- Témoignage 4 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Une expérience fluide et motivante</h2>
                                    <p>
                                        La plateforme est simple à utiliser, même pour quelqu’un qui n’est pas très à l’aise
                                        avec la technologie.
                                        J’ai pu m’inscrire, trouver un tuteur et commencer mes cours en moins de dix
                                        minutes.
                                    </p>
                                    <p>
                                        Le suivi des progrès est un vrai plus ! Je peux voir mes résultats s’améliorer au
                                        fil des semaines.
                                        EduBenin Tutorat a totalement changé ma façon d’apprendre.
                                    </p>
                                    <div class="profile d-flex align-items-center">
                                        <img src="{{ asset('images/person-f-8.webp') }}" class="profile-img"
                                            alt="">
                                        <div class="profile-info">
                                            <h3>Jena Karlis</h3>
                                            <span>Parent d’élève</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="featured-img-wrapper">
                                        <img src="{{ asset('images/person-f-8.webp') }}" class="featured-img"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Testimonial Item -->

                </div>

                <div class="swiper-navigation w-100 d-flex align-items-center justify-content-center">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>

            </div>

        </div>

    </section><!-- /Témoignages Section -->


    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">

                <!-- Image à gauche -->
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
                    <div class="contact-image text-center">
                        <img src="{{ asset('images/image_3.webp') }}" class="img-fluid rounded-3 shadow"
                            alt="Contact EduBenin Tutorat">
                    </div>
                </div>

                <!-- Formulaire à droite (version lumineuse bleue) -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="contact-form p-4 p-lg-5 rounded-4"
                        style="background: linear-gradient(135deg, #e3f2fd, #ffffff);
               box-shadow: 0 8px 24px rgba(0, 123, 255, 0.15);
               border: 1px solid rgba(0, 123, 255, 0.2);">

                        <div class="section-title mb-4 text-primary">
                            <h2 class="fw-bold" style="color: #0f0f0f;">Contactez-nous</h2>
                            <p style="color: #0d47a1;">Une question, une suggestion ou un partenariat ?
                                L’équipe <strong>EduBenin Tutorat</strong> est à votre écoute.</p>
                        </div>

                        <form action="#" method="post" class="php-email-form">
                            <div class="row gy-3">

                                <div class="col-md-6">
                                    <label for="name" class="form-label text-dark fw-semibold">Nom complet</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control border-0 shadow-sm" style="background-color: #f8fbff;"
                                        placeholder="Votre nom" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label text-dark fw-semibold">Adresse e-mail</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control border-0 shadow-sm" style="background-color: #f8fbff;"
                                        placeholder="votremail@example.com" required>
                                </div>

                                <div class="col-12">
                                    <label for="subject" class="form-label text-dark fw-semibold">Sujet</label>
                                    <input type="text" name="subject" id="subject"
                                        class="form-control border-0 shadow-sm" style="background-color: #f8fbff;"
                                        placeholder="Objet de votre message" required>
                                </div>

                                <div class="col-12">
                                    <label for="message" class="form-label text-dark fw-semibold">Message</label>
                                    <textarea name="message" id="message" rows="5" class="form-control border-0 shadow-sm"
                                        style="background-color: #f8fbff;" placeholder="Écrivez votre message ici..." required></textarea>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary mt-3 px-4 py-2"
                                        style="background: linear-gradient(135deg, #2196f3, #0d6efd);
                               border: none;
                               box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
                               transition: 0.3s;">
                                        <i class="bi bi-send me-2"></i>Envoyer le message
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>


            </div>

        </div>

    </section><!-- /Contact Section -->
@endsection
