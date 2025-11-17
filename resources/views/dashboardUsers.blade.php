<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduBenin Tutorat - Dashboard</title>
    <link href="{{ asset('images/image_1.webp') }}" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0351BC;
            --primary-light: #4a7fd4;
            --primary-dark: #023a8a;
            --white: #ffffff;
            --light-gray: #f5f7fa;
            --medium-gray: #e4e7ec;
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
            background-color: var(--light-gray);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background-color: var(--primary-color);
            color: var(--white);
            transition: all 0.3s ease;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--primary-light);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            width: 40px;
            height: 40px;
            background-color: var(--white);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
            font-size: 20px;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: var(--primary-light);
        }

        .menu-item i {
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Profile Completion Banner */
        .profile-banner {
            background-color: var(--white);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-left: 4px solid var(--primary-color);
        }

        .profile-banner-content {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile-banner-icon {
            width: 48px;
            height: 48px;
            background-color: var(--primary-light);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .profile-banner-text h3 {
            margin-bottom: 4px;
            color: var(--primary-color);
        }

        .profile-banner-text p {
            color: var(--dark-gray);
            font-size: 14px;
        }

        .btn-complete-profile {
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-complete-profile:hover {
            background-color: var(--primary-dark);
        }

        /* Dashboard Stats */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .stat-card-title {
            font-size: 14px;
            color: var(--dark-gray);
        }

        .stat-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .stat-card-icon.blue {
            background-color: var(--primary-color);
        }

        .stat-card-icon.green {
            background-color: var(--success);
        }

        .stat-card-icon.orange {
            background-color: var(--warning);
        }

        .stat-card-icon.red {
            background-color: var(--danger);
        }

        .stat-card-value {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .stat-card-change {
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-card-change.positive {
            color: var(--success);
        }

        .stat-card-change.negative {
            color: var(--danger);
        }

        /* Upcoming Sessions */
        .sessions-container {
            background-color: var(--white);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .view-all {
            color: var(--primary-color);
            font-size: 14px;
            text-decoration: none;
            font-weight: 500;
        }

        .session-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .session-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            border-radius: 8px;
            background-color: var(--light-gray);
            transition: all 0.2s ease;
        }

        .session-item:hover {
            background-color: var(--medium-gray);
        }

        .session-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .session-info {
            flex: 1;
        }

        .session-name {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .session-details {
            font-size: 14px;
            color: var(--dark-gray);
            display: flex;
            gap: 16px;
        }

        .session-time {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: var(--primary-color);
            font-weight: 500;
        }

        .session-actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-outline:hover {
            background-color: var(--primary-color);
            color: var(--white);
        }

        /* Recent Activity */
        .activity-container {
            background-color: var(--white);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .activity-item {
            display: flex;
            gap: 16px;
            padding: 12px 0;
            border-bottom: 1px solid var(--medium-gray);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .activity-time {
            font-size: 12px;
            color: var(--dark-gray);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }

            .sidebar .logo-text,
            .sidebar .menu-text {
                display: none;
            }

            .main-content {
                margin-left: 80px;
            }

            .sidebar-header {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }

            .session-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .session-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            .main-content {
                margin-left: 0;
            }

            .profile-banner {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .btn-complete-profile {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">EB</div>
                <div class="logo-text">EduBenin</div>
            </div>
            <div class="sidebar-menu">
                <div class="menu-item active">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Tableau de bord</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="menu-text">Mes cours</span>
                </div>

                <div class="menu-item">
                    <i class="fas fa-chart-line"></i>
                    <span class="menu-text">Analytiques</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-wallet"></i>
                    <span class="menu-text">Paiements</span>
                </div>

                <div class="menu-item logout-item" style="width: 100%;">
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit"
                            style="display: flex; align-items: center; gap: 10px; color: #fff; background: #e02c18;
                   padding: 13px 10px; border: none; border-radius: 6px; text-decoration: none;
                   font-weight: 500; margin-top: 5px; transition: background 0.3s; width: 100%; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span style="font-size: 16px;">Déconnexion</span>
                        </button>
                    </form>
                </div>



            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1 class="page-title">Tableau de bord</h1>
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1)) }}
                    </div>
                    <span>{{ $user->firstname }} {{ $user->lastname }}</span>

                </div>
            </div>

            <!-- Profile Completion Banner -->
            <div class="profile-banner">
                <div class="profile-banner-content">
                    <div class="profile-banner-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div class="profile-banner-text">
                        <h3>Complétez votre profil</h3>
                        <p>Votre profil est complété à {{ $profileCompletion }}%. Ajoutez plus d'informations pour
                            améliorer votre visibilité.</p>
                        <div class="progress-bar"
                            style="background: #e0e0e0; border-radius: 5px; height: 20px; width: 100%;">
                            <div class="progress-bar-fill"
                                style="
                        background: {{ $profileCompletion < 100 ? '#f44336' : '#4caf50' }};
                        width: {{ $profileCompletion }}%;
                        height: 100%;
                        border-radius: 5px;
                    ">
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('CompleterProfilUser.edit') }}" class="btn-complete-profile"
                    style="text-decoration: none;">
                    <i class="fas fa-pencil-alt"></i>
                    Compléter mon profil
                </a>
            </div>


            <!-- Dashboard Stats -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Heures enseignées</div>
                        <div class="stat-card-icon blue">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="stat-card-value">42h</div>
                    <div class="stat-card-change positive">
                        <i class="fas fa-arrow-up"></i>
                        12% ce mois
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Étudiants actifs</div>
                        <div class="stat-card-icon green">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                    <div class="stat-card-value">18</div>
                    <div class="stat-card-change positive">
                        <i class="fas fa-arrow-up"></i>
                        5% ce mois
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Revenus ce mois</div>
                        <div class="stat-card-icon orange">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                    <div class="stat-card-value">125,000 FCFA</div>
                    <div class="stat-card-change positive">
                        <i class="fas fa-arrow-up"></i>
                        8% ce mois
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">Note moyenne</div>
                        <div class="stat-card-icon red">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="stat-card-value">4.7/5</div>
                    <div class="stat-card-change negative">
                        <i class="fas fa-arrow-down"></i>
                        0.2 ce mois
                    </div>
                </div>
            </div>

            <!-- Upcoming Sessions -->
            <div class="sessions-container">
                <div class="section-header">
                    <h2 class="section-title">Statistiques de la plateforme</h2>
                </div>

                <div class="stats-grid">
                    <!-- Graphique 1: Répartition Tuteurs/Étudiants -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <h3>Répartition des utilisateurs</h3>
                            <span class="total-users">Total: {{ $stats['totalUsers'] }}</span>
                        </div>
                        <div class="chart-container">
                            <canvas id="usersChart" width="400" height="200"></canvas>
                        </div>
                        <div class="stat-details">
                            <div class="stat-item">
                                <span class="stat-label">👨‍🏫 Tuteurs</span>
                                <span class="stat-value">{{ $stats['tutorsPercentage'] }}%</span>
                                <span class="stat-count">({{ $stats['tutorsCount'] }})</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">👨‍🎓 Étudiants</span>
                                <span class="stat-value">{{ $stats['studentsPercentage'] }}%</span>
                                <span class="stat-count">({{ $stats['studentsCount'] }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Graphique 2: Préférences d'apprentissage des tuteurs -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <h3>Mode d'enseignement des tuteurs</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="tutorsPreferenceChart" width="400" height="200"></canvas>
                        </div>
                        <div class="stat-details">
                            <div class="stat-item">
                                <span class="stat-label">💻 En ligne</span>
                                <span class="stat-value">{{ $stats['onlineTutors'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">🏫 Présentiel</span>
                                <span class="stat-value">{{ $stats['inPersonTutors'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">🔀 Hybride</span>
                                <span class="stat-value">{{ $stats['hybridTutors'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Graphique 3: Préférences d'apprentissage des étudiants -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <h3>Préférences d'apprentissage des étudiants</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="studentsPreferenceChart" width="400" height="200"></canvas>
                        </div>
                        <div class="stat-details">
                            <div class="stat-item">
                                <span class="stat-label">💻 En ligne</span>
                                <span class="stat-value">{{ $stats['onlineStudents'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">🏫 Présentiel</span>
                                <span class="stat-value">{{ $stats['inPersonStudents'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">🔀 Hybride</span>
                                <span class="stat-value">{{ $stats['hybridStudents'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scripts pour les graphiques -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Graphique 1: Répartition Tuteurs/Étudiants
                    const usersCtx = document.getElementById('usersChart').getContext('2d');
                    new Chart(usersCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Tuteurs', 'Étudiants'],
                            datasets: [{
                                data: [{{ $stats['tutorsCount'] }}, {{ $stats['studentsCount'] }}],
                                backgroundColor: ['#4f46e5', '#10b981'],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });

                    // Graphique 2: Préférences des tuteurs
                    const tutorsPreferenceCtx = document.getElementById('tutorsPreferenceChart').getContext('2d');
                    new Chart(tutorsPreferenceCtx, {
                        type: 'bar',
                        data: {
                            labels: ['En ligne', 'Présentiel', 'Hybride'],
                            datasets: [{
                                label: 'Tuteurs',
                                data: [{{ $stats['onlineTutors'] }}, {{ $stats['inPersonTutors'] }},
                                    {{ $stats['hybridTutors'] }}
                                ],
                                backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b'],
                                borderWidth: 1
                            }]
                        },
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
                            }
                        }
                    });

                    // Graphique 3: Préférences des étudiants
                    const studentsPreferenceCtx = document.getElementById('studentsPreferenceChart').getContext('2d');
                    new Chart(studentsPreferenceCtx, {
                        type: 'bar',
                        data: {
                            labels: ['En ligne', 'Présentiel', 'Hybride'],
                            datasets: [{
                                label: 'Étudiants',
                                data: [{{ $stats['onlineStudents'] }}, {{ $stats['inPersonStudents'] }},
                                    {{ $stats['hybridStudents'] }}
                                ],
                                backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b'],
                                borderWidth: 1
                            }]
                        },
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
                            }
                        }
                    });
                });
            </script>

            <style>
                .stats-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 1.5rem;
                    margin-top: 1rem;
                }

                .stat-card {
                    background: white;
                    border-radius: 12px;
                    padding: 1.5rem;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    border: 1px solid #e5e7eb;
                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                }

                .stat-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                }

                .stat-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 1rem;
                }

                .stat-header h3 {
                    margin: 0;
                    font-size: 1.1rem;
                    font-weight: 600;
                    color: #374151;
                }

                .total-users {
                    font-size: 0.8rem;
                    color: #6b7280;
                    background: #f3f4f6;
                    padding: 0.25rem 0.5rem;
                    border-radius: 6px;
                }

                .chart-container {
                    height: 200px;
                    margin-bottom: 1rem;
                }

                .stat-details {
                    display: flex;
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .stat-item {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.5rem 0;
                    border-bottom: 1px solid #f3f4f6;
                }

                .stat-item:last-child {
                    border-bottom: none;
                }

                .stat-label {
                    font-size: 0.9rem;
                    color: #6b7280;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }

                .stat-value {
                    font-weight: 600;
                    color: #374151;
                }

                .stat-count {
                    font-size: 0.8rem;
                    color: #9ca3af;
                }

                /* Responsive */
                @media (max-width: 768px) {
                    .stats-grid {
                        grid-template-columns: 1fr;
                    }

                    .stat-card {
                        padding: 1rem;
                    }

                    .chart-container {
                        height: 180px;
                    }

                    .stat-header {
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 0.5rem;
                    }
                }

                @media (max-width: 480px) {
                    .stats-grid {
                        gap: 1rem;
                    }

                    .stat-card {
                        padding: 0.75rem;
                    }
                }
            </style>

        </div>
    </div>

    <script>
        // Script pour gérer l'interactivité du dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du bouton "Compléter mon profil"
            const completeProfileBtn = document.querySelector('.btn-complete-profile');

            // Gestion des boutons de session
            const sessionButtons = document.querySelectorAll('.session-actions .btn');
            sessionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (this.textContent.includes('Rejoindre')) {
                        alert('Connexion à la session de cours...');
                    } else if (this.textContent.includes('Détails')) {
                        alert('Affichage des détails de la session...');
                    } else if (this.textContent.includes('Message')) {
                        alert('Ouverture de la messagerie...');
                    } else if (this.textContent.includes('Reporter')) {
                        alert('Ouverture du calendrier pour reporter la session...');
                    }
                });
            });

            // Simulation de données dynamiques (pourrait être remplacé par des appels API)
            function updateStats() {
                // Cette fonction pourrait être utilisée pour mettre à jour les statistiques en temps réel
                console.log('Mise à jour des statistiques...');
            }

            // Mettre à jour les stats toutes les 30 secondes (simulation)
            setInterval(updateStats, 30000);
        });
    </script>
</body>

</html>
