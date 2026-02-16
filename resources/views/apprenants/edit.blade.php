@extends('layouts.adminLayout')

@section('content')
    <style>
        :root {
            --primary-color: #3a86ff;
            --primary-dark: #2a76ef;
            --secondary-color: #8338ec;
            --success-color: #06d6a0;
            --warning-color: #f8961e;
            --danger-color: #ef476f;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --gray-color: #64748b;
            --border-color: #e2e8f0;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            --radius: 15px;
            --radius-sm: 10px;
        }

        

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .header h2 {
            color: var(--dark-color);
            font-size: 28px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header h2 i {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 32px;
        }

        /* Boutons header */
        .header-actions {
            display: flex;
            gap: 10px;
        }

        .header-actions .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .header-actions .btn-info {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            color: white;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.2);
        }

        .header-actions .btn-info:hover {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
        }

        .header-actions .btn-secondary {
            background: linear-gradient(135deg, #64748b, #475569);
            color: white;
            box-shadow: 0 4px 15px rgba(100, 116, 139, 0.2);
        }

        .header-actions .btn-secondary:hover {
            background: linear-gradient(135deg, #475569, #334155);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.3);
        }

        /* Conteneur centré */
        .form-container {
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Progress Indicator */
        .progress-indicator {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            position: relative;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            flex: 1;
            position: relative;
            cursor: pointer;
            transition: var(--transition);
            z-index: 2;
        }

        .progress-step:hover:not(.step-active) .step-number {
            background: rgba(58, 134, 255, 0.1);
            border-color: var(--primary-color);
        }

        .progress-step::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            right: -50%;
            height: 3px;
            background: var(--border-color);
            z-index: 1;
            transition: var(--transition);
        }

        .progress-step.step-active::after {
            background: var(--primary-color);
        }

        .progress-step:last-child::after {
            display: none;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 3px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: var(--gray-color);
            z-index: 2;
            transition: var(--transition);
            font-size: 16px;
        }

        .step-active .step-number {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-color: transparent;
            transform: scale(1.1);
            box-shadow: 0 5px 20px rgba(58, 134, 255, 0.4);
        }

        .step-label {
            font-size: 12px;
            color: var(--gray-color);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }

        .step-active .step-label {
            color: var(--primary-color);
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: var(--radius);
            padding: 0;
            box-shadow: var(--shadow);
            border: none;
            overflow: hidden;
            animation: fadeInUp 0.6s ease 0.2s both;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Form Sections */
        .form-section {
            display: none;
            flex-direction: column;
            flex: 1;
        }

        .form-section.active {
            display: flex;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-section h3 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            padding-left: 15px;
            border-left: 4px solid var(--primary-color);
        }

        .form-section h3 i {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 20px;
        }

        /* Form Labels */
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .form-label i {
            color: var(--primary-color);
            font-size: 14px;
        }

        .form-label .required {
            color: var(--danger-color);
            margin-left: 3px;
        }

        /* Inputs */
        .form-control,
        .form-select {
            border: 2px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 12px 15px;
            font-size: 14px;
            transition: var(--transition);
            background: var(--light-color);
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.15);
            background: white;
            transform: translateY(-2px);
            outline: none;
        }

        .form-control::placeholder {
            color: #94a3b8;
            font-size: 13px;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: var(--danger-color);
            background: linear-gradient(to right, rgba(239, 71, 111, 0.05), transparent);
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 71, 111, 0.15);
        }

        /* File Input */
        .file-input-container {
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .file-input-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--light-color);
            border: 3px dashed var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px auto 15px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
        }

        .file-input-preview:hover {
            border-color: var(--primary-color);
            transform: scale(1.05);
            background: rgba(58, 134, 255, 0.05);
        }

        .file-input-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .file-input-preview i {
            font-size: 36px;
            color: var(--gray-color);
        }

        #photo {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            top: 0;
            left: 0;
        }

        /* Switch */
        .form-switch {
            padding-left: 3.5rem;
        }

        .form-switch .form-check-input {
            width: 2.8rem;
            height: 1.5rem;
            margin-left: -3.5rem;
            background-color: var(--border-color);
            border-color: var(--border-color);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
            cursor: pointer;
            transition: var(--transition);
        }

        .form-switch .form-check-input:checked {
            background-color: var(--success-color);
            border-color: var(--success-color);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        }

        .form-switch .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(6, 214, 160, 0.25);
        }

        .form-check-label {
            font-weight: 500;
            color: var(--dark-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        /* Textarea */
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
            font-size: 14px;
        }

        /* Form Section Actions */
        .form-section-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 30px;
            border-top: 2px solid var(--light-color);
        }

        .form-section-actions .btn {
            padding: 12px 25px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            min-width: 120px;
            justify-content: center;
        }

        .form-section-actions .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 15px rgba(58, 134, 255, 0.3);
        }

        .form-section-actions .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), #7328dc);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(58, 134, 255, 0.4);
        }

        .form-section-actions .btn-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .form-section-actions .btn-outline:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .form-section-actions .btn-secondary {
            background: linear-gradient(135deg, #64748b, #475569);
            color: white;
            box-shadow: 0 4px 15px rgba(100, 116, 139, 0.2);
        }

        .form-section-actions .btn-secondary:hover {
            background: linear-gradient(135deg, #475569, #334155);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.3);
        }

        /* Error Messages */
        .invalid-feedback {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--danger-color);
            font-weight: 600;
            font-size: 12px;
            margin-top: 6px;
            padding: 8px 12px;
            background: linear-gradient(to right, rgba(239, 71, 111, 0.1), transparent);
            border-radius: var(--radius-sm);
            border-left: 3px solid var(--danger-color);
        }

        .invalid-feedback::before {
            content: '⚠';
            font-size: 12px;
            font-weight: bold;
        }

        /* Info Text */
        .form-text {
            color: var(--gray-color);
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-text i {
            color: var(--primary-color);
            font-size: 12px;
        }

        /* Password Strength */
        .password-strength {
            height: 6px;
            background: var(--border-color);
            border-radius: 3px;
            margin-top: 8px;
            overflow: hidden;
            position: relative;
        }

        .password-strength-fill {
            height: 100%;
            width: 0%;
            transition: width 0.4s ease;
            border-radius: 3px;
        }

        .strength-0 {
            width: 0%;
            background: var(--danger-color);
        }

        .strength-1 {
            width: 25%;
            background: var(--danger-color);
        }

        .strength-2 {
            width: 50%;
            background: var(--warning-color);
        }

        .strength-3 {
            width: 75%;
            background: #f4c542;
        }

        .strength-4 {
            width: 100%;
            background: var(--success-color);
        }

        /* Bio Counter */
        #bioCounter {
            font-weight: 600;
            font-size: 12px;
            transition: color 0.3s;
        }

        /* Settings Card */
        .settings-card {
            border: 2px solid var(--light-color) !important;
            border-radius: var(--radius-sm) !important;
            padding: 15px !important;
            background: var(--light-color);
            margin-top: 10px;
        }

        /* Confirmation Section */
        .confirmation-summary {
            margin: 20px 0;
        }

        .summary-card {
            background: var(--light-color);
            border-radius: var(--radius-sm);
            padding: 20px;
            border-left: 4px solid var(--warning-color);
            margin-bottom: 20px;
        }

        .summary-card h4 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }

        .summary-card h4 i {
            color: var(--warning-color);
        }

        .summary-content {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-label {
            font-weight: 600;
            color: var(--gray-color);
            font-size: 14px;
        }

        .summary-value {
            font-weight: 700;
            color: var(--dark-color);
            font-size: 14px;
            text-align: right;
        }

        .confirmation-message {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(58, 134, 255, 0.1);
            border-radius: var(--radius-sm);
            padding: 15px;
            border-left: 4px solid var(--primary-color);
            margin-top: 20px;
        }

        .confirmation-message i {
            color: var(--primary-color);
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .confirmation-message p {
            margin: 0;
            color: var(--dark-color);
            font-size: 14px;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .main-content {
                padding: 20px;
            }

            .form-container {
                max-width: 100%;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .header-actions {
                width: 100%;
                flex-wrap: wrap;
            }

            .header-actions .btn {
                flex: 1;
                min-width: 120px;
                justify-content: center;
            }

            .progress-step::after {
                display: none;
            }

            .card-body {
                padding: 20px;
            }

            .form-section-actions {
                flex-direction: column;
                gap: 15px;
            }

            .form-section-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .header h2 {
                font-size: 24px;
            }

            .progress-indicator {
                padding: 15px;
                flex-wrap: wrap;
                gap: 15px;
            }

            .progress-step {
                flex: 0 0 calc(50% - 15px);
            }

            .step-number {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .step-label {
                font-size: 11px;
            }

            .form-section h3 {
                font-size: 16px;
            }

            .confirmation-message {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .progress-step {
                flex: 0 0 100%;
            }

            .card-header h2 {
                font-size: 18px;
            }

            .form-control,
            .form-select {
                padding: 10px 12px;
                font-size: 13px;
            }

            .form-label {
                font-size: 12px;
            }

            .form-section-actions .btn {
                padding: 10px 20px;
                font-size: 13px;
            }
        }

        /* Row spacing */
        .row {
            margin-bottom: 10px;
        }

        .mb-4 {
            margin-bottom: 1.2rem !important;
        }

        /* Animation for inputs */
        @keyframes inputFocus {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.01);
            }
            100% {
                transform: scale(1);
            }
        }

        .form-control:focus,
        .form-select:focus {
            animation: inputFocus 0.3s ease;
        }

        /* Shake animation */
        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: translateX(-5px);
            }
            20%, 40%, 60%, 80% {
                transform: translateX(5px);
            }
        }

        /* Photo Preview */
        .current-photo {
            position: relative;
            display: inline-block;
            margin-bottom: 10px;
        }

        .current-photo img {
            border-radius: 50%;
            border: 3px solid var(--border-color);
            transition: var(--transition);
        }

        .current-photo:hover img {
            transform: scale(1.05);
            border-color: var(--primary-color);
        }

        .photo-actions {
            position: absolute;
            top: 5px;
            right: 5px;
            opacity: 0;
            transition: var(--transition);
        }

        .current-photo:hover .photo-actions {
            opacity: 1;
        }

        .photo-actions .btn {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 20px;
        }
    </style>

    <div class="admin-container">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h2>
                    <i class="fas fa-user-edit"></i>
                    Modifier l'Apprenant
                </h2>
                <div class="header-actions">
                    <a href="{{ route('apprenants.show', $apprenant->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Voir
                    </a>
                    <a href="{{ route('apprenants.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>

            <!-- Conteneur centré du formulaire -->
            <div class="form-container">
                <!-- Indicateur de progression -->
                <div class="progress-indicator">
                    <div class="progress-step step-active" data-step="1">
                        <div class="step-number">1</div>
                        <span class="step-label">Informations</span>
                    </div>
                    <div class="progress-step" data-step="2">
                        <div class="step-number">2</div>
                        <span class="step-label">Contact</span>
                    </div>
                    <div class="progress-step" data-step="3">
                        <div class="step-number">3</div>
                        <span class="step-label">Paramètres</span>
                    </div>
                    <div class="progress-step" data-step="4">
                        <div class="step-number">4</div>
                        <span class="step-label">Confirmation</span>
                    </div>
                </div>

                <!-- Card du formulaire -->
                <div class="form-card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-user-graduate"></i>
                            Modification de l'apprenant - {{ $apprenant->firstname }} {{ $apprenant->lastname }}
                        </h2>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('apprenants.update', $apprenant->id) }}" method="POST" enctype="multipart/form-data" id="apprenantForm">
                            @csrf
                            @method('PUT')

                            <!-- Section 1 : Informations personnelles -->
                            <div class="form-section active" id="section-1">
                                <h3><i class="fas fa-user-circle"></i> Informations Personnelles</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="firstname" class="form-label">
                                                <i class="fas fa-user"></i> Prénom <span class="required">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('firstname') is-invalid @enderror"
                                                id="firstname" name="firstname"
                                                value="{{ old('firstname', $apprenant->firstname) }}" required
                                                placeholder="Ex: Jean">
                                            @error('firstname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="lastname" class="form-label">
                                                <i class="fas fa-user-tag"></i> Nom <span class="required">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('lastname') is-invalid @enderror"
                                                id="lastname" name="lastname"
                                                value="{{ old('lastname', $apprenant->lastname) }}" required
                                                placeholder="Ex: Dupont">
                                            @error('lastname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="city" class="form-label">
                                                <i class="fas fa-city"></i> Ville <span class="required">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('city') is-invalid @enderror"
                                                id="city" name="city"
                                                value="{{ old('city', $apprenant->city) }}" required
                                                placeholder="Ex: Paris">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="learning_preference" class="form-label">
                                                <i class="fas fa-graduation-cap"></i> Préférence d'apprentissage
                                            </label>
                                            <select class="form-select @error('learning_preference') is-invalid @enderror"
                                                id="learning_preference" name="learning_preference">
                                                <option value="">-- Sélectionner un mode --</option>
                                                <option value="online" {{ (old('learning_preference', $apprenant->learning_preference) == 'online') ? 'selected' : '' }}>
                                                    En ligne
                                                </option>
                                                <option value="in_person" {{ (old('learning_preference', $apprenant->learning_preference) == 'in_person') ? 'selected' : '' }}>
                                                    En présentiel
                                                </option>
                                                <option value="hybrid" {{ (old('learning_preference', $apprenant->learning_preference) == 'hybrid') ? 'selected' : '' }}>
                                                    Hybride
                                                </option>
                                            </select>
                                            @error('learning_preference')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="fas fa-info-circle"></i> Définissez le mode d'apprentissage préféré
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-actions">
                                    <button type="button" class="btn btn-secondary" id="cancelBtn">
                                        <i class="fas fa-times"></i> Annuler
                                    </button>
                                    <button type="button" class="btn btn-primary next-section" data-current="1" data-next="2">
                                        Suivant <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Section 2 : Informations de contact -->
                            <div class="form-section" id="section-2" style="display: none;">
                                <h3><i class="fas fa-address-card"></i> Informations de Contact</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="email" class="form-label">
                                                <i class="fas fa-envelope"></i> Email <span class="required">*</span>
                                            </label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email"
                                                value="{{ old('email', $apprenant->email) }}" required
                                                placeholder="exemple@email.com">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="telephone" class="form-label">
                                                <i class="fas fa-phone"></i> Téléphone
                                            </label>
                                            <input type="tel"
                                                class="form-control @error('telephone') is-invalid @enderror"
                                                id="telephone" name="telephone"
                                                value="{{ old('telephone', $apprenant->telephone) }}"
                                                placeholder="+33 1 23 45 67 89">
                                            @error('telephone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="fas fa-info-circle"></i> Format international recommandé
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="password" class="form-label">
                                                <i class="fas fa-lock"></i> Nouveau mot de passe
                                            </label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password"
                                                placeholder="Minimum 8 caractères (laisser vide pour ne pas changer)">
                                            <div class="password-strength">
                                                <div class="password-strength-fill" id="passwordStrength"></div>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="fas fa-info-circle"></i> Laisser vide pour conserver le mot de passe actuel
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="password_confirmation" class="form-label">
                                                <i class="fas fa-lock"></i> Confirmation
                                            </label>
                                            <input type="password"
                                                class="form-control"
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                placeholder="Répétez le nouveau mot de passe">
                                            <div class="form-text">
                                                <i class="fas fa-info-circle"></i> Doit correspondre au mot de passe
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-actions">
                                    <button type="button" class="btn btn-outline prev-section" data-current="2" data-prev="1">
                                        <i class="fas fa-arrow-left"></i> Précédent
                                    </button>
                                    <button type="button" class="btn btn-primary next-section" data-current="2" data-next="3">
                                        Suivant <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Section 3 : Informations supplémentaires -->
                            <div class="form-section" id="section-3" style="display: none;">
                                <h3><i class="fas fa-plus-circle"></i> Informations Supplémentaires</h3>

                                <div class="mb-4">
                                    <label for="bio" class="form-label">
                                        <i class="fas fa-edit"></i> Biographie
                                    </label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror"
                                        id="bio" name="bio" rows="4"
                                        placeholder="Décrivez brièvement l'apprenant (parcours, objectifs, etc.)">{{ old('bio', $apprenant->bio) }}</textarea>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i> Maximum 500 caractères
                                        </div>
                                        <small class="text-muted" id="bioCounter">0/500</small>
                                    </div>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">
                                                <i class="fas fa-camera"></i> Photo de profil
                                            </label>
                                            <div class="file-input-container">
                                                <div class="file-input-preview" id="photoPreview">
                                                    @if($apprenant->photo_path)
                                                        <img src="{{ asset('storage/' . $apprenant->photo_path) }}"
                                                            alt="Photo actuelle" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <i class="fas fa-user-circle"></i>
                                                    @endif
                                                </div>
                                                <input type="file"
                                                    class="form-control @error('photo') is-invalid @enderror"
                                                    id="photo" name="photo" accept="image/*">
                                            </div>
                                            @error('photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text text-center">
                                                <i class="fas fa-info-circle"></i> JPEG, PNG, JPG, GIF, WEBP (max 2MB)
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">
                                                <i class="fas fa-toggle-on"></i> Paramètres du compte
                                            </label>
                                            <div class="card settings-card">
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="is_active" name="is_active" value="1"
                                                        {{ old('is_active', $apprenant->is_active) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        <i class="fas fa-power-off"></i> Compte actif
                                                    </label>
                                                </div>

                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="is_valid" name="is_valid" value="1"
                                                        {{ old('is_valid', $apprenant->is_valid) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_valid">
                                                        <i class="fas fa-check-circle"></i> Compte validé
                                                    </label>
                                                </div>

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="receive_notifications" name="receive_notifications" value="1"
                                                        {{ old('receive_notifications', $apprenant->receive_notifications ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="receive_notifications">
                                                        <i class="fas fa-bell"></i> Recevoir les notifications
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-actions">
                                    <button type="button" class="btn btn-outline prev-section" data-current="3" data-prev="2">
                                        <i class="fas fa-arrow-left"></i> Précédent
                                    </button>
                                    <button type="button" class="btn btn-primary next-section" data-current="3" data-next="4">
                                        Suivant <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Section 4 : Confirmation -->
                            <div class="form-section" id="section-4" style="display: none;">
                                <h3><i class="fas fa-check-circle"></i> Confirmation</h3>

                                <div class="confirmation-summary">
                                    <div class="summary-card">
                                        <h4><i class="fas fa-user-check"></i> Récapitulatif des modifications</h4>
                                        <div class="summary-content">
                                            <div class="summary-item">
                                                <span class="summary-label">Nom complet :</span>
                                                <span class="summary-value" id="summary-name"></span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Email :</span>
                                                <span class="summary-value" id="summary-email"></span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Ville :</span>
                                                <span class="summary-value" id="summary-city"></span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Préférence :</span>
                                                <span class="summary-value" id="summary-preference"></span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Statut :</span>
                                                <span class="summary-value" id="summary-status"></span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Validation :</span>
                                                <span class="summary-value" id="summary-valid"></span>
                                            </div>
                                            <div class="summary-item">
                                                <span class="summary-label">Photo :</span>
                                                <span class="summary-value" id="summary-photo"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="confirmation-message">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <p><strong>Attention :</strong> Vérifiez attentivement les modifications avant de les sauvegarder.</p>
                                    </div>
                                </div>

                                <div class="form-section-actions">
                                    <button type="button" class="btn btn-outline prev-section" data-current="4" data-prev="3">
                                        <i class="fas fa-arrow-left"></i> Précédent
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="submitForm">
                                        <i class="fas fa-save"></i> Mettre à jour
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables globales
            let currentSection = 1;
            const totalSections = 4;

            // Initialiser la première section
            showSection(1);

            // Prévisualisation de la photo
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photoPreview');
            const currentPhotoSrc = "{{ $apprenant->photo_path ? asset('storage/' . $apprenant->photo_path) : '' }}";

            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Vérifier la taille du fichier (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        showNotification('Le fichier est trop volumineux. Maximum 2MB autorisé.', 'error');
                        this.value = '';
                        return;
                    }

                    // Vérifier le type de fichier
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        showNotification(
                            'Format de fichier non supporté. Utilisez JPEG, PNG, JPG, GIF ou WEBP.',
                            'error');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.innerHTML =
                            `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">`;
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Réinitialiser à la photo actuelle
                    if (currentPhotoSrc) {
                        photoPreview.innerHTML = `<img src="${currentPhotoSrc}" alt="Photo actuelle" style="width: 100%; height: 100%; object-fit: cover;">`;
                    } else {
                        photoPreview.innerHTML = '<i class="fas fa-user-circle"></i>';
                    }
                }
            });

            // Compteur de caractères pour la biographie
            const bioTextarea = document.getElementById('bio');
            const bioCounter = document.getElementById('bioCounter');

            bioTextarea.addEventListener('input', function() {
                const length = this.value.length;
                bioCounter.textContent = `${length}/500`;

                if (length > 500) {
                    bioCounter.style.color = '#ef476f';
                    bioCounter.style.fontWeight = 'bold';
                    this.value = this.value.substring(0, 500);
                } else if (length > 400) {
                    bioCounter.style.color = '#f8961e';
                    bioCounter.style.fontWeight = '600';
                } else {
                    bioCounter.style.color = '#64748b';
                    bioCounter.style.fontWeight = 'normal';
                }
            });

            // Initialiser le compteur avec la valeur existante
            if (bioTextarea.value) {
                bioTextarea.dispatchEvent(new Event('input'));
            }

            // Indicateur de force du mot de passe
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('passwordStrength');

            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                if (password.length === 0) {
                    strengthBar.style.display = 'none';
                    return;
                }

                strengthBar.style.display = 'block';

                // Vérifier la longueur
                if (password.length >= 8) strength++;
                if (password.length >= 12) strength++;

                // Vérifier la complexité
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;

                // Limiter à 4 niveaux
                strength = Math.min(strength, 4);

                // Mettre à jour la barre
                strengthBar.className = 'password-strength-fill';
                strengthBar.classList.add(`strength-${strength}`);
            });

            // Validation de la confirmation du mot de passe
            const passwordConfirm = document.getElementById('password_confirmation');

            passwordConfirm.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirm = this.value;

                if (confirm && password !== confirm) {
                    this.style.borderColor = '#ef476f';
                    this.style.boxShadow = '0 0 0 3px rgba(239, 71, 111, 0.15)';
                } else if (confirm) {
                    this.style.borderColor = '#06d6a0';
                    this.style.boxShadow = '0 0 0 3px rgba(6, 214, 160, 0.15)';
                } else {
                    this.style.borderColor = '#e2e8f0';
                    this.style.boxShadow = 'none';
                }
            });

            // Navigation entre les sections
            document.querySelectorAll('.next-section').forEach(button => {
                button.addEventListener('click', function() {
                    const current = parseInt(this.dataset.current);
                    const next = parseInt(this.dataset.next);

                    // Valider la section courante avant de passer à la suivante
                    if (validateSection(current)) {
                        showSection(next);
                        updateProgress(next);
                        currentSection = next;
                    }
                });
            });

            document.querySelectorAll('.prev-section').forEach(button => {
                button.addEventListener('click', function() {
                    const current = parseInt(this.dataset.current);
                    const prev = parseInt(this.dataset.prev);

                    showSection(prev);
                    updateProgress(prev);
                    currentSection = prev;
                });
            });

            // Navigation par les étapes du progress
            document.querySelectorAll('.progress-step').forEach(step => {
                step.addEventListener('click', function() {
                    const stepNumber = parseInt(this.dataset.step);

                    // Permettre de revenir en arrière, mais valider pour avancer
                    if (stepNumber < currentSection) {
                        showSection(stepNumber);
                        updateProgress(stepNumber);
                        currentSection = stepNumber;
                    } else if (stepNumber === currentSection + 1) {
                        // Si on veut aller à l'étape suivante, valider d'abord
                        if (validateSection(currentSection)) {
                            showSection(stepNumber);
                            updateProgress(stepNumber);
                            currentSection = stepNumber;
                        }
                    }
                });
            });

            // Fonction pour afficher une section
            function showSection(sectionNumber) {
                // Cacher toutes les sections
                document.querySelectorAll('.form-section').forEach(section => {
                    section.classList.remove('active');
                    section.style.display = 'none';
                });

                // Afficher la section demandée
                const targetSection = document.getElementById(`section-${sectionNumber}`);
                targetSection.style.display = 'flex';
                setTimeout(() => {
                    targetSection.classList.add('active');
                }, 10);

                // Mettre à jour le résumé pour la section 4
                if (sectionNumber === 4) {
                    updateSummary();
                }
            }

            // Fonction pour mettre à jour la barre de progression
            function updateProgress(stepNumber) {
                document.querySelectorAll('.progress-step').forEach(step => {
                    step.classList.remove('step-active');
                    const stepNum = parseInt(step.dataset.step);
                    if (stepNum <= stepNumber) {
                        step.classList.add('step-active');
                    }
                });
            }

            // Fonction pour valider une section
            function validateSection(sectionNumber) {
                let isValid = true;
                let firstInvalid = null;

                // Validation pour la section 1
                if (sectionNumber === 1) {
                    const requiredFields = ['firstname', 'lastname', 'city'];
                    requiredFields.forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (!field.value.trim()) {
                            field.classList.add('is-invalid');
                            shakeElement(field);
                            isValid = false;
                            if (!firstInvalid) firstInvalid = field;
                        }
                    });
                }

                // Validation pour la section 2
                if (sectionNumber === 2) {
                    const requiredFields = ['email'];
                    requiredFields.forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (!field.value.trim()) {
                            field.classList.add('is-invalid');
                            shakeElement(field);
                            isValid = false;
                            if (!firstInvalid) firstInvalid = field;
                        }
                    });

                    // Vérifier la correspondance des mots de passe seulement si un mot de passe est saisi
                    const password = passwordInput.value;
                    const confirm = passwordConfirm.value;

                    if (password && confirm && password !== confirm) {
                        showNotification('Les mots de passe ne correspondent pas !', 'error');
                        passwordConfirm.style.borderColor = '#ef476f';
                        passwordConfirm.style.boxShadow = '0 0 0 3px rgba(239, 71, 111, 0.15)';
                        shakeElement(passwordConfirm);
                        isValid = false;
                        if (!firstInvalid) firstInvalid = passwordConfirm;
                    }

                    // Vérifier la force du mot de passe si un mot de passe est saisi
                    if (password && password.length > 0 && password.length < 8) {
                        showNotification('Le mot de passe doit contenir au moins 8 caractères', 'warning');
                        isValid = false;
                    }
                }

                // Si invalide, focus sur le premier champ invalide
                if (!isValid && firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                return isValid;
            }

            // Fonction pour mettre à jour le résumé
            function updateSummary() {
                document.getElementById('summary-name').textContent =
                    `${document.getElementById('firstname').value} ${document.getElementById('lastname').value}`;
                document.getElementById('summary-email').textContent =
                    document.getElementById('email').value;
                document.getElementById('summary-city').textContent =
                    document.getElementById('city').value || 'Non spécifié';

                const preferenceSelect = document.getElementById('learning_preference');
                const preferenceText = preferenceSelect.options[preferenceSelect.selectedIndex].text;
                document.getElementById('summary-preference').textContent =
                    preferenceText === '-- Sélectionner un mode --' ? 'Non spécifié' : preferenceText;

                const isActive = document.getElementById('is_active').checked;
                document.getElementById('summary-status').textContent =
                    isActive ? 'Actif' : 'Inactif';
                document.getElementById('summary-status').style.color =
                    isActive ? 'var(--success-color)' : 'var(--danger-color)';

                const isValid = document.getElementById('is_valid').checked;
                document.getElementById('summary-valid').textContent =
                    isValid ? 'Validé' : 'En attente';
                document.getElementById('summary-valid').style.color =
                    isValid ? 'var(--success-color)' : 'var(--warning-color)';

                // Statut de la photo
                const photoFile = document.getElementById('photo').files[0];
                if (photoFile) {
                    document.getElementById('summary-photo').textContent = 'Nouvelle photo sélectionnée';
                    document.getElementById('summary-photo').style.color = 'var(--primary-color)';
                } else if (currentPhotoSrc) {
                    document.getElementById('summary-photo').textContent = 'Photo actuelle conservée';
                    document.getElementById('summary-photo').style.color = 'var(--success-color)';
                } else {
                    document.getElementById('summary-photo').textContent = 'Aucune photo';
                    document.getElementById('summary-photo').style.color = 'var(--gray-color)';
                }
            }

            // Soumission du formulaire
            const form = document.getElementById('apprenantForm');
            const submitBtn = document.getElementById('submitForm');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Valider toutes les sections
                let allValid = true;
                for (let i = 1; i <= 3; i++) {
                    if (!validateSection(i)) {
                        allValid = false;
                        showSection(i);
                        updateProgress(i);
                        currentSection = i;
                        break;
                    }
                }

                if (allValid) {
                    // Animation de chargement
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mise à jour en cours...';
                    submitBtn.disabled = true;

                    // Soumettre le formulaire après un court délai
                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                } else {
                    showNotification('Veuillez corriger les erreurs dans le formulaire', 'error');
                }
            });

            // Bouton annuler
            const cancelBtn = document.getElementById('cancelBtn');
            cancelBtn.addEventListener('click', function() {
                if (currentSection > 1 || formHasChanges()) {
                    if (confirm(
                            'Êtes-vous sûr de vouloir annuler ? Toutes les modifications non sauvegardées seront perdues.'
                        )) {
                        window.location.href = "{{ route('apprenants.show', $apprenant->id) }}";
                    }
                } else {
                    window.location.href = "{{ route('apprenants.show', $apprenant->id) }}";
                }
            });

            // Vérifier si le formulaire a des modifications
            function formHasChanges() {
                const originalValues = {
                    firstname: "{{ $apprenant->firstname }}",
                    lastname: "{{ $apprenant->lastname }}",
                    email: "{{ $apprenant->email }}",
                    city: "{{ $apprenant->city }}",
                    bio: "{{ $apprenant->bio }}",
                    telephone: "{{ $apprenant->telephone }}",
                    learning_preference: "{{ $apprenant->learning_preference }}",
                    is_active: {{ $apprenant->is_active ? 'true' : 'false' }},
                    is_valid: {{ $apprenant->is_valid ? 'true' : 'false' }}
                };

                return document.getElementById('firstname').value !== originalValues.firstname ||
                       document.getElementById('lastname').value !== originalValues.lastname ||
                       document.getElementById('email').value !== originalValues.email ||
                       document.getElementById('city').value !== originalValues.city ||
                       document.getElementById('bio').value !== originalValues.bio ||
                       document.getElementById('telephone').value !== originalValues.telephone ||
                       document.getElementById('learning_preference').value !== originalValues.learning_preference ||
                       document.getElementById('is_active').checked !== (originalValues.is_active === 'true') ||
                       document.getElementById('is_valid').checked !== (originalValues.is_valid === 'true') ||
                       document.getElementById('password').value.length > 0 ||
                       document.getElementById('photo').files.length > 0;
            }

            // Fonction d'animation de secousse
            function shakeElement(element) {
                element.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    element.style.animation = '';
                }, 500);
            }

            // Fonction d'affichage des notifications
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.innerHTML = `
                <div style="position: fixed; top: 20px; right: 20px; background: ${
                    type === 'error' ? '#ef476f' :
                    type === 'warning' ? '#f8961e' :
                    type === 'success' ? '#06d6a0' : '#3a86ff'
                }; color: white; padding: 15px 25px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); z-index: 1000; animation: slideIn 0.3s ease;">
                    <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} mr-2"></i>
                    ${message}
                </div>
            `;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 3000);

                // Ajouter l'animation slideOut
                const style = document.createElement('style');
                style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
            `;
                if (!document.querySelector('#notificationStyles')) {
                    style.id = 'notificationStyles';
                    document.head.appendChild(style);
                }
            }

            // Focus sur le premier champ au chargement
            document.getElementById('firstname').focus();
        });
    </script>
@endsection
