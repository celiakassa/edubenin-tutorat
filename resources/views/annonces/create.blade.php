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

    <!-- Main Content -->
    <div class="main-content">
        <div class="create-annonce-container">
            <div class="annonce-header">
                <h1><i class="fas fa-plus-circle"></i> Créer une nouvelle annonce</h1>
                <p>Trouvez le tuteur parfait pour vos besoins d'apprentissage</p>
            </div>

            <div class="info-banner">
                <i class="fas fa-info-circle"></i>
                <p>Un acompte de 20-30% du budget sera automatiquement calculé et requis pour valider votre annonce.</p>
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
                                    <div class="amount-label">Acompte (20-30%)</div>
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

        // Fonction pour formater l'heure (HH:MM)
        function formatTime(time) {
            if (!time) return '00:00';
            const [hours, minutes] = time.split(':');
            return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
        }

        // Fonction pour générer un ID unique
        function generateId() {
            return 'disp_' + Date.now() + '_' + Math.floor(Math.random() * 1000);
        }

        // Fonction pour créer un nouvel élément de disponibilité
        function createDisponibiliteItem() {
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
                    <select class="jour-select" onchange="updatePreview()">
                        <option value="">Sélectionner un jour</option>
                        <option value="lundi">Lundi</option>
                        <option value="mardi">Mardi</option>
                        <option value="mercredi">Mercredi</option>
                        <option value="jeudi">Jeudi</option>
                        <option value="vendredi">Vendredi</option>
                        <option value="samedi">Samedi</option>
                        <option value="dimanche">Dimanche</option>
                    </select>
                    <input type="time" class="heure-debut" onchange="updatePreview()">
                    <input type="time" class="heure-fin" onchange="updatePreview()">
                </div>
            `;

            return item;
        }

        // Fonction pour supprimer un créneau
        function removeDisponibilite(id) {
            const element = document.getElementById(id);
            if (element) {
                element.remove();
                disponibiliteCounter--;
                // Renumérotation
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

        // Fonction pour mettre à jour la prévisualisation et le champ caché
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

            // Mettre à jour la prévisualisation
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

            // Mettre à jour le champ caché avec le format texte
            const textDisponibilites = disponibilites.map(disp =>
                `${disp.jour} ${disp.debut} - ${disp.fin}`
            ).join('\n');

            disponibiliteInput.value = textDisponibilites;
        }

        // Ajouter un créneau au clic sur le bouton
        document.getElementById('add-disponibilite').addEventListener('click', function() {
            const newItem = createDisponibiliteItem();
            disponibiliteContainer.appendChild(newItem);
            updatePreview();
        });

        // Calcul automatique de l'acompte et mise à jour du preview
        document.getElementById('budget').addEventListener('input', function() {
            updateBudgetPreview(this.value);
        });

        function updateBudgetPreview(budget) {
            const totalBudget = parseFloat(budget) || 0;

            // Calculer l'acompte (20-30% aléatoire)
            const depositPercentage = 20 + Math.floor(Math.random() * 11); // 20 à 30%
            const depositAmount = (totalBudget * depositPercentage) / 100;
            const remainingAmount = totalBudget - depositAmount;

            // Mettre à jour l'affichage
            document.getElementById('totalBudget').textContent =
                formatCurrency(totalBudget) + ' FCFA';
            document.getElementById('depositAmount').textContent =
                formatCurrency(depositAmount) + ' FCFA';
            document.getElementById('remainingAmount').textContent =
                formatCurrency(remainingAmount) + ' FCFA';

            // Mettre à jour le pourcentage affiché
            const depositElement = document.querySelector('.amount-note');
            if (depositElement) {
                depositElement.textContent = `À payer maintenant (${depositPercentage}%)`;
            }
        }

        function formatCurrency(amount) {
            return amount.toLocaleString('fr-FR', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Validation du formulaire
        document.getElementById('annonceForm').addEventListener('submit', function(e) {
            // Vérifier les disponibilités
            const items = disponibiliteContainer.querySelectorAll('.disponibilite-item');
            let isValid = true;
            let errorMessage = '';

            items.forEach((item, index) => {
                const jour = item.querySelector('.jour-select').value;
                const heureDebut = item.querySelector('.heure-debut').value;
                const heureFin = item.querySelector('.heure-fin').value;

                if (!jour || !heureDebut || !heureFin) {
                    isValid = false;
                    errorMessage = `Veuillez remplir tous les champs du créneau ${index + 1}`;
                } else if (heureFin <= heureDebut) {
                    isValid = false;
                    errorMessage = `L'heure de fin doit être après l'heure de début dans le créneau ${index + 1}`;
                }
            });

            if (items.length === 0) {
                isValid = false;
                errorMessage = 'Veuillez ajouter au moins un créneau de disponibilité';
            }

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
                return false;
            }

            // Vérifier le budget
            const budgetInput = document.getElementById('budget');
            if (parseFloat(budgetInput.value) < 1000) {
                e.preventDefault();
                alert('Le budget minimum est de 1000 FCFA.');
                budgetInput.focus();
                return false;
            }

            return true;
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter un créneau par défaut
            const addButton = document.getElementById('add-disponibilite');
            if (addButton) {
                addButton.click();
            }

            // Mettre à jour le budget au chargement
            const budgetInput = document.getElementById('budget');
            if (budgetInput.value) {
                updateBudgetPreview(budgetInput.value);
            }

            // Charger les anciennes disponibilités si elles existent
            const oldDisponibilite = "{{ old('disponibilite') }}";
            if (oldDisponibilite && oldDisponibilite.trim()) {
                const lines = oldDisponibilite.trim().split('\n');
                lines.forEach(line => {
                    if (line.trim()) {
                        const match = line.trim().match(/^(\w+)\s+(\d{2}:\d{2})\s+-\s+(\d{2}:\d{2})$/);
                        if (match) {
                            const [, jour, debut, fin] = match;
                            const newItem = createDisponibiliteItem();
                            disponibiliteContainer.appendChild(newItem);

                            // Remplir les champs
                            setTimeout(() => {
                                const lastItem = disponibiliteContainer.lastElementChild;
                                if (lastItem) {
                                    lastItem.querySelector('.jour-select').value = jour.toLowerCase();
                                    lastItem.querySelector('.heure-debut').value = debut;
                                    lastItem.querySelector('.heure-fin').value = fin;
                                }
                            }, 100);
                        }
                    }
                });
                updatePreview();
            }
        });
    </script>
</body>
</html>
