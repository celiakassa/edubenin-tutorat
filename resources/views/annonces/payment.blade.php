<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement de l'acompte - Kopiao</title>
    <link href="{{ asset('images/image_1.webp') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0351BC;
            --primary-light: #4a7fd4;
            --primary-dark: #023a8a;
            --white: #ffffff;
            --light-gray: #f8fafc;
            --medium-gray: #e2e8f0;
            --dark-gray: #64748b;
            --text-dark: #1e293b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #2a819b 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            padding: 0;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset('images/image_4.webp') }}');
            background-size: cover;
            opacity: 0.1;
        }

        /* Navigation Styles */
        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 30px 25px;
            border-bottom: 1px solid var(--medium-gray);
            text-align: center;
        }

        .platform-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: bold;
            font-size: 18px;
        }

        .platform-name {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .platform-tagline {
            font-size: 12px;
            color: var(--dark-gray);
            margin-bottom: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: var(--light-gray);
            border-radius: 12px;
            margin-top: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }

        .user-details h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .user-details p {
            font-size: 12px;
            color: var(--dark-gray);
        }

        .sidebar-stats {
            padding: 20px 25px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .stat-item:last-child {
            margin-bottom: 0;
        }

        .stat-label {
            font-size: 13px;
            color: var(--dark-gray);
        }

        .stat-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--dark-gray);
            text-decoration: none;
        }

        .menu-item:hover,
        .menu-item.active {
            background: var(--primary-light);
            color: var(--white);
            border-right: 3px solid var(--primary-color);
        }

        .menu-item i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .menu-text {
            font-size: 14px;
            font-weight: 500;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
        }

        .payment-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .payment-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 30px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .payment-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .payment-header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .payment-header p {
            font-size: 14px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Annonce Summary */
        .annonce-summary {
            background: var(--light-gray);
            border-radius: 15px;
            padding: 25px;
            margin: 30px;
            border: 1px solid var(--medium-gray);
        }

        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--medium-gray);
        }

        .summary-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .summary-status {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: var(--warning);
            color: white;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .summary-label {
            font-size: 13px;
            color: var(--dark-gray);
            font-weight: 500;
        }

        .summary-value {
            font-size: 15px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .summary-value.amount {
            color: var(--primary-color);
            font-size: 18px;
        }

        /* Payment Amount */
        .payment-amount {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            color: var(--white);
            margin: 30px;
        }

        .amount-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .amount-note {
            font-size: 13px;
            opacity: 0.8;
        }

        /* Payment Actions */
        .payment-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 30px;
            text-align: center;
        }

        .btn-pay {
            background: linear-gradient(135deg, var(--success) 0%, #34d399 100%);
            color: var(--white);
            padding: 16px 40px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .btn-pay:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-pay:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-cancel {
            background: var(--white);
            color: var(--dark-gray);
            padding: 16px 40px;
            border: 2px solid var(--medium-gray);
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 16px;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .btn-cancel:hover {
            background: var(--light-gray);
            border-color: var(--dark-gray);
            transform: translateY(-2px);
        }

        /* Payment Instructions */
        .payment-instructions {
            background: var(--light-gray);
            border-radius: 15px;
            padding: 25px;
            margin: 30px;
            border-left: 4px solid var(--info);
        }

        .instructions-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .instructions-list {
            list-style: none;
            padding-left: 0;
        }

        .instructions-list li {
            padding: 8px 0;
            color: var(--dark-gray);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .instructions-list li i {
            color: var(--info);
            font-size: 12px;
        }

        /* Payment Success/Error */
        .payment-result {
            text-align: center;
            padding: 40px;
        }

        .result-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
        }

        .result-icon.success {
            background: var(--success);
            color: var(--white);
        }

        .result-icon.error {
            background: var(--danger);
            color: var(--white);
        }

        .result-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .result-message {
            font-size: 16px;
            color: var(--dark-gray);
            margin-bottom: 25px;
            line-height: 1.5;
        }

        /* Frais de transaction */
        .fees-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            color: #856404;
            max-width: 400px;
            margin: 0 auto;
            margin-top: 15px;
        }

        /* Loading */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Version horizontale uniquement pour le succès */
        .payment-actions-inline {
            flex-direction: row !important;
        }

        .payment-actions-inline a {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            color: white;
        }

        /* Bleu = Voir */
        .btn-view {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        /* Vert = Payer */
        .btn-pay-acompte {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }

        /* Alertes */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 30px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        .alert-warning {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert i {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <!-- Navigation Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboardUser') }}" style="text-decoration: none;">
                <div class="platform-logo">
                    <div class="logo-icon">KP</div>
                    <div class="platform-name">Kopiao</div>
                </div>
            </a>
            <div class="platform-tagline">Votre plateforme éducative</div>

            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1)) }}
                </div>
                <div class="user-details">
                    <h4>{{ $user->firstname }} {{ $user->lastname }}</h4>
                    <p>
                        @if ($user->role_id == 3)
                            Tuteur
                        @elseif($user->role_id == 2)
                            Apprenant
                        @else
                            Administrateur
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboardUser') }}" class="menu-item">
                <i class="fas fa-home"></i>
                <span class="menu-text">Tableau de bord</span>
            </a>
            <a href="{{ route('CompleterProfilUser.show') }}" class="menu-item">
                <i class="fas fa-user-edit"></i>
                <span class="menu-text">Mon profil</span>
            </a>
            <a href="{{ route('annonces.index') }}" class="menu-item">
                <i class="fas fa-bullhorn"></i>
                <span class="menu-text">Mes annonces</span>
            </a>
            <a href="{{ route('annonces.create') }}" class="menu-item">
                <i class="fas fa-plus-circle"></i>
                <span class="menu-text">Nouvelle annonce</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="payment-container">
            <div class="payment-header">
                <h1><i class="fas fa-credit-card"></i> Paiement de l'acompte</h1>
                <p>Finalisez votre annonce en payant l'acompte</p>
            </div>

            <!-- Payment Content -->
            <div class="payment-content">
                @if (session('success'))
                    <div class="payment-result">
                        <div class="result-icon success">
                            <i class="fas fa-check"></i>
                        </div>
                        <h2 class="result-title">Annonce créée avec succès !</h2>
                        <p class="result-message">{{ session('success') }}</p>

                        <div class="payment-actions payment-actions-inline">
                            <a href="{{ route('annonces.show', $annonce->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i>&nbsp; Voir mon annonce
                            </a>
                            <a href="{{ route('annonces.payment', $annonce->id) }}" class="btn-pay-acompte">
                                <i class="fas fa-credit-card"></i>&nbsp; Payer l'acompte
                            </a>
                        </div>
                    </div>
                @elseif(session('error'))
                    <div class="payment-result">
                        <div class="result-icon error">
                            <i class="fas fa-times"></i>
                        </div>
                        <h2 class="result-title">Paiement échoué</h2>
                        <p class="result-message">{{ session('error') }}</p>
                        <div class="payment-actions">
                            <a href="{{ route('annonces.payment', $annonce->id) }}" class="btn-pay">
                                <i class="fas fa-redo"></i> Réessayer
                            </a>
                            <a href="{{ route('annonces.index') }}" class="btn-cancel">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Résumé de l'annonce -->
                    <div class="annonce-summary">
                        <div class="summary-header">
                            <h3 class="summary-title">
                                <i class="fas fa-file-invoice"></i>
                                Résumé de l'annonce
                            </h3>
                            <span class="summary-status">À payer</span>
                        </div>

                        <div class="summary-grid">
                            <div class="summary-item">
                                <span class="summary-label">Domaine</span>
                                <span class="summary-value">{{ $annonce->domaine }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Format</span>
                                <span class="summary-value">
                                    @if ($annonce->format == 'presentiel')
                                        Présentiel
                                    @elseif($annonce->format == 'en_ligne')
                                        En ligne
                                    @else
                                        Hybride
                                    @endif
                                </span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Disponibilités</span>
                                <span class="summary-value"
                                    style="white-space: pre-line;">{{ $annonce->disponibilite }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Budget total</span>
                                <span class="summary-value amount">{{ number_format($annonce->budget, 0, ',', ' ') }}
                                    FCFA</span>
                            </div>
                        </div>
                    </div>

                    <!-- Montant à payer -->
                    <div class="payment-amount">
                        <div class="amount-label">Acompte à régler</div>
                        <div class="amount-value">{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</div>
                        <div class="amount-note">
                            {{ round(($annonce->acompte / $annonce->budget) * 100) }}% du budget total
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="payment-instructions">
                        <h4 class="instructions-title">
                            <i class="fas fa-info-circle"></i>
                            Instructions importantes
                        </h4>
                        <ul class="instructions-list">
                            <li><i class="fas fa-check"></i> L'acompte sera déduit du montant total à payer au tuteur
                            </li>
                            <li><i class="fas fa-check"></i> Votre annonce sera visible par les tuteurs uniquement
                                après paiement</li>

                        </ul>
                    </div>

                    <!-- Commentaire: Sélecteur de mode de paiement désactivé - Moneroo par défaut -->
                    <!--
                    <div class="payment-methods">
                        <button type="button" class="payment-method-btn active" id="btn-fedapay">
                            <i class="fas fa-credit-card"></i>
                            FedaPay
                        </button>
                        <button type="button" class="payment-method-btn" id="btn-moneroo">
                            <i class="fas fa-lock"></i>
                            Moneroo
                        </button>
                    </div>
                    -->

                    <!-- Commentaire: Section FedaPay désactivée -->
                    <!--
                    <div class="payment-section" id="section-fedapay">
                        <div class="payment-actions">
                            <button type="button" class="btn-pay" id="pay-button-fedapay"
                                data-annonce-id="{{ $annonce->id }}">
                                <i class="fas fa-lock"></i>
                                <span>Payer avec FedaPay - {{ number_format($annonce->acompte, 0, ',', ' ') }}
                                    FCFA</span>
                            </button>
                            <div class="fees-notice">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Note :</strong> FedaPay ajoute des frais de transaction (environ 2%).
                            </div>
                        </div>
                    </div>
                    -->

                    <!-- Section Moneroo (active par défaut) -->
                    <div class="payment-section" id="section-moneroo" style="display: block;">
                        <div class="payment-actions">
                            <button type="button" class="btn-pay" id="pay-button-moneroo"
                                data-annonce-id="{{ $annonce->id }}">
                                <i class="fas fa-lock"></i>
                                <span>Payer la somme de {{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA pour publier l'annonce</span>
                            </button>

                        </div>
                    </div>

                    <!-- Bouton Annuler -->
                    <div class="payment-actions" style="padding-top: 0;">
                        <a href="{{ route('annonces.index') }}" class="btn-cancel">
                            <i class="fas fa-times"></i>
                            Annuler
                        </a>
                        <p class="small text-muted mt-3 mb-0">
                            <i class="fas fa-shield-alt"></i> Paiement 100% sécurisé
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Script FedaPay (commenté car plus utilisé) -->
    <!-- <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script> -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (!session('success') && !session('error'))

                // Commentaire: Switch de méthodes de paiement désactivé
                /*
                const btnFedapay = document.getElementById('btn-fedapay');
                const btnMoneroo = document.getElementById('btn-moneroo');
                const sectionFedapay = document.getElementById('section-fedapay');
                const sectionMoneroo = document.getElementById('section-moneroo');

                if (btnFedapay && btnMoneroo) {
                    btnFedapay.addEventListener('click', function() {
                        btnFedapay.classList.add('active');
                        btnMoneroo.classList.remove('active');
                        sectionFedapay.classList.add('active');
                        sectionMoneroo.classList.remove('active');
                    });

                    btnMoneroo.addEventListener('click', function() {
                        btnMoneroo.classList.add('active');
                        btnFedapay.classList.remove('active');
                        sectionMoneroo.classList.add('active');
                        sectionFedapay.classList.remove('active');
                    });
                }
                */

                // Commentaire: Paiement FedaPay désactivé
                /*
                const payButtonFedapay = document.getElementById('pay-button-fedapay');
                if (payButtonFedapay) {
                    payButtonFedapay.addEventListener('click', function() {
                        @auth
                        const annonceId = this.dataset.annonceId;
                        const button = this;
                        const originalText = button.innerHTML;

                        // Afficher le chargement
                        button.disabled = true;
                        button.innerHTML = '<span class="loading-spinner"></span> Initialisation...';

                        // Initialiser la transaction via AJAX
                        fetch(`/annonces/${annonceId}/init-payment`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success && data.token) {
                                    // Réinitialiser le bouton
                                    button.disabled = false;
                                    button.innerHTML = originalText;

                                    // Ouvrir le widget FedaPay avec le token
                                    const widget = FedaPay.init({
                                        public_key: '{{ config('services.fedapay.public_key') }}',
                                        transaction: {
                                            token: data.token
                                        },
                                        onComplete: function(response) {
                                            if (response.reason === 'CHECKOUT_COMPLETE' ||
                                                response.reason === 'CHECKOUT COMPLETE') {
                                                // Créer un formulaire pour le callback
                                                const form = document.createElement('form');
                                                form.method = 'POST';
                                                form.action =
                                                    '{{ route('annonces.payment.callback') }}';

                                                const csrf = document.createElement(
                                                'input');
                                                csrf.type = 'hidden';
                                                csrf.name = '_token';
                                                csrf.value = '{{ csrf_token() }}';
                                                form.appendChild(csrf);

                                                const transactionInput = document
                                                    .createElement('input');
                                                transactionInput.type = 'hidden';
                                                transactionInput.name = 'id';
                                                transactionInput.value = response
                                                    .transaction.id;
                                                form.appendChild(transactionInput);

                                                const annonceInput = document.createElement(
                                                    'input');
                                                annonceInput.type = 'hidden';
                                                annonceInput.name = 'annonce_id';
                                                annonceInput.value = annonceId;
                                                form.appendChild(annonceInput);

                                                document.body.appendChild(form);
                                                form.submit();
                                            }
                                        }
                                    });

                                    widget.open();
                                } else {
                                    alert('Erreur: ' + (data.message ||
                                        'Impossible d\'initialiser le paiement'));
                                    button.disabled = false;
                                    button.innerHTML = originalText;
                                }
                            })
                            .catch(error => {
                                console.error('Erreur:', error);
                                alert('Une erreur est survenue lors de l\'initialisation du paiement');
                                button.disabled = false;
                                button.innerHTML = originalText;
                            });
                        @else
                            window.location.href = '{{ route('login') }}';
                        @endauth
                    });
                }
                */

                // Paiement Moneroo (actif)
                const payButtonMoneroo = document.getElementById('pay-button-moneroo');
                if (payButtonMoneroo) {
                    payButtonMoneroo.addEventListener('click', async function() {
                        @auth
                        const annonceId = this.dataset.annonceId;
                        const button = this;
                        const originalText = button.innerHTML;

                        // Afficher le chargement
                        button.disabled = true;
                        button.innerHTML = '<span class="loading-spinner"></span> Initialisation...';

                        try {
                            const response = await fetch(`/annonces/${annonceId}/init-payment-moneroo`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await response.json();

                            if (data.success && data.checkout_url) {
                                // Rediriger vers la page de paiement Moneroo
                                window.location.href = data.checkout_url;
                            } else {
                                alert('Erreur: ' + (data.message ||
                                    'Impossible d\'initialiser le paiement'));
                                button.disabled = false;
                                button.innerHTML = originalText;
                            }
                        } catch (error) {
                            console.error('Erreur:', error);
                            alert('Une erreur est survenue lors de l\'initialisation du paiement');
                            button.disabled = false;
                            button.innerHTML = originalText;
                        }
                        @else
                            window.location.href = '{{ route('login') }}';
                        @endauth
                    });
                }
            @endif
        });
    </script>
</body>

</html>
