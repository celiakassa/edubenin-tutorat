<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - Kopiao</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* Layout */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #1E63C4, #2a7cd6);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: white;
            color: #1E63C4;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .logo h1 {
            font-size: 18px;
            font-weight: 600;
            color: white;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            margin-top: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: white;
            color: #1E63C4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .user-details h4 {
            font-size: 14px;
            margin-bottom: 2px;
        }

        .user-details p {
            font-size: 12px;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 0 20px;
        }

        .menu-item {
            margin-bottom: 5px;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .menu-item a:hover,
        .menu-item a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .menu-item i {
            width: 24px;
            font-size: 16px;
        }

        .menu-text {
            font-size: 14px;
            font-weight: 500;
        }

        .logout-btn {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e6ef;
        }

        .header h2 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .notification-bell {
            position: relative;
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            color: #5a6c7d;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Stats Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 5px solid #1E63C4;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-card.users {
            border-left-color: #1E63C4;
        }

        .stat-card.teachers {
            border-left-color: #2ecc71;
        }

        .stat-card.students {
            border-left-color: #f39c12;
        }

        .stat-card.active {
            border-left-color: #e74c3c;
        }

        .stat-card.inactive {
            border-left-color: #95a5a6;
        }

        .stat-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-info h3 {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-card.users .stat-icon {
            background: rgba(30, 99, 196, 0.1);
            color: #1E63C4;
        }

        .stat-card.teachers .stat-icon {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
        }

        .stat-card.students .stat-icon {
            background: rgba(243, 156, 18, 0.1);
            color: #f39c12;
        }

        .stat-card.active .stat-icon {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .stat-card.inactive .stat-icon {
            background: rgba(149, 165, 166, 0.1);
            color: #95a5a6;
        }

        /* Content Sections */
        .content-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f3f8;
        }

        .section-header h3 {
            font-size: 18px;
            color: #2c3e50;
            font-weight: 700;
        }

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1E63C4, #2a7cd6);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1953a8, #1E63C4);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: white;
            color: #1E63C4;
            border: 2px solid #1E63C4;
        }

        .btn-outline:hover {
            background: #f8fafc;
        }

        .btn-success {
            background: #2ecc71;
            color: white;
        }

        .btn-success:hover {
            background: #27ae60;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #d68910;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Tables */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid #f0f3f8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        thead {
            background: #f8fafc;
        }

        th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 1px solid #e0e6ef;
            font-size: 14px;
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f3f8;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* User Cell */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1E63C4, #2a7cd6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .user-info-text h4 {
            font-size: 15px;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .user-info-text p {
            font-size: 12px;
            color: #7f8c8d;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge.pending {
            background: rgba(243, 156, 18, 0.1);
            color: #f39c12;
        }

        .badge.verified {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
        }

        .badge.rejected {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .badge.incomplete {
            background: rgba(149, 165, 166, 0.1);
            color: #95a5a6;
        }

        .badge.online {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .badge.in_person {
            background: rgba(155, 89, 182, 0.1);
            color: #9b59b6;
        }

        .badge.hybrid {
            background: rgba(230, 126, 34, 0.1);
            color: #e67e22;
        }

        .badge.active {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
        }

        .badge.inactive {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .action-btn.view {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .action-btn.view:hover {
            background: #3498db;
            color: white;
        }

        .action-btn.approve {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
        }

        .action-btn.approve:hover {
            background: #2ecc71;
            color: white;
        }

        .action-btn.reject {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .action-btn.reject:hover {
            background: #e74c3c;
            color: white;
        }

        .action-btn.download {
            background: rgba(155, 89, 182, 0.1);
            color: #9b59b6;
        }

        .action-btn.download:hover {
            background: #9b59b6;
            color: white;
        }

        .action-btn.deactivate {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .action-btn.deactivate:hover {
            background: #e74c3c;
            color: white;
        }

        .action-btn.reactivate {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
        }

        .action-btn.reactivate:hover {
            background: #2ecc71;
            color: white;
        }

        .action-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: rgba(149, 165, 166, 0.1);
            color: #95a5a6;
        }

        .action-btn:disabled:hover {
            background: rgba(149, 165, 166, 0.1);
            color: #95a5a6;
        }

        /* Progress Bar */
        .progress-bar {
            width: 100px;
            height: 8px;
            background: #ecf0f1;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .progress-fill.high {
            background: #2ecc71;
        }

        .progress-fill.medium {
            background: #f39c12;
        }

        .progress-fill.low {
            background: #e74c3c;
        }

        /* Charts Section */
        .charts-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }

        .chart-container {
            background: #f8fafc;
            border-radius: 10px;
            padding: 20px;
            position: relative;
            height: 300px;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #f0f3f8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 18px;
            color: #2c3e50;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #7f8c8d;
        }

        .modal-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #1E63C4;
            box-shadow: 0 0 0 3px rgba(30, 99, 196, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 10px;
        }

        .loading-spinner i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2ecc71;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            display: none;
            z-index: 1001;
            max-width: 400px;
            animation: slideIn 0.3s ease;
        }

        .notification.error {
            background: #e74c3c;
        }

        .notification.warning {
            background: #f39c12;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
                padding: 20px;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .admin-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: static;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">KP</div>
                    <h1>Kopiao Admin</h1>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h4>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h4>
                        <p>Administrateur</p>
                    </div>
                </div>
            </div>

            <div class="sidebar-menu">
                <div class="menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="active">
                        <i class="fas fa-home"></i>
                        <span class="menu-text">Tuteurs</span>
                    </a>
                </div>


                <div class="menu-item">
                    <a href="{{ route('apprenants.index') }}">
                        <i class="fas fa-user-graduate"></i>
                        <span class="menu-text">Apprenants</span>
                    </a>
                </div>


                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h2>Tableau de Bord Administrateur</h2>
                <div class="header-actions">
                    <div class="notification-bell">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">{{ $pendingTeachersCount }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="stat-card users">
                    <div class="stat-info">
                        <div>
                            <h3>Utilisateurs Totaux</h3>
                            <div class="stat-number">{{ $totalUsers }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card teachers">
                    <div class="stat-info">
                        <div>
                            <h3>Professeurs</h3>
                            <div class="stat-number">{{ $totalTeachers }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card students">
                    <div class="stat-info">
                        <div>
                            <h3>Étudiants</h3>
                            <div class="stat-number">{{ $totalStudents }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card active">
                    <div class="stat-info">
                        <div>
                            <h3>Comptes Actifs</h3>
                            <div class="stat-number">{{ $activeAccounts }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card inactive">
                    <div class="stat-info">
                        <div>
                            <h3>Comptes Désactivés</h3>
                            <div class="stat-number">{{ $inactiveAccounts }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques Statistiques -->
            <div class="charts-section">
                <div class="section-header">
                    <h3><i class="fas fa-chart-bar"></i> Statistiques des Professeurs</h3>
                </div>
                <div class="charts-grid">
                    <div class="chart-container">
                        <canvas id="verificationChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Professeurs en Attente de Vérification -->
            <div class="content-section">
                <div class="section-header">
                    <h3>
                        <i class="fas fa-clock"></i>
                        Professeurs en Attente de Vérification
                        <span class="badge pending">{{ $pendingTeachersCount }}</span>
                    </h3>
                </div>

                <!-- Barre de recherche -->
                <div class="section-actions">
                    <div class="search-box">
                        <input type="text" id="searchPendingInput" placeholder="Rechercher un professeur..."
                            autocomplete="off">
                        <i class="fas fa-search"></i>
                    </div>
                </div>

                <!-- Tableau -->
                <div class="table-container">
                    <table id="profsTable">
                        <thead>
                            <tr>
                                <th>Professeur</th>
                                <th>Spécialité</th>
                                <th>Date d'inscription</th>
                                <th>Complétion</th>
                                <th>Pièce d'identité</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingTeachers as $teacher)
                                @php
                                    $completion = $teacher->profile_completion ?? 0;
                                    $completionClass =
                                        $completion >= 80 ? 'high' : ($completion >= 50 ? 'medium' : 'low');
                                @endphp
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar-small">
                                                {{ strtoupper(substr($teacher->firstname, 0, 1) . substr($teacher->lastname, 0, 1)) }}
                                            </div>
                                            <div class="user-info-text">
                                                <h4>{{ $teacher->firstname }} {{ $teacher->lastname }}</h4>
                                                <p>{{ $teacher->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($teacher->subjects)
                                            @php
                                                $subjects = json_decode($teacher->subjects, true);
                                                if (is_array($subjects)) {
                                                    echo implode(', ', $subjects);
                                                } else {
                                                    echo $teacher->subjects;
                                                }
                                            @endphp
                                        @else
                                            Non renseigné
                                        @endif
                                    </td>
                                    <td>{{ $teacher->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="progress-bar">
                                            <div class="progress-fill {{ $completionClass }}"
                                                style="width: {{ $completion }}%"></div>
                                        </div>
                                        <small style="display: block; margin-top: 5px; color: #7f8c8d;">
                                            {{ $completion }}%
                                        </small>
                                    </td>
                                    <td>
                                        @if ($teacher->identity_document_path)
                                            <button class="btn btn-outline btn-sm view-document"
                                                data-teacher-id="{{ $teacher->id }}"
                                                style="padding: 5px 10px; font-size: 12px;">
                                                <i class="fas fa-file-pdf"></i> Voir la pièce
                                            </button>
                                        @else
                                            <span class="badge incomplete">Manquante</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($teacher->is_active)
                                            <span class="badge active">Actif</span>
                                        @else
                                            <span class="badge inactive">Désactivé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn view"
                                                onclick="window.location.href='{{ route('admin.teacher.details', $teacher->id) }}'"
                                                title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="action-btn approve" data-teacher-id="{{ $teacher->id }}"
                                                title="Approuver">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="action-btn reject" data-teacher-id="{{ $teacher->id }}"
                                                title="Rejeter">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            @if ($teacher->is_active)
                                                <button class="action-btn deactivate"
                                                    data-teacher-id="{{ $teacher->id }}" title="Désactiver">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button class="action-btn reactivate"
                                                    data-teacher-id="{{ $teacher->id }}" title="Réactiver">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <div class="loading-spinner" id="loading-{{ $teacher->id }}">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CSS barre de recherche -->
            <style>
                .search-box {
                    position: relative;
                    width: 100%;
                    max-width: 300px;
                    margin-bottom: 20px;
                }

                .search-box input {
                    width: 100%;
                    padding: 10px 35px 10px 15px;
                    border-radius: 25px;
                    border: 1px solid #ccc;
                    font-size: 14px;
                    transition: all 0.3s ease;
                }

                .search-box input:focus {
                    outline: none;
                    border-color: #e74c3c;
                    /* rouge lumineux */
                    box-shadow: 0 0 8px rgba(231, 76, 60, 0.5);
                }

                .search-box i {
                    position: absolute;
                    right: 12px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #888;
                    font-size: 16px;
                    pointer-events: none;
                }
            </style>

            <!-- JS recherche fonctionnelle -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchPendingInput = document.getElementById('searchPendingInput');

                    searchPendingInput.addEventListener('keyup', function() {
                        const value = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#profsTable tbody tr');

                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(value) ? '' : 'none';
                        });
                    });
                });
            </script>


            <!-- Professeurs Vérifiés -->
            <div class="content-section">
                <div class="section-header">
                    <h3>
                        <i class="fas fa-check-circle"></i>
                        Professeurs Vérifiés
                        <span class="badge verified">{{ $verifiedTeachersCount }}</span>
                    </h3>
                </div>

                <!-- CSS barre de recherche -->
                <style>
                    .search-box {
                        position: relative;
                        width: 100%;
                        max-width: 300px;
                        margin-bottom: 20px;
                    }

                    .search-box input {
                        width: 100%;
                        padding: 10px 35px 10px 15px;
                        border-radius: 25px;
                        border: 1px solid #ccc;
                        font-size: 14px;
                        transition: all 0.3s ease;
                    }

                    .search-box input:focus {
                        outline: none;
                        border-color: #e74c3c;
                        /* rouge lumineux */
                        box-shadow: 0 0 8px rgba(231, 76, 60, 0.5);
                    }

                    .search-box i {
                        position: absolute;
                        right: 12px;
                        top: 50%;
                        transform: translateY(-50%);
                        color: #888;
                        font-size: 16px;
                        pointer-events: none;
                        /* icône non cliquable */
                    }
                </style>

                <!-- Barre de recherche -->
                <div class="section-actions">
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Rechercher un professeur..."
                            autocomplete="off">
                        <i class="fas fa-search"></i>
                    </div>
                </div>

                <!-- Tableau -->
                <div class="table-container">
                    <table id="profs2Table">
                        <thead>
                            <tr>
                                <th>Professeur</th>
                                <th>Spécialité</th>
                                <th>Taux horaire</th>
                                <th>Ville</th>
                                <th>Type de cours</th>
                                <th>Date vérification</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($verifiedTeachers as $teacher)
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar-small">
                                                {{ strtoupper(substr($teacher->firstname, 0, 1) . substr($teacher->lastname, 0, 1)) }}
                                            </div>
                                            <div class="user-info-text">
                                                <h4>{{ $teacher->firstname }} {{ $teacher->lastname }}</h4>
                                                <p>{{ $teacher->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($teacher->subjects)
                                            @php
                                                $subjects = json_decode($teacher->subjects, true);
                                                if (is_array($subjects)) {
                                                    echo implode(', ', $subjects);
                                                } else {
                                                    echo $teacher->subjects;
                                                }
                                            @endphp
                                        @else
                                            Non renseigné
                                        @endif
                                    </td>
                                    <td>
                                        @if ($teacher->rate_per_hour)
                                            {{ number_format($teacher->rate_per_hour, 0, ',', ' ') }} FCFA
                                        @else
                                            Non renseigné
                                        @endif
                                    </td>
                                    <td>{{ $teacher->city ?? 'Non renseignée' }}</td>
                                    <td>
                                        @if ($teacher->learning_preference)
                                            <span class="badge {{ $teacher->learning_preference }}">
                                                {{ $teacher->learning_preference == 'in_person'
                                                    ? 'Présentiel'
                                                    : ($teacher->learning_preference == 'online'
                                                        ? 'En ligne'
                                                        : 'Hybride') }}
                                            </span>
                                        @else
                                            Non renseigné
                                        @endif
                                    </td>
                                    <td>{{ $teacher->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if ($teacher->is_active)
                                            <span class="badge active">Actif</span>
                                        @else
                                            <span class="badge inactive">Désactivé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn view"
                                                onclick="window.location.href='{{ route('admin.teacher.details', $teacher->id) }}'"
                                                title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if ($teacher->identity_document_path)
                                                <button class="action-btn download"
                                                    onclick="window.open('{{ route('admin.viewIdentityDocument', $teacher->id) }}', '_blank')"
                                                    title="Voir pièce d'identité">
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>
                                            @endif
                                            @if ($teacher->is_active)
                                                <button class="action-btn deactivate"
                                                    data-teacher-id="{{ $teacher->id }}" title="Désactiver">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button class="action-btn reactivate"
                                                    data-teacher-id="{{ $teacher->id }}" title="Réactiver">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <div class="loading-spinner" id="loading-{{ $teacher->id }}">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- JS recherche corrigée -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('searchInput');

                    searchInput.addEventListener('keyup', function() {
                        const value = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#profs2Table tbody tr');

                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(value) ? '' : 'none';
                        });
                    });
                });
            </script>

            <!-- Professeurs sans pièce d'identité -->
            @if ($teachersWithoutDoc->count() > 0)
                <div class="content-section">
                    <div class="section-header">
                        <h3>
                            <i class="fas fa-exclamation-triangle"></i>
                            Professeurs sans pièce d'identité
                            <span class="badge incomplete">{{ $teachersWithoutDoc->count() }}</span>
                        </h3>
                    </div>

                    <!-- Barre de recherche -->
                    <div class="section-actions">
                        <div class="search-box">
                            <input type="text" id="searchNoDocInput" placeholder="Rechercher un professeur..."
                                autocomplete="off">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>

                    <!-- Tableau -->
                    <div class="table-container">
                        <table id="noDocTable">
                            <thead>
                                <tr>
                                    <th>Professeur</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Date d'inscription</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachersWithoutDoc as $teacher)
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar-small">
                                                    {{ strtoupper(substr($teacher->firstname, 0, 1) . substr($teacher->lastname, 0, 1)) }}
                                                </div>
                                                <div class="user-info-text">
                                                    <h4>{{ $teacher->firstname }} {{ $teacher->lastname }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->telephone ?? 'Non renseigné' }}</td>
                                        <td>{{ $teacher->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($teacher->is_active)
                                                <span class="badge active">Actif</span>
                                            @else
                                                <span class="badge inactive">Désactivé</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn view"
                                                    onclick="window.location.href='{{ route('admin.teacher.details', $teacher->id) }}'"
                                                    title="Voir détails">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if ($teacher->is_active)
                                                    <button class="action-btn deactivate"
                                                        data-teacher-id="{{ $teacher->id }}" title="Désactiver">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                @else
                                                    <button class="action-btn reactivate"
                                                        data-teacher-id="{{ $teacher->id }}" title="Réactiver">
                                                        <i class="fas fa-power-off"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="loading-spinner" id="loading-{{ $teacher->id }}">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- CSS barre de recherche -->
            <style>
                .search-box {
                    position: relative;
                    width: 100%;
                    max-width: 300px;
                    margin-bottom: 20px;
                }

                .search-box input {
                    width: 100%;
                    padding: 10px 35px 10px 15px;
                    border-radius: 25px;
                    border: 1px solid #2d3688;
                    font-size: 14px;
                    transition: all 0.3s ease;
                }

                .search-box input:focus {
                    outline: none;
                    border-color: #3c47e7;
                    box-shadow: 0 0 8px rgba(63, 60, 231, 0.5);
                }

                .search-box i {
                    position: absolute;
                    right: 12px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #888;
                    font-size: 16px;
                    pointer-events: none;
                }
            </style>

            <!-- JS recherche fonctionnelle -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchNoDocInput = document.getElementById('searchNoDocInput');

                    searchNoDocInput.addEventListener('keyup', function() {
                        const value = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#noDocTable tbody tr');

                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(value) ? '' : 'none';
                        });
                    });
                });
            </script>



            <!-- Professeurs Désactivés -->
            @if ($inactiveTeachers->count() > 0)
                <div class="content-section">
                    <div class="section-header">
                        <h3>
                            <i class="fas fa-ban"></i>
                            Professeurs Désactivés
                            <span class="badge inactive">{{ $inactiveTeachers->count() }}</span>
                        </h3>
                    </div>

                    <!-- Barre de recherche -->
                    <div class="section-actions">
                        <div class="search-box">
                            <input type="text" id="searchInactiveInput" placeholder="Rechercher un professeur..."
                                autocomplete="off">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>

                    <!-- Tableau -->
                    <div class="table-container">
                        <table id="inactiveTable">
                            <thead>
                                <tr>
                                    <th>Professeur</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Date de désactivation</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inactiveTeachers as $teacher)
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar-small">
                                                    {{ strtoupper(substr($teacher->firstname, 0, 1) . substr($teacher->lastname, 0, 1)) }}
                                                </div>
                                                <div class="user-info-text">
                                                    <h4>{{ $teacher->firstname }} {{ $teacher->lastname }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->telephone ?? 'Non renseigné' }}</td>
                                        <td>{{ $teacher->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge inactive">Désactivé</span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn view"
                                                    onclick="window.location.href='{{ route('admin.teacher.details', $teacher->id) }}'"
                                                    title="Voir détails">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="action-btn reactivate"
                                                    data-teacher-id="{{ $teacher->id }}" title="Réactiver">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            </div>
                                            <div class="loading-spinner" id="loading-{{ $teacher->id }}">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- CSS barre de recherche  -->
            <style>
                .search-box {
                    position: relative;
                    width: 100%;
                    max-width: 300px;
                    margin-bottom: 20px;
                }

                .search-box input {
                    width: 100%;
                    padding: 10px 35px 10px 15px;
                    border-radius: 25px;
                    border: 1px solid #ccc;
                    font-size: 14px;
                    transition: all 0.3s ease;
                }

                .search-box input:focus {
                    outline: none;
                    border-color: #e74c3c;
                    /* rouge lumineux */
                    box-shadow: 0 0 8px rgba(231, 76, 60, 0.5);
                }

                .search-box i {
                    position: absolute;
                    right: 12px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #888;
                    font-size: 16px;
                    pointer-events: none;
                }
            </style>

            <!-- JS recherche -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInactiveInput = document.getElementById('searchInactiveInput');

                    searchInactiveInput.addEventListener('keyup', function() {
                        const value = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#inactiveTable tbody tr');

                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(value) ? '' : 'none';
                        });
                    });
                });
            </script>


            <!-- Modals -->
            <!-- Modal d'approbation -->
            <div id="approvalModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><i class="fas fa-check-circle"></i> Approuver le professeur</h3>
                        <button class="close-modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="approvalForm" method="POST">
                            @csrf
                            <input type="hidden" name="teacher_id" id="approvalTeacherId">
                            <div class="form-group">
                                <label for="approvalReason">Message d'approbation (optionnel)</label>
                                <textarea id="approvalReason" name="approval_reason" class="form-control" rows="4"
                                    placeholder="Message à envoyer au professeur..."></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-outline close-modal">Annuler</button>
                                <button type="submit" class="btn btn-success" id="approveSubmitBtn">
                                    <i class="fas fa-check"></i> Confirmer l'approbation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de rejet -->
            <div id="rejectionModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><i class="fas fa-times-circle"></i> Rejeter le professeur</h3>
                        <button class="close-modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="rejectionForm" method="POST">
                            @csrf
                            <input type="hidden" name="teacher_id" id="rejectionTeacherId">
                            <div class="form-group">
                                <label for="rejectionReason">Raison du rejet <span
                                        style="color: #e74c3c">*</span></label>
                                <textarea id="rejectionReason" name="rejection_reason" class="form-control" rows="4"
                                    placeholder="Veuillez expliquer la raison du rejet..." required></textarea>
                                <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                                    Cette raison sera envoyée par email au professeur.
                                </small>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-outline close-modal">Annuler</button>
                                <button type="submit" class="btn btn-danger" id="rejectSubmitBtn">
                                    <i class="fas fa-times"></i> Confirmer le rejet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de désactivation -->
            <div id="deactivationModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><i class="fas fa-ban"></i> Désactiver le compte</h3>
                        <button class="close-modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="deactivationForm" method="POST">
                            @csrf
                            <input type="hidden" name="teacher_id" id="deactivationTeacherId">
                            <div class="form-group">
                                <label for="deactivationReason">Raison de la désactivation <span
                                        style="color: #e74c3c">*</span></label>
                                <textarea id="deactivationReason" name="deactivation_reason" class="form-control" rows="4"
                                    placeholder="Veuillez expliquer la raison de la désactivation..." required></textarea>
                                <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                                    Cette raison sera envoyée par email au professeur. L'utilisateur sera déconnecté
                                    immédiatement.
                                </small>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-outline close-modal">Annuler</button>
                                <button type="submit" class="btn btn-danger" id="deactivateSubmitBtn">
                                    <i class="fas fa-ban"></i> Confirmer la désactivation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de réactivation -->
            <div id="reactivationModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><i class="fas fa-power-off"></i> Réactiver le compte</h3>
                        <button class="close-modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="reactivationForm" method="POST">
                            @csrf
                            <input type="hidden" name="teacher_id" id="reactivationTeacherId">
                            <div class="form-group">
                                <label for="reactivationReason">Message de réactivation (optionnel)</label>
                                <textarea id="reactivationReason" name="reactivation_reason" class="form-control" rows="4"
                                    placeholder="Message à envoyer au professeur..."></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-outline close-modal">Annuler</button>
                                <button type="submit" class="btn btn-success" id="reactivateSubmitBtn">
                                    <i class="fas fa-power-off"></i> Confirmer la réactivation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de visualisation de pièce d'identité -->
            <div id="documentModal" class="modal">
                <div class="modal-content" style="max-width: 800px;">
                    <div class="modal-header">
                        <h3><i class="fas fa-file-pdf"></i> Pièce d'identité</h3>
                        <button class="close-modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="documentViewer">
                            <div style="text-align: center; padding: 20px;">
                                <i class="fas fa-spinner fa-spin fa-2x" style="color: #1E63C4;"></i>
                                <p style="margin-top: 10px;">Chargement de la pièce d'identité...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification -->
            <div id="notification" class="notification"></div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Initialisation des graphiques
                    initializeCharts();

                    // Modals
                    const approvalModal = document.getElementById('approvalModal');
                    const rejectionModal = document.getElementById('rejectionModal');
                    const deactivationModal = document.getElementById('deactivationModal');
                    const reactivationModal = document.getElementById('reactivationModal');
                    const documentModal = document.getElementById('documentModal');
                    const closeButtons = document.querySelectorAll('.close-modal');
                    const notification = document.getElementById('notification');

                    // Variables pour suivre les actions en cours
                    const pendingActions = new Set();

                    // Fonction pour désactiver les boutons
                    function disableActionButtons(teacherId, disable = true) {
                        const row = document.querySelector(`[data-teacher-id="${teacherId}"]`)?.closest('tr');
                        if (!row) return;

                        const buttons = row.querySelectorAll('.action-btn');
                        const loadingSpinner = row.querySelector('.loading-spinner');

                        if (disable) {
                            buttons.forEach(btn => btn.disabled = true);
                            if (loadingSpinner) loadingSpinner.style.display = 'block';
                            pendingActions.add(teacherId);
                        } else {
                            buttons.forEach(btn => btn.disabled = false);
                            if (loadingSpinner) loadingSpinner.style.display = 'none';
                            pendingActions.delete(teacherId);
                        }
                    }

                    // Fonction pour désactiver le bouton de soumission modal
                    function disableModalButton(buttonId, disable = true) {
                        const button = document.getElementById(buttonId);
                        if (button) {
                            button.disabled = disable;
                            if (disable) {
                                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Veuillez patienter...';
                            }
                        }
                    }

                    // Fonction pour réinitialiser le bouton modal
                    function resetModalButton(buttonId, originalText) {
                        const button = document.getElementById(buttonId);
                        if (button) {
                            button.disabled = false;
                            button.innerHTML = originalText;
                        }
                    }

                    // Ouvrir modal d'approbation
                    document.querySelectorAll('.action-btn.approve').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const teacherId = this.getAttribute('data-teacher-id');
                            if (pendingActions.has(teacherId)) {
                                showNotification('Une action est déjà en cours pour ce professeur',
                                    'warning');
                                return;
                            }
                            document.getElementById('approvalTeacherId').value = teacherId;
                            approvalModal.style.display = 'flex';
                        });
                    });

                    // Ouvrir modal de rejet
                    document.querySelectorAll('.action-btn.reject').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const teacherId = this.getAttribute('data-teacher-id');
                            if (pendingActions.has(teacherId)) {
                                showNotification('Une action est déjà en cours pour ce professeur',
                                    'warning');
                                return;
                            }
                            document.getElementById('rejectionTeacherId').value = teacherId;
                            rejectionModal.style.display = 'flex';
                        });
                    });

                    // Ouvrir modal de désactivation
                    document.querySelectorAll('.action-btn.deactivate').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const teacherId = this.getAttribute('data-teacher-id');
                            if (pendingActions.has(teacherId)) {
                                showNotification('Une action est déjà en cours pour ce professeur',
                                    'warning');
                                return;
                            }
                            document.getElementById('deactivationTeacherId').value = teacherId;
                            deactivationModal.style.display = 'flex';
                        });
                    });

                    // Ouvrir modal de réactivation
                    document.querySelectorAll('.action-btn.reactivate').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const teacherId = this.getAttribute('data-teacher-id');
                            if (pendingActions.has(teacherId)) {
                                showNotification('Une action est déjà en cours pour ce professeur',
                                    'warning');
                                return;
                            }
                            document.getElementById('reactivationTeacherId').value = teacherId;
                            reactivationModal.style.display = 'flex';
                        });
                    });

                    // Voir pièce d'identité
                    document.querySelectorAll('.view-document').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const teacherId = this.getAttribute('data-teacher-id');
                            const documentViewer = document.getElementById('documentViewer');

                            documentViewer.innerHTML = `
                        <div style="text-align: center; padding: 20px;">
                            <i class="fas fa-spinner fa-spin fa-2x" style="color: #1E63C4;"></i>
                            <p style="margin-top: 10px;">Chargement de la pièce d'identité...</p>
                        </div>
                    `;

                            documentModal.style.display = 'flex';

                            // Charger le document
                            const url = `/admin/teachers/${teacherId}/identity-document`;
                            documentViewer.innerHTML = `
                        <iframe src="${url}"
                                style="width: 100%; height: 500px; border: none; border-radius: 8px;"></iframe>
                        <div style="text-align: center; margin-top: 15px;">
                            <a href="${url}"
                               target="_blank" class="btn btn-primary" style="padding: 10px 20px;">
                                <i class="fas fa-external-link-alt"></i> Ouvrir dans un nouvel onglet
                            </a>
                        </div>
                    `;
                        });
                    });

                    // Fermer modals
                    closeButtons.forEach(btn => {
                        btn.addEventListener('click', function() {
                            approvalModal.style.display = 'none';
                            rejectionModal.style.display = 'none';
                            deactivationModal.style.display = 'none';
                            reactivationModal.style.display = 'none';
                            documentModal.style.display = 'none';

                            // Réinitialiser les formulaires
                            document.getElementById('approvalForm').reset();
                            document.getElementById('rejectionForm').reset();
                            document.getElementById('deactivationForm').reset();
                            document.getElementById('reactivationForm').reset();

                            // Réinitialiser les boutons modaux
                            resetModalButton('approveSubmitBtn',
                                '<i class="fas fa-check"></i> Confirmer l\'approbation');
                            resetModalButton('rejectSubmitBtn',
                                '<i class="fas fa-times"></i> Confirmer le rejet');
                            resetModalButton('deactivateSubmitBtn',
                                '<i class="fas fa-ban"></i> Confirmer la désactivation');
                            resetModalButton('reactivateSubmitBtn',
                                '<i class="fas fa-power-off"></i> Confirmer la réactivation');
                        });
                    });

                    // Fermer modals en cliquant en dehors
                    window.addEventListener('click', function(event) {
                        if (event.target === approvalModal) {
                            approvalModal.style.display = 'none';
                            document.getElementById('approvalForm').reset();
                        }
                        if (event.target === rejectionModal) {
                            rejectionModal.style.display = 'none';
                            document.getElementById('rejectionForm').reset();
                        }
                        if (event.target === deactivationModal) {
                            deactivationModal.style.display = 'none';
                            document.getElementById('deactivationForm').reset();
                        }
                        if (event.target === reactivationModal) {
                            reactivationModal.style.display = 'none';
                            document.getElementById('reactivationForm').reset();
                        }
                        if (event.target === documentModal) {
                            documentModal.style.display = 'none';
                        }
                    });

                    // Soumission du formulaire d'approbation
                    document.getElementById('approvalForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const teacherId = document.getElementById('approvalTeacherId').value;
                        const formData = new FormData(this);

                        // Désactiver les boutons
                        disableActionButtons(teacherId, true);
                        disableModalButton('approveSubmitBtn', true);

                        fetch(`/admin/teachers/${teacherId}/approve`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showNotification('Professeur approuvé avec succès !', 'success');
                                    approvalModal.style.display = 'none';
                                    document.getElementById('approvalForm').reset();
                                    // Recharger la page après 2 secondes
                                    setTimeout(() => location.reload(), 2000);
                                } else {
                                    showNotification('Erreur lors de l\'approbation: ' + data.message, 'error');
                                    disableActionButtons(teacherId, false);
                                    resetModalButton('approveSubmitBtn',
                                        '<i class="fas fa-check"></i> Confirmer l\'approbation');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('Erreur lors de l\'approbation', 'error');
                                disableActionButtons(teacherId, false);
                                resetModalButton('approveSubmitBtn',
                                    '<i class="fas fa-check"></i> Confirmer l\'approbation');
                            });
                    });

                    // Soumission du formulaire de rejet
                    document.getElementById('rejectionForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const teacherId = document.getElementById('rejectionTeacherId').value;
                        const formData = new FormData(this);

                        // Désactiver les boutons
                        disableActionButtons(teacherId, true);
                        disableModalButton('rejectSubmitBtn', true);

                        fetch(`/admin/teachers/${teacherId}/reject`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showNotification('Professeur rejeté avec succès !', 'success');
                                    rejectionModal.style.display = 'none';
                                    document.getElementById('rejectionForm').reset();
                                    // Recharger la page après 2 secondes
                                    setTimeout(() => location.reload(), 2000);
                                } else {
                                    showNotification('Erreur lors du rejet: ' + data.message, 'error');
                                    disableActionButtons(teacherId, false);
                                    resetModalButton('rejectSubmitBtn',
                                        '<i class="fas fa-times"></i> Confirmer le rejet');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('Erreur lors du rejet', 'error');
                                disableActionButtons(teacherId, false);
                                resetModalButton('rejectSubmitBtn',
                                    '<i class="fas fa-times"></i> Confirmer le rejet');
                            });
                    });

                    // Soumission du formulaire de désactivation
                    document.getElementById('deactivationForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const teacherId = document.getElementById('deactivationTeacherId').value;
                        const formData = new FormData(this);

                        // Désactiver les boutons
                        disableActionButtons(teacherId, true);
                        disableModalButton('deactivateSubmitBtn', true);

                        fetch(`/admin/teachers/${teacherId}/deactivate`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showNotification('Compte désactivé avec succès !', 'success');
                                    deactivationModal.style.display = 'none';
                                    document.getElementById('deactivationForm').reset();
                                    // Recharger la page après 2 secondes
                                    setTimeout(() => location.reload(), 2000);
                                } else {
                                    showNotification('Erreur lors de la désactivation: ' + data.message,
                                        'error');
                                    disableActionButtons(teacherId, false);
                                    resetModalButton('deactivateSubmitBtn',
                                        '<i class="fas fa-ban"></i> Confirmer la désactivation');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('Erreur lors de la désactivation', 'error');
                                disableActionButtons(teacherId, false);
                                resetModalButton('deactivateSubmitBtn',
                                    '<i class="fas fa-ban"></i> Confirmer la désactivation');
                            });
                    });

                    // Soumission du formulaire de réactivation
                    document.getElementById('reactivationForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const teacherId = document.getElementById('reactivationTeacherId').value;
                        const formData = new FormData(this);

                        // Désactiver les boutons
                        disableActionButtons(teacherId, true);
                        disableModalButton('reactivateSubmitBtn', true);

                        fetch(`/admin/teachers/${teacherId}/reactivate`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showNotification('Compte réactivé avec succès !', 'success');
                                    reactivationModal.style.display = 'none';
                                    document.getElementById('reactivationForm').reset();
                                    // Recharger la page après 2 secondes
                                    setTimeout(() => location.reload(), 2000);
                                } else {
                                    showNotification('Erreur lors de la réactivation: ' + data.message,
                                        'error');
                                    disableActionButtons(teacherId, false);
                                    resetModalButton('reactivateSubmitBtn',
                                        '<i class="fas fa-power-off"></i> Confirmer la réactivation');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('Erreur lors de la réactivation', 'error');
                                disableActionButtons(teacherId, false);
                                resetModalButton('reactivateSubmitBtn',
                                    '<i class="fas fa-power-off"></i> Confirmer la réactivation');
                            });
                    });

                    // Fonction pour afficher les notifications
                    function showNotification(message, type) {
                        notification.textContent = message;
                        notification.className = 'notification';

                        switch (type) {
                            case 'success':
                                notification.style.background = '#2ecc71';
                                break;
                            case 'error':
                                notification.style.background = '#e74c3c';
                                notification.classList.add('error');
                                break;
                            case 'warning':
                                notification.style.background = '#f39c12';
                                notification.classList.add('warning');
                                break;
                            default:
                                notification.style.background = '#3498db';
                        }

                        notification.style.display = 'block';

                        setTimeout(() => {
                            notification.style.display = 'none';
                        }, 5000);
                    }

                    // Fonction pour initialiser les graphiques
                    function initializeCharts() {
                        // Graphique de vérification
                        const verificationCtx = document.getElementById('verificationChart').getContext('2d');
                        new Chart(verificationCtx, {
                            type: 'bar',
                            data: {
                                labels: ['Vérifiés', 'En attente', 'Rejetés', 'Sans document'],
                                datasets: [{
                                    label: 'Nombre de professeurs',
                                    data: [
                                        {{ $verifiedTeachersCount }},
                                        {{ $pendingTeachersCount }},
                                        {{ $rejectedTeachersCount }},
                                        {{ $teachersWithoutDoc->count() }}
                                    ],
                                    backgroundColor: [
                                        'rgba(46, 204, 113, 0.7)',
                                        'rgba(243, 156, 18, 0.7)',
                                        'rgba(231, 76, 60, 0.7)',
                                        'rgba(149, 165, 166, 0.7)'
                                    ],
                                    borderColor: [
                                        '#2ecc71',
                                        '#f39c12',
                                        '#e74c3c',
                                        '#95a5a6'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    title: {
                                        display: true,
                                        text: 'Statut de vérification des professeurs'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
                        });

                        // Graphique circulaire des comptes
                        const statusCtx = document.getElementById('statusChart').getContext('2d');
                        new Chart(statusCtx, {
                            type: 'pie',
                            data: {
                                labels: ['Actifs', 'Désactivés'],
                                datasets: [{
                                    data: [
                                        {{ $totalTeachers - $inactiveTeachersCount }},
                                        {{ $inactiveTeachersCount }}
                                    ],
                                    backgroundColor: [
                                        'rgba(46, 204, 113, 0.7)',
                                        'rgba(231, 76, 60, 0.7)'
                                    ],
                                    borderColor: [
                                        '#2ecc71',
                                        '#e74c3c'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    },
                                    title: {
                                        display: true,
                                        text: 'Statut des comptes professeurs'
                                    }
                                }
                            }
                        });
                    }

                    // Afficher les messages de session
                    @if (session('success'))
                        showNotification('{{ session('success') }}', 'success');
                    @endif

                    @if (session('error'))
                        showNotification('{{ session('error') }}', 'error');
                    @endif
                });
            </script>
</body>

</html>
