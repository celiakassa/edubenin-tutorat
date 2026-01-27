<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatures - {{ $annonce->domaine }} | Kopiao</title>
    <link href="{{ asset('images/image_1.webp') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 30px 40px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-info h1 {
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .annonce-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .info-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back {
            background: var(--white);
            color: var(--primary-color);
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        /* Stats Cards */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 25px 40px;
            background: var(--light-gray);
            border-bottom: 1px solid var(--medium-gray);
        }

        .stat-card {
            background: var(--white);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--white);
        }

        .stat-icon.en-attente { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }
        .stat-icon.acceptee { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); }
        .stat-icon.refusee { background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); }
        .stat-icon.total { background: linear-gradient(135deg, #0351BC 0%, #4a7fd4 100%); }

        .stat-info h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .stat-info p {
            font-size: 14px;
            color: var(--dark-gray);
        }

        /* Charts Section */
        .charts-section {
            padding: 30px 40px;
            background: var(--white);
            border-bottom: 1px solid var(--medium-gray);
        }

        .chart-container {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            height: 300px;
        }

        /* Candidatures List */
        .candidatures-section {
            padding: 30px 40px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light-gray);
        }

        .section-title {
            font-size: 20px;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 8px 16px;
            border-radius: 20px;
            border: 2px solid var(--medium-gray);
            background: var(--white);
            color: var(--dark-gray);
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: var(--primary-color);
            color: var(--white);
            border-color: var(--primary-color);
        }

        .candidatures-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .candidature-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid var(--medium-gray);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .candidature-card:hover {
            border-color: var(--primary-light);
            box-shadow: 0 6px 20px rgba(3, 81, 188, 0.1);
            transform: translateY(-3px);
        }

        .candidature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
        }

        .candidature-card.en-attente::before { background: var(--warning); }
        .candidature-card.acceptee::before { background: var(--success); }
        .candidature-card.refusee::before { background: var(--danger); }

        .candidature-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .tuteur-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
        }

        .tuteur-info h3 {
            font-size: 18px;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .tuteur-matiere {
            color: var(--primary-color);
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .candidature-status {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-en_attente { background: #fef3c7; color: #92400e; }
        .status-acceptee { background: #d1fae5; color: #065f46; }
        .status-refusee { background: #fee2e2; color: #991b1b; }

        .candidature-details {
            display: grid;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--light-gray);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-label {
            color: var(--dark-gray);
            font-size: 14px;
        }

        .detail-value {
            color: var(--text-dark);
            font-weight: 500;
        }

        .candidature-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
            flex: 1;
            justify-content: center;
            min-width: 100px;
        }

        .btn-profil {
            background: var(--info);
            color: var(--white);
        }

        .btn-accepter {
            background: var(--success);
            color: var(--white);
        }

        .btn-refuser {
            background: var(--danger);
            color: var(--white);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .btn-action:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            grid-column: 1 / -1;
        }

        .empty-icon {
            font-size: 80px;
            color: var(--medium-gray);
            margin-bottom: 25px;
        }

        .empty-state h3 {
            color: var(--text-dark);
            font-size: 22px;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--dark-gray);
            margin-bottom: 30px;
            max-width: 500px;
            margin: 0 auto 30px;
        }

        /* Messages */
        .alert-message {
            padding: 15px 20px;
            border-radius: 10px;
            margin: 0 40px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
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

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .stats-section,
            .charts-section,
            .candidatures-section {
                padding: 20px;
            }

            .candidatures-grid {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .candidature-actions {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
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
        <div class="container">
            <!-- Header -->
            <div class="header">
                <div class="header-content">
                    <div class="header-info">
                        <h1>
                            <i class="fas fa-users"></i>
                            Candidatures - {{ $annonce->domaine }}
                        </h1>
                        <div class="annonce-info">
                            <span class="info-badge">
                                <i class="fas fa-calendar"></i>
                                {{ $annonce->created_at->format('d/m/Y') }}
                            </span>
                            <span class="info-badge">
                                <i class="fas fa-money-bill-wave"></i>
                                {{ number_format($annonce->budget, 0, ',', ' ') }} FCFA
                            </span>
                            <span class="info-badge">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $annonce->format }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('annonces.show', $annonce->id) }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Retour à l'annonce
                    </a>
                </div>
            </div>

            <!-- Messages -->
            @if(session('success'))
                <div class="alert-message alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-message alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="stats-section">
                <div class="stat-card">
                    <div class="stat-icon total">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $stats['total'] }}</h3>
                        <p>Total candidatures</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon en-attente">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $stats['en_attente'] }}</h3>
                        <p>En attente</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon acceptee">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $stats['acceptees'] }}</h3>
                        <p>Acceptées</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon refusee">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $stats['refusees'] }}</h3>
                        <p>Refusées</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            @if($stats['total'] > 0)
            <div class="charts-section">
                <div class="chart-container">
                    <canvas id="candidaturesChart"></canvas>
                </div>
            </div>
            @endif

            <!-- Candidatures List -->
            <div class="candidatures-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-list"></i>
                        Tous les tuteurs candidats
                    </h2>
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">Tous ({{ $stats['total'] }})</button>
                        <button class="filter-btn" data-filter="en_attente">En attente ({{ $stats['en_attente'] }})</button>
                        <button class="filter-btn" data-filter="acceptee">Acceptées ({{ $stats['acceptees'] }})</button>
                        <button class="filter-btn" data-filter="refusee">Refusées ({{ $stats['refusees'] }})</button>
                    </div>
                </div>

                @if($stats['total'] > 0)
                <div class="candidatures-grid" id="candidaturesGrid">
                    @foreach($candidaturesParStatut as $statut => $candidatures)
                        @foreach($candidatures as $candidature)
                        <div class="candidature-card {{ str_replace('_', '-', $statut) }}" data-statut="{{ $statut }}">
                            <div class="candidature-header">
                                <div class="tuteur-avatar">
                                    {{ strtoupper(substr($candidature->tuteur->firstname, 0, 1) . substr($candidature->tuteur->lastname, 0, 1)) }}
                                </div>
                                <div class="tuteur-info">
                                    <h3>{{ $candidature->tuteur->firstname }} {{ $candidature->tuteur->lastname }}</h3>
                                    <div class="tuteur-matiere">
    <i class="fas fa-book"></i>
    @php
        $subjects = json_decode($candidature->tuteur->subjects, true);
    @endphp
    {{ $subjects ? implode(', ', $subjects) : ($candidature->tuteur->subjects ?? 'Non spécifié') }}
</div>

                                    <span class="candidature-status status-{{ $candidature->statut }}">
                                        {{ $candidature->statut }}
                                    </span>
                                </div>
                            </div>

                            <div class="candidature-details">
                                <div class="detail-row">
                                    <span class="detail-label">Taux horaire:</span>
                                    <span class="detail-value">{{ number_format($candidature->tuteur->rate_per_hour, 0, ',', ' ') }} FCFA/h</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Ville:</span>
                                    <span class="detail-value">{{ $candidature->tuteur->city ?? 'Non spécifiée' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Postulé le:</span>
                                    <span class="detail-value">{{ $candidature->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Expérience:</span>
                                    <span class="detail-value">
                                        @if($candidature->tuteur->satisfaction_score)
                                            Note: {{ $candidature->tuteur->satisfaction_score }}/5
                                        @else
                                            Nouveau tuteur
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="candidature-actions">
                                <a href="{{ route('candidatures.profil', $candidature->id) }}" class="btn-action btn-profil">
                                    <i class="fas fa-user"></i> Voir profil
                                </a>
                                
                                @if($candidature->estEnAttente())
                                <form action="{{ route('candidatures.accepter', $candidature->id) }}" method="POST" class="action-form">
                                    @csrf
                                    <button type="submit" class="btn-action btn-accepter" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir accepter ce tuteur ? Cela refusera automatiquement les autres candidatures.')">
                                        <i class="fas fa-check"></i> Accepter
                                    </button>
                                </form>
                                
                                <form action="{{ route('candidatures.refuser', $candidature->id) }}" method="POST" class="action-form">
                                    @csrf
                                    <button type="submit" class="btn-action btn-refuser"
                                            onclick="return confirm('Êtes-vous sûr de vouloir refuser ce tuteur ?')">
                                        <i class="fas fa-times"></i> Refuser
                                    </button>
                                </form>
                                @endif
                                
                                @if($candidature->estAcceptee())
                                <button class="btn-action btn-accepter" disabled>
                                    <i class="fas fa-check"></i> Accepté
                                </button>
                                @endif
                                
                                @if($candidature->estRefusee())
                                <button class="btn-action btn-refuser" disabled>
                                    <i class="fas fa-times"></i> Refusé
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3>Aucune candidature reçue</h3>
                    <p>Votre annonce n'a pas encore reçu de candidatures. Partagez-la davantage pour attirer des tuteurs qualifiés.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart des candidatures
            @if($stats['total'] > 0)
            const ctx = document.getElementById('candidaturesChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['En attente', 'Acceptées', 'Refusées'],
                    datasets: [{
                        data: [
                            {{ $stats['en_attente'] }},
                            {{ $stats['acceptees'] }},
                            {{ $stats['refusees'] }}
                        ],
                        backgroundColor: [
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderColor: [
                            '#f59e0b',
                            '#10b981',
                            '#ef4444'
                        ],
                        borderWidth: 2,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
            @endif

            // Filtrage des candidatures
            const filterButtons = document.querySelectorAll('.filter-btn');
            const candidatureCards = document.querySelectorAll('.candidature-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Retirer la classe active de tous les boutons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    // Ajouter la classe active au bouton cliqué
                    this.classList.add('active');
                    
                    const filter = this.dataset.filter;
                    
                    candidatureCards.forEach(card => {
                        if (filter === 'all' || card.dataset.statut === filter) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 10);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });

            // Animation des cartes
            const cards = document.querySelectorAll('.candidature-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Rafraîchir les stats toutes les 30 secondes
            setInterval(function() {
                fetch('{{ route("candidatures.stats", $annonce->id) }}')
                    .then(response => response.json())
                    .then(data => {
                        // Mettre à jour le graphique si nécessaire
                        if (chart) {
                            chart.data.datasets[0].data = data.data;
                            chart.update();
                        }
                    });
            }, 30000);
        });
    </script>
</body>
</html>