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
    transition: all 0.3s ease;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    z-index: 1000;
}

/* Sidebar pour les étudiants (bleu) */
.sidebar-etudiant {
    background-color: var(--primary-color);
    color: var(--white);
}

/* Sidebar pour les tuteurs (jaune) */
.sidebar-tuteur {
    background-color: #57e285; /* Jaune */
    color: #ffffff !important ; /* Texte noir pour contraste */
}

/* Vous pouvez aussi utiliser des variables CSS si vous préférez */
:root {
    --primary-color: #0351BC; /* Bleu pour étudiants */
    --tuteur-color: #1d8f43; /* Jaune pour tuteurs */
    --text-light: #ffffff;
    --text-dark: #000000;
}

.sidebar-tuteur {
    background-color: var(--tuteur-color);
    color: var(--text-dark);
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

    /* Badge Tuteur Vérifié */
    .verified-badge {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, #FFD700, #FFA500);
        color: #8B6914;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-left: 10px;
        box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3);
        }
        50% {
            box-shadow: 0 3px 15px rgba(255, 215, 0, 0.5);
        }
        100% {
            box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3);
        }
    }

    .verified-badge i {
        margin-right: 5px;
        font-size: 0.9rem;
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
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #444;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        cursor: pointer;
        overflow: hidden;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-dropdown {
        list-style: none;
        background: white;
        position: absolute;
        top: 55px;
        right: 0;
        width: 160px;
        border-radius: 6px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        padding: 8px 0;
        display: none;
        z-index: 999;
    }

    .user-dropdown li {
        padding: 8px 15px;
    }

    .user-dropdown li a {
        text-decoration: none;
        color: #333;
    }

    .user-dropdown li:hover {
        background: #f0f0f0;
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

    /* Sessions Container */
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

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
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

        .stats-grid {
            gap: 1rem;
        }

        .stat-card {
            padding: 0.75rem;
        }
    }
</style>
