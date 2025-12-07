<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Professeur - Admin Kopiao</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        /* Header */
        .admin-header {
            background: linear-gradient(135deg, #1E63C4, #2a7cd6);
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .back-btn:hover {
            transform: translateX(-3px);
        }

        .header-left h1 {
            font-size: 24px;
            font-weight: 700;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-avatar {
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

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Teacher Header */
        .teacher-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            border-left: 5px solid #1E63C4;
        }

        .teacher-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #1E63C4;
            box-shadow: 0 8px 25px rgba(30, 99, 196, 0.2);
        }

        .teacher-info {
            flex: 1;
        }

        .teacher-name {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .teacher-email {
            color: #7f8c8d;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .teacher-stats {
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 10px;
        }

        .status-badge.pending {
            background: rgba(243, 156, 18, 0.1);
            color: #f39c12;
        }

        .status-badge.verified {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
        }

        /* Progress Bar */
        .progress-container {
            margin-top: 20px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .progress-label span {
            font-size: 14px;
            color: #2c3e50;
            font-weight: 600;
        }

        .progress-bar {
            width: 100%;
            height: 12px;
            background: #ecf0f1;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 6px;
            background: linear-gradient(90deg, #2ecc71, #27ae60);
            transition: width 0.5s ease;
        }

        /* Sections Grid */
        .sections-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        @media (max-width: 1100px) {
            .sections-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f3f8;
        }

        .card-header i {
            font-size: 20px;
            color: #1E63C4;
            margin-right: 12px;
        }

        .card-header h3 {
            font-size: 18px;
            color: #2c3e50;
            font-weight: 700;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .info-item {
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
            border-left: 4px solid #1E63C4;
        }

        .info-label {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 600;
        }

        .info-value.empty {
            color: #95a5a6;
            font-style: italic;
        }

        /* Bio Section */
        .bio-content {
            padding: 20px;
            background: #f8fafc;
            border-radius: 10px;
            line-height: 1.6;
            color: #2c3e50;
        }

        /* Subjects */
        .subjects-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .subject-tag {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Identity Document */
        .document-section {
            text-align: center;
            padding: 20px;
            border: 2px dashed #ddd;
            border-radius: 10px;
            margin-top: 20px;
            transition: border-color 0.3s ease;
        }

        .document-section:hover {
            border-color: #1E63C4;
        }

        .document-icon {
            font-size: 48px;
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .document-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1E63C4, #2a7cd6);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1953a8, #1E63C4);
            transform: translateY(-2px);
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

        .btn-outline {
            background: white;
            color: #1E63C4;
            border: 2px solid #1E63C4;
        }

        .btn-outline:hover {
            background: #f8fafc;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        /* Action Bar */
        .action-bar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Modals */
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

        /* Responsive */
        @media (max-width: 768px) {
            .teacher-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .teacher-stats {
                flex-wrap: wrap;
                justify-content: center;
            }

            .action-bar {
                flex-direction: column;
                gap: 15px;
            }

            .sections-grid {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="admin-header">
        <div class="header-left">
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Détails du Professeur</h1>
        </div>
        <div class="header-right">
            <div class="admin-avatar">
                {{ strtoupper(substr(Auth::user()->firstname, 0, 1) . substr(Auth::user()->lastname, 0, 1)) }}
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Teacher Header -->
        <div class="teacher-header">
            <img src="{{ $teacher->photo_path ? asset('storage/' . $teacher->photo_path) : asset('images/profill_default.webp') }}"
                 alt="Photo de profil" class="teacher-avatar">
            <div class="teacher-info">
                <h2 class="teacher-name">{{ $teacher->firstname }} {{ $teacher->lastname }}</h2>
                <p class="teacher-email">{{ $teacher->email }}</p>

                @if($teacher->identity_verified)
                    <span class="status-badge verified">
                        <i class="fas fa-check-circle"></i> Professeur vérifié
                    </span>
                @else
                    <span class="status-badge pending">
                        <i class="fas fa-clock"></i> En attente de vérification
                    </span>
                @endif

                <div class="progress-container">
                    <div class="progress-label">
                        <span>Complétion du profil</span>
                        <span>{{ $profileCompletion }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $profileCompletion }}%"></div>
                    </div>
                </div>
            </div>
            <div class="teacher-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $teacher->rate_per_hour ? number_format($teacher->rate_per_hour, 0, ',', ' ') : '0' }}</div>
                    <div class="stat-label">FCFA/heure</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $teacher->city ?? '?' }}</div>
                    <div class="stat-label">Ville</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        @if($teacher->learning_preference == 'online')
                            🌐
                        @elseif($teacher->learning_preference == 'in_person')
                            👥
                        @else
                            🔀
                        @endif
                    </div>
                    <div class="stat-label">
                        {{ $teacher->learning_preference == 'online' ? 'En ligne' :
                           ($teacher->learning_preference == 'in_person' ? 'Présentiel' : 'Hybride') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sections Grid -->
        <div class="sections-grid">
            <!-- Informations Personnelles -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-circle"></i>
                    <h3>Informations Personnelles</h3>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $teacher->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Téléphone</div>
                        <div class="info-value {{ empty($teacher->telephone) ? 'empty' : '' }}">
                            {{ $teacher->telephone ?? 'Non renseigné' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ville</div>
                        <div class="info-value {{ empty($teacher->city) ? 'empty' : '' }}">
                            {{ $teacher->city ?? 'Non renseignée' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date d'inscription</div>
                        <div class="info-value">{{ $teacher->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Informations Professionnelles -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h3>Informations Professionnelles</h3>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Taux horaire</div>
                        <div class="info-value {{ empty($teacher->rate_per_hour) ? 'empty' : '' }}">
                            {{ $teacher->rate_per_hour ? number_format($teacher->rate_per_hour, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Type de cours</div>
                        <div class="info-value {{ empty($teacher->learning_preference) ? 'empty' : '' }}">
                            @if($teacher->learning_preference == 'online')
                                En ligne
                            @elseif($teacher->learning_preference == 'in_person')
                                Présentiel
                            @elseif($teacher->learning_preference == 'hybrid')
                                Hybride
                            @else
                                Non renseigné
                            @endif
                        </div>
                    </div>
                    <div class="info-item" style="grid-column: span 2;">
                        <div class="info-label">Qualifications</div>
                        <div class="info-value {{ empty($teacher->qualifications) ? 'empty' : '' }}">
                            {{ $teacher->qualifications ?? 'Non renseignées' }}
                        </div>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <div class="info-label" style="margin-bottom: 10px;">Matières enseignées</div>
                    @if($teacher->subjects)
                        <div class="subjects-list">
                            @php
                                $subjects = json_decode($teacher->subjects, true);
                                if(is_array($subjects)) {
                                    foreach($subjects as $subject) {
                                        echo '<span class="subject-tag">' . $subject . '</span>';
                                    }
                                } else {
                                    echo '<span class="subject-tag">' . $teacher->subjects . '</span>';
                                }
                            @endphp
                        </div>
                    @else
                        <div class="info-value empty">Non renseignées</div>
                    @endif
                </div>
            </div>

            <!-- Biographie -->
            <div class="card" style="grid-column: span 2;">
                <div class="card-header">
                    <i class="fas fa-book-open"></i>
                    <h3>Biographie</h3>
                </div>
                <div class="bio-content {{ empty($teacher->bio) ? 'empty' : '' }}">
                    {{ $teacher->bio ?? 'Aucune biographie renseignée.' }}
                </div>
            </div>

            <!-- Pièce d'identité -->
            <div class="card" style="grid-column: span 2;">
                <div class="card-header">
                    <i class="fas fa-file-contract"></i>
                    <h3>Pièce d'identité</h3>
                </div>

                @if($teacher->identity_document_path)
                    <div class="document-section">
                        <div class="document-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <h4 style="color: #2c3e50; margin-bottom: 10px;">Pièce d'identité téléchargée</h4>
                        <p style="color: #7f8c8d; margin-bottom: 20px;">
                            Statut :
                            @if($teacher->identity_verified)
                                <span style="color: #2ecc71; font-weight: 600;">
                                    <i class="fas fa-check-circle"></i> Vérifiée
                                </span>
                            @else
                                <span style="color: #f39c12; font-weight: 600;">
                                    <i class="fas fa-clock"></i> En attente de vérification
                                </span>
                            @endif
                        </p>
                        <div class="document-actions">
                            <button class="btn btn-primary view-document-btn"
                                    data-teacher-id="{{ $teacher->id }}">
                                <i class="fas fa-eye"></i> Voir la pièce
                            </button>
                            <a href="/admin/teachers/{{ $teacher->id }}/identity-document"
                               target="_blank" class="btn btn-outline">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>
                    </div>
                @else
                    <div class="document-section" style="background: #f8fafc;">
                        <div class="document-icon">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <h4 style="color: #e74c3c; margin-bottom: 10px;">Pièce d'identité manquante</h4>
                        <p style="color: #7f8c8d;">Ce professeur n'a pas encore téléchargé sa pièce d'identité.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <div>
                @if(!$teacher->identity_verified && $teacher->identity_document_path)
                    <button class="btn btn-success approve-btn" data-teacher-id="{{ $teacher->id }}">
                        <i class="fas fa-check"></i> Approuver le professeur
                    </button>
                    <button class="btn btn-danger reject-btn" data-teacher-id="{{ $teacher->id }}">
                        <i class="fas fa-times"></i> Rejeter le professeur
                    </button>
                @endif
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>

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
                        <textarea id="approvalReason" name="approval_reason" class="form-control"
                                  rows="4" placeholder="Message à envoyer au professeur..."></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline close-modal">Annuler</button>
                        <button type="submit" class="btn btn-success">
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
                        <label for="rejectionReason">Raison du rejet <span style="color: #e74c3c">*</span></label>
                        <textarea id="rejectionReason" name="rejection_reason" class="form-control"
                                  rows="4" placeholder="Veuillez expliquer la raison du rejet..." required></textarea>
                        <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                            Cette raison sera envoyée par email au professeur.
                        </small>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline close-modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Confirmer le rejet
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modals
            const approvalModal = document.getElementById('approvalModal');
            const rejectionModal = document.getElementById('rejectionModal');
            const documentModal = document.getElementById('documentModal');
            const closeButtons = document.querySelectorAll('.close-modal');

            // Ouvrir modal d'approbation
            document.querySelectorAll('.approve-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const teacherId = this.getAttribute('data-teacher-id');
                    document.getElementById('approvalTeacherId').value = teacherId;
                    approvalModal.style.display = 'flex';
                });
            });

            // Ouvrir modal de rejet
            document.querySelectorAll('.reject-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const teacherId = this.getAttribute('data-teacher-id');
                    document.getElementById('rejectionTeacherId').value = teacherId;
                    rejectionModal.style.display = 'flex';
                });
            });

            // Voir pièce d'identité
            document.querySelectorAll('.view-document-btn').forEach(btn => {
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

                    // Simuler le chargement
                    setTimeout(() => {
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
                    }, 1000);
                });
            });

            // Fermer modals
            closeButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    approvalModal.style.display = 'none';
                    rejectionModal.style.display = 'none';
                    documentModal.style.display = 'none';
                });
            });

            // Fermer modals en cliquant en dehors
            window.addEventListener('click', function(event) {
                if (event.target === approvalModal) {
                    approvalModal.style.display = 'none';
                }
                if (event.target === rejectionModal) {
                    rejectionModal.style.display = 'none';
                }
                if (event.target === documentModal) {
                    documentModal.style.display = 'none';
                }
            });

            // Soumission des formulaires
            document.getElementById('approvalForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const teacherId = document.getElementById('approvalTeacherId').value;
                const formData = new FormData(this);

                fetch(`/admin/teachers/${teacherId}/approve`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Professeur approuvé avec succès !');
                        window.location.href = '{{ route("admin.dashboard") }}';
                    } else {
                        alert('Erreur lors de l\'approbation');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de l\'approbation');
                });
            });

            document.getElementById('rejectionForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const teacherId = document.getElementById('rejectionTeacherId').value;
                const formData = new FormData(this);

                fetch(`/admin/teachers/${teacherId}/reject`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Professeur rejeté avec succès !');
                        window.location.href = '{{ route("admin.dashboard") }}';
                    } else {
                        alert('Erreur lors du rejet');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors du rejet');
                });
            });
        });
    </script>
</body>
</html>
