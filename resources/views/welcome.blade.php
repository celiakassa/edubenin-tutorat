@extends('layouts.welcomeLayout')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center">
                <!-- Partie gauche avec la barre de recherche -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                    <h1 class="hero-title mb-4">Kopiao</h1>

                    <p class="hero-subtitle mb-4">Trouvez le tuteur idéal pour réussir vos études</p>

                    <!-- Barre de recherche principale -->
                    <form action="{{ route('recherche.tuteur') }}" method="GET" class="search-main-form mb-4">
                        <div class="search-wrapper">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search text-primary"></i>
                                </span>
                                <input type="text" name="search"
                                    class="form-control form-control-lg border-start-0 ps-0"
                                    placeholder="Rechercher un tuteur, une matière, une ville..."
                                    value="{{ $searchQuery }}">
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    Rechercher
                                </button>
                            </div>
                        </div>

                        <!-- Filtres rapides -->
                        <div class="filters-wrapper mt-4">
                            <div class="row g-2">
                                <!-- Filtre par matière -->
                                <div class="col-md-6">
                                    <select name="subject" class="form-select filter-select">
                                        <option value="">Toutes les matières</option>
                                        @foreach ($allSubjects as $subject)
                                            <option value="{{ $subject }}"
                                                {{ $selectedSubject == $subject ? 'selected' : '' }}>
                                                {{ $subject }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filtre par ville (basé sur la base de données) -->
                                <div class="col-md-6">
                                    <select name="city" class="form-select filter-select">
                                        <option value="">Toutes les villes</option>
                                        @foreach ($allCities as $city)
                                            <option value="{{ $city }}"
                                                {{ $selectedCity == $city ? 'selected' : '' }}>
                                                {{ $city }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filtre par mode d'enseignement -->
                                <div class="col-md-6">
                                    <select name="learning_preference" class="form-select filter-select">
                                        <option value="">Tous les modes</option>
                                        <option value="online" {{ $selectedPreference == 'online' ? 'selected' : '' }}>En
                                            ligne</option>
                                        <option value="in_person"
                                            {{ $selectedPreference == 'in_person' ? 'selected' : '' }}>Présentiel</option>
                                        <option value="hybrid" {{ $selectedPreference == 'hybrid' ? 'selected' : '' }}>
                                            Hybride</option>
                                    </select>
                                </div>

                                <!-- Filtre par tarif (basé sur rate_per_hour) -->
                                <div class="col-md-6">
                                    <select name="price_range" class="form-select filter-select">
                                        <option value="">Tous les tarifs</option>
                                        <option value="0-5000" {{ $selectedPriceRange == '0-5000' ? 'selected' : '' }}>
                                            Moins de 5 000 FCFA</option>
                                        <option value="5000-10000"
                                            {{ $selectedPriceRange == '5000-10000' ? 'selected' : '' }}>5 000 - 10 000 FCFA
                                        </option>
                                        <option value="10000-15000"
                                            {{ $selectedPriceRange == '10000-15000' ? 'selected' : '' }}>10 000 - 15 000
                                            FCFA</option>
                                        <option value="15000-20000"
                                            {{ $selectedPriceRange == '15000-20000' ? 'selected' : '' }}>15 000 - 20 000
                                            FCFA</option>
                                        <option value="20000-25000"
                                            {{ $selectedPriceRange == '20000-25000' ? 'selected' : '' }}>20 000 - 25 000
                                            FCFA</option>
                                        <option value="25000-30000"
                                            {{ $selectedPriceRange == '25000-30000' ? 'selected' : '' }}>25 000 - 30 000
                                            FCFA</option>
                                        <option value="30000-35000"
                                            {{ $selectedPriceRange == '30000-35000' ? 'selected' : '' }}>30 000 - 35 000
                                            FCFA</option>
                                        <option value="35000-40000"
                                            {{ $selectedPriceRange == '35000-40000' ? 'selected' : '' }}>35 000 - 40 000
                                            FCFA</option>
                                        <option value="40000-45000"
                                            {{ $selectedPriceRange == '40000-45000' ? 'selected' : '' }}>40 000 - 45 000
                                            FCFA</option>
                                        <option value="45000-50000"
                                            {{ $selectedPriceRange == '45000-50000' ? 'selected' : '' }}>45 000 - 50 000
                                            FCFA</option>
                                        <option value="50000+" {{ $selectedPriceRange == '50000+' ? 'selected' : '' }}>Plus
                                            de 50 000 FCFA</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton pour effacer les filtres (visible si des filtres sont appliqués) -->
                        @if ($searchQuery || $selectedSubject || $selectedCity || $selectedPreference || $selectedPriceRange)
                            <div class="mt-3 text-end">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-x-circle"></i> Effacer tous les filtres
                                </a>
                            </div>
                        @endif
                    </form>


                    <!-- Statistiques -->
                    <div class="stats-wrapper mt-4">
                        <div class="row g-3">
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">{{ $totalTutors }}+</h3>
                                    <p class="stat-label">Tuteurs certifiés</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">{{ count($allCities) }}+</h3>
                                    <p class="stat-label">Villes disponibles</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="stat-number">{{ count($allSubjects) }}+</h3>
                                    <p class="stat-label">Matières enseignées</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Partie droite avec l'image -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="hero-image-wrapper position-relative">
                        <img src="{{ asset('images/image_1.webp') }}" alt="Kopiao - Trouvez votre tuteur"
                            class="img-fluid hero-image rounded-4 shadow-lg">

                        <!-- Badges flottants -->
                        <div class="floating-badges">
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="600">
                                <div class="badge-icon">
                                    <i class="bi bi-person-check"></i>
                                </div>
                                <div class="badge-content">
                                    <span class="badge-number">{{ $totalTutors }}+</span>
                                    <span class="badge-label">Tuteurs actifs</span>
                                </div>
                            </div>
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="650">
                                <div class="badge-icon">
                                    <i class="bi bi-book"></i>
                                </div>
                                <div class="badge-content">
                                    <span class="badge-number">{{ count($allSubjects) }}+</span>
                                    <span class="badge-label">Matières</span>
                                </div>
                            </div>
                            <div class="badge-item" data-aos="zoom-in" data-aos-delay="700">
                                <div class="badge-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <div class="badge-content">
                                    <span class="badge-number">100%</span>
                                    <span class="badge-label">Paiement sécurisé</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>
    <!-- Cartes d'inscription en débordement -->
    <div class="row registration-row">
        <div class="col-12">
            <div class="registration-cards-container">
                <!-- Carte Tuteur (déborde vers le bas) -->
                <div class="registration-card tutor-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-content">
                        <div class="card-icon-wrapper">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <h3>Devenir Tuteur</h3>
                        <p class="card-description">
                            Partagez votre expertise et enseignez à des apprenants du monde entier.
                            Rejoignez notre communauté de tuteurs certifiés.
                        </p>
                        <a href="{{ route('register.tuteur') }}" class="btn-register tutor-register">
                            S'inscrire comme Tuteur
                        </a>
                    </div>
                </div>

                <!-- Carte Consulter les Tuteurs (NOUVELLE) -->
                <div class="registration-card browse-card" data-aos="fade-up" data-aos-delay="450">
                    <div class="card-content">
                        <div class="card-icon-wrapper">
                            <i class="bi bi-search-heart"></i>
                        </div>
                        <h3>Consulter les Tuteurs</h3>
                        <p class="card-description">
                            Parcourez notre liste de tuteurs qualifiés et trouvez celui qui correspond à vos besoins.

                        </p>

                        <a href="{{ route('recherche.tuteur') }}" class="btn-register browse-register">
                            <i class="bi bi-eye me-2"></i>Voir tous les tuteurs
                        </a>
                    </div>
                </div>

                <!-- Carte Apprenant (déborde vers le bas) -->
                <div class="registration-card student-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="card-content">
                        <div class="card-icon-wrapper">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <h3>Devenir Apprenant</h3>
                        <p class="card-description">
                            Trouvez le tuteur idéal pour atteindre vos objectifs académiques.
                            Apprenez à votre rythme avec des professionnels qualifiés.
                        </p>
                        <a href="{{ route('register') }}" class="btn-register student-register">
                            S'inscrire comme Apprenant
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styles existants de la section hero */
        .hero {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            padding: 80px 0 150px 0;
            /* Augmentation du padding bottom pour accueillir les cartes */
            position: relative;
            overflow: hidden;
            /* Changé de hidden à visible pour permettre le débordement */
            z-index: 1;
            height: 200px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: #2c3e50;
            font-weight: 500;
        }

        /* Style de la barre de recherche */
        .search-wrapper {
            background: white;
            border-radius: 60px;
            padding: 5px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search-wrapper:hover {
            box-shadow: 0 15px 40px rgba(13, 110, 253, 0.15);
            transform: translateY(-2px);
        }

        .input-group {
            border-radius: 60px;
            overflow: hidden;
        }

        .input-group-text {
            border: none;
            background: white;
            padding-left: 25px;
        }

        .input-group-text i {
            font-size: 1.3rem;
            color: #0d6efd;
        }

        .form-control {
            border: none;
            padding: 15px 0;
            font-size: 1.1rem;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-primary {
            border-radius: 50px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(13, 110, 253, 0.3);
        }

        /* Style des filtres */
        .filter-select {
            border-radius: 30px;
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            background: white;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-select:hover {
            border-color: #0d6efd;
            background: #f8f9fa;
        }

        .filter-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        /* Badges populaires */
        .popular-badge {
            padding: 8px 18px;
            background: white;
            border-radius: 30px;
            color: #495057;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .popular-badge:hover {
            background: #0d6efd;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
            border-color: #0d6efd;
        }

        .popular-badge i {
            font-size: 0.8rem;
        }

        .city-badge {
            background: linear-gradient(135deg, #fff5f5, #fff);
            border-color: #dc3545;
            color: #dc3545;
        }

        .city-badge:hover {
            background: #dc3545 !important;
            color: white !important;
            border-color: #dc3545;
        }

        /* Statistiques */
        .stat-item {
            text-align: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0d6efd;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0;
            font-weight: 500;
        }

        /* Image et badges flottants */
        .hero-image-wrapper {
            position: relative;
            padding: 20px;
        }

        .hero-image {
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            transition: all 0.5s ease;
        }

        .hero-image:hover {
            transform: scale(1.02);
        }

        .floating-badges {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .badge-item {
            position: absolute;
            display: flex;
            align-items: center;
            background: white;
            padding: 12px 20px;
            border-radius: 60px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            pointer-events: auto;
            transition: all 0.3s ease;
        }

        .badge-item:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .badge-item:nth-child(1) {
            top: 10%;
            left: -5%;
            animation: float 3s ease-in-out infinite;
        }

        .badge-item:nth-child(2) {
            bottom: 15%;
            right: -5%;
            animation: float 4s ease-in-out infinite;
        }

        .badge-item:nth-child(3) {
            top: 40%;
            right: 5%;
            animation: float 3.5s ease-in-out infinite;
        }

        .badge-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .badge-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .badge-content {
            display: flex;
            flex-direction: column;
        }

        .badge-number {
            font-weight: 800;
            color: #2c3e50;
            font-size: 1.1rem;
            line-height: 1.2;
        }

        .badge-label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Styles pour les cartes d'inscription en débordement */
        .registration-row {
            margin-top: 50px;
            position: relative;
            z-index: 10;
        }

        .registration-cards-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .registration-card {
            flex: 0 1 400px;
            background: white;
            border-radius: 30px;
            padding: 35px 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transform: translateY(50px);
            /* Fait déborder les cartes vers le bas */
            margin-bottom: -20px;
            /* Crée l'effet de superposition */
        }

        .registration-card:hover {
            transform: translateY(40px) scale(1.02);
            /* Légère remontée au survol */
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.2);
        }

        .registration-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #0d6efd, #0a58ca);
            border-radius: 30px 30px 0 0;
        }

        .student-card::before {
            background: linear-gradient(90deg, #20c997, #0dcaf0);
        }

        .card-icon-wrapper {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e6f0ff, #cce0ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }

        .student-card .card-icon-wrapper {
            background: linear-gradient(135deg, #e6faf5, #cff2e9);
        }

        .card-icon-wrapper i {
            font-size: 2.8rem;
            color: #0d6efd;
        }

        .student-card .card-icon-wrapper i {
            color: #20c997;
        }

        .registration-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .card-description {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 25px;
            font-size: 1rem;
        }

        .btn-register {
            width: 100%;
            padding: 15px 25px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            text-decoration: none;
        }

        .tutor-register {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: white;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2);
        }

        .tutor-register:hover {
            background: linear-gradient(135deg, #0a58ca, #084298);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(13, 110, 253, 0.3);
        }

        .student-register {
            background: linear-gradient(135deg, #20c997, #0dcaf0);
            color: white;
            box-shadow: 0 10px 20px rgba(32, 201, 151, 0.2);
        }

        .student-register:hover {
            background: linear-gradient(135deg, #1ba87e, #0bb5d0);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(32, 201, 151, 0.3);
        }

        /* Animation d'entrée */
        .registration-card {
            animation: slideUpCard 0.8s ease-out forwards;
            opacity: 0;
        }

        .registration-card:nth-child(1) {
            animation-delay: 0.2s;
        }

        /* Styles pour la nouvelle carte */
        .browse-card::before {
            background: linear-gradient(90deg, #6f42c1, #d63384);
        }

        .browse-card .card-icon-wrapper {
            background: linear-gradient(135deg, #f3e8ff, #e6d9ff);
        }

        .browse-card .card-icon-wrapper i {
            color: #6f42c1;
        }

        .browse-register {
            background: linear-gradient(135deg, #6f42c1, #d63384);
            color: white;
            box-shadow: 0 10px 20px rgba(111, 66, 193, 0.2);
        }

        .browse-register:hover {
            background: linear-gradient(135deg, #5a32a3, #b82b6f);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(111, 66, 193, 0.3);
        }

        /* Mini statistiques pour la carte */
        .card-stats {
            display: flex;
            justify-content: space-around;
            background: rgba(111, 66, 193, 0.05);
            border-radius: 15px;
            padding: 12px 10px;
            margin: 15px 0;
        }

        .stat-mini {
            text-align: center;
            display: flex;
            flex-direction: column;
        }

        .stat-mini-number {
            font-weight: 700;
            font-size: 1.2rem;
            color: #6f42c1;
            line-height: 1.2;
        }

        .stat-mini-label {
            font-size: 0.7rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Ajustement du container pour 3 cartes */
        .registration-cards-container {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .registration-card {
            flex: 0 1 350px;
            /* Légèrement réduit pour 3 cartes */
        }

        /* Responsive pour 3 cartes */
        @media (max-width: 1200px) {
            .registration-card {
                flex: 0 1 320px;
            }
        }

        @media (max-width: 991.98px) {
            .registration-card {
                flex: 0 1 300px;
            }

            .card-stats {
                padding: 10px 5px;
            }

            .stat-mini-number {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .registration-card {
                flex: 0 1 100%;
                max-width: 400px;
            }

            .card-stats {
                padding: 12px 15px;
            }

            .stat-mini-number {
                font-size: 1.2rem;
            }
        }

        /* Animation personnalisée pour la nouvelle carte */
        .browse-card {
            animation: slideUpCard 0.8s ease-out forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }

        @keyframes slideUpCard {
            0% {
                opacity: 0;
                transform: translateY(100px);
            }

            100% {
                opacity: 1;
                transform: translateY(50px);
            }
        }

        .registration-card:nth-child(2) {
            animation-delay: 0.4s;
        }

        @keyframes slideUpCard {
            0% {
                opacity: 0;
                transform: translateY(100px);
            }

            100% {
                opacity: 1;
                transform: translateY(50px);
            }
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .hero {
                padding: 60px 0 120px 0;
            }

            .hero-title {
                font-size: 2.8rem;
            }

            .badge-item {
                display: none;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .registration-card {
                flex: 0 1 350px;
                padding: 30px 25px;
                transform: translateY(30px);
            }

            @keyframes slideUpCard {
                0% {
                    opacity: 0;
                    transform: translateY(80px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(30px);
                }
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .btn-primary {
                padding: 10px 20px;
            }

            .filter-select {
                font-size: 0.9rem;
            }

            .popular-badge {
                padding: 6px 12px;
                font-size: 0.85rem;
            }

            .registration-card {
                flex: 0 1 100%;
                max-width: 400px;
                margin-left: auto;
                margin-right: auto;
            }

            .registration-card h3 {
                font-size: 1.5rem;
            }

            .card-icon-wrapper {
                width: 60px;
                height: 60px;
            }

            .card-icon-wrapper i {
                font-size: 2rem;
            }

            .btn-register {
                padding: 12px 20px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .hero {
                padding: 40px 0 100px 0;
            }

            .stat-item {
                padding: 10px;
            }

            .stat-number {
                font-size: 1.2rem;
            }

            .stat-label {
                font-size: 0.8rem;
            }

            .registration-card {
                padding: 25px 20px;
                transform: translateY(20px);
            }

            @keyframes slideUpCard {
                0% {
                    opacity: 0;
                    transform: translateY(60px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(20px);
                }
            }
        }
    </style>


    <br><br><br>
    <!-- Matières Section -->
    <section id="subjects" class="subjects-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold gradient-text">Explorez les matières</h2>
                <p class="lead text-muted">Découvrez les {{ count($allSubjects) }} matières enseignées par nos tuteurs
                    certifiés</p>
                <div class="divider mx-auto"></div>
            </div>

            <!-- Conteneur des matières avec navigation -->
            <div class="subjects-carousel-container position-relative">
                <!-- Bouton précédent -->
                <button class="carousel-nav-btn prev-btn" id="prevSubjects" aria-label="Matières précédentes">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <!-- Grille des matières -->
                <div class="subjects-grid-wrapper overflow-hidden">
                    <div class="subjects-grid" id="subjectsGrid">
                        @foreach ($allSubjects as $index => $subject)
                            <div class="subject-card-wrapper" data-index="{{ $index }}">
                                <div class="subject-card">
                                    <div class="card-inner">
                                        <div class="subject-icon-wrapper">
                                            <div class="subject-icon">
                                                @php
                                                    // Association des icônes par matière
                                                    $iconMap = [
                                                        'Math' => 'bi-calculator',
                                                        'Mathématiques' => 'bi-calculator',
                                                        'Mathematics' => 'bi-calculator',
                                                        'Français' => 'bi-chat-quote',
                                                        'French' => 'bi-chat-quote',
                                                        'Anglais' => 'bi-chat',
                                                        'English' => 'bi-chat',
                                                        'Physique' => 'bi-flask',
                                                        'Physics' => 'bi-flask',
                                                        'Chimie' => 'bi-flask',
                                                        'Chemistry' => 'bi-flask',
                                                        'Biologie' => 'bi-tree',
                                                        'Biology' => 'bi-tree',
                                                        'SVT' => 'bi-tree',
                                                        'Histoire' => 'bi-clock-history',
                                                        'History' => 'bi-clock-history',
                                                        'Géographie' => 'bi-map',
                                                        'Geography' => 'bi-map',
                                                        'Philosophie' => 'bi-pencil',
                                                        'Philosophy' => 'bi-pencil',
                                                        'Économie' => 'bi-graph-up',
                                                        'Economics' => 'bi-graph-up',
                                                        'Management' => 'bi-briefcase',
                                                        'Informatique' => 'bi-laptop',
                                                        'Computer' => 'bi-laptop',
                                                        'Programmation' => 'bi-code-slash',
                                                        'Programming' => 'bi-code-slash',
                                                        'Musique' => 'bi-music-note',
                                                        'Music' => 'bi-music-note',
                                                        'Arts' => 'bi-brush',
                                                        'Art' => 'bi-brush',
                                                        'Sport' => 'bi-trophy',
                                                        'Droit' => 'bi-bank',
                                                        'Law' => 'bi-bank',
                                                        'Médecine' => 'bi-heart-pulse',
                                                        'Medicine' => 'bi-heart-pulse',
                                                        'Comptabilité' => 'bi-calculator',
                                                        'Accounting' => 'bi-calculator',
                                                        'Marketing' => 'bi-megaphone',
                                                        'Communication' => 'bi-chat-dots',
                                                        'Langues' => 'bi-translate',
                                                        'Languages' => 'bi-translate',
                                                    ];

                                                    $icon = 'bi-book'; // Icône par défaut
                                                    foreach ($iconMap as $key => $value) {
                                                        if (str_contains(strtolower($subject), strtolower($key))) {
                                                            $icon = $value;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                <i class="bi {{ $icon }}"></i>
                                            </div>
                                        </div>

                                        <h3 class="subject-title">{{ $subject }}</h3>

                                        @php
                                            $tutorCount = \App\Models\User::where('role_id', 3)
                                                ->where('is_valid', 1)
                                                ->where('is_active', 1)
                                                ->where(function ($query) use ($subject) {
                                                    $query
                                                        ->where('subjects', 'LIKE', '%"' . $subject . '"%')
                                                        ->orWhere('subjects', 'LIKE', '%' . $subject . '%');
                                                })
                                                ->count();
                                        @endphp

                                        <div class="subject-stats">
                                            <span class="tutor-count">{{ $tutorCount }}</span>
                                            <span class="tutor-label">tuteur(s) disponible(s)</span>
                                        </div>

                                        <a href="{{ route('recherche.tuteur', ['subject' => $subject]) }}"
                                            class="subject-link">
                                            <span>Voir les tuteurs</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>

                                        <!-- Éléments décoratifs -->
                                        <div class="card-glow"></div>
                                        <div class="card-particles"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Bouton suivant -->
                <button class="carousel-nav-btn next-btn" id="nextSubjects" aria-label="Matières suivantes">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <!-- Indicateurs de page -->
            <div class="pagination-indicators mt-5" id="paginationIndicators">
                <!-- Généré dynamiquement par JavaScript -->
            </div>

            <!-- Lien voir toutes les matières -->
            @if (count($allSubjects) > 8)
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('recherche.tuteur') }}" class="btn-view-all">
                        <span>Explorer toutes les matières</span>
                        <i class="bi bi-arrow-right-circle ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <style>
        .subjects-section {
            background: linear-gradient(135deg, #fafbfc 0%, #f5f7fa 100%);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        /* Éléments décoratifs de fond */
        .subjects-section::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.03) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            animation: float 20s ease-in-out infinite;
        }

        .subjects-section::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.02) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            animation: float 15s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(2%, 2%) rotate(2deg);
            }

            75% {
                transform: translate(-2%, -2%) rotate(-2deg);
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #0d6efd, #0a58ca, #6f42c1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #0d6efd, #6f42c1);
            border-radius: 2px;
            margin-top: 20px;
            animation: dividerPulse 2s ease-in-out infinite;
        }

        @keyframes dividerPulse {

            0%,
            100% {
                width: 80px;
                opacity: 1;
            }

            50% {
                width: 120px;
                opacity: 0.8;
            }
        }

        .subjects-carousel-container {
            position: relative;
            padding: 20px 60px;
            z-index: 1;
        }

        .subjects-grid-wrapper {
            overflow: hidden;
            border-radius: 30px;
            padding: 20px 10px;
        }

        .subjects-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .subject-card-wrapper {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
            animation: cardAppear 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            transition: all 0.3s ease;
        }

        @keyframes cardAppear {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }



        .subject-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 30px 20px 35px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(13, 110, 253, 0.05);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .subject-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 30px 60px rgba(13, 110, 253, 0.15), 0 0 0 2px rgba(13, 110, 253, 0.1);
            background: white;
        }

        .card-inner {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .subject-icon-wrapper {
            position: relative;
            margin-bottom: 25px;
        }

        .subject-icon-wrapper::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.4s ease;
        }

        .subject-card:hover .subject-icon-wrapper::before {
            opacity: 1;
            transform: scale(1);
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {

            0%,
            100% {
                opacity: 0.5;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.1);
            }
        }

        .subject-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid rgba(13, 110, 253, 0.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .subject-card:hover .subject-icon {
            transform: rotate(5deg) scale(1.1);
            border-color: #0d6efd;
            box-shadow: 0 15px 30px rgba(13, 110, 253, 0.2);
        }

        .subject-icon i {
            font-size: 3rem;
            color: #0d6efd;
            transition: all 0.4s ease;
        }

        .subject-card:hover .subject-icon i {
            transform: scale(1.1);
            color: #0a58ca;
        }

        .subject-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 15px;
            transition: all 0.3s ease;
        }

        .subject-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #0d6efd, transparent);
            transition: all 0.3s ease;
        }

        .subject-card:hover .subject-title::after {
            width: 60px;
            background: linear-gradient(90deg, #0d6efd, #6f42c1);
        }

        .subject-stats {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.05), rgba(111, 66, 193, 0.05));
            padding: 12px 20px;
            border-radius: 50px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            border: 1px solid rgba(13, 110, 253, 0.1);
            backdrop-filter: blur(5px);
        }

        .subject-card:hover .subject-stats {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.1), rgba(111, 66, 193, 0.1));
            border-color: rgba(13, 110, 253, 0.2);
            transform: scale(1.05);
        }

        .tutor-count {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0d6efd, #6f42c1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-right: 5px;
        }

        .tutor-label {
            font-size: 0.95rem;
            color: #495057;
            font-weight: 500;
        }

        .subject-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
            padding: 12px 25px;
            border-radius: 50px;
            background: white;
            border: 2px solid rgba(13, 110, 253, 0.1);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            margin-top: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
        }

        .subject-link:hover {
            background: linear-gradient(135deg, #0d6efd, #6f42c1);
            color: white;
            gap: 15px;
            padding: 12px 30px;
            border-color: transparent;
            box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3);
        }

        .subject-link i {
            transition: transform 0.3s ease;
        }

        .subject-link:hover i {
            transform: translateX(8px);
        }

        /* Éléments décoratifs */
        .card-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: radial-gradient(circle at 50% 0%, rgba(13, 110, 253, 0.1), transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .subject-card:hover .card-glow {
            opacity: 1;
        }

        .card-particles {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(circle, #0d6efd 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
            mask-image: radial-gradient(circle at 50% 50%, black, transparent 80%);
        }

        .subject-card:hover .card-particles {
            opacity: 0.1;
            animation: particlesMove 20s linear infinite;
        }

        @keyframes particlesMove {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 40px 40px;
            }
        }

        /* Boutons de navigation */
        .carousel-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: white;
            border: none;
            color: #0d6efd;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 10;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(13, 110, 253, 0.1);
        }

        .carousel-nav-btn:hover {
            background: linear-gradient(135deg, #0d6efd, #6f42c1);
            color: white;
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 15px 35px rgba(13, 110, 253, 0.3);
            border-color: transparent;
        }

        .carousel-nav-btn:active {
            transform: translateY(-50%) scale(0.95);
        }

        .carousel-nav-btn.prev-btn {
            left: -15px;
        }

        .carousel-nav-btn.next-btn {
            right: -15px;
        }

        /* Indicateurs de page */
        .pagination-indicators {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .page-indicator {
            width: 45px;
            height: 6px;
            border-radius: 3px;
            background: #e9ecef;
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .page-indicator::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #0d6efd, #6f42c1);
            transform: translateX(-100%);
            transition: transform 0.4s ease;
        }

        .page-indicator.active {
            width: 60px;
        }

        .page-indicator.active::before {
            transform: translateX(0);
        }

        .page-indicator:hover {
            background: #dee2e6;
            transform: scale(1.1);
        }

        /* Bouton voir tout */
        .btn-view-all {
            display: inline-flex;
            align-items: center;
            padding: 18px 45px;
            background: linear-gradient(135deg, #0d6efd, #6f42c1);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.2rem;
            border-radius: 60px;
            box-shadow: 0 15px 30px rgba(13, 110, 253, 0.2);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-view-all::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn-view-all:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.3);
        }

        .btn-view-all:hover::before {
            left: 100%;
        }

        .btn-view-all i {
            transition: transform 0.3s ease;
        }

        .btn-view-all:hover i {
            transform: translateX(8px);
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .subjects-grid {
                gap: 25px;
            }
        }

        @media (max-width: 1200px) {
            .subjects-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .subject-title {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 992px) {
            .subjects-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .carousel-nav-btn {
                width: 45px;
                height: 45px;
                font-size: 1.5rem;
            }

            .btn-view-all {
                padding: 15px 35px;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 768px) {
            .subjects-section {
                padding: 60px 0;
            }

            .subjects-carousel-container {
                padding: 20px 15px;
            }

            .subjects-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .subject-card {
                padding: 25px 15px 30px;
            }

            .subject-icon {
                width: 70px;
                height: 70px;
            }

            .subject-icon i {
                font-size: 2.2rem;
            }

            .subject-title {
                font-size: 1.1rem;
                padding-bottom: 12px;
            }

            .subject-stats {
                padding: 8px 15px;
            }

            .tutor-count {
                font-size: 1.2rem;
            }

            .tutor-label {
                font-size: 0.85rem;
            }

            .subject-link {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .carousel-nav-btn {
                display: none;
            }

            .subjects-carousel-container {
                padding: 0;
            }

            .page-indicator {
                width: 35px;
            }

            .page-indicator.active {
                width: 50px;
            }
        }

        @media (max-width: 576px) {
            .subjects-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .subject-card {
                max-width: 320px;
                margin: 0 auto;
            }

            .gradient-text {
                font-size: 2rem;
            }

            .lead {
                font-size: 1rem;
            }

            .btn-view-all {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const grid = document.getElementById('subjectsGrid');
            const prevBtn = document.getElementById('prevSubjects');
            const nextBtn = document.getElementById('nextSubjects');
            const indicators = document.getElementById('paginationIndicators');

            const cards = document.querySelectorAll('.subject-card-wrapper');
            const cardsPerPage = 8;
            const totalCards = cards.length;
            const totalPages = Math.ceil(totalCards / cardsPerPage);

            let currentPage = 0;

            // Animation d'entrée fluide
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.08}s`;
            });

            // Fonction pour mettre à jour l'affichage
            function updateDisplay() {
                const start = currentPage * cardsPerPage;
                const end = start + cardsPerPage;

                // Animation de sortie
                cards.forEach((card, index) => {
                    if (index >= start && index < end) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0) scale(1)';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px) scale(0.95)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });

                // Mettre à jour les indicateurs
                updateIndicators();

                // Gérer l'état des boutons
                prevBtn.disabled = currentPage === 0;
                nextBtn.disabled = currentPage >= totalPages - 1;

                // Style des boutons désactivés
                [prevBtn, nextBtn].forEach(btn => {
                    if (btn.disabled) {
                        btn.style.opacity = '0.5';
                        btn.style.cursor = 'not-allowed';
                        btn.style.pointerEvents = 'none';
                        btn.style.transform = 'translateY(-50%) scale(0.9)';
                    } else {
                        btn.style.opacity = '1';
                        btn.style.cursor = 'pointer';
                        btn.style.pointerEvents = 'auto';
                        btn.style.transform = 'translateY(-50%) scale(1)';
                    }
                });
            }

            // Créer les indicateurs de page
            function createIndicators() {
                indicators.innerHTML = '';
                for (let i = 0; i < totalPages; i++) {
                    const indicator = document.createElement('button');
                    indicator.className = 'page-indicator' + (i === currentPage ? ' active' : '');
                    indicator.setAttribute('data-page', i);
                    indicator.setAttribute('aria-label', `Page ${i + 1}`);
                    indicator.addEventListener('click', () => {
                        currentPage = i;
                        updateDisplay();

                        // Animation du clic
                        indicator.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            indicator.style.transform = 'scale(1)';
                        }, 200);
                    });
                    indicators.appendChild(indicator);
                }
            }

            // Mettre à jour les indicateurs
            function updateIndicators() {
                const indicatorButtons = document.querySelectorAll('.page-indicator');
                indicatorButtons.forEach((btn, index) => {
                    if (index === currentPage) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });
            }

            // Event listeners pour les boutons
            prevBtn.addEventListener('click', () => {
                if (currentPage > 0) {
                    // Animation du bouton
                    prevBtn.style.transform = 'translateY(-50%) scale(0.9)';
                    setTimeout(() => {
                        prevBtn.style.transform = 'translateY(-50%) scale(1)';
                    }, 200);

                    currentPage--;
                    updateDisplay();
                }
            });

            nextBtn.addEventListener('click', () => {
                if (currentPage < totalPages - 1) {
                    // Animation du bouton
                    nextBtn.style.transform = 'translateY(-50%) scale(0.9)';
                    setTimeout(() => {
                        nextBtn.style.transform = 'translateY(-50%) scale(1)';
                    }, 200);

                    currentPage++;
                    updateDisplay();
                }
            });

            // Initialisation
            if (totalPages > 1) {
                createIndicators();
                updateDisplay();
            } else {
                // Si une seule page, afficher toutes les cartes et cacher la navigation
                cards.forEach(card => {
                    card.style.display = 'block';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0) scale(1)';
                });
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
            }

            // Observer pour les animations au scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '50px'
            });

            document.querySelectorAll('.subject-card-wrapper').forEach(card => {
                observer.observe(card);
            });
        });
    </script>



<!-- Annonces Section -->
<section id="annonces" class="annonces-section py-5">
    <div class="container-fluid px-4">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold" style="color: #0000FF;">Opportunités d'enseignement</h2>
            <p class="lead text-muted">Découvrez les {{ $annonces->count() }} annonces publiées par nos étudiants</p>
            <div class="divider mx-auto" style="background: #0000FF;"></div>
        </div>

        <!-- Filtres des annonces -->
        <div class="filters-container mb-5 p-4 bg-white rounded-4 shadow-sm" data-aos="fade-up">
            <form action="{{ route('home') }}#annonces" method="GET" class="filters-form">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-2 col-md-4">
                        <div class="filter-group">
                            <label class="filter-label text-primary mb-2 fw-semibold" style="color: #0000FF !important;">
                                <i class="bi bi-book me-1" style="color: #0000FF;"></i> Domaine
                            </label>
                            <input type="text"
                                   name="annonce_subject"
                                   class="form-control border-2"
                                   style="border-color: #e0e0e0; color: #333; background: white;"
                                   placeholder="Maths, Français..."
                                   value="{{ $selectedAnnonceSubject }}"
                                   list="annonceSubjects">
                            <datalist id="annonceSubjects">
                                @foreach($allSubjects as $subject)
                                    <option value="{{ $subject }}">
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <div class="filter-group">
                            <label class="filter-label text-primary mb-2 fw-semibold" style="color: #0000FF !important;">
                                <i class="bi bi-coin me-1" style="color: #0000FF;"></i> Budget min
                            </label>
                            <input type="number"
                                   name="annonce_budget_min"
                                   class="form-control border-2"
                                   style="border-color: #e0e0e0; color: #333; background: white;"
                                   placeholder="Min (FCFA)"
                                   value="{{ $selectedAnnonceBudgetMin }}">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <div class="filter-group">
                            <label class="filter-label text-primary mb-2 fw-semibold" style="color: #0000FF !important;">
                                <i class="bi bi-coin me-1" style="color: #0000FF;"></i> Budget max
                            </label>
                            <input type="number"
                                   name="annonce_budget_max"
                                   class="form-control border-2"
                                   style="border-color: #e0e0e0; color: #333; background: white;"
                                   placeholder="Max (FCFA)"
                                   value="{{ $selectedAnnonceBudgetMax }}">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <div class="filter-group">
                            <label class="filter-label text-primary mb-2 fw-semibold" style="color: #0000FF !important;">
                                <i class="bi bi-laptop me-1" style="color: #0000FF;"></i> Format
                            </label>
                            <select name="annonce_format" class="form-select border-2"
                                    style="border-color: #e0e0e0; color: #333; background: white;">
                                <option value="">Tous</option>
                                <option value="presentiel" {{ $selectedAnnonceFormat == 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                                <option value="en_ligne" {{ $selectedAnnonceFormat == 'en_ligne' ? 'selected' : '' }}>En ligne</option>
                                <option value="hybrid" {{ $selectedAnnonceFormat == 'hybrid' ? 'selected' : '' }}>Hybride</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <div class="filter-group">
                            <label class="filter-label text-primary mb-2 fw-semibold" style="color: #0000FF !important;">
                                <i class="bi bi-calendar me-1" style="color: #0000FF;"></i> Disponibilité
                            </label>
                            <input type="text"
                                   name="annonce_disponibilite"
                                   class="form-control border-2"
                                   style="border-color: #e0e0e0; color: #333; background: white;"
                                   placeholder="Lundi, Mardi..."
                                   value="{{ $selectedAnnonceDisponibilite }}">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <button type="submit" class="btn w-100 py-2"
                                style="background: #0000FF; color: white; border: none; border-radius: 8px; font-weight: 500;">
                            <i class="bi bi-funnel me-2"></i>Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Carousel des annonces -->
        <div class="annonces-carousel-container position-relative" data-aos="fade-up">
            <button class="carousel-nav-btn prev-btn" id="prevAnnonce" aria-label="Annonce précédente"
                    style="background: white; color: #0000FF; border: 2px solid #0000FF;">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="annonces-carousel-wrapper overflow-hidden">
                <div class="annonces-carousel" id="annoncesCarousel">
                    @forelse($annonces as $annonce)
                        <div class="annonce-card-wrapper">
                            <div class="annonce-card bg-white rounded-4 shadow-sm"
                                 style="border: 1px solid #e0e0e0; transition: all 0.3s ease;">
                                <div class="card-badge {{ $annonce->format }}"
                                     style="background: #0000FF; color: white;">
                                    @if($annonce->format == 'presentiel')
                                        <i class="bi bi-person-workspace"></i> Présentiel
                                    @elseif($annonce->format == 'en_ligne')
                                        <i class="bi bi-laptop"></i> En ligne
                                    @else
                                        <i class="bi bi-arrow-left-right"></i> Hybride
                                    @endif
                                </div>

                                <div class="card-header d-flex justify-content-between align-items-start mb-3">
                                    <h3 class="annonce-title fw-bold mb-0" style="color: #333;">{{ $annonce->domaine }}</h3>
                                    <div class="annonce-budget text-end">
                                        <span class="budget-amount d-block fw-bold" style="color: #0000FF; font-size: 1.3rem;">
                                            {{ number_format($annonce->budget, 0, ',', ' ') }}
                                        </span>
                                        <span class="budget-currency" style="color: #666; font-size: 0.8rem;">FCFA</span>
                                    </div>
                                </div>

                                <div class="annonce-student d-flex align-items-center gap-3 mb-3 pb-2"
                                     style="border-bottom: 1px solid #f0f0f0;">
                                    <div class="student-avatar rounded-circle overflow-hidden d-flex align-items-center justify-content-center"
                                         style="width: 45px; height: 45px; background: #f0f0f0;">
                                        @if($annonce->student->photo_path)
                                            <img src="{{ asset('storage/' . $annonce->student->photo_path) }}"
                                                 alt="{{ $annonce->student->firstname }}"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-person-circle" style="font-size: 2rem; color: #0000FF;"></i>
                                        @endif
                                    </div>
                                    <div class="student-info">
                                        <span class="student-name d-block fw-semibold" style="color: #333;">
                                            {{ $annonce->student->firstname }} {{ $annonce->student->lastname }}
                                        </span>
                                        <span class="post-date" style="color: #666; font-size: 0.8rem;">
                                            Publiée {{ $annonce->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>

                                <p class="annonce-description mb-3" style="color: #555; line-height: 1.5;">
                                    {{ Str::limit($annonce->description, 120) }}
                                </p>

                                <div class="annonce-disponibilite d-flex align-items-center gap-2 p-2 rounded mb-3"
                                     style="background: #f8f9fa;">
                                    <i class="bi bi-calendar-check" style="color: #0000FF;"></i>
                                    <span style="color: #555; font-size: 0.9rem;">{{ Str::limit($annonce->disponibilite, 50) }}</span>
                                </div>

                                <div class="card-footer mt-auto">
                                    <a href="{{ route('login') }}"
                                       class="btn-postuler d-flex align-items-center justify-content-center gap-2 w-100 py-2 rounded"
                                       style="background: #0000FF; color: white; text-decoration: none; font-weight: 500; border: none;"
                                       onclick="event.preventDefault(); showLoginMessage();">
                                        <i class="bi bi-send"></i>
                                        Postuler
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-annonces text-center py-5 w-100">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <h4 class="mt-3" style="color: #333;">Aucune annonce pour le moment</h4>
                            <p class="text-muted">Revenez plus tard ou créez une alerte</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <button class="carousel-nav-btn next-btn" id="nextAnnonce" aria-label="Annonce suivante"
                    style="background: white; color: #0000FF; border: 2px solid #0000FF;">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        <!-- Indicateurs de page -->
        @if($annonces->count() > 0)
            <div class="carousel-indicators mt-4 d-flex justify-content-center gap-2" id="annonceIndicators"></div>
        @endif

        <!-- Message de connexion (modal) -->
        <div class="modal fade" id="loginMessageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px; border: none;">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <div class="modal-icon mb-4 mx-auto d-flex align-items-center justify-content-center rounded-circle"
                             style="width: 80px; height: 80px; background: #0000FF;">
                            <i class="bi bi-person-lock" style="font-size: 2.5rem; color: white;"></i>
                        </div>
                        <h4 class="fw-bold mb-3" style="color: #333;">Connexion requise</h4>
                        <p class="text-muted mb-4">
                            Pour postuler à une annonce, vous devez être connecté en tant que tuteur.
                            Connectez-vous ou créez un compte tuteur pour continuer.
                        </p>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                            <a href="{{ route('login') }}" class="btn px-4 py-2"
                               style="background: #0000FF; color: white; border-radius: 8px; text-decoration: none;">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                            </a>
                            <a href="{{ route('register.tuteur') }}" class="btn px-4 py-2"
                               style="background: white; color: #0000FF; border: 2px solid #0000FF; border-radius: 8px; text-decoration: none;">
                                <i class="bi bi-person-plus me-2"></i>Devenir tuteur
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.annonces-section {
    background: white;
    padding: 80px 0;
    position: relative;
}

.section-header .divider {
    width: 80px;
    height: 4px;
    background: #0000FF;
    border-radius: 2px;
    margin-top: 20px;
}

/* Filtres */
.filters-container {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 15px;
}

.filter-label {
    color: #0000FF !important;
    font-size: 0.9rem;
}

.filter-label i {
    color: #0000FF;
}

.form-control, .form-select {
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 10px 12px;
    color: #333;
    background: white;
}

.form-control:focus, .form-select:focus {
    border-color: #0000FF;
    box-shadow: 0 0 0 0.2rem rgba(0, 0, 255, 0.1);
    outline: none;
}

.form-control::placeholder {
    color: #999;
}

/* Carousel */
.annonces-carousel-container {
    padding: 20px 60px;
    position: relative;
}

.annonces-carousel-wrapper {
    overflow: hidden;
    border-radius: 15px;
}

.annonces-carousel {
    display: flex;
    gap: 25px;
    transition: transform 0.5s ease;
}

.annonce-card-wrapper {
    flex: 0 0 calc(33.333% - 17px);
    min-width: 300px;
}

.annonce-card {
    padding: 25px;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
}

.annonce-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 255, 0.1) !important;
    border-color: #0000FF;
}

.card-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    background: #0000FF;
    color: white;
}

/* Navigation */
.carousel-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: white;
    color: #0000FF;
    border: 2px solid #0000FF;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.carousel-nav-btn:hover {
    background: #0000FF;
    color: white;
    transform: translateY(-50%) scale(1.1);
}

.carousel-nav-btn.prev-btn {
    left: 0;
}

.carousel-nav-btn.next-btn {
    right: 0;
}

/* Indicateurs */
.carousel-indicators {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.carousel-indicator {
    width: 40px;
    height: 4px;
    border-radius: 2px;
    background: #e0e0e0;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.carousel-indicator.active {
    background: #0000FF;
    width: 60px;
}

.carousel-indicator:hover {
    background: #666;
}

/* Responsive */
@media (max-width: 1200px) {
    .annonce-card-wrapper {
        flex: 0 0 calc(50% - 12.5px);
    }
}

@media (max-width: 768px) {
    .annonce-card-wrapper {
        flex: 0 0 100%;
    }

    .annonces-carousel-container {
        padding: 20px 40px;
    }

    .carousel-nav-btn {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 576px) {
    .annonces-carousel-container {
        padding: 20px 30px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('annoncesCarousel');
    const prevBtn = document.getElementById('prevAnnonce');
    const nextBtn = document.getElementById('nextAnnonce');
    const indicators = document.getElementById('annonceIndicators');

    if (!carousel || !prevBtn || !nextBtn) return;

    const cards = document.querySelectorAll('.annonce-card-wrapper');
    const visibleCards = window.innerWidth > 1200 ? 3 : (window.innerWidth > 768 ? 2 : 1);
    const totalCards = cards.length;
    const totalPages = Math.ceil(totalCards / visibleCards);

    let currentPage = 0;

    function updateCarousel() {
        const translateX = -(currentPage * 100) + '%';
        carousel.style.transform = `translateX(${translateX})`;
        updateIndicators();
    }

    function createIndicators() {
        if (!indicators) return;
        indicators.innerHTML = '';
        for (let i = 0; i < totalPages; i++) {
            const indicator = document.createElement('button');
            indicator.className = 'carousel-indicator' + (i === currentPage ? ' active' : '');
            indicator.setAttribute('data-page', i);
            indicator.addEventListener('click', () => {
                currentPage = i;
                updateCarousel();
            });
            indicators.appendChild(indicator);
        }
    }

    function updateIndicators() {
        document.querySelectorAll('.carousel-indicator').forEach((btn, index) => {
            if (index === currentPage) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    prevBtn.addEventListener('click', () => {
        if (currentPage > 0) {
            currentPage--;
            updateCarousel();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentPage < totalPages - 1) {
            currentPage++;
            updateCarousel();
        }
    });

    if (totalPages > 1) {
        createIndicators();
    } else {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    }
});

function showLoginMessage() {
    const modal = new bootstrap.Modal(document.getElementById('loginMessageModal'));
    modal.show();
}
</script>




    <!-- Top Tutors Section -->
    <section id="tutors" class="tutors-gallery section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Tuteurs récemment inscrits</h2>
            <p>Découvrez les derniers professeurs à avoir rejoint Kopiao</p>
        </div>

        <div class="container" data-aos="fade-up">
            <!-- Première rangée (3 tuteurs) -->
            <div class="row justify-content-center mb-4">
                @foreach ($recentTutors->take(3) as $index => $tutor)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="tutor-card" data-tutor-id="{{ $tutor->id }}">

                            <!-- Badge tuteur vérifié -->
                            @if ($tutor->role_id == 3 && $tutor->is_valid == 1)
                                <div class="mb-2" style="display:flex; justify-content:center;">
                                    <span
                                        style="
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:8px 18px;
            font-size:14px;
            font-weight:600;
            border-radius:50px;
            background:linear-gradient(135deg,#8ca728,#20c997);
            color:#ffffff;
            box-shadow:0 8px 20px rgba(40,167,69,0.3);
            transition:all 0.3s ease;
        ">
                                        <i class="fas fa-check-circle" style="font-size:16px;"></i>
                                        Tuteur vérifié
                                    </span>
                                </div>
                            @endif


                            <div class="tutor-image-wrapper">
                                <img src="{{ $tutor->photo_path ? asset('storage/' . $tutor->photo_path) : asset('images/profill_default.webp') }}"
                                    alt="{{ $tutor->firstname }}" class="tutor-img">
                                <div class="tutor-overlay">
                                    <button class="btn-view-profile" data-bs-toggle="modal"
                                        data-bs-target="#tutorModal{{ $tutor->id }}">
                                        <i class="bi bi-eye"></i> Voir le profil
                                    </button>
                                </div>
                            </div>
                            <div class="tutor-info">

                                <h4 class="tutor-name">{{ $tutor->firstname }} {{ $tutor->lastname }}</h4>

                                @php
                                    // Gestion des matières
                                    $subjects = [];
                                    if (!empty($tutor->subjects)) {
                                        $decoded = json_decode($tutor->subjects, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $subjects = $decoded;
                                        } else {
                                            $subjects = array_map('trim', explode(',', $tutor->subjects));
                                        }
                                    }
                                    $subjects = array_filter($subjects);
                                @endphp

                                <p class="tutor-subjects">
                                    @if (!empty($subjects))
                                        {{ implode(', ', array_slice($subjects, 0, 2)) }}
                                        @if (count($subjects) > 2)
                                            <span class="more-subjects">+{{ count($subjects) - 2 }}</span>
                                        @endif
                                    @else
                                        Spécialité non précisée
                                    @endif
                                </p>
                                <p class="tutor-location">
                                    <i class="bi bi-geo-alt"></i> {{ $tutor->city ?? 'Ville non précisée' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Deuxième rangée (3 tuteurs) avec effet de superposition -->
            @if ($recentTutors->count() > 3)
                <div class="row justify-content-center mt-5 g-4">
                    @foreach ($recentTutors->slice(3, 3) as $tutor)
                        <div class="col-lg-4 col-md-6">
                            <div class="tutor-card" data-tutor-id="{{ $tutor->id }}">


                                <!-- Badge tuteur vérifié -->
                                @if ($tutor->role_id == 3 && $tutor->is_valid == 1)
                                    <div class="mb-2" style="display:flex; justify-content:center;">
                                        <span
                                            style="
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:8px 18px;
            font-size:14px;
            font-weight:600;
            border-radius:50px;
            background:linear-gradient(135deg,#92ce23,#20c997);
            color:#ffffff;
            box-shadow:0 8px 20px rgba(40,167,69,0.3);
            transition:all 0.3s ease;
            cursor:default;
        ">
                                            <i class="fas fa-check-circle" style="font-size:16px;"></i>
                                            Tuteur vérifié
                                        </span>
                                    </div>
                                @endif



                                <div class="tutor-image-wrapper">
                                    <img src="{{ $tutor->photo_path ? asset('storage/' . $tutor->photo_path) : asset('images/profill_default.webp') }}"
                                        alt="{{ $tutor->firstname }}" class="tutor-img">
                                    <div class="tutor-overlay">
                                        <button class="btn-view-profile" data-bs-toggle="modal"
                                            data-bs-target="#tutorModal{{ $tutor->id }}">
                                            <i class="bi bi-eye"></i> Voir le profil
                                        </button>
                                    </div>
                                </div>
                                <div class="tutor-info">
                                    <h4 class="tutor-name">{{ $tutor->firstname }} {{ $tutor->lastname }}</h4>

                                    @php
                                        $subjects = [];
                                        if (!empty($tutor->subjects)) {
                                            $decoded = json_decode($tutor->subjects, true);
                                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                $subjects = $decoded;
                                            } else {
                                                $subjects = array_map('trim', explode(',', $tutor->subjects));
                                            }
                                        }
                                        $subjects = array_filter($subjects);
                                    @endphp

                                    <p class="tutor-subjects">
                                        @if (!empty($subjects))
                                            {{ implode(', ', array_slice($subjects, 0, 2)) }}
                                            @if (count($subjects) > 2)
                                                <span class="more-subjects">+{{ count($subjects) - 2 }}</span>
                                            @endif
                                        @else
                                            Spécialité non précisée
                                        @endif
                                    </p>
                                    <p class="tutor-location">
                                        <i class="bi bi-geo-alt"></i> {{ $tutor->city ?? 'Ville non précisée' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        <!-- Bouton Voir plus -->

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('recherche.tuteur') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-arrow-right"></i> Voir tous les tuteurs
            </a>
        </div>

    </section>

    <!-- Modals pour chaque tuteur -->
    @foreach ($recentTutors as $tutor)
        <div class="modal fade" id="tutorModal{{ $tutor->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0 position-relative">
                        <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="tutor-modal-content">
                            <div class="tutor-modal-image">
                                <img src="{{ $tutor->photo_path ? asset('storage/' . $tutor->photo_path) : asset('images/profill_default.webp') }}"
                                    alt="{{ $tutor->firstname }}">
                            </div>
                            <div class="tutor-modal-info">
                                <div class="tutor-modal-header">
                                    <h3>{{ $tutor->firstname }} {{ $tutor->lastname }}</h3>

                                </div>

                                <div class="tutor-modal-details">
                                    <div class="detail-item">
                                        <i class="bi bi-geo-alt"></i>
                                        <span>{{ $tutor->city ?? 'Ville non précisée' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="bi bi-cash-coin"></i>
                                        <span>{{ $tutor->rate_per_hour ? number_format($tutor->rate_per_hour, 0, ',', ' ') . ' FCFA / h' : 'Tarif non défini' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="bi bi-whatsapp"></i>
                                        <span>{{ $tutor->telephone ?? 'Non disponible' }}</span>
                                    </div>
                                </div>

                                <div class="tutor-modal-subjects">
                                    <h6>Spécialités :</h6>
                                    @php
                                        $subjects = [];
                                        if (!empty($tutor->subjects)) {
                                            $decoded = json_decode($tutor->subjects, true);
                                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                $subjects = $decoded;
                                            } else {
                                                $subjects = array_map('trim', explode(',', $tutor->subjects));
                                            }
                                        }
                                        $subjects = array_filter($subjects);
                                    @endphp

                                    <div class="subjects-list">
                                        @foreach ($subjects as $subject)
                                            <span class="subject-badge">{{ $subject }}</span>
                                        @endforeach
                                        @if (empty($subjects))
                                            <span class="text-muted">Aucune spécialité renseignée</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="tutor-modal-bio">
                                    <h6>À propos :</h6>
                                    <p>{{ $tutor->bio ?? 'Pas encore de biographie disponible.' }}</p>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        .tutors-gallery {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 80px 0;
        }

        .tutor-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            height: 100%;
        }

        .tutor-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            z-index: 50 !important;
        }

        .tutor-card.stacked {
            position: relative;
            transition: all 0.4s ease;
        }

        .tutor-card.stacked:hover {
            margin-left: 0 !important;
            z-index: 100 !important;
        }

        .tutor-image-wrapper {
            position: relative;
            height: 280px;
            overflow: hidden;
        }

        .tutor-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .tutor-card:hover .tutor-img {
            transform: scale(1.1);
        }

        .tutor-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.4s ease;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 20px;
        }

        .tutor-card:hover .tutor-overlay {
            opacity: 1;
        }

        .btn-view-profile {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            color: #0d6efd;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-view-profile:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .tutor-info {
            padding: 25px;
        }

        .tutor-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #ffc107;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .tutor-name {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1.3rem;
        }

        .tutor-subjects {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .more-subjects {
            background: #e9ecef;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.8rem;
            margin-left: 5px;
        }

        .tutor-location {
            color: #495057;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 25px;
            overflow: hidden;
            border: none;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #666;
            transition: all 0.3s ease;
            z-index: 1000;
            border: 2px solid #eee;
        }

        .close-modal:hover {
            background: #f8f9fa;
            color: #333;
            transform: rotate(90deg);
        }

        .tutor-modal-content {
            display: flex;
            height: 600px;
        }

        .tutor-modal-image {
            flex: 0 0 40%;
            overflow: hidden;
        }

        .tutor-modal-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .tutor-modal-info {
            flex: 0 0 60%;
            padding: 40px;
            overflow-y: auto;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .tutor-modal-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .tutor-modal-header h3 {
            color: #2c3e50;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .tutor-modal-rating {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stars {
            color: #ddd;
            font-size: 1.2rem;
        }

        .stars .active {
            color: #ffc107;
        }

        .rating-text {
            font-weight: 600;
            color: #6c757d;
        }

        .tutor-modal-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #495057;
        }

        .detail-item i {
            color: #0d6efd;
            font-size: 1.2rem;
        }

        .tutor-modal-subjects h6,
        .tutor-modal-bio h6 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .subjects-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
        }

        .subject-badge {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .tutor-modal-bio p {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .tutor-modal-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .tutor-modal-actions .btn {
            flex: 1;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .tutor-modal-actions .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .tutor-modal-content {
                flex-direction: column;
                height: auto;
            }

            .tutor-modal-image {
                flex: 0 0 300px;
            }

            .tutor-modal-info {
                flex: 1;
            }

            .tutor-card.stacked {
                margin-left: 0 !important;
                margin-top: -50px;
                z-index: 10;
            }
        }

        @media (max-width: 768px) {
            .tutor-modal-details {
                grid-template-columns: 1fr;
            }

            .tutor-modal-actions {
                flex-direction: column;
            }

            .tutor-image-wrapper {
                height: 250px;
            }
        }

        @media (max-width: 576px) {
            .tutor-card {
                margin-bottom: 30px;
            }

            .tutor-card.stacked {
                margin-top: -30px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser AOS
            AOS.init({
                duration: 800,
                once: true
            });

            // Animation des cartes empilées
            const stackedCards = document.querySelectorAll('.tutor-card.stacked');

            stackedCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    // Remettre toutes les cartes en position initiale
                    stackedCards.forEach(c => {
                        c.style.transform = 'translateY(0)';
                        c.style.marginLeft = c.style.marginLeft;
                    });

                    // Animer la carte survolée
                    this.style.transform = 'translateY(-20px)';
                    this.style.marginLeft = '0px';

                    // Déplacer les autres cartes
                    const index = Array.from(stackedCards).indexOf(this);
                    stackedCards.forEach((c, i) => {
                        if (i < index) {
                            c.style.marginLeft = '-40px';
                        } else if (i > index) {
                            c.style.marginLeft = '40px';
                        }
                    });
                });

                card.addEventListener('mouseleave', function() {
                    // Revenir à la position initiale
                    stackedCards.forEach((c, i) => {
                        c.style.transform = 'translateY(0)';
                        c.style.marginLeft = (i * -20) + 'px';
                    });
                });
            });

            // Animation d'ouverture des modals
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-bs-target');
                    const modal = document.querySelector(modalId);

                    // Animation d'entrée
                    modal.querySelector('.modal-content').style.transform = 'scale(0.9)';
                    modal.querySelector('.modal-content').style.opacity = '0';

                    setTimeout(() => {
                        modal.querySelector('.modal-content').style.transition =
                            'all 0.4s ease';
                        modal.querySelector('.modal-content').style.transform = 'scale(1)';
                        modal.querySelector('.modal-content').style.opacity = '1';
                    }, 10);
                });
            });

            // Animation de fermeture des modals
            document.querySelectorAll('.close-modal').forEach(button => {
                button.addEventListener('click', function() {
                    const modal = this.closest('.modal');

                    // Animation de sortie
                    modal.querySelector('.modal-content').style.transform = 'scale(0.9)';
                    modal.querySelector('.modal-content').style.opacity = '0';

                    setTimeout(() => {
                        const bsModal = bootstrap.Modal.getInstance(modal);
                        if (bsModal) {
                            bsModal.hide();
                        }
                    }, 300);
                });
            });

            // Reset modal animation quand elle se ferme
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    this.querySelector('.modal-content').style.transform = '';
                    this.querySelector('.modal-content').style.opacity = '';
                    this.querySelector('.modal-content').style.transition = '';
                });
            });
        });
    </script>





<!-- Section CTA Annonces -->
<section id="annonces-cta" class="annonces-cta-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold" style="color: #0000FF;">Trouvez un tuteur ou proposez vos compétences</h2>
            <p class="lead text-muted">Rejoignez notre communauté et donnez un coup d'accélérateur à votre apprentissage</p>
            <div class="divider mx-auto" style="background: #0000FF; width: 80px; height: 4px; border-radius: 2px; margin-top: 20px;"></div>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Carte Publier une annonce (pour trouver un tuteur) -->
            <div class="col-lg-6 col-md-6" data-aos="fade-right" data-aos-delay="100">
                <div class="cta-card publish-card bg-white rounded-4 shadow-lg p-4 h-100 d-flex flex-column align-items-center text-center">

                    <!-- Image circulaire en haut -->
                    <div class="circular-image-wrapper mb-4">
                        <div class="circular-image rounded-circle overflow-hidden border border-4"
                             style="border-color: #0000FF !important; width: 180px; height: 180px; box-shadow: 0 10px 30px rgba(0,0,255,0.2);">
                            <img src="{{ asset('images/image_5.webp') }}" alt="Étudiant"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>

                    <!-- Icône de badge -->
                    <div class="icon-badge d-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm position-relative"
                         style="width: 50px; height: 50px; margin-top: -25px; margin-bottom: 15px; border: 2px solid #0000FF;">
                        <i class="bi bi-megaphone" style="font-size: 1.5rem; color: #0000FF;"></i>
                    </div>

                    <h3 class="fw-bold mb-3" style="color: #000; font-size: 1.8rem;">Vous cherchez un tuteur ?</h3>

                    <p class="mb-3 px-2" style="color: #333; font-size: 1rem; line-height: 1.6;">
                        Publiez une annonce gratuite et trouvez le tuteur idéal pour vos besoins spécifiques.
                        Des professionnels qualifiés vous répondront rapidement.
                    </p>

                    <div class="features-list mb-4 text-start w-100 px-3">
                        <div class="feature-item d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #0000FF;"></i>
                            <span style="color: #333;">Annonce gratuite</span>
                        </div>
                        <div class="feature-item d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #0000FF;"></i>
                            <span style="color: #333;">Tuteurs certifiés</span>
                        </div>
                        <div class="feature-item d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #0000FF;"></i>
                            <span style="color: #333;">Réponse rapide</span>
                        </div>
                    </div>

                    @auth
                        @if(Auth::user()->role_id == 2)
                            <a href="{{ route('annonces.create') }}" class="btn-cta btn-publish py-2 px-4 rounded-pill fw-bold mt-auto"
                               style="background: #0000FF; color: white; border: none; transition: all 0.3s ease; text-decoration: none;">
                                <i class="bi bi-plus-circle me-2"></i>Publier une annonce
                            </a>
                        @else
                            <button onclick="showRoleMessage('publier')" class="btn-cta btn-publish py-2 px-4 rounded-pill fw-bold mt-auto border-0"
                                    style="background: #0000FF; color: white; transition: all 0.3s ease;">
                                <i class="bi bi-plus-circle me-2"></i>Publier une annonce
                            </button>
                        @endif
                    @else
                        <button onclick="showLoginMessage('publier')" class="btn-cta btn-publish py-2 px-4 rounded-pill fw-bold mt-auto border-0"
                                style="background: #0000FF; color: white; transition: all 0.3s ease;">
                            <i class="bi bi-plus-circle me-2"></i>Publier une annonce
                        </button>
                    @endauth
                </div>
            </div>

            <!-- Carte Consulter les annonces (pour les tuteurs) -->
            <div class="col-lg-6 col-md-6" data-aos="fade-left" data-aos-delay="200">
                <div class="cta-card consult-card bg-white rounded-4 shadow-lg p-4 h-100 d-flex flex-column align-items-center text-center">

                    <!-- Image circulaire en haut -->
                    <div class="circular-image-wrapper mb-4">
                        <div class="circular-image rounded-circle overflow-hidden border border-4"
                             style="border-color: #00a36c !important; width: 180px; height: 180px; box-shadow: 0 10px 30px rgba(0,163,108,0.2);">
                            <img src="{{ asset('images/image_6.webp') }}" alt="Tuteur"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>

                    <!-- Icône de badge -->
                    <div class="icon-badge d-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm position-relative"
                         style="width: 50px; height: 50px; margin-top: -25px; margin-bottom: 15px; border: 2px solid #00a36c;">
                        <i class="bi bi-search-heart" style="font-size: 1.5rem; color: #00a36c;"></i>
                    </div>

                    <h3 class="fw-bold mb-3" style="color: #000; font-size: 1.8rem;">Vous êtes tuteur ?</h3>

                    <p class="mb-3 px-2" style="color: #333; font-size: 1rem; line-height: 1.6;">
                        Consultez les annonces publiées par les étudiants et trouvez des missions
                        qui correspondent à vos compétences et disponibilités.
                    </p>

                    <div class="features-list mb-4 text-start w-100 px-3">
                        <div class="feature-item d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #00a36c;"></i>
                            <span style="color: #333;">Missions variées</span>
                        </div>
                        <div class="feature-item d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #00a36c;"></i>
                            <span style="color: #333;">Choisissez vos horaires</span>
                        </div>
                        <div class="feature-item d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill" style="color: #00a36c;"></i>
                            <span style="color: #333;">Rémunération attractive</span>
                        </div>
                    </div>

                    @auth
                        @if(Auth::user()->role_id == 3)
                            <a href="{{ route('annonces.index') }}#annonces" class="btn-cta btn-consult py-2 px-4 rounded-pill fw-bold mt-auto"
                               style="background: #00a36c; color: white; border: none; transition: all 0.3s ease; text-decoration: none;">
                                <i class="bi bi-eye me-2"></i>Postuler à des annonces
                            </a>
                        @else
                            <button onclick="showRoleMessage('consulter')" class="btn-cta btn-consult py-2 px-4 rounded-pill fw-bold mt-auto border-0"
                                    style="background: #00a36c; color: white; transition: all 0.3s ease;">
                                <i class="bi bi-eye me-2"></i>Postuler à des annonces
                            </button>
                        @endif
                    @else
                        <button onclick="showLoginMessage('consulter')" class="btn-cta btn-consult py-2 px-4 rounded-pill fw-bold mt-auto border-0"
                                style="background: #00a36c; color: white; transition: all 0.3s ease;">
                            <i class="bi bi-eye me-2"></i>Postuler à des annonces
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour demander la connexion -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="modal-icon mb-4 mx-auto d-flex align-items-center justify-content-center rounded-circle"
                         style="width: 90px; height: 90px; background: #0000FF;">
                        <i class="bi bi-person-lock" style="font-size: 3rem; color: white;"></i>
                    </div>

                    <h3 class="fw-bold mb-3" style="color: #333;">Connexion requise</h3>

                    <p class="text-muted mb-4" id="modalMessage">
                        Pour continuer, vous devez d'abord créer un compte ou vous connecter.
                    </p>

                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="{{ route('login') }}" class="btn px-4 py-2"
                           style="background: #0000FF; color: white; border-radius: 10px; text-decoration: none; font-weight: 500;">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="btn px-4 py-2"
                           style="background: white; color: #0000FF; border: 2px solid #0000FF; border-radius: 10px; text-decoration: none; font-weight: 500;">
                            <i class="bi bi-person-plus me-2"></i>S'inscrire
                        </a>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <p class="mb-2 text-muted">Vous êtes tuteur ?</p>
                        <a href="{{ route('register.tuteur') }}" class="text-decoration-none" style="color: #0000FF;">
                            <i class="bi bi-arrow-right"></i> Créer un compte tuteur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour demander le bon rôle -->
    <div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="modal-icon mb-4 mx-auto d-flex align-items-center justify-content-center rounded-circle"
                         style="width: 90px; height: 90px; background: #FFA500;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem; color: white;"></i>
                    </div>

                    <h3 class="fw-bold mb-3" style="color: #333;">Action non autorisée</h3>

                    <p class="text-muted mb-4" id="roleModalMessage">
                        Cette action est réservée à un type de compte spécifique.
                    </p>

                    <div class="d-flex flex-column gap-3">
                        @auth
                            <p class="mb-0">Vous êtes connecté en tant que
                                <strong>
                                    @if(Auth::user()->role_id == 2)
                                        Étudiant
                                    @elseif(Auth::user()->role_id == 3)
                                        Tuteur
                                    @else
                                        Administrateur
                                    @endif
                                </strong>
                            </p>
                        @endauth

                        <a href="{{ route('home') }}" class="btn px-4 py-2"
                           style="background: #0000FF; color: white; border-radius: 10px; text-decoration: none; font-weight: 500;">
                            <i class="bi bi-house me-2"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.annonces-cta-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.cta-card {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid rgba(0,0,0,0.05);
}

.cta-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.circular-image-wrapper {
    transition: all 0.4s ease;
}

.cta-card:hover .circular-image-wrapper {
    transform: scale(1.05);
}

.circular-image {
    transition: all 0.4s ease;
}

.cta-card:hover .circular-image {
    border-color: #0000FF !important;
}

.cta-card:hover .consult-card .circular-image {
    border-color: #00a36c !important;
}

.icon-badge {
    transition: all 0.4s ease;
    z-index: 10;
}

.cta-card:hover .icon-badge {
    transform: rotate(360deg);
}

.feature-item {
    transition: all 0.3s ease;
}

.cta-card:hover .feature-item {
    transform: translateX(5px);
}

.btn-cta {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
    z-index: 1;
    cursor: pointer;
    font-size: 1rem;
}

.btn-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s ease;
    z-index: -1;
}

.btn-cta:hover::before {
    left: 100%;
}

.btn-publish:hover {
    background: #0000CC !important;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 255, 0.2) !important;
}

.btn-consult:hover {
    background: #008f5c !important;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 150, 0, 0.2) !important;
}

/* Modal Styles */
.modal-content {
    border-radius: 20px;
    overflow: hidden;
}

.modal-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .circular-image {
        width: 150px !important;
        height: 150px !important;
    }

    .cta-card h3 {
        font-size: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .circular-image {
        width: 130px !important;
        height: 130px !important;
    }

    .icon-badge {
        width: 40px !important;
        height: 40px !important;
    }

    .icon-badge i {
        font-size: 1.2rem !important;
    }

    .cta-card {
        padding: 1.5rem !important;
    }
}
</style>

<script>
function showLoginMessage(action) {
    const modal = new bootstrap.Modal(document.getElementById('loginModal'));
    const modalMessage = document.getElementById('modalMessage');

    if (action === 'publier') {
        modalMessage.textContent = 'Pour publier une annonce, vous devez d\'abord créer un compte étudiant ou vous connecter.';
    } else {
        modalMessage.textContent = 'Pour consulter les annonces et postuler, vous devez d\'abord créer un compte tuteur ou vous connecter.';
    }

    modal.show();
}

function showRoleMessage(action) {
    const modal = new bootstrap.Modal(document.getElementById('roleModal'));
    const modalMessage = document.getElementById('roleModalMessage');

    @auth
        if (action === 'publier') {
            modalMessage.textContent = 'Seuls les étudiants peuvent publier des annonces. Vous êtes connecté en tant que ' +
                (@json(Auth::user()->role_id) == 2 ? 'étudiant' : (@json(Auth::user()->role_id) == 3 ? 'tuteur' : 'administrateur')) + '.';
        } else {
            modalMessage.textContent = 'Seuls les tuteurs peuvent consulter et postuler aux annonces. Vous êtes connecté en tant que ' +
                (@json(Auth::user()->role_id) == 2 ? 'étudiant' : (@json(Auth::user()->role_id) == 3 ? 'tuteur' : 'administrateur')) + '.';
        }
    @endauth

    modal.show();
}
</script>






    <!-- Contact Section -->
    <section id="inscription" class="inscription-section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center position-relative">

                <!-- Image en arrière-plan -->
                <div class="col-lg-12 position-absolute start-0 top-0 w-100 h-100 d-none d-lg-block" style="z-index: 1;">
                    <div class="background-image-wrapper rounded-4 overflow-hidden">
                        <img src="{{ asset('images/image_3.webp') }}" class="img-fluid w-100 h-100 object-fit-cover"
                            alt="Devenir tuteur EduBenin">
                    </div>
                </div>

                <!-- Formulaire d'inscription simplifié -->
                <div class="col-lg-6 offset-lg-6" data-aos="fade-left" data-aos-delay="300"
                    style="z-index: 2; position: relative;">
                    <br><br><br>
                    <div class="inscription-form rounded-4 overflow-hidden"
                        style="box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
                    border: 1px solid rgba(0, 0, 0, 0.1);">

                        <!-- En-tête bleu -->
                        <div class="form-header text-white text-center py-4"
                            style="background: linear-gradient(135deg, #0d6efd, #004aad);">
                            <h2 class="fw-bold mb-2" style="font-size: 2.2rem; color:white;">Devenir Tuteur</h2>
                            <p style="font-size: 1.1rem; opacity: 0.9;">Rejoignez notre communauté d'enseignants</p>
                        </div>

                        <!-- Contenu du formulaire -->
                        <div class="form-content p-4 p-lg-5" style="background: rgba(255, 255, 255, 0.95);">

                            <!-- Formulaire simplifié - Étape 1: Email -->
                            <form id="inscriptionFormStep1">
                                @csrf
                                <input type="hidden" name="role_id" value="3">

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold" style="color: #333;">
                                        <i class="bi bi-envelope me-1"></i>Email
                                    </label>
                                    <input type="email" name="email" id="email"
                                        class="form-control rounded-pill border px-3 py-2"
                                        style="border-color: #ddd; background: #f8f9fa;" placeholder="exemple@email.com"
                                        required>
                                </div>

                                <!-- Bouton pour continuer -->
                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold"
                                        style="background: linear-gradient(135deg, #0d6efd, #004aad);
                                           border: none;
                                           box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
                                           font-size: 1.1rem;">
                                        <i class="bi bi-check-circle me-2"></i>Continuer
                                    </button>
                                </div>

                                <!-- Lien vers connexion -->
                                <div class="text-center mt-4 pt-3" style="border-top: 1px solid #eee;">
                                    <p class="text-muted mb-0" style="font-size: 0.95rem;">
                                        Déjà inscrit ?
                                        <a href="{{ route('login') }}"
                                            class="text-primary fw-semibold text-decoration-none">
                                            Se connecter
                                        </a>
                                    </p>
                                </div>

                            </form>

                        </div>

                    </div>
                    <br><br><br>
                </div>

            </div>

        </div>

    </section>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4 p-md-5">
                    <!-- Icône de succès -->
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>

                    <!-- Titre -->
                    <h3 class="fw-bold mb-3" style="color: #0d6efd;">Email enregistré avec succès !</h3>

                    <!-- Message -->
                    <p class="text-muted mb-4" style="font-size: 1.1rem;">
                        Nous avons bien récupéré votre email <strong id="userEmail"></strong>.
                        Cliquez sur "Finaliser l'inscription" pour compléter votre profil.
                    </p>

                    <!-- Boutons -->
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <!-- Bouton pour finaliser l'inscription -->
                        <form id="inscriptionFinalForm" method="GET" action="{{ route('register.tuteur') }}">
                            @csrf
                            <input type="hidden" name="email" id="finalEmail" value="">
                            <input type="hidden" name="role_id" value="3">
                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2 fw-bold"
                                style="background: linear-gradient(135deg, #0d6efd, #004aad);
                                       border: none;
                                       border-radius: 50px;">
                                <i class="bi bi-person-plus me-2"></i>Finaliser l'inscription
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .inscription-section {
            position: relative;
            padding: 5rem 0;
            overflow: hidden;
            background: #f8fafc;
        }

        .background-image-wrapper {
            width: 100%;
            height: 100%;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        /* Styles pour le formulaire */
        .inscription-form {
            transition: all 0.3s ease;
            margin-right: 50px;
        }

        .inscription-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2) !important;
        }

        .form-control {
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15) !important;
            background: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4) !important;
        }

        /* Styles pour le modal */
        .modal-content {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Responsive design */
        @media (max-width: 991.98px) {
            .inscription-section {
                padding: 3rem 0;
            }

            .col-lg-6.offset-lg-6 {
                margin-left: 0 !important;
            }

            .d-none.d-lg-block {
                display: none !important;
            }

            .inscription-form {
                background: white !important;
            }
        }

        @media (max-width: 767.98px) {
            .inscription-form {
                padding: 2rem !important;
                margin: 0 1rem;
            }

            .modal-body {
                padding: 2rem !important;
            }
        }

        @media (max-width: 576px) {
            .inscription-form {
                padding: 1.5rem !important;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem !important;
                font-size: 1rem !important;
            }

            .modal-body {
                padding: 1.5rem !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formStep1 = document.getElementById('inscriptionFormStep1');
            const emailInput = document.getElementById('email');
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            const userEmailSpan = document.getElementById('userEmail');
            const finalEmailInput = document.getElementById('finalEmail');

            formStep1.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validation de l'email
                const email = emailInput.value.trim();
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailPattern.test(email)) {
                    emailInput.classList.add('is-invalid');
                    return;
                }

                // Afficher l'email dans le modal
                userEmailSpan.textContent = email;
                finalEmailInput.value = email;

                // Afficher le modal
                confirmationModal.show();

                // Réinitialiser le formulaire
                formStep1.reset();
                emailInput.classList.remove('is-invalid');
            });

            // Validation en temps réel
            emailInput.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    </script>
@endsection
