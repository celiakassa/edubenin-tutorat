<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil du tuteur - {{ $tuteur->firstname }} {{ $tuteur->lastname }} | Kopiao</title>
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

        .profile-container {
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

        .profile-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 40px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--white);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 40px;
            border: 4px solid var(--white);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }

        .profile-title {
            position: relative;
            z-index: 1;
        }

        .profile-title h1 {
            font-size: 32px;
            margin-bottom: 5px;
        }

        .profile-title p {
            font-size: 16px;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-content {
            padding: 40px;
        }

        .info-section {
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--light-gray);
        }

        .section-title {
            font-size: 20px;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .info-item {
            background: var(--light-gray);
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
        }

        .info-label {
            font-size: 13px;
            color: var(--dark-gray);
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .subjects-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .subject-tag {
            background: var(--primary-color);
            color: var(--white);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 14px;
        }

        .bio-text {
            font-size: 15px;
            line-height: 1.8;
            color: var(--text-dark);
            white-space: pre-line;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-color);
            color: var(--white);
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navigation Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboardUser') }}" style="text-decoration: none;">
                <div class="platform-logo" style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <div class="logo-icon" style="background-color: #3948c9; color: white; padding: 10px; border-radius: 6px; font-weight: bold;">KP</div>
                    <div class="platform-name" style="font-size: 1.2em; font-weight: bold; color: #333;">Kopiao</div>
                </div>
            </a>
            <div class="platform-tagline">Votre plateforme éducative</div>
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}</div>
                <div class="user-details">
                    <h4>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h4>
                    <p>
                        @if (Auth::user()->role_id == 3) Tuteur
                        @elseif(Auth::user()->role_id == 2) Apprenant
                        @else Administrateur @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboardUser') }}" class="menu-item"><i class="fas fa-home"></i><span class="menu-text">Tableau de bord</span></a>
            <a href="{{ route('CompleterProfilUser.show') }}" class="menu-item"><i class="fas fa-user-edit"></i><span class="menu-text">Mon profil</span></a>
            <a href="{{ route('annonces.index') }}" class="menu-item"><i class="fas fa-bullhorn"></i><span class="menu-text">Mes annonces</span></a>
            <a href="{{ route('annonces.create') }}" class="menu-item"><i class="fas fa-plus-circle"></i><span class="menu-text">Nouvelle annonce</span></a>
            @if(Auth::user()->role_id == 1)
                <a href="{{ route('admin.dashboard') }}" class="menu-item"><i class="fas fa-cog"></i><span class="menu-text">Administration</span></a>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ strtoupper(substr($tuteur->firstname, 0, 1) . substr($tuteur->lastname, 0, 1)) }}
                </div>
                <div class="profile-title">
                    <h1>{{ $tuteur->firstname }} {{ $tuteur->lastname }}</h1>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $tuteur->city ?? 'Ville non spécifiée' }}</p>
                    <p><i class="fas fa-star"></i> Note: {{ $tuteur->satisfaction_score ?? 'Nouveau tuteur' }}/5</p>
                </div>
            </div>

            <div class="profile-content">
                <div class="info-section">
                    <h2 class="section-title"><i class="fas fa-graduation-cap"></i> Matières enseignées</h2>
                    <div class="subjects-list">
                        @if($tuteur->subjects && $tuteur->subjects->count() > 0)
                            @foreach($tuteur->subjects as $subject)
                                <span class="subject-tag">{{ $subject->nom }}</span>
                            @endforeach
                        @else
                            <p>Aucune matière spécifiée</p>
                        @endif
                    </div>
                </div>

                <div class="info-section">
                    <h2 class="section-title"><i class="fas fa-info-circle"></i> Informations</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Taux horaire</div>
                            <div class="info-value">{{ number_format($tuteur->rate_per_hour, 0, ',', ' ') }} FCFA/h</div>
                        </div>
                

                    </div>
                </div>

                @if($tuteur->bio)
                <div class="info-section">
                    <h2 class="section-title"><i class="fas fa-align-left"></i> Biographie</h2>
                    <div class="bio-text">{{ $tuteur->bio }}</div>
                </div>
                @endif

                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ route('annonces.candidatures.index', $annonce->id) }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Retour aux candidatures
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
