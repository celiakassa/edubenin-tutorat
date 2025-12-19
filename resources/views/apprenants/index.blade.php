@extends('layouts.adminLayout')

<style>
    /* Styles améliorés avec plus de couleurs */
    html,
    body {
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .main-content {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .container,
    .container-fluid {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }



    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #ffffff 0%, #e4edf5 100%);
        min-height: 100vh;
    }

    .admin-container {
        display: flex;
        margin: 0;
        padding: 0;
        width: 100%;
        min-height: 100vh;
    }

    /* Stats Cards - Version colorée */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        border: none;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
    }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-card.total {
        --card-color: #4361ee;
        --card-color-light: #4895ef;
    }

    .stat-card.complete {
        --card-color: #06d6a0;
        --card-color-light: #4cc9f0;
    }

    .stat-card.validated {
        --card-color: #7209b7;
        --card-color-light: #b5179e;
    }

    .stat-card.active {
        --card-color: #f3722c;
        --card-color-light: #f8961e;
    }

    .stat-card.inscriptions {
        --card-color: #3a86ff;
        --card-color-light: #8338ec;
    }

    .stat-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        z-index: 2;
    }

    .stat-info h3 {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-number {
        font-size: 42px;
        font-weight: 800;
        background: linear-gradient(135deg, var(--card-color), var(--card-color-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin: 15px 0;
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        background: linear-gradient(135deg, var(--card-color), var(--card-color-light));
        color: white;
        box-shadow: 0 8px 20px rgba(var(--card-color-rgb), 0.3);
        transition: transform 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .progress-bar-container {
        margin-top: 20px;
        position: relative;
    }

    .progress-bar {
        width: 100%;
        height: 12px;
        background: linear-gradient(90deg, #e2e8f0, #cbd5e1);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
        box-shadow: 0 2px 10px rgba(var(--card-color-rgb), 0.4);
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.6),
                transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .progress-text {
        display: flex;
        justify-content: space-between;
        margin-top: 8px;
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }

    /* Mini badges colorés */
    .mini-badges {
        display: flex;
        gap: 8px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .mini-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .mini-badge:hover {
        transform: translateY(-2px);
    }

    .mini-badge.active {
        background: linear-gradient(135deg, #06d6a0, #4cc9f0);
        color: white;
    }

    .mini-badge.inactive {
        background: linear-gradient(135deg, #ef476f, #ff6b6b);
        color: white;
    }

    .mini-badge.validated {
        background: linear-gradient(135deg, #7209b7, #b5179e);
        color: white;
    }

    .mini-badge.pending {
        background: linear-gradient(135deg, #f3722c, #f8961e);
        color: white;
    }

    /* Charts Section améliorée */
    .charts-section {
        background: white;
        border-radius: 25px;
        padding: 30px;
        margin-bottom: 40px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .charts-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #4361ee, #7209b7, #06d6a0, #f3722c);
    }

    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 35px;
        margin-top: 25px;
    }

    .chart-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 20px;
        padding: 25px;
        position: relative;
        height: 350px;
        border: 1px solid #e2e8f0;
        transition: transform 0.3s ease;
    }

    .chart-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Content Section améliorée */
    .content-section {
        background: white;
        border-radius: 25px;
        padding: 30px;
        margin-bottom: 40px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .content-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #3a86ff, #8338ec);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
        position: relative;
    }

    .section-header h3 {
        font-size: 22px;
        color: #1e293b;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-header h3 i {
        font-size: 26px;
        background: linear-gradient(135deg, #3a86ff, #8338ec);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    /* Buttons améliorés */
    .btn {
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3a86ff, #8338ec);
        color: white;
        box-shadow: 0 8px 20px rgba(58, 134, 255, 0.4);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2a76ef, #7328dc);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 12px 25px rgba(58, 134, 255, 0.5);
    }

    .btn-outline {
        background: transparent;
        color: #3a86ff;
        border: 2px solid #3a86ff;
        position: relative;
        z-index: 1;
    }

    .btn-outline::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #3a86ff, #8338ec);
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 10px;
    }

    .btn-outline:hover {
        color: white;
        border-color: transparent;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(58, 134, 255, 0.3);
    }

    .btn-outline:hover::after {
        opacity: 1;
    }

    /* Search box stylisé */
    .search-box {
        position: relative;
    }

    .search-box input {
        padding: 12px 20px 12px 45px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        width: 300px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .search-box input:focus {
        outline: none;
        border-color: #3a86ff;
        box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.1);
        background: white;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }

    /* Table Styles améliorés */
    .table-container {
        overflow-x: auto;
        border-radius: 18px;
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        padding: 5px;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1100px;
    }

    thead {
        background: linear-gradient(135deg, #3a86ff, #8338ec);
    }

    th {
        padding: 20px 25px;
        text-align: left;
        font-weight: 700;
        color: white;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    th:last-child {
        border-right: none;
    }

    th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 25px;
        right: 25px;
        height: 3px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    td {
        padding: 18px 25px;
        border-bottom: 2px solid #f1f5f9;
        vertical-align: middle;
        background: white;
        transition: all 0.3s ease;
    }

    tbody tr {
        transition: all 0.3s ease;
    }

    tbody tr:hover {
        transform: translateX(10px);
    }

    tbody tr:hover td {
        background: linear-gradient(90deg, rgba(58, 134, 255, 0.05), rgba(131, 56, 236, 0.05));
        box-shadow: 5px 0 15px rgba(58, 134, 255, 0.1);
    }

    /* User Cell amélioré */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar-small {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3a86ff, #8338ec);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        position: relative;
        overflow: hidden;
        border: 3px solid white;
        box-shadow: 0 4px 15px rgba(58, 134, 255, 0.3);
    }

    .user-avatar-small::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s;
    }

    .user-cell:hover .user-avatar-small::before {
        transform: translateX(100%);
    }

    .user-info-text h4 {
        font-size: 16px;
        color: #1e293b;
        margin-bottom: 4px;
        font-weight: 700;
    }

    .user-info-text p {
        font-size: 13px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Badges améliorés */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.5px;
        margin: 3px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        gap: 6px;
    }

    .badge:hover {
        transform: translateY(-2px) scale(1.05);
    }

    .badge.active {
        background: linear-gradient(135deg, #06d6a0, #4cc9f0);
        color: white;
    }

    .badge.inactive {
        background: linear-gradient(135deg, #ef476f, #ff6b6b);
        color: white;
    }

    .badge.validated {
        background: linear-gradient(135deg, #7209b7, #b5179e);
        color: white;
    }

    .badge.pending {
        background: linear-gradient(135deg, #f3722c, #f8961e);
        color: white;
    }

    .badge.city {
        background: linear-gradient(135deg, #3a86ff, #8338ec);
        color: white;
    }

    /* Action Buttons améliorés */
    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-size: 15px;
        position: relative;
        overflow: hidden;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.2);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .action-btn:hover::before {
        opacity: 1;
    }

    .action-btn.view {
        background: linear-gradient(135deg, #3a86ff, #4895ef);
        color: white;
        box-shadow: 0 4px 15px rgba(58, 134, 255, 0.3);
    }

    .action-btn.view:hover {
        transform: translateY(-3px) rotate(5deg);
        background: linear-gradient(135deg, #3a86ff, #4895ef);
        box-shadow: 0 8px 20px rgba(58, 134, 255, 0.4);
    }

    .action-btn.edit {
        background: linear-gradient(135deg, #f3722c, #f8961e);
        color: white;
        box-shadow: 0 4px 15px rgba(243, 114, 44, 0.3);
    }

    .action-btn.edit:hover {
        transform: translateY(-3px) rotate(5deg);
        box-shadow: 0 8px 20px rgba(243, 114, 44, 0.4);
    }

    .action-btn.validate {
        background: linear-gradient(135deg, #06d6a0, #4cc9f0);
        color: white;
        box-shadow: 0 4px 15px rgba(6, 214, 160, 0.3);
    }

    .action-btn.validate:hover {
        transform: translateY(-3px) rotate(5deg);
        box-shadow: 0 8px 20px rgba(6, 214, 160, 0.4);
    }



    .action-btn.delete {
        background: linear-gradient(135deg, #ef476f, #ff6b6b);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 71, 111, 0.3);
    }

    .action-btn.delete:hover {
        transform: translateY(-3px) rotate(5deg);
        box-shadow: 0 8px 20px rgba(239, 71, 111, 0.4);
    }

    /* Pagination améliorée */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding: 20px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 18px;
        border: 2px solid #e2e8f0;
    }

    .pagination-info {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pagination-info i {
        color: #3a86ff;
        font-size: 18px;
    }

    .pagination-links {
        display: flex;
        gap: 8px;
    }

    .page-link {
        padding: 10px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        color: #3a86ff;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        background: white;
    }

    .page-link:hover {
        background: linear-gradient(135deg, #3a86ff, #8338ec);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(58, 134, 255, 0.3);
    }

    .page-link.active {
        background: linear-gradient(135deg, #3a86ff, #8338ec);
        color: white;
        border-color: transparent;
        box-shadow: 0 6px 15px rgba(58, 134, 255, 0.3);
    }

    /* Empty State amélioré */
    .empty-state {
        text-align: center;
        padding: 60px 40px;
        color: #64748b;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 20px;
        margin: 20px;
    }

    .empty-state i {
        font-size: 64px;
        background: linear-gradient(135deg, #3a86ff, #8338ec);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h4 {
        font-size: 22px;
        margin-bottom: 15px;
        color: #1e293b;
        font-weight: 800;
    }

    .empty-state p {
        font-size: 16px;
        margin-bottom: 25px;
        color: #64748b;
        max-width: 400px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }

    /* Notification améliorée */
    .notification {
        position: fixed;
        top: 30px;
        right: 30px;
        background: linear-gradient(135deg, #06d6a0, #4cc9f0);
        color: white;
        padding: 20px 30px;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(6, 214, 160, 0.3);
        display: none;
        z-index: 1001;
        max-width: 450px;
        animation: slideIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border-left: 5px solid rgba(255, 255, 255, 0.5);
    }

    .notification.error {
        background: linear-gradient(135deg, #ef476f, #ff6b6b);
        box-shadow: 0 15px 35px rgba(239, 71, 111, 0.3);
    }

    .notification.warning {
        background: linear-gradient(135deg, #f3722c, #f8961e);
        box-shadow: 0 15px 35px rgba(243, 114, 44, 0.3);
    }

    .notification.info {
        background: linear-gradient(135deg, #3a86ff, #8338ec);
        box-shadow: 0 15px 35px rgba(58, 134, 255, 0.3);
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%) translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateX(0) translateY(0);
            opacity: 1;
        }
    }

    /* Responsive amélioré */
    @media (max-width: 1200px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-cards {
            grid-template-columns: 1fr;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .section-actions {
            width: 100%;
            flex-direction: column;
        }

        .search-box input {
            width: 100%;
        }

        .pagination-container {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }
    }

    /* Animation d'entrée */
    .fade-in {
        animation: fadeInUp 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        opacity: 0;
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

    .delay-1 {
        animation-delay: 0.1s;
    }

    .delay-2 {
        animation-delay: 0.2s;
    }

    .delay-3 {
        animation-delay: 0.3s;
    }

    .delay-4 {
        animation-delay: 0.4s;
    }

    .delay-5 {
        animation-delay: 0.5s;
    }
</style>

@section('content')
    <div class="admin-container">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h2>
                    <i class="fas fa-user-graduate"
                        style="background: linear-gradient(135deg, #3a86ff, #8338ec); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    <span
                        style="background: linear-gradient(135deg, #1e293b, #3a86ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Dashboard Apprenants
                    </span>
                </h2>


                <style>
                    .header-actions {
                        display: flex;
                        gap: 12px;
                        align-items: center;
                    }

                    .btn-action {
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        padding: 10px 16px;
                        border-radius: 10px;
                        font-weight: 600;
                        text-decoration: none;
                        color: #fff;
                        transition: all 0.25s ease;
                    }

                    /* Vert moderne */
                    .btn-success {
                        background: linear-gradient(135deg, #16a34a, #22c55e);
                    }

                    .btn-success:hover {
                        background: linear-gradient(135deg, #15803d, #16a34a);
                    }

                    /* Optionnel : hover global */
                    .btn-action:hover {
                        transform: translateY(-2px);
                    }
                </style>

                <div class="header-actions">

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-success btn-action">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>


                </div>

            </div>


            <style>
                /* ====== CONTENEUR GLOBAL ====== */
                #stats-cards {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                    gap: 20px;
                    width: 100%;
                    margin: 20px 0;
                }

                /* ====== CARTE ====== */
                #stats-cards .stat-card {
                    background: #ffffff;
                    border-radius: 14px;
                    padding: 20px;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
                    position: relative;
                    overflow: hidden;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }

                #stats-cards .stat-card:hover {
                    transform: translateY(-6px);
                    box-shadow: 0 16px 35px rgba(0, 0, 0, 0.12);
                }

                /* ====== HEADER INFO ====== */
                #stats-cards .stat-info {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 15px;
                }

                #stats-cards h3 {
                    font-size: 13px;
                    font-weight: 700;
                    letter-spacing: 0.5px;
                    color: #555;
                    margin-bottom: 8px;
                }

                /* ====== CHIFFRE ====== */
                #stats-cards .stat-number {
                    font-size: 34px;
                    font-weight: 800;
                    color: #111;
                }

                /* ====== ICÔNE ====== */
                #stats-cards .stat-icon {
                    font-size: 42px;
                    opacity: 0.15;
                }

                /* ====== BARRE DE PROGRESSION ====== */
                #stats-cards .progress-bar-container {
                    margin-top: 15px;
                }

                #stats-cards .progress-bar {
                    height: 8px;
                    background: #eaeef3;
                    border-radius: 10px;
                    overflow: hidden;
                }

                #stats-cards .progress-fill {
                    height: 100%;
                    border-radius: 10px;
                }

                #stats-cards .progress-text {
                    display: flex;
                    justify-content: space-between;
                    font-size: 12px;
                    margin-top: 5px;
                    color: #666;
                }

                /* ====== MINI BADGES ====== */
                #stats-cards .mini-badges {
                    display: flex;
                    gap: 8px;
                    margin-top: 15px;
                    flex-wrap: wrap;
                }

                #stats-cards .mini-badge {
                    font-size: 11px;
                    padding: 6px 10px;
                    border-radius: 20px;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                /* ====== COULEURS PAR TYPE ====== */
                #stats-cards .total {
                    border-left: 5px solid #4f46e5;
                }

                #stats-cards .total .progress-fill {
                    background: linear-gradient(90deg, #4f46e5, #6366f1);
                }

                #stats-cards .complete {
                    border-left: 5px solid #16a34a;
                }

                #stats-cards .complete .progress-fill {
                    background: linear-gradient(90deg, #16a34a, #22c55e);
                }

                #stats-cards .validated {
                    border-left: 5px solid #f59e0b;
                }

                #stats-cards .validated .progress-fill {
                    background: linear-gradient(90deg, #f59e0b, #fbbf24);
                }

                #stats-cards .active {
                    border-left: 5px solid #0ea5e9;
                }

                #stats-cards .active .progress-fill {
                    background: linear-gradient(90deg, #0ea5e9, #38bdf8);
                }

                /* ====== BADGES COULEURS ====== */
                #stats-cards .mini-badge.active {
                    background: #e0f2fe;
                    color: #0369a1;
                }

                #stats-cards .mini-badge.inactive {
                    background: #fee2e2;
                    color: #991b1b;
                }

                #stats-cards .mini-badge.validated {
                    background: #dcfce7;
                    color: #166534;
                }

                #stats-cards .mini-badge.pending {
                    background: #fef3c7;
                    color: #92400e;
                }

                #stats-cards .mini-badge.city {
                    background: #ede9fe;
                    color: #5b21b6;
                }
            </style>


            <!-- Stats Cards avec animations -->
            <div class="stats-cards" id="stats-cards">

                <!-- Carte 1 : Total Apprenants -->
                <div class="stat-card total fade-in">
                    <div class="stat-info">
                        <div style="flex: 1;">
                            <h3><i class="fas fa-users me-2"></i>TOTAL APPRENANTS</h3>
                            <div class="stat-number">{{ $stats['total'] }}</div>
                            <div class="progress-bar-container">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 100%"></div>
                                </div>
                                <div class="progress-text">
                                    <span>Tous les apprenants</span>
                                    <span>100%</span>
                                </div>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                    <div class="mini-badges">
                        <span class="mini-badge active">
                            <i class="fas fa-check-circle"></i> {{ $stats['actifs'] }} Actifs
                        </span>
                        <span class="mini-badge inactive">
                            <i class="fas fa-ban"></i> {{ $stats['inactifs'] }} Inactifs
                        </span>
                    </div>
                </div>

                <!-- Carte 2 : Profils Complets -->
                <div class="stat-card complete fade-in delay-1">
                    <div class="stat-info">
                        <div style="flex: 1;">
                            <h3><i class="fas fa-check-double me-2"></i>PROFILS COMPLETS</h3>
                            <div class="stat-number">{{ $stats['avecProfilComplet'] }}</div>
                            <div class="progress-bar-container">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $stats['pourcentageProfilComplet'] }}%">
                                    </div>
                                </div>
                                <div class="progress-text">
                                    <span>Taux de complétion</span>
                                    <span>{{ $stats['pourcentageProfilComplet'] }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                    <div class="mini-badges">
                        <span class="mini-badge validated">
                            <i class="fas fa-star"></i> {{ $stats['avecProfilComplet'] }} Complets
                        </span>
                        <span class="mini-badge pending">
                            <i class="fas fa-clock"></i> {{ $stats['total'] - $stats['avecProfilComplet'] }} Incomplets
                        </span>
                    </div>
                </div>

                {{--   <!-- Carte 3 : Apprenants Validés -->
                <div class="stat-card validated fade-in delay-2">
                    <div class="stat-info">
                        <div style="flex: 1;">
                            <h3><i class="fas fa-award me-2"></i>APPRENANTS VALIDÉS</h3>
                            <div class="stat-number">{{ $stats['valides'] }}</div>
                            <div class="progress-bar-container">
                                @php
                                    $validationRate =
                                        $stats['total'] > 0 ? round(($stats['valides'] / $stats['total']) * 100) : 0;
                                @endphp
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $validationRate }}%"></div>
                                </div>
                                <div class="progress-text">
                                    <span>Taux de validation</span>
                                    <span>{{ $validationRate }}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                    </div>
                    <div class="mini-badges">
                        <span class="mini-badge validated">
                            <i class="fas fa-check-circle"></i> {{ $stats['valides'] }} Validés
                        </span>
                        <span class="mini-badge pending">
                            <i class="fas fa-hourglass-half"></i> {{ $stats['nonValides'] }} En attente
                        </span>
                    </div>
                </div>   --}}

                <!-- Carte 4 : Inscriptions -->
                <div class="stat-card active fade-in delay-3">
                    <div class="stat-info">
                        <div style="flex: 1;">
                            <h3><i class="fas fa-chart-line me-2"></i>INSCRIPTIONS (6 MOIS)</h3>
                            <div class="stat-number">{{ array_sum($stats['inscriptionsParMois']) }}</div>
                            <div class="progress-bar-container">
                                @php
                                    $maxMonthly = max($stats['inscriptionsParMois']);
                                    $currentMonth = end($stats['inscriptionsParMois']);
                                    $currentMonthPercentage =
                                        $maxMonthly > 0 ? round(($currentMonth / $maxMonthly) * 100) : 0;
                                @endphp
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $currentMonthPercentage }}%"></div>
                                </div>
                                <div class="progress-text">
                                    <span>Ce mois-ci</span>
                                    <span>+{{ $currentMonth }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-signal"></i>
                        </div>
                    </div>
                    <div class="mini-badges">
                        <span class="mini-badge active">
                            <i class="fas fa-arrow-up"></i> +{{ $currentMonth }} ce mois
                        </span>
                        <span class="mini-badge city">
                            <i class="fas fa-calendar"></i> 6 mois
                        </span>
                    </div>
                </div>
            </div>

            <!-- Graphiques Statistiques -->

            <style>
                .charts-row {
                    display: flex;
                    gap: 20px;
                    margin-bottom: 25px;
                }

                /* Par défaut : 50% */
                .chart-container {
                    flex: 0 0 50%;
                    max-width: 50%;
                    background: #fff;
                    padding: 15px;
                    border-radius: 10px;
                }

                /* Ligne pleine largeur */
                #chart2 {
                    display: flex;
                    width: 100%;
                }

                /* Graphique pleine largeur */
                #chart22 {
                    flex: 0 0 100% !important;
                    max-width: 100% !important;
                    width: 100% !important;
                }


                /* Responsive (mobile) */
                @media (max-width: 768px) {
                    .charts-row {
                        flex-direction: column;
                    }

                    .chart-container {
                        max-width: 100%;
                    }
                }
            </style>

            <div class="charts-section fade-in delay-4">

                <div class="section-header">
                    <h3><i class="fas fa-chart-pie"></i> ANALYSE DES APPRENANTS</h3>
                    <div class="section-actions">

                    </div>
                </div>

                <!-- Ligne 1 : Graphique 1 & 3 -->
                <div class="charts-row">

                    <!-- Graphique 2 : Répartition par ville -->
                    <div class="chart-container">
                        <canvas id="villeChart"></canvas>
                    </div>
                    <!-- Graphique 3 : Statut des apprenants -->
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Ligne 2 : Graphique 2 & 4 -->
                <div class="charts-row" id="chart2">



                    <!-- Graphique 1 : Inscriptions mensuelles -->
                    <div class="chart-container" id="chart22">
                        <canvas id="inscriptionsChart"></canvas>
                    </div>

                </div>

            </div>


            <!-- Liste des Apprenants -->
            <div class="content-section fade-in delay-5">
                <div class="section-header">
                    <h3>
                        <i class="fas fa-list-check"></i>
                        LISTE DES APPRENANTS
                    </h3>
                    <div class="section-actions">
                        <div class="search-box">
                            <input type="text" id="searchInput" placeholder="Rechercher un apprenant..."
                                autocomplete="off">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>

                    <script>
                        document.getElementById('searchInput').addEventListener('keyup', function() {
                            const value = this.value.toLowerCase();
                            const rows = document.querySelectorAll('#apprenantsTable tbody tr');

                            rows.forEach(row => {
                                const text = row.textContent.toLowerCase();
                                row.style.display = text.includes(value) ? '' : 'none';
                            });
                        });
                    </script>


                </div>

                <div class="table-container">
                    <table id="apprenantsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>APPRENANT</th>
                                <th>CONTACT</th>
                                <th>LOCALISATION</th>
                                <th>PROFIL</th>
                                <th>STATUT</th>
                                <th>INSCRIPTION</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($apprenants as $apprenant)
                                @php
                                    $profileCompletion = $apprenant->profile_completion ?? 0;
                                    $completionClass =
                                        $profileCompletion >= 80
                                            ? 'high'
                                            : ($profileCompletion >= 50
                                                ? 'medium'
                                                : 'low');
                                @endphp
                                <tr data-name="{{ strtolower($apprenant->firstname . ' ' . $apprenant->lastname) }}"
                                    data-email="{{ strtolower($apprenant->email) }}"
                                    data-city="{{ strtolower($apprenant->city) }}">
                                    <td>
                                        <strong
                                            style="background: linear-gradient(135deg, #3a86ff, #8338ec); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                            #{{ $apprenant->id }}
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar-small">
                                                @if ($apprenant->photo_path)
                                                    <img src="{{ asset('storage/' . $apprenant->photo_path) }}"
                                                        alt="{{ $apprenant->firstname }}"
                                                        style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                                @else
                                                    {{ strtoupper(substr($apprenant->firstname, 0, 1) . substr($apprenant->lastname, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div class="user-info-text">
                                                <h4>{{ $apprenant->firstname }} {{ $apprenant->lastname }}</h4>
                                                <p>
                                                    <i class="fas fa-phone"></i>
                                                    {{ $apprenant->telephone ?? 'Non renseigné' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 5px;">
                                            <span style="font-weight: 600; color: #1e293b;">
                                                <i class="fas fa-envelope" style="color: #3a86ff;"></i>
                                                {{ $apprenant->email }}
                                            </span>
                                            @if ($apprenant->telephone)
                                                <span style="font-size: 12px; color: #64748b;">
                                                    <i class="fas fa-phone" style="color: #06d6a0;"></i>
                                                    {{ $apprenant->telephone }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge city">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $apprenant->city ?? 'Non spécifiée' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 8px;">
                                            <div class="progress-bar" style="height: 10px;">
                                                <div class="progress-fill {{ $completionClass }}"
                                                    style="width: {{ $profileCompletion }}%"></div>
                                            </div>
                                            <div
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <small style="color: #64748b; font-weight: 600;">
                                                    <i class="fas fa-chart-line"></i> {{ $profileCompletion }}%
                                                </small>
                                                @if ($profileCompletion == 100)
                                                    <i class="fas fa-crown" style="color: #f8961e;"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 5px;">
                                            @if ($apprenant->is_active)
                                                <span class="badge active">
                                                    <i class="fas fa-power-off"></i> Actif
                                                </span>
                                            @else
                                                <span class="badge inactive">
                                                    <i class="fas fa-power-off"></i> Inactif
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 3px;">
                                            <span style="font-weight: 700; color: #1e293b;">
                                                {{ $apprenant->created_at->format('d/m/Y') }}
                                            </span>
                                            <small style="color: #64748b; display: flex; align-items: center; gap: 5px;">
                                                <i class="far fa-clock" style="color: #3a86ff;"></i>
                                                {{ $apprenant->created_at->format('H:i') }}
                                            </small>
                                            @if ($apprenant->created_at->diffInDays(now()) < 7)
                                                <span style="font-size: 11px; color: #06d6a0; font-weight: 700;">
                                                    <i class="fas fa-bolt"></i> Nouveau
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('apprenants.show', $apprenant->id) }}"
                                                class="action-btn view" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            {{-- Lien de mise a jour du compte --}}
                                            {{--  <a href="{{ route('apprenants.edit', $apprenant->id) }}"
                                                class="action-btn edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>  --}}
                                            <form action="{{ route('apprenants.toggle-status', $apprenant->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" id="toggle-btn-{{ $apprenant->id }}"
                                                    class="action-btn toggle"
                                                    title="{{ $apprenant->is_active ? 'Désactiver' : 'Activer' }}"
                                                    style="
            background-color: {{ $apprenant->is_active ? '#28a745' : '#dc3545' }} !important;
            color: #ffffff !important;
            border: none;
            border-radius: 6px;
            padding: 6px 10px;
            cursor: pointer;
        ">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            </form>


                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-user-graduate"></i>
                                            <h4>Aucun apprenant trouvé</h4>
                                            <p>Commencez par ajouter un nouvel apprenant à votre plateforme</p>
                                            <a href="{{ route('apprenants.create') }}" class="btn btn-primary"
                                                style="margin-top: 15px;">
                                                <i class="fas fa-user-plus"></i> Ajouter un Apprenant
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($apprenants->hasPages())
                    <div class="pagination-container">
                        <div class="pagination-info">
                            <i class="fas fa-info-circle"></i>
                            Affichage de {{ $apprenants->firstItem() }} à {{ $apprenants->lastItem() }}
                            sur {{ $apprenants->total() }} apprenants
                        </div>
                        <div class="pagination-links">
                            {{ $apprenants->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div id="notification" class="notification"></div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation des graphiques
            initializeCharts();

            // Recherche en temps réel
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#apprenantsTable tbody tr');

                    rows.forEach(row => {
                        const name = row.getAttribute('data-name');
                        const email = row.getAttribute('data-email');
                        const city = row.getAttribute('data-city');

                        if (name.includes(searchTerm) || email.includes(searchTerm) || city
                            .includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Fonction pour afficher les notifications
            function showNotification(message, type = 'info') {
                const notification = document.getElementById('notification');
                notification.textContent = message;
                notification.className = `notification ${type}`;

                notification.style.display = 'block';

                setTimeout(() => {
                    notification.style.display = 'none';
                }, 5000);
            }

            // Fonction pour confirmer la suppression
            window.confirmDelete = function() {
                return confirm(
                    'Êtes-vous sûr de vouloir supprimer cet apprenant ? Cette action est irréversible.');
            }

            // Fonctions d'export
            window.exportToExcel = function() {
                showNotification('Export Excel en cours de préparation...', 'info');
            }

            window.exportToPDF = function() {
                showNotification('Export PDF en cours de préparation...', 'info');
            }

            window.refreshCharts = function() {
                initializeCharts();
                showNotification('Graphiques actualisés !', 'info');
            }

            // Fonction pour initialiser les graphiques
            function initializeCharts() {
                // Données du contrôleur
                const inscriptionsLabels = {!! json_encode(array_keys($stats['inscriptionsParMois'])) !!};
                const inscriptionsData = {!! json_encode(array_values($stats['inscriptionsParMois'])) !!};

                const villeLabels = {!! json_encode(array_keys($stats['parVille'])) !!};
                const villeData = {!! json_encode(array_values($stats['parVille'])) !!};

                // Palette de couleurs
                const colors = {
                    primary: '#3a86ff',
                    secondary: '#8338ec',
                    success: '#06d6a0',
                    warning: '#f8961e',
                    danger: '#ef476f',
                    info: '#4cc9f0',
                    purple: '#b5179e',
                    dark: '#1e293b'
                };

                // Graphique 1 : Inscriptions mensuelles
                const ctx1 = document.getElementById('inscriptionsChart').getContext('2d');
                const gradient1 = ctx1.createLinearGradient(0, 0, 0, 400);
                gradient1.addColorStop(0, 'rgba(58, 134, 255, 0.8)');
                gradient1.addColorStop(1, 'rgba(58, 134, 255, 0.1)');

                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: inscriptionsLabels,
                        datasets: [{
                            label: 'Inscriptions',
                            data: inscriptionsData,
                            backgroundColor: gradient1,
                            borderColor: colors.primary,
                            borderWidth: 4,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: colors.primary,
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 3,
                            pointRadius: 8,
                            pointHoverRadius: 12,
                            pointHoverBackgroundColor: colors.secondary,
                            pointHoverBorderColor: '#ffffff',
                            pointHoverBorderWidth: 3
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
                                text: 'ÉVOLUTION DES INSCRIPTIONS',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                color: colors.dark,
                                padding: {
                                    bottom: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(30, 41, 59, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: colors.primary,
                                borderWidth: 2,
                                cornerRadius: 10,
                                padding: 12,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.8)'
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    color: colors.dark,
                                    stepSize: 1
                                },
                                border: {
                                    display: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    color: colors.dark
                                },
                                border: {
                                    display: false
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        animations: {
                            tension: {
                                duration: 1000,
                                easing: 'linear'
                            }
                        }
                    }
                });

                // Graphique 2 : Répartition par ville
                const ctx2 = document.getElementById('villeChart').getContext('2d');
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: villeLabels,
                        datasets: [{
                            data: villeData,
                            backgroundColor: [
                                colors.primary,
                                colors.secondary,
                                colors.success,
                                colors.warning,
                                colors.info,
                                colors.purple,
                                colors.danger
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 3,
                            hoverOffset: 20,
                            hoverBorderColor: colors.dark,
                            hoverBorderWidth: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    color: colors.dark
                                }
                            },
                            title: {
                                display: true,
                                text: 'RÉPARTITION PAR VILLE',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                color: colors.dark,
                                padding: {
                                    bottom: 20
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
                        },
                        cutout: '65%',
                        rotation: -90,
                        circumference: 360,
                        animation: {
                            animateRotate: true,
                            animateScale: true
                        }
                    }
                });

                // Graphique 3 : Statut des apprenants
                // Graphique : Statut des apprenants (Actifs / Inactifs)
                const ctx3 = document.getElementById('statusChart').getContext('2d');

                new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: ['Actifs', 'Inactifs'],
                        datasets: [{
                            label: 'Apprenants',
                            data: [
                                {{ $stats['actifs'] }},
                                {{ $stats['inactifs'] }}
                            ],
                            backgroundColor: [
                                colors.success,
                                colors.danger
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            borderRadius: 10,
                            borderSkipped: false,
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
                                text: 'STATUT DES APPRENANTS',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                color: colors.dark,
                                padding: {
                                    bottom: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(30, 41, 59, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: colors.primary,
                                borderWidth: 2,
                                cornerRadius: 10,
                                padding: 12
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.8)'
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    color: colors.dark,
                                    stepSize: 1
                                },
                                border: {
                                    display: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    color: colors.dark
                                },
                                border: {
                                    display: false
                                }
                            }
                        }
                    }
                });


                // Graphique 4 : Évolution des validations
                const ctx4 = document.getElementById('validationChart').getContext('2d');
                const gradient4 = ctx4.createLinearGradient(0, 0, 0, 400);
                gradient4.addColorStop(0, 'rgba(114, 9, 183, 0.8)');
                gradient4.addColorStop(1, 'rgba(114, 9, 183, 0.1)');

                // Données fictives pour l'évolution
                const validationLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'];
                const validationData = [3, 5, 8, 12, 15, 18];

                new Chart(ctx4, {
                    type: 'radar',
                    data: {
                        labels: validationLabels,
                        datasets: [{
                            label: 'Validations',
                            data: validationData,
                            backgroundColor: gradient4,
                            borderColor: colors.secondary,
                            borderWidth: 3,
                            pointBackgroundColor: colors.secondary,
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 3,
                            pointRadius: 6,
                            pointHoverRadius: 10
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
                                text: 'ÉVOLUTION DES VALIDATIONS',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                color: colors.dark,
                                padding: {
                                    bottom: 20
                                }
                            }
                        },
                        scales: {
                            r: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.8)'
                                },
                                ticks: {
                                    display: false
                                },
                                pointLabels: {
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    color: colors.dark
                                }
                            }
                        }
                    }
                });
            }

            // Afficher les messages de session
            @if (session('success'))
                showNotification('{{ session('success') }}', 'info');
            @endif

            @if (session('error'))
                showNotification('{{ session('error') }}', 'error');
            @endif

            // Animation d'entrée
            document.querySelectorAll('.fade-in').forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
@endsection
