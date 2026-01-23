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

            <form method="POST" action="{{ route('annonces.update', $annonce->id) }}" class="edit-form">
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
                        <label for="disponibilite">Date et heure souhaitées *</label>
                        <input type="datetime-local" id="disponibilite" name="disponibilite" 
                               value="{{ old('disponibilite', $annonce->disponibilite->format('Y-m-d\TH:i')) }}" 
                               min="{{ date('Y-m-d\TH:i') }}" required>
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
        // Calcul automatique du nouvel acompte estimé
        document.getElementById('budget').addEventListener('input', function() {
            const budget = parseFloat(this.value) || 0;
            const depositPercentage = 20 + Math.floor(Math.random() * 11); // 20 à 30%
            const depositAmount = (budget * depositPercentage) / 100;
            
            document.getElementById('newDeposit').textContent = 
                formatCurrency(depositAmount) + ' FCFA';
        });

        // Mettre à jour l'affichage au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const budgetInput = document.getElementById('budget');
            if (budgetInput.value) {
                budgetInput.dispatchEvent(new Event('input'));
            }
        });

        function formatCurrency(amount) {
            return amount.toLocaleString('fr-FR', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Validation de la date
        document.querySelector('form').addEventListener('submit', function(e) {
            const dateInput = document.getElementById('disponibilite');
            const selectedDate = new Date(dateInput.value);
            const now = new Date();
            
            if (selectedDate <= now) {
                e.preventDefault();
                alert('La date et l\'heure doivent être dans le futur.');
                dateInput.focus();
            }
            
            const budgetInput = document.getElementById('budget');
            if (parseFloat(budgetInput.value) < 1000) {
                e.preventDefault();
                alert('Le budget minimum est de 1000 FCFA.');
                budgetInput.focus();
            }
        });
    </script>
</body>
</html>