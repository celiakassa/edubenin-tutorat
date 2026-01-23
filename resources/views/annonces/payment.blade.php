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

        /* Navigation Styles (identique à create.blade.php) */
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

        /* Payment Steps */
        .payment-steps {
            display: flex;
            justify-content: center;
            padding: 30px 40px 0;
            position: relative;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
            max-width: 200px;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--light-gray);
            border: 3px solid var(--medium-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .step.active .step-number {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--white);
        }

        .step.completed .step-number {
            background: var(--success);
            border-color: var(--success);
            color: var(--white);
        }

        .step-label {
            font-size: 13px;
            color: var(--dark-gray);
            text-align: center;
            font-weight: 500;
        }

        .step.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        .steps-line {
            position: absolute;
            top: 20px;
            left: 20%;
            right: 20%;
            height: 3px;
            background: var(--medium-gray);
            z-index: 1;
        }

        /* Payment Content */
        .payment-content {
            padding: 40px;
        }

        /* Annonce Summary */
        .annonce-summary {
            background: var(--light-gray);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
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
            margin-bottom: 30px;
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

        /* Payment Methods */
        .payment-methods {
            margin-bottom: 40px;
        }

        .methods-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .methods-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .method-card {
            background: var(--white);
            border: 2px solid var(--medium-gray);
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .method-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(3, 81, 188, 0.1);
        }

        .method-card.selected {
            border-color: var(--primary-color);
            background: var(--light-gray);
            box-shadow: 0 5px 15px rgba(3, 81, 188, 0.1);
        }

        .method-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: var(--white);
        }

        .method-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .method-description {
            font-size: 13px;
            color: var(--dark-gray);
            line-height: 1.4;
        }

        /* Payment Instructions */
        .payment-instructions {
            background: var(--light-gray);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
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

        /* Payment Actions */
        .payment-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
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
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
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
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .btn-cancel:hover {
            background: var(--light-gray);
            border-color: var(--dark-gray);
            transform: translateY(-2px);
        }

        /* Payment Processing */
        .payment-processing {
            text-align: center;
            padding: 40px;
        }

        .processing-spinner {
            width: 80px;
            height: 80px;
            border: 5px solid var(--light-gray);
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .processing-message {
            font-size: 16px;
            color: var(--text-dark);
            margin-bottom: 15px;
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

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .payment-content {
                padding: 20px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .methods-grid {
                grid-template-columns: 1fr;
            }

            .payment-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboardUser') }}" style="text-decoration: none;">
                <div class="platform-logo" style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <div class="logo-icon"
                        style="background-color: #3948c9; color: white; padding: 10px; border-radius: 6px; font-weight: bold;">
                        KP
                    </div>
                    <div class="platform-name" style="font-size: 1.2em; font-weight: bold; color: #333;">
                        Kopiao
                    </div>
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
                            Étudiant
                        @else
                            Administrateur
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="sidebar-stats">
            <div class="stat-item">
                <span class="stat-label">Statut</span>
                <span class="stat-value">Étudiant</span>
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

            <!-- Payment Steps -->
            <div class="payment-steps">
                <div class="steps-line"></div>
                <div class="step active">
                    <div class="step-number">1</div>
                    <div class="step-label">Détails</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-label">Paiement</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>

            <!-- Payment Content -->
            <div class="payment-content">
                @if(session('success'))
                    <div class="payment-result">
                        <div class="result-icon success">
                            <i class="fas fa-check"></i>
                        </div>
                        <h2 class="result-title">Paiement réussi !</h2>
                        <p class="result-message">{{ session('success') }}</p>
                        <div class="payment-actions">
                            <a href="{{ route('annonces.show', $annonce->id) }}" class="btn-pay">
                                <i class="fas fa-eye"></i> Voir mon annonce
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
                @elseif($pendingPayment)
                    <!-- Paiement en cours -->
                    <div class="payment-processing" id="paymentProcessing">
                        <div class="processing-spinner"></div>
                        <p class="processing-message">Vérification du paiement en cours...</p>
                        <p style="color: var(--dark-gray); font-size: 14px;">Veuillez patienter quelques secondes.</p>
                    </div>

                    <script>
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    </script>
                @else
                    <!-- Formulaire de paiement -->
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
                                    @if($annonce->format == 'presentiel')
                                        Présentiel
                                    @elseif($annonce->format == 'en_ligne')
                                        En ligne
                                    @else
                                        Hybride
                                    @endif
                                </span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Date souhaitée</span>
                                <span class="summary-value">{{ $annonce->disponibilite->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Budget total</span>
                                <span class="summary-value amount">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>

                    <div class="payment-amount">
                        <div class="amount-label">Acompte à régler</div>
                        <div class="amount-value">{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</div>
                        <div class="amount-note">
                            {{ round(($annonce->acompte / $annonce->budget) * 100) }}% du budget total
                        </div>
                    </div>

             <style>
.payment-methods {
    margin-top: 30px;
}

.methods-title {
    font-size: 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.methods-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.method-card {
    position: relative;
    height: 180px;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    background-size: cover;
    background-position: center;
    color: #fff;
}

.method-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
}

.method-content {
    position: relative;
    z-index: 2;
    height: 100%;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
}

.method-icon {
    font-size: 32px;
    margin-bottom: 10px;
}

.method-name {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 8px;
    color:white;
}

.method-description {
    font-size: 14px;
    opacity: 0.9;
    color:white;
}

.method-card:hover {
    transform: scale(1.03);
    transition: 0.3s ease;
}
</style>

<div class="payment-methods">
    <h3 class="methods-title">
        <i class="fas fa-mobile-alt"></i>
        Choisissez votre moyen de paiement
    </h3>

    <div class="methods-grid">

        <div class="method-card" data-method="mobile_money"
             style="background-image: url('{{ asset('images/woo.webp') }}');">
            <div class="method-content">
                <div class="method-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="method-name">Mobile Money</div>
                <div class="method-description">
                    Moov Money, MTN Mobile Money, Flooz
                </div>
            </div>
        </div>
        

        <div class="method-card" data-method="card"
             style="background-image: url('{{ asset('images/carte.webp') }}');">
            <div class="method-content">
                <div class="method-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="method-name">Carte Bancaire</div>
                <div class="method-description">
                    Visa, Mastercard, cartes locales
                </div>
            </div>
        </div>
        

        <div class="method-card" data-method="bank"
             style="background-image: url('{{ asset('images/Virement-bancaire.webp') }}');">
            <div class="method-content">
                <div class="method-icon">
                    <i class="fas fa-university"></i>
                </div>
                <div class="method-name">Virement Bancaire</div>
                <div class="method-description">
                    Transfert direct depuis votre banque
                </div>
            </div>
        </div>

    </div>
</div>


                    <div class="payment-instructions">
                        <h4 class="instructions-title">
                            <i class="fas fa-info-circle"></i>
                            Instructions importantes
                        </h4>
                        <ul class="instructions-list">
                            <li><i class="fas fa-check"></i> L'acompte sera déduit du montant total à payer au tuteur</li>
                            <li><i class="fas fa-check"></i> Votre annonce sera visible par les tuteurs uniquement après paiement</li>
                            <li><i class="fas fa-check"></i> Paiement 100% sécurisé via FedaPay</li>
                            <li><i class="fas fa-check"></i> Remboursement possible sous 24h si annulation</li>
                        </ul>
                    </div>

                    <div class="payment-actions">
                        <button id="btnInitPayment" class="btn-pay">
                            <i class="fas fa-lock"></i>
                            Payer {{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA
                        </button>
                        <a href="{{ route('annonces.index') }}" class="btn-cancel">
                            <i class="fas fa-times"></i>
                            Annuler
                        </a>
                    </div>

                    <!-- Modal de redirection -->
                    <div id="redirectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 9999; justify-content: center; align-items: center;">
                        <div style="background: white; padding: 40px; border-radius: 15px; text-align: center; max-width: 500px;">
                            <div class="processing-spinner" style="margin: 0 auto 20px;"></div>
                            <h3 style="color: var(--primary-color); margin-bottom: 15px;">Redirection vers FedaPay</h3>
                            <p style="color: var(--dark-gray); margin-bottom: 20px;">Vous allez être redirigé vers la page sécurisée de FedaPay pour finaliser votre paiement.</p>
                            <button id="btnContinueRedirect" class="btn-pay" style="margin-top: 20px;">
                                <i class="fas fa-external-link-alt"></i>
                                Continuer vers FedaPay
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(!session('success') && !session('error') && !$pendingPayment)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnInitPayment = document.getElementById('btnInitPayment');
            const methodCards = document.querySelectorAll('.method-card');
            const redirectModal = document.getElementById('redirectModal');
            const btnContinueRedirect = document.getElementById('btnContinueRedirect');
            
            let selectedMethod = 'mobile_money';
            
            // Sélection de la méthode de paiement
            methodCards.forEach(card => {
                card.addEventListener('click', function() {
                    methodCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedMethod = this.dataset.method;
                });
            });
            
            // Initialiser le premier comme sélectionné
            methodCards[0].classList.add('selected');
            
            // Initialisation du paiement
            btnInitPayment.addEventListener('click', async function() {
                btnInitPayment.disabled = true;
                btnInitPayment.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Initialisation...';
                
                try {
                    const response = await fetch('{{ route("annonces.init-payment", $annonce->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_method: selectedMethod
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Afficher le modal de redirection
                        redirectModal.style.display = 'flex';
                        
                        // Rediriger après confirmation
                        btnContinueRedirect.addEventListener('click', function() {
                            window.location.href = data.payment_url;
                        });
                        
                        // Redirection automatique après 5 secondes
                        setTimeout(() => {
                            window.location.href = data.payment_url;
                        }, 5000);
                        
                    } else {
                        alert('Erreur: ' + (data.error || 'Une erreur est survenue'));
                        btnInitPayment.disabled = false;
                        btnInitPayment.innerHTML = '<i class="fas fa-lock"></i> Payer {{ number_format($annonce->acompte, 0, ',', " ") }} FCFA';
                    }
                    
                } catch (error) {
                    console.error('Error:', error);
                    alert('Erreur de connexion. Veuillez réessayer.');
                    btnInitPayment.disabled = false;
                    btnInitPayment.innerHTML = '<i class="fas fa-lock"></i> Payer {{ number_format($annonce->acompte, 0, ',', " ") }} FCFA';
                }
            });
            
            // Vérification périodique du statut (en cas de retour sans callback)
            setInterval(async () => {
                try {
                    const response = await fetch('{{ route("annonces.check-payment", $annonce->id) }}');
                    const data = await response.json();
                    
                    if (data.status === 'completed') {
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Erreur vérification statut:', error);
                }
            }, 10000);
        });
    </script>
    @endif
</body>
</html>