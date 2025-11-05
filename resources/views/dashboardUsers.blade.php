<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduBenin Tutorat - Dashboard</title>
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
                    <i class="fas fa-users"></i>
                    <span class="menu-text">Étudiants</span>
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
                    <h2 class="section-title">Prochaines sessions</h2>
                    <a href="#" class="view-all">Voir tout</a>
                </div>
                <div class="session-list">
                    <div class="session-item">
                        <div class="session-avatar">MJ</div>
                        <div class="session-info">
                            <div class="session-name">Mathématiques - Niveau Terminale</div>
                            <div class="session-details">
                                <span>Marie Johnson</span>
                                <span>En ligne</span>
                            </div>
                        </div>
                        <div class="session-time">
                            <i class="far fa-clock"></i>
                            Aujourd'hui, 15h00
                        </div>
                        <div class="session-actions">
                            <button class="btn btn-primary">Rejoindre</button>
                            <button class="btn btn-outline">Reporter</button>
                        </div>
                    </div>
                    <div class="session-item">
                        <div class="session-avatar">KD</div>
                        <div class="session-info">
                            <div class="session-name">Physique - Niveau Première</div>
                            <div class="session-details">
                                <span>Koffi Dossou</span>
                                <span>En présentiel</span>
                            </div>
                        </div>
                        <div class="session-time">
                            <i class="far fa-clock"></i>
                            Demain, 10h00
                        </div>
                        <div class="session-actions">
                            <button class="btn btn-primary">Détails</button>
                            <button class="btn btn-outline">Message</button>
                        </div>
                    </div>
                    <div class="session-item">
                        <div class="session-avatar">AS</div>
                        <div class="session-info">
                            <div class="session-name">Anglais - Conversation</div>
                            <div class="session-details">
                                <span>Aïcha Sarr</span>
                                <span>En ligne</span>
                            </div>
                        </div>
                        <div class="session-time">
                            <i class="far fa-clock"></i>
                            Vendredi, 14h30
                        </div>
                        <div class="session-actions">
                            <button class="btn btn-primary">Détails</button>
                            <button class="btn btn-outline">Message</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="activity-container">
                <div class="section-header">
                    <h2 class="section-title">Activité récente</h2>
                    <a href="#" class="view-all">Voir tout</a>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Paiement reçu de Jean A.</div>
                            <div class="activity-time">Il y a 2 heures</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Nouvelle évaluation 5 étoiles</div>
                            <div class="activity-time">Il y a 5 heures</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Nouvelle réservation de cours</div>
                            <div class="activity-time">Il y a 1 jour</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Nouveau message de Fatou D.</div>
                            <div class="activity-time">Il y a 2 jours</div>
                        </div>
                    </div>
                </div>
            </div>
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
