<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une annonce - Kopiao</title>
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
            --danger-light: #fee2e2;
            --danger-dark: #991b1b;
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

        .create-annonce-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .annonce-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 30px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .annonce-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .annonce-header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .annonce-header p {
            font-size: 14px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Info Banner */
        .info-banner {
            background: var(--light-gray);
            border-left: 4px solid var(--primary-color);
            padding: 20px;
            margin: 25px 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .info-banner i {
            color: var(--primary-color);
            font-size: 24px;
        }

        .info-banner p {
            color: var(--text-dark);
            font-size: 14px;
            line-height: 1.5;
        }

        /* Form Styles */
        .annonce-form {
            padding: 0 40px 40px;
        }

        .form-section {
            margin-bottom: 25px;
            padding: 25px;
            border: 1px solid var(--medium-gray);
            border-radius: 16px;
            background: var(--white);
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .form-section:hover {
            border-color: var(--primary-light);
            box-shadow: 0 6px 20px rgba(3, 81, 188, 0.1);
        }

        .form-section h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .form-section h2 i {
            font-size: 18px;
            width: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--medium-gray);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(3, 81, 188, 0.1);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Radio Group */
        .radio-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
            margin-top: 8px;
        }

        .radio-option {
            position: relative;
        }

        .radio-option input {
            position: absolute;
            opacity: 0;
        }

        .radio-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px 12px;
            border: 2px solid var(--medium-gray);
            border-radius: 10px;
            background: var(--white);
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .radio-label:hover {
            border-color: var(--primary-light);
        }

        .radio-option input:checked + .radio-label {
            border-color: var(--primary-color);
            background: var(--primary-color);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(3, 81, 188, 0.2);
        }

        .radio-icon {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .radio-text {
            font-weight: 500;
            font-size: 13px;
        }

        /* Disponibilités Styles */
        .disponibilite-container {
            margin-top: 10px;
        }

        .disponibilite-item {
            background: var(--light-gray);
            border: 1px solid var(--medium-gray);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .disponibilite-item:hover {
            border-color: var(--primary-light);
        }

        .disponibilite-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .disponibilite-title {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remove-disponibilite {
            background: var(--danger);
            color: var(--white);
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-disponibilite:hover {
            transform: scale(1.1);
            background: #dc2626;
        }

        .disponibilite-fields {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
        }

        .disponibilite-fields select,
        .disponibilite-fields input {
            padding: 10px 12px;
            border: 2px solid var(--medium-gray);
            border-radius: 8px;
            font-size: 14px;
            background: var(--white);
        }

        .disponibilite-fields select:focus,
        .disponibilite-fields input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .add-disponibilite-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .add-disponibilite-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .disponibilite-preview {
            background: var(--light-gray);
            border: 1px solid var(--medium-gray);
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }

        .disponibilite-preview h4 {
            color: var(--primary-color);
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .disponibilite-list {
            list-style: none;
        }

        .disponibilite-list li {
            padding: 8px 0;
            border-bottom: 1px solid var(--medium-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }

        .disponibilite-list li:last-child {
            border-bottom: none;
        }

        .disponibilite-day {
            font-weight: 600;
            color: var(--text-dark);
            min-width: 100px;
        }

        .disponibilite-time {
            color: var(--dark-gray);
        }

        /* Budget Preview */
        .budget-preview {
            background: linear-gradient(135deg, var(--light-gray) 0%, #e6efff 100%);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .budget-preview h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 16px;
        }

        .budget-amounts {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .amount-item {
            padding: 15px;
            background: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .amount-label {
            font-size: 12px;
            color: var(--dark-gray);
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .amount-note {
            font-size: 11px;
            color: var(--dark-gray);
            font-style: italic;
            margin-top: 3px;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid var(--medium-gray);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 14px 32px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(3, 81, 188, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(3, 81, 188, 0.4);
        }

        .btn-cancel {
            background: var(--white);
            color: var(--dark-gray);
            padding: 14px 32px;
            border: 2px solid var(--medium-gray);
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .btn-cancel:hover {
            background: var(--light-gray);
            border-color: var(--dark-gray);
            transform: translateY(-2px);
        }

        .error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 6px;
            display: block;
            font-weight: 500;
        }

        .success-message {
            background: var(--success);
            color: var(--white);
            padding: 12px 16px;
            border-radius: 10px;
            margin: 20px 40px;
            text-align: center;
            font-weight: 500;
            font-size: 14px;
        }

        /* Error Modal */
        .error-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .error-modal {
            background: var(--white);
            border-radius: 20px;
            padding: 30px;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transform: translateY(0);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .error-modal-icon {
            width: 60px;
            height: 60px;
            background: var(--danger-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 30px;
            color: var(--danger-dark);
        }

        .error-modal-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 10px;
        }

        .error-modal-message {
            color: var(--dark-gray);
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        .error-modal-details {
            background: var(--light-gray);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid var(--danger);
            display: none;
        }

        .error-modal-detail-item {
            display: flex;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid var(--medium-gray);
        }

        .error-modal-detail-item:last-child {
            border-bottom: none;
        }

        .error-modal-detail-icon {
            color: var(--danger);
            font-size: 14px;
            margin-top: 3px;
        }

        .error-modal-detail-text {
            font-size: 13px;
            color: var(--text-dark);
            flex: 1;
        }

        .error-modal-close {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            color: var(--white);
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .error-modal-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
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

            .annonce-header,
            .annonce-form {
                padding: 20px;
            }

            .budget-amounts {
                grid-template-columns: 1fr;
            }

            .radio-group {
                grid-template-columns: 1fr;
            }

            .disponibilite-fields {
                grid-template-columns: 1fr;
            }

            .form-actions {
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
            <div class="stat-item">
                <span class="stat-label">Crédit</span>
                <span class="stat-value">-</span>
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
            <a href="{{ route('annonces.create') }}" class="menu-item active">
                <i class="fas fa-plus-circle"></i>
                <span class="menu-text">Nouvelle annonce</span>
            </a>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="error-modal-overlay" id="errorModal">
        <div class="error-modal">
            <div class="error-modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="error-modal-title" id="errorModalTitle">Erreur de validation</h3>
            <div class="error-modal-message" id="errorModalMessage"></div>
            <div class="error-modal-details" id="errorModalDetails"></div>
            <button class="error-modal-close" onclick="closeErrorModal()">
                <i class="fas fa-times"></i> Compris
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="create-annonce-container">
            <div class="annonce-header">
                <h1><i class="fas fa-plus-circle"></i> Créer une nouvelle annonce</h1>
                <p>Trouvez le tuteur parfait pour vos besoins d'apprentissage</p>
            </div>

            <div class="info-banner">
                <i class="fas fa-info-circle"></i>
                <p>Un acompte fixe de <strong>30%</strong> du budget sera requis pour valider votre annonce.</p>
            </div>

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('annonces.store') }}" class="annonce-form" id="annonceForm">
                @csrf

                <div class="form-section">
                    <h2><i class="fas fa-book"></i> Informations sur la formation</h2>

                    <div class="form-group">
                        <label for="domaine">Domaine / Matière *</label>
                        <input type="text" id="domaine" name="domaine"
                               value="{{ old('domaine') }}"
                               placeholder="Ex: Mathématiques, Anglais, Physique..." required>
                        @error('domaine')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description détaillée de votre besoin *</label>
                        <textarea id="description" name="description"
                                  placeholder="Décrivez précisément ce que vous souhaitez apprendre, votre niveau actuel, vos objectifs..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Format de formation *</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="format_presentiel" name="format" value="presentiel"
                                       {{ old('format') == 'presentiel' ? 'checked' : 'checked' }} required>
                                <label for="format_presentiel" class="radio-label">
                                    <i class="fas fa-user-friends radio-icon"></i>
                                    <span class="radio-text">Présentiel</span>
                                </label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="format_en_ligne" name="format" value="en_ligne"
                                       {{ old('format') == 'en_ligne' ? 'checked' : '' }} required>
                                <label for="format_en_ligne" class="radio-label">
                                    <i class="fas fa-laptop radio-icon"></i>
                                    <span class="radio-text">En ligne</span>
                                </label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="format_hybrid" name="format" value="hybrid"
                                       {{ old('format') == 'hybrid' ? 'checked' : '' }} required>
                                <label for="format_hybrid" class="radio-label">
                                    <i class="fas fa-blender-phone radio-icon"></i>
                                    <span class="radio-text">Hybride</span>
                                </label>
                            </div>
                        </div>
                        @error('format')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Mes disponibilités *</label>
                        <small class="text-muted d-block mb-2">
                            Ajoutez vos créneaux de disponibilité en sélectionnant le jour et les heures
                        </small>

                        <!-- Container pour les créneaux -->
                        <div id="disponibilite-container">
                            <!-- Les créneaux seront ajoutés ici dynamiquement -->
                        </div>

                        <!-- Bouton pour ajouter un créneau -->
                        <button type="button" id="add-disponibilite" class="add-disponibilite-btn">
                            <i class="fas fa-plus"></i> Ajouter un créneau
                        </button>

                        <!-- Prévisualisation -->
                        <div class="disponibilite-preview" id="disponibilite-preview">
                            <h4><i class="fas fa-eye"></i> Prévisualisation</h4>
                            <ul class="disponibilite-list" id="preview-list">
                                <li class="text-muted">Aucun créneau ajouté</li>
                            </ul>
                        </div>

                        <!-- Champ caché pour stocker les disponibilités formatées -->
                        <input type="hidden" name="disponibilite" id="disponibilite-input" value="{{ old('disponibilite') }}">

                        @error('disponibilite')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-money-bill-wave"></i> Mon Budget</h2>

                    <div class="form-group">
                        <label for="budget">Budget total (en FCFA) *</label>
                        <div class="form-group">
                            <input type="number" id="budget" name="budget"
                                   value="{{ old('budget') }}"
                                   placeholder="Ex: 50000" required>
                            <small style="color: var(--dark-gray); font-size: 12px; display: block; margin-top: 5px;">
                                Ce budget couvrira l'ensemble de la formation.
                            </small>
                            @error('budget')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Budget Preview -->
                        <div class="budget-preview" id="budgetPreview">
                            <h3><i class="fas fa-calculator"></i> Aperçu du coût</h3>
                            <div class="budget-amounts">
                                <div class="amount-item">
                                    <div class="amount-label">Budget total</div>
                                    <div class="amount-value" id="totalBudget">0 FCFA</div>
                                </div>
                                <div class="amount-item">
                                    <div class="amount-label">Acompte (30%)</div>
                                    <div class="amount-value" id="depositAmount">0 FCFA</div>
                                    <div class="amount-note">À payer maintenant</div>
                                </div>
                                <div class="amount-item">
                                    <div class="amount-label">Solde restant</div>
                                    <div class="amount-value" id="remainingAmount">0 FCFA</div>
                                    <div class="amount-note">À payer plus tard</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-check-circle"></i>
                        Créer l'annonce
                    </button>
                    <a href="{{ route('annonces.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Variables globales
        let disponibiliteCounter = 0;
        const disponibiliteContainer = document.getElementById('disponibilite-container');
        const disponibiliteInput = document.getElementById('disponibilite-input');
        const previewList = document.getElementById('preview-list');
        const errorModal = document.getElementById('errorModal');
        const errorModalTitle = document.getElementById('errorModalTitle');
        const errorModalMessage = document.getElementById('errorModalMessage');
        const errorModalDetails = document.getElementById('errorModalDetails');

        // Fonctions utilitaires
        function formatTime(time) {
            if (!time) return '00:00';
            const [hours, minutes] = time.split(':');
            return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
        }

        function generateId() {
            return 'disp_' + Date.now() + '_' + Math.floor(Math.random() * 1000);
        }

        function formatCurrency(amount) {
            return amount.toLocaleString('fr-FR', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Fonction pour afficher l'erreur de façon stylisée
        function showErrorModal(title, message, details = []) {
            errorModalTitle.textContent = title;
            errorModalMessage.textContent = message;

            if (details.length > 0) {
                let detailsHtml = '';
                details.forEach(detail => {
                    detailsHtml += `
                        <div class="error-modal-detail-item">
                            <div class="error-modal-detail-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="error-modal-detail-text">${detail}</div>
                        </div>
                    `;
                });
                errorModalDetails.innerHTML = detailsHtml;
                errorModalDetails.style.display = 'block';
            } else {
                errorModalDetails.style.display = 'none';
            }

            errorModal.style.display = 'flex';
        }

        // Fonction pour fermer l'erreur
        window.closeErrorModal = function() {
            errorModal.style.display = 'none';
        }

        // Fermer en cliquant en dehors
        errorModal.addEventListener('click', function(e) {
            if (e.target === errorModal) {
                closeErrorModal();
            }
        });

        // Fonction pour vérifier les doublons
        function checkDuplicate(jour, debut, fin, currentId = null) {
            const items = disponibiliteContainer.querySelectorAll('.disponibilite-item');
            let duplicates = [];

            items.forEach(item => {
                if (currentId && item.id === currentId) return;

                const itemJour = item.querySelector('.jour-select').value;
                const itemDebut = item.querySelector('.heure-debut').value;
                const itemFin = item.querySelector('.heure-fin').value;

                if (itemJour === jour && itemDebut === debut && itemFin === fin) {
                    duplicates.push(item);
                }
            });

            return duplicates.length > 0;
        }

        // Fonction pour créer un nouvel élément de disponibilité
        function createDisponibiliteItem(jour = '', debut = '', fin = '') {
            const id = generateId();
            disponibiliteCounter++;

            const item = document.createElement('div');
            item.className = 'disponibilite-item';
            item.id = id;

            item.innerHTML = `
                <div class="disponibilite-header">
                    <div class="disponibilite-title">
                        <i class="far fa-clock"></i>
                        Créneau ${disponibiliteCounter}
                    </div>
                    <button type="button" class="remove-disponibilite" onclick="removeDisponibilite('${id}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="disponibilite-fields">
                    <select class="jour-select" onchange="validateAndUpdate('${id}')">
                        <option value="">Sélectionner un jour</option>
                        <option value="lundi" ${jour === 'lundi' ? 'selected' : ''}>Lundi</option>
                        <option value="mardi" ${jour === 'mardi' ? 'selected' : ''}>Mardi</option>
                        <option value="mercredi" ${jour === 'mercredi' ? 'selected' : ''}>Mercredi</option>
                        <option value="jeudi" ${jour === 'jeudi' ? 'selected' : ''}>Jeudi</option>
                        <option value="vendredi" ${jour === 'vendredi' ? 'selected' : ''}>Vendredi</option>
                        <option value="samedi" ${jour === 'samedi' ? 'selected' : ''}>Samedi</option>
                        <option value="dimanche" ${jour === 'dimanche' ? 'selected' : ''}>Dimanche</option>
                    </select>
                    <input type="time" class="heure-debut" value="${debut}" onchange="validateAndUpdate('${id}')">
                    <input type="time" class="heure-fin" value="${fin}" onchange="validateAndUpdate('${id}')">
                </div>
            `;

            return item;
        }

        // Fonction pour supprimer un créneau
        window.removeDisponibilite = function(id) {
            const element = document.getElementById(id);
            if (element) {
                element.remove();
                disponibiliteCounter--;
                const items = disponibiliteContainer.querySelectorAll('.disponibilite-item');
                items.forEach((item, index) => {
                    const title = item.querySelector('.disponibilite-title');
                    if (title) {
                        title.innerHTML = `<i class="far fa-clock"></i> Créneau ${index + 1}`;
                    }
                });
                disponibiliteCounter = items.length;
                updatePreview();
            }
        }

        // Fonction pour valider et mettre à jour
        function validateAndUpdate(itemId) {
            const item = document.getElementById(itemId);
            if (!item) return;

            const jour = item.querySelector('.jour-select').value;
            const heureDebut = item.querySelector('.heure-debut').value;
            const heureFin = item.querySelector('.heure-fin').value;

            if (jour && heureDebut && heureFin) {
                if (checkDuplicate(jour, heureDebut, heureFin, itemId)) {
                    item.querySelector('.jour-select').value = '';
                    item.querySelector('.heure-debut').value = '';
                    item.querySelector('.heure-fin').value = '';
                    showErrorModal(
                        'Créneau en double',
                        'Ce créneau existe déjà. Veuillez choisir un autre horaire.',
                        []
                    );
                }
            }

            updatePreview();
        }

        // Fonction pour mettre à jour la prévisualisation
        function updatePreview() {
            const items = disponibiliteContainer.querySelectorAll('.disponibilite-item');
            const disponibilites = [];

            items.forEach(item => {
                const jour = item.querySelector('.jour-select').value;
                const heureDebut = item.querySelector('.heure-debut').value;
                const heureFin = item.querySelector('.heure-fin').value;

                if (jour && heureDebut && heureFin) {
                    disponibilites.push({
                        jour: jour,
                        debut: formatTime(heureDebut),
                        fin: formatTime(heureFin)
                    });
                }
            });

            if (disponibilites.length > 0) {
                previewList.innerHTML = '';
                disponibilites.forEach(disp => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <span class="disponibilite-day">${disp.jour.charAt(0).toUpperCase() + disp.jour.slice(1)}</span>
                        <span class="disponibilite-time">${disp.debut} - ${disp.fin}</span>
                    `;
                    previewList.appendChild(li);
                });
            } else {
                previewList.innerHTML = '<li class="text-muted">Aucun créneau ajouté</li>';
            }

            const textDisponibilites = disponibilites.map(disp =>
                `${disp.jour} ${disp.debut} - ${disp.fin}`
            ).join('\n');

            disponibiliteInput.value = textDisponibilites;
        }

        // Fonction pour mettre à jour le budget
        function updateBudgetPreview(budget) {
            const totalBudget = parseFloat(budget) || 0;
            const depositAmount = totalBudget * 0.3;
            const remainingAmount = totalBudget - depositAmount;

            document.getElementById('totalBudget').textContent = formatCurrency(totalBudget) + ' FCFA';
            document.getElementById('depositAmount').textContent = formatCurrency(depositAmount) + ' FCFA';
            document.getElementById('remainingAmount').textContent = formatCurrency(remainingAmount) + ' FCFA';
        }

        // Ajouter un créneau
        document.getElementById('add-disponibilite').addEventListener('click', function() {
            const items = disponibiliteContainer.querySelectorAll('.disponibilite-item');

            if (items.length > 0) {
                const lastItem = items[items.length - 1];
                const jour = lastItem.querySelector('.jour-select').value;
                const debut = lastItem.querySelector('.heure-debut').value;
                const fin = lastItem.querySelector('.heure-fin').value;

                if (!jour || !debut || !fin) {
                    showErrorModal(
                        'Créneau incomplet',
                        'Veuillez d\'abord compléter le créneau actuel avant d\'en ajouter un nouveau.',
                        []
                    );
                    return;
                }
            }

            const newItem = createDisponibiliteItem();
            disponibiliteContainer.appendChild(newItem);
            updatePreview();
        });

        // Validation du formulaire
        document.getElementById('annonceForm').addEventListener('submit', function(e) {
            const items = disponibiliteContainer.querySelectorAll('.disponibilite-item');
            let isValid = true;
            let errors = [];
            let seenSlots = new Set();

            items.forEach((item, index) => {
                const jour = item.querySelector('.jour-select').value;
                const heureDebut = item.querySelector('.heure-debut').value;
                const heureFin = item.querySelector('.heure-fin').value;

                if (!jour || !heureDebut || !heureFin) {
                    isValid = false;
                    errors.push(`Le créneau ${index + 1} est incomplet`);
                } else if (heureFin <= heureDebut) {
                    isValid = false;
                    errors.push(`Créneau ${index + 1}: L'heure de fin doit être après l'heure de début`);
                } else {
                    const slotKey = `${jour}-${heureDebut}-${heureFin}`;
                    if (seenSlots.has(slotKey)) {
                        isValid = false;
                        errors.push(`Créneau ${index + 1}: Ce créneau existe déjà (${jour} ${heureDebut} - ${heureFin})`);
                    } else {
                        seenSlots.add(slotKey);
                    }
                }
            });

            if (items.length === 0) {
                isValid = false;
                errors.push('Vous devez ajouter au moins un créneau de disponibilité');
            }

            const budgetInput = document.getElementById('budget');
            if (parseFloat(budgetInput.value) < 1000) {
                isValid = false;
                errors.push('Le budget minimum est de 1000 FCFA');
            }

            if (!isValid) {
                e.preventDefault();
                showErrorModal(
                    'Erreur de validation',
                    'Veuillez corriger les erreurs suivantes :',
                    errors
                );
                return false;
            }

            return true;
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            const oldDisponibilite = "{{ old('disponibilite') }}";

            if (oldDisponibilite && oldDisponibilite.trim()) {
                const lines = oldDisponibilite.trim().split('\n');
                let seenSlots = new Set();

                lines.forEach(line => {
                    if (line.trim()) {
                        const match = line.trim().match(/^(\w+)\s+(\d{2}:\d{2})\s+-\s+(\d{2}:\d{2})$/);
                        if (match) {
                            const [, jour, debut, fin] = match;
                            const slotKey = `${jour.toLowerCase()}-${debut}-${fin}`;

                            if (!seenSlots.has(slotKey)) {
                                seenSlots.add(slotKey);
                                const newItem = createDisponibiliteItem(jour.toLowerCase(), debut, fin);
                                disponibiliteContainer.appendChild(newItem);
                            }
                        }
                    }
                });
                updatePreview();
            } else {
                // Ajouter un seul créneau par défaut
                const addButton = document.getElementById('add-disponibilite');
                if (addButton) {
                    addButton.click();
                }
            }

            const budgetInput = document.getElementById('budget');
            if (budgetInput.value) {
                updateBudgetPreview(budgetInput.value);
            } else {
                updateBudgetPreview(0);
            }

            budgetInput.addEventListener('input', function() {
                updateBudgetPreview(this.value);
            });
        });
    </script>
</body>
</html>
