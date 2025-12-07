<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopiao - Dashboard Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/image_1.webp') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1a73e8;
            --primary-dark: #0d47a1;
            --primary-light: #64b5f6;
            --secondary: #f8f9fa;
            --accent: #ff6b6b;
            --text: #333333;
            --text-light: #757575;
            --success: #4caf50;
            --warning: #ff9800;
            --danger: #f44336;
            --white: #ffffff;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            color: var(--text);
            min-height: 100vh;

            padding: 20px;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1800px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            min-height: calc(100vh - 40px);
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: 30px 0;
            transition: all 0.3s ease;
        }

        .logo {
            display: flex;
            align-items: center;
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .logo i {
            font-size: 28px;
            margin-right: 12px;
            color: var(--white);
        }

        .logo h1 {
            font-size: 22px;
            font-weight: 600;
        }

        .menu {
            list-style: none;
            padding: 0 15px;
        }

        .menu-item {
            margin-bottom: 8px;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .menu-item a:hover, .menu-item a.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
        }

        .menu-item i {
            font-size: 20px;
            margin-right: 15px;
            width: 24px;
            text-align: center;
        }

        .menu-item span {
            font-weight: 500;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            background: var(--secondary);
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        .user-details h4 {
            font-weight: 600;
        }

        .user-details p {
            font-size: 14px;
            color: var(--text-light);
        }

        /* Stats Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-info h3 {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 8px;
            font-weight: 500;
        }

        .stat-info .number {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .stat-icon.blue {
            background: rgba(26, 115, 232, 0.1);
            color: var(--primary);
        }

        .stat-icon.green {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .stat-icon.orange {
            background: rgba(255, 152, 0, 0.1);
            color: var(--warning);
        }

        .stat-icon.red {
            background: rgba(244, 67, 54, 0.1);
            color: var(--danger);
        }

        /* Content Sections */
        .content-section {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: rgba(26, 115, 232, 0.1);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
            color: var(--text-light);
            font-size: 14px;
        }

        td {
            font-size: 14px;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status.pending {
            background: rgba(255, 152, 0, 0.1);
            color: var(--warning);
        }

        .status.approved {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .status.rejected {
            background: rgba(244, 67, 54, 0.1);
            color: var(--danger);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge.blue {
            background: rgba(26, 115, 232, 0.1);
            color: var(--primary);
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn.approve {
            color: var(--success);
        }

        .action-btn.approve:hover {
            background: rgba(76, 175, 80, 0.1);
        }

        .action-btn.reject {
            color: var(--danger);
        }

        .action-btn.reject:hover {
            background: rgba(244, 67, 54, 0.1);
        }

        /* Charts Section */
        .charts {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .chart-container {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: var(--shadow);
        }

        .chart-wrapper {
            height: 300px;
            position: relative;
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
            border-radius: 16px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            box-shadow: var(--shadow);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h3 {
            color: var(--primary-dark);
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-light);
        }

        .filter-options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-group label {
            font-weight: 500;
            color: var(--text);
        }

        .filter-group select, .filter-group input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: var(--success);
            color: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            display: none;
            z-index: 1001;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .charts {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                padding: 20px;
            }
            .menu {
                display: flex;
                overflow-x: auto;
                padding-bottom: 10px;
            }
            .menu-item {
                margin-bottom: 0;
                margin-right: 10px;
            }
            .menu-item a {
                white-space: nowrap;
            }
        }

        @media (max-width: 768px) {
            .stats-cards {
                grid-template-columns: 1fr 1fr;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            body {
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .stats-cards {
                grid-template-columns: 1fr;
            }
            .main-content {
                padding: 20px;
            }
        }
        /* Styles pour la section Paramètres */
.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.settings-card {
    background: var(--white);
    border-radius: 12px;
    padding: 25px;
    box-shadow: var(--shadow);
    border-left: 4px solid var(--primary);
}

.settings-card h4 {
    color: var(--primary-dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
}

.setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.setting-item:last-child {
    border-bottom: none;
}

.setting-item label {
    font-weight: 500;
    color: var(--text);
    font-size: 14px;
}

.setting-input {
    padding: 8px 12px;
    border: 2px solid #e9ecef;
    border-radius: 6px;
    font-family: 'Poppins', sans-serif;
    width: 120px;
    font-size: 14px;
}

.setting-input:focus {
    outline: none;
    border-color: var(--primary);
}

.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: var(--success);
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.settings-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}
/* Styles pour la section Utilisateurs */
.filters-bar {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    align-items: center;
}

.filter-group {
    display: flex;
    gap: 10px;
}

.filter-input, .filter-select {
    padding: 10px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    min-width: 200px;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: var(--primary);
}

.users-count {
    background: var(--primary-light);
    color: var(--primary-dark);
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 500;
    display: inline-block;
}

/* Responsive */
@media (max-width: 768px) {
    .filters-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-input, .filter-select {
        min-width: auto;
        width: 100%;
    }

    .action-buttons {
        flex-direction: column;
    }

    .action-btn {
        width: 32px;
        height: 32px;
    }
}
/* Styles pour la section Professeurs */
.teachers-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.stat-item {
    background: var(--white);
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: var(--shadow);
    border-left: 4px solid var(--primary);
}

.stat-number {
    font-size: 28px;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 5px;
}

.stat-number.verified {
    color: var(--success);
}

.stat-number.pending {
    color: var(--warning);
}

.stat-label {
    font-size: 12px;
    color: var(--text-light);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Amélioration des filtres */
.filters-bar {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    align-items: center;
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
}

.filter-group {
    display: flex;
    gap: 10px;
}

.filter-input, .filter-select {
    padding: 10px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    min-width: 180px;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: var(--primary);
}

/* Responsive */
@media (max-width: 1200px) {
    .teachers-stats {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .teachers-stats {
        grid-template-columns: 1fr;
    }

    .filters-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-input, .filter-select {
        min-width: auto;
        width: 100%;
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        min-width: 800px;
    }
}

/* Styles pour la section Étudiants */
.students-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.students-stats .stat-item {
    background: var(--white);
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: var(--shadow);
    border-left: 4px solid var(--primary);
}

.students-stats .stat-number {
    font-size: 28px;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 5px;
}

.students-stats .stat-number.active {
    color: var(--success);
}

.students-stats .stat-label {
    font-size: 12px;
    color: var(--text-light);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Amélioration des boutons d'action pour étudiants */
.action-buttons {
    display: flex;
    gap: 6px;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 12px;
}

.action-btn:hover {
    background: rgba(26, 115, 232, 0.1);
}

.action-btn.message-student {
    color: var(--primary);
}

.action-btn.message-student:hover {
    background: rgba(26, 115, 232, 0.1);
}

/* Responsive pour étudiants */
@media (max-width: 1200px) {
    .students-stats {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 992px) {
    .students-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .students-stats {
        grid-template-columns: 1fr;
    }

    .filters-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-input, .filter-select {
        min-width: auto;
        width: 100%;
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        min-width: 900px;
    }

    .action-buttons {
        flex-direction: column;
    }
}
/* Styles pour la section Cours */
.courses-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.courses-stats .stat-item {
    background: var(--white);
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: var(--shadow);
    border-left: 4px solid var(--primary);
}

.courses-stats .stat-number {
    font-size: 28px;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 5px;
}

.courses-stats .stat-number.active {
    color: var(--success);
}

.courses-stats .stat-number.revenue {
    color: var(--success);
}

.courses-stats .stat-label {
    font-size: 12px;
    color: var(--text-light);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Styles spécifiques pour les cours */
.course-info {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.course-title {
    font-weight: 600;
    color: var(--text);
    font-size: 14px;
}

.course-teacher {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--text-light);
}

.user-avatar-xs {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 10px;
}

/* Badges de niveau */
.level-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
}

.level-badge.débutant {
    background: rgba(76, 175, 80, 0.1);
    color: var(--success);
}

.level-badge.intermédiaire {
    background: rgba(255, 152, 0, 0.1);
    color: var(--warning);
}

.level-badge.avancé {
    background: rgba(244, 67, 54, 0.1);
    color: var(--danger);
}

/* Badges de type */
.badge.green {
    background: rgba(76, 175, 80, 0.1);
    color: var(--success);
}

.badge.orange {
    background: rgba(255, 152, 0, 0.1);
    color: var(--warning);
}

/* Compteur d'élèves */
.students-count {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
    color: var(--text);
}

.students-count i {
    color: var(--primary);
    font-size: 12px;
}

/* Notation */
.rating {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
    color: var(--warning);
}

.rating i {
    font-size: 12px;
}

/* Statut warning */
.status.warning {
    background: rgba(255, 152, 0, 0.1);
    color: var(--warning);
}

/* Responsive pour cours */
@media (max-width: 1200px) {
    .courses-stats {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 992px) {
    .courses-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .courses-stats {
        grid-template-columns: 1fr;
    }

    .filters-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-input, .filter-select {
        min-width: auto;
        width: 100%;
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        min-width: 1000px;
    }

    .action-buttons {
        flex-direction: column;
    }
}
/* Styles pour la section Réservations */
.bookings-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.bookings-stats .stat-item {
    background: var(--white);
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: var(--shadow);
    border-left: 4px solid var(--primary);
}

.bookings-stats .stat-number {
    font-size: 28px;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 5px;
}

.bookings-stats .stat-number.confirmed {
    color: var(--success);
}

.bookings-stats .stat-number.pending {
    color: var(--warning);
}

.bookings-stats .stat-number.revenue {
    color: var(--success);
}

.bookings-stats .stat-label {
    font-size: 12px;
    color: var(--text-light);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Styles spécifiques pour les réservations */
.booking-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.booking-users {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-pair {
    display: flex;
    gap: 4px;
}

.user-pair .user-avatar-xs {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 11px;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.user-pair .user-avatar-xs:last-child {
    background: var(--warning);
    margin-left: -8px;
}

.user-names {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.student-name {
    font-weight: 600;
    font-size: 13px;
    color: var(--text);
}

.teacher-name {
    font-size: 11px;
    color: var(--text-light);
}

.course-name {
    font-weight: 500;
    font-size: 13px;
    color: var(--text);
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.datetime-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.booking-date {
    font-weight: 600;
    font-size: 13px;
    color: var(--text);
}

.booking-time {
    font-size: 11px;
    color: var(--text-light);
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    display: inline-block;
}

/* Statut complété */
.status.completed {
    background: rgba(103, 58, 183, 0.1);
    color: #673ab7;
}

/* Badges de type */
.badge.blue {
    background: rgba(26, 115, 232, 0.1);
    color: var(--primary);
}

.badge.green {
    background: rgba(76, 175, 80, 0.1);
    color: var(--success);
}

.badge.orange {
    background: rgba(255, 152, 0, 0.1);
    color: var(--warning);
}

/* Actions spécifiques pour réservations */
.action-btn.complete-booking {
    color: #673ab7;
}

.action-btn.complete-booking:hover {
    background: rgba(103, 58, 183, 0.1);
}

.action-btn.cancel-booking-main {
    color: var(--danger);
}

.action-btn.cancel-booking-main:hover {
    background: rgba(244, 67, 54, 0.1);
}

/* Responsive pour réservations */
@media (max-width: 1200px) {
    .bookings-stats {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 992px) {
    .bookings-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .bookings-stats {
        grid-template-columns: 1fr;
    }

    .filters-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-input, .filter-select {
        min-width: auto;
        width: 100%;
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        min-width: 1000px;
    }

    .action-buttons {
        flex-direction: column;
        gap: 4px;
    }

    .booking-users {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}
    </style>
</head>


<main class="main">

    @yield('content')

</main>




</html>
