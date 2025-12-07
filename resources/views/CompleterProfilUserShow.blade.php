<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(hsla(226, 61%, 85%, 0.8), rgba(212, 222, 240, 0.9)), url('{{ asset('images/image_4.webp') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Sidebar Styles */
        .sidebar {
            width: 300px;
            background: linear-gradient(135deg, #1E63C4, #1E63C4);
            color: white;
            padding: 0;
            position: relative;
        }

        .sidebar-header {
            padding: 40px 30px;
            background: rgba(0, 0, 0, 0.2);
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info {
            text-align: center;
            margin-bottom: 30px;
        }

        .user-name {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: white;
        }

        .user-role {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 18px 30px;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            left: -100%;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .menu-item:hover::before {
            left: 100%;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #3498db;
            border-left-color: #3498db;
            transform: translateX(5px);
        }

        .menu-item.active {
            background: rgba(52, 152, 219, 0.2);
            color: #3498db;
            border-left-color: #3498db;
            font-weight: 600;
        }

        .menu-item i {
            width: 25px;
            margin-right: 15px;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .menu-item:hover i {
            transform: scale(1.2);
        }

        .menu-text {
            font-size: 1rem;
            font-weight: 500;
            color: #ffffff;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 40px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeIn 1s ease-out;
            position: relative;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #3498db;
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 35px rgba(52, 152, 219, 0.4);
        }

        .profile-name {
            font-size: 2.2rem;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .profile-role {
            display: inline-block;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
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

        /* Profile Cards */
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 5px solid #3498db;
            animation: cardSlide 0.6s ease-out;
        }

        @keyframes cardSlide {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .info-card h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.3rem;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .info-card h3 i {
            margin-right: 10px;
            color: #3498db;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f8f9fa;
            transition: background-color 0.3s ease;
        }

        .info-item:hover {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #34495e;
            min-width: 180px;
        }

        .info-value {
            color: #7f8c8d;
            text-align: right;
            flex: 1;
        }

        /* Pièce d'identité */
        .identity-document-container {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            margin-top: 15px;
            border: 2px dashed #dee2e6;
        }

        .document-icon {
            font-size: 2.5rem;
            color: #3498db;
            margin-bottom: 10px;
        }

        .document-status {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 10px;
        }

        .document-status.verified {
            background: #d4edda;
            color: #155724;
        }

        .document-status.pending {
            background: #fff3cd;
            color: #856404;
        }

        .document-status.missing {
            background: #f8d7da;
            color: #721c24;
        }

        .document-view-btn {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            margin-top: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .document-view-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .document-view-btn i {
            margin-right: 5px;
        }

        /* Modal pour afficher la pièce d'identité */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            animation: fadeInModal 0.3s ease-out;
        }

        @keyframes fadeInModal {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 80%;
            max-height: 80%;
            border-radius: 10px;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1001;
        }

        .modal-header:hover {
            color: #bbb;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                order: 2;
            }

            .main-content {
                order: 1;
            }

            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }

            .profile-name {
                font-size: 1.8rem;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-value {
                text-align: left;
                margin-top: 5px;
            }

            .sidebar-header {
                padding: 30px 20px;
            }

            .menu-item {
                padding: 15px 20px;
            }
        }
    </style>
</head>

<body>
    <br><br> <br><br>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="profile-header">
                    <img src="{{ $user->photo_path ? asset('storage/' . $user->photo_path) : asset('images/profill_default.webp') }}"
                        alt="Photo de profil" class="profile-avatar" onclick="viewPhoto('{{ $user->photo_path ? asset('storage/' . $user->photo_path) : asset('images/profill_default.webp') }}')">
                    <h1 class="profile-name">
                        {{ $user->firstname }} {{ $user->lastname }}
                        @if ($user->role_id == 3 && $user->is_valid == 1)
                            <span class="verified-badge">
                                <i class="fas fa-check-circle"></i> Tuteur vérifié
                            </span>
                        @endif
                    </h1>
                    <div class="profile-role">
                        @if ($user->role_id == 3)
                            <i class="fas fa-chalkboard-teacher"></i> Tuteur
                        @elseif($user->role_id == 2)
                            <i class="fas fa-user-graduate"></i> Étudiant
                        @else
                            <i class="fas fa-user"></i> Utilisateur
                        @endif
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <a href="{{ route('dashboardUser') }}" class="menu-item">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Tableau de bord</span>
                </a>
                <a href="{{ route('CompleterProfilUser.edit') }}" class="menu-item active">
                    <i class="fas fa-user-edit"></i>
                    <span class="menu-text">Modifier mon profil</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="profile-grid">
                <!-- Carte Informations Personnelles -->
                <div class="info-card" style="animation-delay: 0.1s">
                    <h3><i class="fas fa-user-circle"></i> Informations Personnelles</h3>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value">{{ $user->telephone ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date de naissance</span>
                        <span
                            class="info-value">{{ $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') : 'Non renseignée' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Ville</span>
                        <span class="info-value">{{ $user->city ?? 'Non renseignée' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Bio</span>
                        <span class="info-value">{{ $user->bio ?? 'Aucune bio renseignée' }}</span>
                    </div>
                </div>

                <!-- Carte Préférences d'Apprentissage -->
                <div class="info-card" style="animation-delay: 0.2s">
                    <h3><i class="fas fa-graduation-cap"></i> Préférences d'Apprentissage</h3>
                    @php
                        $preference = $user->learning_preference;
                        if (is_object($preference)) {
                            $preference = $preference->value ?? ($preference->name ?? '');
                        }

                        $preferenceLabels = [
                            'online' => '🌐 En ligne',
                            'in_person' => '👥 En présentiel',
                            'hybrid' => '🔀 Hybride',
                        ];
                    @endphp

                    <div class="info-item">
                        <span class="info-label">Type préféré</span>
                        <span class="info-value">{{ $preferenceLabels[$preference] ?? 'Non renseigné' }}</span>
                    </div>

                    @if ($user->role_id == 2)
                        <div class="info-item">
                            <span class="info-label">Historique</span>
                            <span class="info-value">{{ $user->learning_history ?? 'Non renseigné' }}</span>
                        </div>
                    @endif
                </div>

                <!-- Carte Spécifique selon le rôle -->
                @if ($user->role_id == 3)
                    <div class="info-card" style="animation-delay: 0.3s">
                        <h3><i class="fas fa-chalkboard-teacher"></i> Informations Tuteur</h3>
                        <div class="info-item">
                            <span class="info-label">Qualifications</span>
                            <span class="info-value">{{ $user->qualifications ?? 'Non renseignées' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Matières</span>
                            <span class="info-value">
                                @if ($user->subjects)
                                    @php
                                        $subjects = json_decode($user->subjects, true);
                                        if (is_array($subjects)) {
                                            echo implode(', ', $subjects);
                                        } else {
                                            echo $user->subjects;
                                        }
                                    @endphp
                                @else
                                    Non renseignées
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Taux horaire</span>
                            <span class="info-value">
                                @if ($user->rate_per_hour)
                                    {{ number_format($user->rate_per_hour, 0, ',', ' ') }} FCFA/heure
                                @else
                                    Non renseigné
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Carte Pièce d'identité -->
                    <div class="info-card" style="animation-delay: 0.4s">
                        <h3><i class="fas fa-id-card"></i> Pièce d'identité</h3>

                        <div class="identity-document-container">
                            @if ($user->identity_document_path)
                                @php
                                    $extension = pathinfo($user->identity_document_path, PATHINFO_EXTENSION);
                                @endphp

                                <div class="document-icon">
                                    @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                        <i class="fas fa-file-image"></i>
                                    @elseif (strtolower($extension) == 'pdf')
                                        <i class="fas fa-file-pdf"></i>
                                    @else
                                        <i class="fas fa-file"></i>
                                    @endif
                                </div>

                                <p style="margin-bottom: 10px; font-weight: 500;">
                                    Pièce d'identité téléchargée
                                </p>

                                <span class="document-status {{ $user->identity_verified ? 'verified' : 'pending' }}">
                                    @if ($user->identity_verified)
                                        <i class="fas fa-check-circle"></i> Vérifiée par l'administrateur
                                    @else
                                        <i class="fas fa-clock"></i> En attente de vérification
                                    @endif
                                </span>

                                <br>
                                <button class="document-view-btn" onclick="viewIdentityDocument('{{ asset('storage/' . $user->identity_document_path) }}', '{{ $extension }}')">
                                    <i class="fas fa-eye"></i> Voir la pièce
                                </button>

                                <p style="margin-top: 15px; font-size: 0.8rem; color: #6c757d;">
                                    Format: .{{ strtoupper($extension) }}
                                </p>
                            @else
                                <div class="document-icon">
                                    <i class="fas fa-file-upload"></i>
                                </div>

                                <p style="margin-bottom: 10px; font-weight: 500;">
                                    Aucune pièce d'identité téléchargée
                                </p>

                                <span class="document-status missing">
                                    <i class="fas fa-exclamation-circle"></i> Manquante
                                </span>

                                <br>
                                <a href="{{ route('CompleterProfilUser.edit') }}" class="document-view-btn">
                                    <i class="fas fa-upload"></i> Télécharger une pièce
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal pour afficher la photo -->
    <div id="photoModal" class="modal">
        <span class="modal-header" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        // Animation au scroll
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.info-card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease-out';
                observer.observe(card);
            });
        });

        // Fonctions pour le modal
        function viewPhoto(imageSrc) {
            const modal = document.getElementById('photoModal');
            const modalImg = document.getElementById('modalImage');
            modal.style.display = "block";
            modalImg.src = imageSrc;
        }

        function viewIdentityDocument(docSrc, extension) {
            if (extension.toLowerCase() === 'pdf') {
                // Pour les PDF, ouvrir dans un nouvel onglet
                window.open(docSrc, '_blank');
            } else {
                // Pour les images, utiliser le modal
                const modal = document.getElementById('photoModal');
                const modalImg = document.getElementById('modalImage');
                modal.style.display = "block";
                modalImg.src = docSrc;
            }
        }

        function closeModal() {
            document.getElementById('photoModal').style.display = "none";
        }

        // Fermer le modal en cliquant en dehors de l'image
        window.onclick = function(event) {
            const modal = document.getElementById('photoModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>
