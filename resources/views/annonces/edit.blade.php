<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'annonce - Kopiao</title>
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

        /* Navigation Sidebar */
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Edit Form Container */
        .edit-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .edit-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 30px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .edit-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .edit-header h1 {
            font-size: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .edit-header p {
            font-size: 14px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Form Styles */
        .edit-form {
            padding: 30px 40px;
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

        /* Budget Info */
        .budget-info {
            background: var(--light-gray);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .budget-info h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 16px;
        }

        .budget-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .budget-item {
            padding: 15px;
            background: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .budget-label {
            font-size: 12px;
            color: var(--dark-gray);
            margin-bottom: 5px;
        }

        .budget-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
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

        .btn-save {
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

        .btn-save:hover {
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
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .edit-header,
            .edit-form {
                padding: 20px;
            }

            .budget-details {
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
    <!-- Navigation Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboardUser') }}" style="text-decoration: none;">
                <div class="platform-logo">
                    <div class="logo-icon">
                        KP
                    </div>
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
                <span>Statut</span>
                <span>Étudiant</span>
            </div>
            <div class="stat-item">
                <span>Crédit</span>
                <span>-</span>
            </div>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboardUser') }}" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('CompleterProfilUser.show') }}" class="menu-item">
                <i class="fas fa-user-edit"></i>
                <span>Mon profil</span>
            </a>
            <a href="{{ route('annonces.index') }}" class="menu-item">
                <i class="fas fa-bullhorn"></i>
                <span>Mes annonces</span>
            </a>
            <a href="{{ route('annonces.create') }}" class="menu-item">
                <i class="fas fa-plus-circle"></i>
                <span>Nouvelle annonce</span>
            </a>
        </div>
    </div>


    <!-- Main Content -->
    <div class="main-content">
        <div class="edit-container">
            <div class="edit-header">
                <h1><i class="fas fa-edit"></i> Modifier l'annonce</h1>
                <p>Mettez à jour les informations de votre annonce</p>
            </div>

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('annonces.update', $annonce->id) }}" class="edit-form" id="editForm">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h2><i class="fas fa-book"></i> Informations sur la formation</h2>

                    <div class="form-group">
                        <label for="domaine">Domaine / Matière *</label>
                        <input type="text" id="domaine" name="domaine"
                               value="{{ old('domaine', $annonce->domaine) }}"
                               placeholder="Ex: Mathématiques, Anglais, Physique..." required>
                        @error('domaine')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description détaillée de votre besoin *</label>
                        <textarea id="description" name="description"
                                  placeholder="Décrivez précisément ce que vous souhaitez apprendre, votre niveau actuel, vos objectifs..."
                                  required>{{ old('description', $annonce->description) }}</textarea>
                        @error('description')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Format de formation *</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="format_presentiel" name="format" value="presentiel"
                                       {{ old('format', $annonce->format) == 'presentiel' ? 'checked' : '' }} required>
                                <label for="format_presentiel" class="radio-label">
                                    <i class="fas fa-user-friends radio-icon"></i>
                                    <span class="radio-text">Présentiel</span>
                                </label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="format_en_ligne" name="format" value="en_ligne"
                                       {{ old('format', $annonce->format) == 'en_ligne' ? 'checked' : '' }} required>
                                <label for="format_en_ligne" class="radio-label">
                                    <i class="fas fa-laptop radio-icon"></i>
                                    <span class="radio-text">En ligne</span>
                                </label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="format_hybrid" name="format" value="hybrid"
                                       {{ old('format', $annonce->format) == 'hybrid' ? 'checked' : '' }} required>
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
                        <input type="hidden" name="disponibilite" id="disponibilite-input" value="{{ old('disponibilite', $annonce->disponibilite) }}">

                        @error('disponibilite')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-money-bill-wave"></i> Budget</h2>

                    <div class="form-group">
                        <label for="budget">Budget total (en FCFA) *</label>
                        <input type="number" id="budget" name="budget"
                               value="{{ old('budget', $annonce->budget) }}"
                               placeholder="Ex: 50000" required>
                        <small style="color: var(--dark-gray); font-size: 12px; display: block; margin-top: 5px;">
                            Ce budget couvrira l'ensemble de la formation.
                        </small>
                        @error('budget')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Budget Information -->
                    <div class="budget-info">
                        <h3><i class="fas fa-info-circle"></i> Information sur l'acompte</h3>
                        <div class="budget-details">
                            <div class="budget-item">
                                <div class="budget-label">Ancien acompte</div>
                                <div class="budget-value">{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div class="budget-item">
                                <div class="budget-label">Nouvel acompte estimé</div>
                                <div class="budget-value" id="newDeposit">0 FCFA</div>
                            </div>
                        </div>
                        <p style="font-size: 12px; color: var(--dark-gray); margin-top: 10px;">
                            <i class="fas fa-exclamation-triangle"></i>
                            L'acompte sera recalculé (20-30% du nouveau budget) lors de la sauvegarde.
                        </p>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i>
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('annonces.show', $annonce->id) }}" class="btn-cancel">
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
                    <select class="jour-select" onchange="updatePreview()">
                        <option value="">Sélectionner un jour</option>
                        <option value="lundi" ${jour === 'lundi' ? 'selected' : ''}>Lundi</option>
                        <option value="mardi" ${jour === 'mardi' ? 'selected' : ''}>Mardi</option>
                        <option value="mercredi" ${jour === 'mercredi' ? 'selected' : ''}>Mercredi</option>
                        <option value="jeudi" ${jour === 'jeudi' ? 'selected' : ''}>Jeudi</option>
                        <option value="vendredi" ${jour === 'vendredi' ? 'selected' : ''}>Vendredi</option>
                        <option value="samedi" ${jour === 'samedi' ? 'selected' : ''}>Samedi</option>
                        <option value="dimanche" ${jour === 'dimanche' ? 'selected' : ''}>Dimanche</option>
                    </select>
                    <input type="time" class="heure-debut" value="${debut}" onchange="updatePreview()">
                    <input type="time" class="heure-fin" value="${fin}" onchange="updatePreview()">
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
                const jourSelect = item.querySelector('.jour-select');
                const heureDebut = item.querySelector('.heure-debut').value;
                const heureFin = item.querySelector('.heure-fin').value;
                const jour = jourSelect ? jourSelect.value : '';

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

        // Calcul automatique du nouvel acompte estimé
        document.getElementById('budget').addEventListener('input', function() {
            const budget = parseFloat(this.value) || 0;
            const depositPercentage = 20 + Math.floor(Math.random() * 11); // 20 à 30%
            const depositAmount = (budget * depositPercentage) / 100;

            document.getElementById('newDeposit').textContent =
                formatCurrency(depositAmount) + ' FCFA';
        });

        function formatCurrency(amount) {
            return amount.toLocaleString('fr-FR', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Validation du formulaire
        document.getElementById('editForm').addEventListener('submit', function(e) {
            // Vérifier les disponibilités
            const items = disponibiliteContainer.querySelectorAll('.disponibilite-item');
            let isValid = true;
            let errorMessage = '';

            items.forEach((item, index) => {
                const jourSelect = item.querySelector('.jour-select');
                const jour = jourSelect ? jourSelect.value : '';
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

        // Fonction pour extraire les données d'une ligne de disponibilité
        function parseDisponibiliteLine(line) {
            line = line.trim();

            // Regex pour capturer: jour HH:MM - HH:MM
            const regex = /^(\w+)\s+(\d{1,2}):(\d{2})\s+-\s+(\d{1,2}):(\d{2})$/;
            const match = line.match(regex);

            if (!match) return null;

            const [, jour, debutHeure, debutMinute, finHeure, finMinute] = match;

            // Formater les heures avec 2 chiffres
            const debut = `${debutHeure.padStart(2, '0')}:${debutMinute}`;
            const fin = `${finHeure.padStart(2, '0')}:${finMinute}`;

            return {
                jour: jour.toLowerCase(),
                debut: debut,
                fin: fin
            };
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Initialisation du formulaire d'édition...");

            // Charger les disponibilités existantes
            const existingDisponibilite = @json($annonce->disponibilite);
            console.log("Disponibilités existantes:", existingDisponibilite);

            if (existingDisponibilite && existingDisponibilite.trim()) {
                // Séparer par les sauts de ligne
                const lines = existingDisponibilite.split('\n');
                console.log("Lignes trouvées:", lines);

                // Ajouter un délai pour s'assurer que le DOM est prêt
                setTimeout(() => {
                    lines.forEach(line => {
                        const trimmedLine = line.trim();
                        if (trimmedLine) {
                            console.log("Traitement de la ligne:", trimmedLine);

                            const disponibilite = parseDisponibiliteLine(trimmedLine);
                            if (disponibilite) {
                                console.log("Disponibilité parsée:", disponibilite);

                                const newItem = createDisponibiliteItem(
                                    disponibilite.jour,
                                    disponibilite.debut,
                                    disponibilite.fin
                                );

                                disponibiliteContainer.appendChild(newItem);
                            } else {
                                console.warn("Ligne non parsée:", trimmedLine);
                            }
                        }
                    });

                    // Mettre à jour la prévisualisation
                    updatePreview();

                    // Si aucun créneau n'a été ajouté, en ajouter un par défaut
                    if (disponibiliteContainer.children.length === 0) {
                        console.log("Aucun créneau trouvé, ajout d'un créneau par défaut");
                        const addButton = document.getElementById('add-disponibilite');
                        if (addButton) {
                            addButton.click();
                        }
                    }

                    console.log("Nombre de créneaux créés:", disponibiliteContainer.children.length);
                }, 100);
            } else {
                // Ajouter un créneau par défaut si vide
                console.log("Aucune disponibilité existante, ajout d'un créneau par défaut");
                const addButton = document.getElementById('add-disponibilite');
                if (addButton) {
                    setTimeout(() => {
                        addButton.click();
                    }, 100);
                }
            }

            // Mettre à jour l'affichage du budget au chargement
            const budgetInput = document.getElementById('budget');
            if (budgetInput.value) {
                budgetInput.dispatchEvent(new Event('input'));
            }

            // Vérifier que le bouton fonctionne
            const addButton = document.getElementById('add-disponibilite');
            if (addButton) {
                addButton.addEventListener('click', function() {
                    console.log("Bouton Ajouter un créneau cliqué");
                });
            }
        });
    </script>
</body>
</html>
