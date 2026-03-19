@extends('layouts.welcomeLayout')
@section('content')

<style>
    .choose-role-section {
        padding: 2rem 0 5rem;
    }

    .section-header {
        margin-bottom: 3rem;
    }

    .section-header h2 {
        font-size: 2.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
    }

    .section-header p {
        font-size: 1.2rem;
        color: #6c757d;
    }

    .divider {
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd, #6f42c1);
        border-radius: 2px;
        margin: 20px auto 0;
        animation: dividerPulse 2s ease-in-out infinite;
    }

    @keyframes dividerPulse {
        0%, 100% { width: 80px; opacity: 1; }
        50% { width: 120px; opacity: 0.8; }
    }

    .role-card {
        background: white;
        border-radius: 30px;
        padding: 40px 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }

    .role-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 60px rgba(13, 110, 253, 0.15);
        border-color: #0d6efd;
    }

    .role-card.selected {
        border: 3px solid #0d6efd;
        box-shadow: 0 20px 40px rgba(13, 110, 253, 0.2);
    }

    .role-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #0d6efd, #0a58ca);
        border-radius: 30px 30px 0 0;
    }

    .card-etudiant::before {
        background: linear-gradient(90deg, #20c997, #0dcaf0);
    }

    .card-tuteur::before {
        background: linear-gradient(90deg, #6f42c1, #d63384);
    }

    .circular-image-wrapper {
        margin-bottom: 25px;
        display: flex;
        justify-content: center;
    }

    .circular-image {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
    }

    .role-card:hover .circular-image {
        transform: scale(1.05);
        box-shadow: 0 15px 40px rgba(13, 110, 253, 0.2);
    }

    .card-etudiant .circular-image {
        border-color: #20c997;
    }

    .card-tuteur .circular-image {
        border-color: #6f42c1;
    }

    .circular-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .icon-badge {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -25px auto 20px;
        border: 2px solid;
        transition: all 0.4s ease;
    }

    .role-card:hover .icon-badge {
        transform: rotate(360deg);
    }

    .card-etudiant .icon-badge {
        border-color: #20c997;
    }

    .card-etudiant .icon-badge i {
        color: #20c997;
        font-size: 1.5rem;
    }

    .card-tuteur .icon-badge {
        border-color: #6f42c1;
    }

    .card-tuteur .icon-badge i {
        color: #6f42c1;
        font-size: 1.5rem;
    }

    .role-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
        text-align: center;
    }

    .card-etudiant .role-title {
        color: #20c997;
    }

    .card-tuteur .role-title {
        color: #6f42c1;
    }

    .role-description {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 25px;
        font-size: 1rem;
        text-align: center;
        flex-grow: 1;
    }

    .role-description strong {
        color: #2c3e50;
        font-size: 1.1rem;
        display: block;
        margin-bottom: 10px;
    }

    .role-description br {
        display: none;
    }

    .role-description ul {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: left;
    }

    .role-description li {
        padding: 8px 0 8px 25px;
        position: relative;
    }

    .card-etudiant .role-description li::before {
        content: '✓';
        color: #20c997;
        position: absolute;
        left: 0;
        font-weight: bold;
    }

    .card-tuteur .role-description li::before {
        content: '✓';
        color: #6f42c1;
        position: absolute;
        left: 0;
        font-weight: bold;
    }

    .btn-select {
        width: 100%;
        padding: 15px 25px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        text-align: center;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        text-decoration: none;
        cursor: pointer;
        margin-top: auto;
    }

    .btn-etudiant {
        background: linear-gradient(135deg, #20c997, #0dcaf0);
        color: white;
        box-shadow: 0 10px 20px rgba(32, 201, 151, 0.2);
    }

    .btn-etudiant:hover {
        background: linear-gradient(135deg, #1ba87e, #0bb5d0);
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(32, 201, 151, 0.3);
        color: white;
    }

    .btn-tuteur {
        background: linear-gradient(135deg, #6f42c1, #d63384);
        color: white;
        box-shadow: 0 10px 20px rgba(111, 66, 193, 0.2);
    }

    .btn-tuteur:hover {
        background: linear-gradient(135deg, #5a32a3, #b82b6f);
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(111, 66, 193, 0.3);
        color: white;
    }

    .btn-continue {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
        padding: 18px 45px;
        border-radius: 60px;
        font-weight: 600;
        font-size: 1.2rem;
        border: none;
        box-shadow: 0 15px 30px rgba(13, 110, 253, 0.2);
        transition: all 0.4s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn-continue:hover:not(:disabled) {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 20px 40px rgba(13, 110, 253, 0.3);
    }

    .btn-continue:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .info-banner {
        background: linear-gradient(135deg, #e8f0fe, #d4e4ff);
        border-radius: 20px;
        padding: 20px 30px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        border-left: 6px solid #0d6efd;
        box-shadow: 0 10px 30px rgba(13, 110, 253, 0.1);
    }

    .info-banner i {
        font-size: 2.5rem;
        color: #0d6efd;
    }

    .info-banner p {
        margin: 0;
        color: #1e293b;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .welcome-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .welcome-header img {
        height: 70px;
        margin-bottom: 1.5rem;
        filter: drop-shadow(0 5px 15px rgba(13, 110, 253, 0.2));
    }

    .welcome-header h2 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 0.5rem;
    }

    .welcome-header .user-name {
        font-size: 1.3rem;
        color: #2c3e50;
    }

    .user-name strong {
        color: #0d6efd;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .section-header h2 {
            font-size: 2rem;
        }

        .role-title {
            font-size: 1.8rem;
        }

        .circular-image {
            width: 140px;
            height: 140px;
        }

        .info-banner {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .info-banner i {
            font-size: 2rem;
        }

        .info-banner p {
            font-size: 1rem;
        }
    }
</style>

<div class="choose-role-section">
    <div class="container">
        <!-- En-tête de bienvenue -->
        <div class="welcome-header">

            <h2>Bienvenue sur Kopiao !</h2>
            <p class="user-name">
                Bonjour <strong>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</strong>
            </p>
            <div class="divider"></div>
        </div>

        <!-- Bannière d'information -->
        <div class="info-banner">
            <i class="bi bi-info-circle-fill"></i>
            <p>
                Pour terminer votre inscription, veuillez choisir le type de profil qui correspond à votre situation.
                Vous pourrez compléter vos informations plus tard dans votre espace personnel.
            </p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('store.role') }}" id="roleForm">
            @csrf
            <input type="hidden" name="role" id="selectedRole" value="">

            <div class="row g-4">
                <!-- Carte Étudiant -->
                <div class="col-lg-6">
                    <div class="role-card card-etudiant" onclick="selectRole('etudiant')" id="card-etudiant">
                        <div class="circular-image-wrapper">
                            <div class="circular-image">
                                <img src="{{ asset('images/image_5.webp') }}" alt="Étudiant">
                            </div>
                        </div>

                        <div class="icon-badge">
                            <i class="bi bi-mortarboard"></i>
                        </div>

                        <h3 class="role-title">Étudiant</h3>

                        <div class="role-description">
                            <strong>Vous cherchez un tuteur ?</strong>
                            <ul>
                                <li>Publiez des annonces de cours</li>
                                <li>Recevez des candidatures de tuteurs qualifiés</li>

                            </ul>
                        </div>

                        <button type="button" class="btn-select btn-etudiant" onclick="selectRole('etudiant')">
                            <i class="bi bi-check-circle me-2"></i>
                            Choisir ce profil
                        </button>
                    </div>
                </div>

                <!-- Carte Tuteur -->
                <div class="col-lg-6">
                    <div class="role-card card-tuteur" onclick="selectRole('tuteur')" id="card-tuteur">
                        <div class="circular-image-wrapper">
                            <div class="circular-image">
                                <img src="{{ asset('images/image_6.webp') }}" alt="Tuteur">
                            </div>
                        </div>

                        <div class="icon-badge">
                            <i class="bi bi-person-workspace"></i>
                        </div>

                        <h3 class="role-title">Tuteur</h3>

                        <div class="role-description">
                            <strong>Vous donnez des cours ?</strong>
                            <ul>
                                <li>Proposez vos services d'enseignement</li>
                                <li>Répondez aux annonces d'étudiants</li>
                               

                            </ul>
                        </div>

                        <button type="button" class="btn-select btn-tuteur" onclick="selectRole('tuteur')">
                            <i class="bi bi-check-circle me-2"></i>
                            Choisir ce profil
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bouton de confirmation -->
            <div class="text-center mt-5">
                <button type="submit"
                        class="btn-continue"
                        id="submitBtn"
                        disabled>
                    <i class="bi bi-arrow-right-circle me-2"></i>
                    Continuer vers mon tableau de bord
                </button>
            </div>

            <p class="text-center mt-4 text-muted">
                <i class="bi bi-pencil-square me-1"></i>
                Vous pourrez modifier ces informations plus tard dans les paramètres de votre compte
            </p>
        </form>
    </div>
</div>

<script>
    function selectRole(role) {
        // Mettre à jour l'input caché
        document.getElementById('selectedRole').value = role;

        // Enlever la classe selected de toutes les cartes
        document.getElementById('card-etudiant').classList.remove('selected');
        document.getElementById('card-tuteur').classList.remove('selected');

        // Ajouter la classe selected à la carte choisie
        document.getElementById('card-' + role).classList.add('selected');

        // Faire défiler jusqu'à la carte sélectionnée (optionnel)
        document.getElementById('card-' + role).scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        // Activer le bouton
        document.getElementById('submitBtn').disabled = false;
    }

    // Empêcher la soumission si aucun rôle n'est sélectionné
    document.getElementById('roleForm').addEventListener('submit', function(e) {
        if (!document.getElementById('selectedRole').value) {
            e.preventDefault();
            alert('Veuillez sélectionner un rôle pour continuer.');
        }
    });

    // Animation au survol des cartes
    document.querySelectorAll('.role-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (!this.classList.contains('selected')) {
                this.style.transform = 'translateY(-10px)';
            }
        });

        card.addEventListener('mouseleave', function() {
            if (!this.classList.contains('selected')) {
                this.style.transform = 'translateY(0)';
            }
        });
    });
</script>
@endsection
