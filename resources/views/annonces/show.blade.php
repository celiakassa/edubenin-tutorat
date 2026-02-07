<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'annonce - Kopiao</title>
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

        .annonce-detail-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .annonce-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 30px 40px;
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

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .annonce-title {
            font-size: 28px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .annonce-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            opacity: 0.9;
        }

        .annonce-status {
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-en_attente { background: var(--warning); color: #fff; }
        .status-en_paiement { background: var(--info); color: #fff; }
        .status-publiee { background: var(--success); color: #fff; }
        .status-attribuee { background: #8b5cf6; color: #fff; }
        .status-terminee { background: var(--dark-gray); color: #fff; }

        /* Annonce Content */
        .annonce-content {
            padding: 40px;
        }

        /* Description Section */
        .description-section {
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid var(--light-gray);
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .description-text {
            font-size: 15px;
            line-height: 1.7;
            color: var(--text-dark);
            white-space: pre-line;
        }

        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: var(--light-gray);
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid var(--primary-color);
        }

        .detail-card h4 {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-list {
            list-style: none;
        }

        .detail-list li {
            padding: 8px 0;
            color: var(--text-dark);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .detail-list li:last-child {
            border-bottom: none;
        }

        .detail-list li i {
            color: var(--primary-color);
            width: 16px;
        }

        /* Disponibilités Styles */
        .disponibilites-list {
            margin-top: 10px;
        }

        .disponibilite-item {
            background: var(--white);
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .disponibilite-item:hover {
            border-color: var(--primary-light);
            box-shadow: 0 2px 8px rgba(3, 81, 188, 0.1);
        }

        .disponibilite-day {
            font-weight: 600;
            color: var(--text-dark);
            min-width: 100px;
        }

        .disponibilite-time {
            color: var(--dark-gray);
            font-weight: 500;
        }

        /* Payment Info */
        .payment-section {
            background: linear-gradient(135deg, var(--light-gray) 0%, #e6efff 100%);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .payment-item {
            text-align: center;
            padding: 15px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .payment-label {
            font-size: 13px;
            color: var(--dark-gray);
            margin-bottom: 5px;
        }

        .payment-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .payment-note {
            font-size: 12px;
            color: var(--dark-gray);
            margin-top: 3px;
            font-style: italic;
        }

        .payment-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .payment-paid {
            background: var(--success);
            color: var(--white);
        }

        .payment-pending {
            background: var(--warning);
            color: var(--white);
        }

        .payment-failed {
            background: var(--danger);
            color: var(--white);
        }

        /* Student Info */
        .student-section {
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid var(--medium-gray);
            margin-bottom: 30px;
        }

        .student-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
        }

        .student-info h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .student-info p {
            font-size: 14px;
            color: var(--dark-gray);
        }

        .student-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .student-detail {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--text-dark);
        }

        .student-detail i {
            color: var(--primary-color);
            width: 16px;
        }

        /* Actions */
        .actions-section {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid var(--medium-gray);
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 12px 28px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(3, 81, 188, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(3, 81, 188, 0.4);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--dark-gray);
            border: 2px solid var(--medium-gray);
        }

        .btn-secondary:hover {
            background: var(--light-gray);
            border-color: var(--dark-gray);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #f87171 100%);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        .btn-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .btn-purple:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        }

        .badge {
            background: var(--white);
            color: #8b5cf6;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 5px;
        }

        /* Timeline */
        .timeline-section {
            margin-bottom: 30px;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
            margin-top: 20px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary-color);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
            padding-left: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 2px solid var(--white);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .timeline-date {
            font-size: 13px;
            color: var(--dark-gray);
            margin-bottom: 5px;
        }

        .timeline-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .timeline-description {
            font-size: 14px;
            color: var(--dark-gray);
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

            .annonce-header,
            .annonce-content {
                padding: 20px;
            }

            .header-top {
                flex-direction: column;
                gap: 15px;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .payment-grid {
                grid-template-columns: 1fr;
            }

            .actions-section {
                flex-direction: column;
            }

            .student-details {
                grid-template-columns: 1fr;
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
                    {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                </div>
                <div class="user-details">
                    <h4>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h4>
                    <p>
                        @if (Auth::user()->role_id == 3)
                            Tuteur
                        @elseif(Auth::user()->role_id == 2)
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
                <span class="stat-value">
                    @if (Auth::user()->role_id == 3)
                        Tuteur
                    @elseif(Auth::user()->role_id == 2)
                        Étudiant
                    @else
                        Admin
                    @endif
                </span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Annonces actives</span>
                <span class="stat-value">{{ Auth::user()->annonces()->where('status', 'publiée')->count() }}</span>
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
            @if(Auth::user()->role_id == 1)
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span class="menu-text">Administration</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="annonce-detail-container">
            <div class="annonce-header">
                <div class="header-top">
                    <div>
                        <h1 class="annonce-title">
                            <i class="fas fa-book"></i>
                            {{ $annonce->domaine }}
                        </h1>
                        <div class="annonce-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                Créée le {{ $annonce->created_at->format('d/m/Y') }}
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-eye"></i>
                                @if($annonce->status == 'publiée')
                                    Publiée le {{ $annonce->published_at?->format('d/m/Y H:i') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="annonce-status status-{{ str_replace('é', 'e', $annonce->status) }}">
                        {{ $annonce->status }}
                    </div>
                </div>
            </div>

            <div class="annonce-content">
                @if(session('success'))
                    <div style="background: var(--success); color: var(--white); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: 500;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div style="background: var(--danger); color: var(--white); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; text-align: center; font-weight: 500;">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <!-- Description -->
                <div class="description-section">
                    <h2 class="section-title">
                        <i class="fas fa-align-left"></i>
                        Description
                    </h2>
                    <div class="description-text">
                        {{ $annonce->description }}
                    </div>
                </div>

                <!-- Détails de l'annonce -->
                <div class="details-grid">
                    <div class="detail-card">
                        <h4><i class="fas fa-info-circle"></i> Informations générales</h4>
                        <ul class="detail-list">
                            <li>
                                <i class="fas fa-calendar-check"></i>
                                <strong>Disponibilités:</strong>
                            </li>
                        </ul>
                        <!-- Section des disponibilités -->
                        <div class="disponibilites-list">
                            @if($annonce->disponibilite)
                                @foreach(explode("\n", trim($annonce->disponibilite)) as $line)
                                    @if(trim($line))
                                        @php
                                            $parts = explode(' ', trim($line));
                                            if (count($parts) >= 3) {
                                                $jour = ucfirst($parts[0]);
                                                $heures = $parts[1] . ' ' . $parts[2] . ' ' . ($parts[3] ?? '');
                                            } else {
                                                $jour = '';
                                                $heures = trim($line);
                                            }
                                        @endphp
                                        <div class="disponibilite-item">
                                            <span class="disponibilite-day">{{ $jour }}</span>
                                            <span class="disponibilite-time">{{ $heures }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p style="color: var(--dark-gray); font-style: italic; margin-top: 10px;">
                                    Non spécifié
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="detail-card">
                        <h4><i class="fas fa-user-graduate"></i> Pour l'étudiant</h4>
                        <ul class="detail-list">
                            <li>
                                <i class="fas fa-user"></i>
                                <strong>Type:</strong> Étudiant
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <strong>Localisation:</strong>
                                {{ $annonce->student->city ?? 'Non spécifiée' }}
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <strong>Contact:</strong>
                                {{ $annonce->student->telephone ?? 'Non spécifié' }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Informations de paiement -->
                <div class="payment-section">
                    <h2 class="section-title">
                        <i class="fas fa-money-bill-wave"></i>
                        Informations financières
                    </h2>
                    <div class="payment-grid">
                        <div class="payment-item">
                            <div class="payment-label">Budget total</div>
                            <div class="payment-value">{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div class="payment-item">
                            <div class="payment-label">Acompte</div>
                            <div class="payment-value">{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</div>
                            <div class="payment-note">
                                {{ round(($annonce->acompte / $annonce->budget) * 100) }}% du budget
                            </div>
                        </div>
                        <div class="payment-item">
                            <div class="payment-label">Solde restant</div>
                            <div class="payment-value">
                                {{ number_format($annonce->budget - $annonce->acompte, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 15px;">
                        <span class="payment-status {{ $annonce->is_paid ? 'payment-paid' : 'payment-pending' }}">
                            <i class="fas fa-{{ $annonce->is_paid ? 'check-circle' : 'clock' }}"></i>
                            {{ $annonce->is_paid ? 'Acompte payé' : 'Acompte en attente' }}
                        </span>
                    </div>
                </div>

                <!-- Informations sur l'étudiant -->
                <div class="student-section">
                    <h2 class="section-title">
                        <i class="fas fa-user-graduate"></i>
                        À propos de l'étudiant
                    </h2>
                    <div class="student-header">
                        <div class="student-avatar">
                            {{ strtoupper(substr($annonce->student->firstname, 0, 1) . substr($annonce->student->lastname, 0, 1)) }}
                        </div>
                        <div class="student-info">
                            <h3>{{ $annonce->student->firstname }} {{ $annonce->student->lastname }}</h3>
                            <p>Étudiant inscrit depuis {{ $annonce->student->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="student-details">
                        <div class="student-detail">
                            <i class="fas fa-envelope"></i>
                            {{ $annonce->student->email }}
                        </div>
                        <br>
                        @if($annonce->student->telephone)
                            <div class="student-detail">
                                <i class="fas fa-phone"></i>
                                {{ $annonce->student->telephone }}
                            </div>
                        @endif
                        @if($annonce->student->city)
                            <div class="student-detail">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $annonce->student->city }}
                            </div>
                        @endif
                        @if($annonce->student->learning_preference)
                            <div class="student-detail">
                                <i class="fas fa-graduation-cap"></i>
                                Préfère:
                                @if($annonce->student->learning_preference == 'online')
                                    Cours en ligne
                                @elseif($annonce->student->learning_preference == 'in_person')
                                    Cours présentiel
                                @else
                                    Mode hybride
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline de l'annonce -->
                <div class="timeline-section">
                    <h2 class="section-title">
                        <i class="fas fa-history"></i>
                        Historique
                    </h2>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-date">{{ $annonce->created_at->format('d/m/Y H:i') }}</div>
                            <div class="timeline-title">Annonce créée</div>
                            <div class="timeline-description">L'annonce a été créée par l'étudiant</div>
                        </div>

                        @if($annonce->status == 'en_paiement')
                            <div class="timeline-item">
                                <div class="timeline-date">En attente</div>
                                <div class="timeline-title">Paiement en cours</div>
                                <div class="timeline-description">En attente de paiement de l'acompte</div>
                            </div>
                        @endif

                        @if($annonce->published_at)
                            <div class="timeline-item">
                                <div class="timeline-date">{{ $annonce->published_at->format('d/m/Y H:i') }}</div>
                                <div class="timeline-title">Annonce publiée</div>
                                <div class="timeline-description">L'annonce est maintenant visible par les tuteurs</div>
                            </div>
                        @endif

                        @if($annonce->payments()->where('status', 'completed')->exists())
                            @foreach($annonce->payments()->where('status', 'completed')->get() as $payment)
                                <div class="timeline-item">
                                    <div class="timeline-date">{{ $payment->paid_at->format('d/m/Y H:i') }}</div>
                                    <div class="timeline-title">Paiement effectué</div>
                                    <div class="timeline-description">
                                        Acompte de {{ number_format($payment->amount, 0, ',', ' ') }} FCFA payé
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="actions-section">
                    <a href="{{ route('annonces.index') }}" class="btn-action btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Retour aux annonces
                    </a>

                    @if(!$annonce->is_paid && $annonce->status == 'en_attente' && Auth::user()->id == $annonce->student_id)
                        <a href="{{ route('annonces.payment', $annonce->id) }}" class="btn-action btn-primary">
                            <i class="fas fa-credit-card"></i>
                            Payer l'acompte
                        </a>
                    @endif

                    @if(($annonce->status == 'publiée' || $annonce->status == 'attribuee') && Auth::user()->id == $annonce->student_id)
                        <a href="{{ route('candidatures.index', $annonce->id) }}" class="btn-action btn-purple">
                            <i class="fas fa-users"></i> Voir les candidatures
                            @if($annonce->candidatures()->count() > 0)
                                <span class="badge">
                                    {{ $annonce->candidatures()->count() }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if(Auth::user()->id == $annonce->student_id && $annonce->status == 'en_attente')
                        <a href="{{ route('annonces.edit', $annonce->id) }}" class="btn-action btn-primary">
                            <i class="fas fa-edit"></i>
                            Modifier
                        </a>
                    @endif

                    @if(Auth::user()->id == $annonce->student_id && $annonce->status != 'attribuee')
                        <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                <i class="fas fa-trash"></i>
                                Supprimer
                            </button>
                        </form>
                    @endif

                    @if(Auth::user()->role_id == 1)
                        <a href="{{ route('admin.dashboard') }}" class="btn-action btn-secondary">
                            <i class="fas fa-cog"></i>
                            Administration
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Confirmation de suppression
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-danger');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
