<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Annonces - Kopiao</title>
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

        /* Header */
        .page-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .page-title {
            color: var(--white);
            font-size: 32px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        /* Container */
        .annonces-container {
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

        .annonces-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 30px 40px;
            position: relative;
            overflow: hidden;
        }

        .annonces-header::before {
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
        }

        .header-content h1 {
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-create {
            background: var(--white);
            color: var(--primary-color);
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
        }

        /* Charts Section */
        .charts-section {
            padding: 30px 40px;
            background: var(--light-gray);
            border-bottom: 1px solid var(--medium-gray);
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 25px 40px;
            background: var(--light-gray);
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

        .stat-icon.total {
            background: linear-gradient(135deg, #0351BC 0%, #4a7fd4 100%);
        }

        .stat-icon.pending {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        }

        .stat-icon.published {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

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

        /* Search Bar */
        .search-container {
            padding: 25px 40px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .search-box {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        .search-box input {
            width: 100%;
            padding: 14px 20px 14px 50px;
            border: 2px solid var(--medium-gray);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(3, 81, 188, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
            font-size: 18px;
        }

        /* Annonces List */
        .annonces-list {
            padding: 30px 40px;
        }

        .annonce-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid var(--medium-gray);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .annonce-card:hover {
            border-color: var(--primary-light);
            box-shadow: 0 6px 20px rgba(3, 81, 188, 0.1);
            transform: translateY(-3px);
        }

        .annonce-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: var(--primary-color);
        }

        .annonce-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .annonce-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .annonce-domain {
            color: var(--primary-color);
            font-weight: 500;
            font-size: 16px;
        }

        .annonce-status {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-en_attente {
            background: #fef3c7;
            color: #92400e;
        }

        .status-en_paiement {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-publiee {
            background: #d1fae5;
            color: #065f46;
        }

        .status-attribuee {
            background: #ede9fe;
            color: #5b21b6;
        }

        .annonce-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--light-gray);
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-icon {
            width: 36px;
            height: 36px;
            background: var(--light-gray);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 14px;
        }

        .detail-content h4 {
            font-size: 12px;
            color: var(--dark-gray);
            margin-bottom: 4px;
        }

        .detail-content p {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .annonce-description {
            color: var(--dark-gray);
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .annonce-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
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
        }

        .btn-view {
            background: var(--light-gray);
            color: var(--text-dark);
        }

        .btn-pay {
            background: var(--success);
            color: var(--white);
        }

        .btn-edit {
            background: #3b82f6;
            color: var(--white);
        }

        .btn-delete {
            background: var(--danger);
            color: var(--white);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
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

            .annonces-container {
                max-width: 100%;
            }

            .annonces-header,
            .charts-section,
            .stats-grid,
            .search-container,
            .annonces-list {
                padding: 20px;
            }

            .header-content {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .chart-container {
                height: 200px;
            }

            .annonce-header {
                flex-direction: column;
                gap: 15px;
            }

            .annonce-actions {
                flex-wrap: wrap;
                justify-content: center;
            }

            .btn-action {
                flex: 1;
                min-width: 120px;
                justify-content: center;
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
                <span>Total Annonces</span>
                <span>{{ $annonces->count() }}</span>
            </div>
            <div class="stat-item">
                <span>À publier</span>
                <span>{{ $annonces->where('status', 'en_attente')->count() }}</span>
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
            <a href="{{ route('annonces.index') }}" class="menu-item active">
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
        <div class="annonces-container">
            <!-- Header -->
            <div class="annonces-header">
                <div class="header-content">
                    <h1>
                        <i class="fas fa-bullhorn"></i>
                        Mes Annonces
                    </h1>
                    <a href="{{ route('annonces.create') }}" class="btn-create">
                        <i class="fas fa-plus"></i>
                        Nouvelle annonce
                    </a>
                </div>
            </div>

            <!-- Messages -->
            @if (session('success'))
                <div class="alert-message alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-message alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Charts Section -->
            @if ($annonces->count() > 0)
                <div class="charts-section">
                    <div class="charts-grid">
                        <!-- Chart 1: Répartition par statut -->
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3><i class="fas fa-chart-pie"></i> Répartition par statut</h3>
                            </div>
                            <div class="chart-container">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>

                        <!-- Chart 2: Évolution des montants -->
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3><i class="fas fa-chart-line"></i> Budget total par annonce</h3>
                            </div>
                            <div class="chart-container">
                                <canvas id="budgetChart"></canvas>
                            </div>
                        </div>

                        <!-- Chart 3: Répartition par domaine -->
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3><i class="fas fa-chart-bar"></i> Répartition par domaine</h3>
                            </div>
                            <div class="chart-container">
                                <canvas id="domainChart"></canvas>
                            </div>
                        </div>


                    </div>

                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon total">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $annonces->count() }}</h3>
                                <p>Total annonces</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon published">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ $annonces->where('status', 'publiée')->count() }}</h3>
                                <p>Publiées</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon"
                                style="background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ number_format($annonces->sum('budget'), 0, ',', ' ') }} F</h3>
                                <p>Budget total</p>
                            </div>
                        </div>
                    </div>



                </div>
            @endif



            @if ($annonces->count() > 0)
                <!-- Search -->
                <div class="search-container">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput"
                            placeholder="Rechercher une annonce par domaine, description...">
                    </div>
                </div>

                <!-- Annonces List -->
                <div class="annonces-list" id="annoncesList">
                    @foreach ($annonces as $annonce)
                        <div class="annonce-card"
                            data-search="{{ strtolower($annonce->domaine . ' ' . $annonce->description) }}">
                            <div class="annonce-header">
                                <div>
                                    <h3 class="annonce-title">{{ $annonce->domaine }}</h3>
                                    <span class="annonce-status status-{{ str_replace('é', 'e', $annonce->status) }}">
                                        {{ $annonce->status }}
                                    </span>
                                </div>
                                <div class="annonce-date">
                                    <i class="far fa-calendar"></i>
                                    {{ $annonce->created_at->format('d/m/Y') }}
                                </div>
                            </div>

                            <div class="annonce-details">
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4>Budget total</h4>
                                        <p>{{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</p>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4>Acompte</h4>
                                        <p>{{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA</p>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="far fa-clock"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4>Mes disponibilités</h4>
                                        <p>{{ $annonce->disponibilite }}</p>

                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-laptop"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4>Format</h4>
                                        <p>
                                            @if ($annonce->format == 'presentiel')
                                                Présentiel
                                            @elseif($annonce->format == 'en_ligne')
                                                En ligne
                                            @else
                                                Hybride
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="annonce-description">
                                {{ Str::limit($annonce->description, 200) }}
                            </div>

                            <div class="annonce-actions">
                                <a href="{{ route('annonces.show', $annonce->id) }}" class="btn-action btn-view">
                                    <i class="fas fa-eye"></i> Voir
                                </a>

                                @if (!$annonce->is_paid && $annonce->status == 'en_attente')
                                    <a href="{{ route('annonces.payment', $annonce->id) }}"
                                        class="btn-action btn-pay">
                                        <i class="fas fa-credit-card"></i> Payer
                                    </a>
                                @endif

                                @if ($annonce->status == 'en_attente')
                                    <a href="{{ route('annonces.edit', $annonce->id) }}" class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                @endif

                                @if ($annonce->status != 'attribuee')
                                    <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Aucune annonce créée</h3>
                    <p>Commencez par créer votre première annonce pour trouver le tuteur idéal pour vos besoins
                        d'apprentissage.</p>
                    <a href="{{ route('annonces.create') }}" class="btn-create" style="margin-top: 10px;">
                        <i class="fas fa-plus"></i>
                        Créer ma première annonce
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Données pour les graphiques (utilisez les données PHP passées)
        const annoncesData = @json($annonces);

        // Préparation des données pour les graphiques
        const statusData = {
            labels: ['En attente', 'En paiement', 'Publiée', 'Attribuée'],
            datasets: [{
                data: [
                    annoncesData.filter(a => a.status === 'en_attente').length,
                    annoncesData.filter(a => a.status === 'en_paiement').length,
                    annoncesData.filter(a => a.status === 'publiee').length,
                    annoncesData.filter(a => a.status === 'attribuee').length
                ],
                backgroundColor: [
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(139, 92, 246, 0.8)'
                ],
                borderColor: [
                    '#f59e0b',
                    '#3b82f6',
                    '#10b981',
                    '#8b5cf6'
                ],
                borderWidth: 2
            }]
        };

        // Données pour le graphique de budget
        const budgetData = {
            labels: annoncesData.map((a, index) => `Annonce ${index + 1}`),
            datasets: [{
                label: 'Budget (FCFA)',
                data: annoncesData.map(a => a.budget),
                backgroundColor: 'rgba(3, 81, 188, 0.2)',
                borderColor: 'rgba(3, 81, 188, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        };

        // Données pour le graphique de domaines
        const domainCounts = {};
        annoncesData.forEach(a => {
            const domain = a.domaine || 'Non spécifié';
            domainCounts[domain] = (domainCounts[domain] || 0) + 1;
        });

        const domainData = {
            labels: Object.keys(domainCounts),
            datasets: [{
                label: 'Nombre d\'annonces',
                data: Object.values(domainCounts),
                backgroundColor: [
                    'rgba(3, 81, 188, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgpa(245, 158, 11, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(6, 182, 212, 0.8)'
                ],
                borderWidth: 1
            }]
        };

        // Initialisation des graphiques
        document.addEventListener('DOMContentLoaded', function() {
            // Chart 1: Répartition par statut (Camembert)
            const statusChartCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusChartCtx, {
                type: 'pie',
                data: statusData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
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

            // Chart 2: Évolution des montants (Ligne)
            const budgetChartCtx = document.getElementById('budgetChart').getContext('2d');
            new Chart(budgetChartCtx, {
                type: 'line',
                data: budgetData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('fr-FR') + ' FCFA';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Budget: ${context.raw.toLocaleString('fr-FR')} FCFA`;
                                }
                            }
                        }
                    }
                }
            });

            // Chart 3: Répartition par domaine (Barres)
            const domainChartCtx = document.getElementById('domainChart').getContext('2d');
            new Chart(domainChartCtx, {
                type: 'bar',
                data: domainData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Recherche en temps réel
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    const annonceCards = document.querySelectorAll('.annonce-card');

                    annonceCards.forEach(card => {
                        const searchText = card.getAttribute('data-search');
                        if (searchText.includes(searchValue)) {
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
            }

            // Animation des cartes
            const cards = document.querySelectorAll('.annonce-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>

</html>
