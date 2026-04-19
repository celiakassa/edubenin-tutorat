<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href="{{ asset('images/image_1.webp') }}" rel="icon">
    <title>Compléter mon profil - Kopiao</title>
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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

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
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('{{ asset('images/image_4.webp') }}');
            background-size: cover;
            opacity: 0.1;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 280px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            height: 100vh;
            position: fixed;
            left: 0; top: 0;
            border-right: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .sidebar-header { padding: 30px 25px; border-bottom: 1px solid var(--medium-gray); text-align: center; }
        .platform-logo { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 15px; }
        .logo-icon { width: 40px; height: 40px; background: var(--primary-color); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--white); font-weight: bold; font-size: 18px; }
        .platform-name { font-size: 22px; font-weight: 700; color: var(--primary-color); }
        .platform-tagline { font-size: 12px; color: var(--dark-gray); margin-bottom: 20px; }
        .user-info { display: flex; align-items: center; gap: 12px; padding: 15px; background: var(--light-gray); border-radius: 12px; margin-top: 15px; }
        .user-avatar { width: 45px; height: 45px; border-radius: 50%; background: var(--primary-color); color: var(--white); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; }
        .user-details h4 { font-size: 14px; font-weight: 600; color: var(--text-dark); }
        .user-details p { font-size: 12px; color: var(--dark-gray); }
        .sidebar-stats { padding: 20px 25px; border-bottom: 1px solid var(--medium-gray); }
        .stat-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .stat-label { font-size: 13px; color: var(--dark-gray); }
        .stat-value { font-size: 14px; font-weight: 600; color: var(--primary-color); }
        .sidebar-menu { padding: 20px 0; }
        .menu-item { padding: 15px 25px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: all 0.3s ease; color: var(--dark-gray); text-decoration: none; }
        .menu-item:hover, .menu-item.active { background: var(--primary-light); color: var(--white); border-right: 3px solid var(--primary-color); }
        .menu-item i { width: 20px; text-align: center; font-size: 16px; }
        .menu-text { font-size: 14px; font-weight: 500; }
        .verified-badge { display: inline-flex; align-items: center; background: linear-gradient(135deg,#FFD700,#FFA500); color: #8B6914; padding: 5px 15px; border-radius: 20px; font-size: 0.9rem; font-weight: 600; margin-left: 10px; box-shadow: 0 3px 10px rgba(255,215,0,0.3); }
        .verified-badge i { margin-right: 5px; }

        /* ── Main ── */
        .main-content { flex: 1; margin-left: 280px; padding: 30px; min-height: 100vh; }
        .profile-edit-container { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); width: 100%; max-width: 900px; margin: 0 auto; overflow: hidden; border: 1px solid rgba(255,255,255,0.3); }
        .profile-header { background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%); color: var(--white); padding: 30px 40px; text-align: center; position: relative; overflow: hidden; }
        .profile-header::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); }
        .profile-header h1 { font-size: 28px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; gap: 12px; position: relative; z-index: 1; }
        .profile-header p { font-size: 14px; opacity: 0.9; position: relative; z-index: 1; }

        .profile-banner { background: var(--white); border-radius: 15px; padding: 25px; margin: 25px 40px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); border-left: 4px solid var(--primary-color); }
        .profile-banner-content { display: flex; align-items: center; gap: 20px; }
        .profile-banner-icon { width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%); color: var(--white); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .profile-banner-text { flex: 1; }
        .profile-banner-text h3 { color: var(--primary-color); margin-bottom: 8px; font-size: 18px; }
        .profile-banner-text p { color: var(--dark-gray); margin-bottom: 15px; font-size: 14px; }
        .progress-bar { background: var(--medium-gray); border-radius: 10px; height: 12px; width: 100%; overflow: hidden; }
        .progress-bar-fill { height: 100%; border-radius: 10px; transition: width 0.5s ease; }
        .progress-text { text-align: center; font-size: 12px; color: var(--dark-gray); margin-top: 8px; font-weight: 500; }

        .profile-form { padding: 0 40px 40px; }
        .form-section { margin-bottom: 25px; padding: 25px; border: 1px solid var(--medium-gray); border-radius: 16px; background: var(--white); transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .form-section:hover { border-color: var(--primary-light); box-shadow: 0 6px 20px rgba(3,81,188,0.1); }
        .form-section h2 { color: var(--primary-color); margin-bottom: 20px; font-size: 18px; display: flex; align-items: center; gap: 8px; font-weight: 600; }
        .form-section h2 i { font-size: 18px; width: 24px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark); font-size: 14px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; border: 2px solid var(--medium-gray); border-radius: 10px; font-size: 14px; transition: all 0.3s ease; background: var(--white); }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(3,81,188,0.1); }

        .subjects-select-container { border: 2px solid var(--medium-gray); border-radius: 10px; padding: 10px; max-height: 300px; overflow-y: auto; background: var(--white); }
        .subject-checkbox { display: flex; align-items: center; padding: 10px 12px; margin-bottom: 5px; border-radius: 8px; transition: all 0.2s ease; cursor: pointer; }
        .subject-checkbox:hover { background: var(--light-gray); }
        .subject-checkbox input[type="checkbox"] { width: 18px; height: 18px; margin-right: 12px; accent-color: var(--primary-color); cursor: pointer; }
        .subject-checkbox label { flex: 1; cursor: pointer; font-weight: 500; color: var(--text-dark); }
        .subject-checkbox small { color: var(--dark-gray); font-size: 11px; }
        .selected-count { margin-top: 10px; padding: 8px 12px; background: var(--light-gray); border-radius: 20px; font-size: 13px; color: var(--primary-color); font-weight: 500; }
        .subject-search { margin-bottom: 15px; }
        .subject-search input { width: 100%; padding: 10px 15px; border: 2px solid var(--medium-gray); border-radius: 8px; font-size: 14px; }
        .subject-search input:focus { border-color: var(--primary-color); outline: none; }

        /* ══ RADIO APPRENTISSAGE ══ */
        .radio-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
            margin-top: 8px;
        }
        .radio-option { position: relative; }
        .radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            pointer-events: none;
        }
        .radio-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px 12px;
            border: 2px solid var(--medium-gray);
            border-radius: 10px;
            background: var(--white);
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.25s ease;
            text-align: center;
            user-select: none;
        }
        .radio-label:hover {
            border-color: var(--primary-light);
            background: #f0f7ff;
        }
        /* Actif géré par JS via .radio-label--active */
        .radio-label--active {
            border-color: var(--primary-color) !important;
            background: var(--primary-color) !important;
            color: var(--white) !important;
            box-shadow: 0 4px 12px rgba(3,81,188,0.25);
        }
        .radio-icon { font-size: 20px; margin-bottom: 8px; }
        .radio-text { font-weight: 500; font-size: 13px; }
        /* ══════════════════════════════════════════ */

        .file-upload { position: relative; display: inline-block; width: 100%; }
        .file-upload-label { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border: 2px dashed var(--medium-gray); border-radius: 10px; background: var(--white); cursor: pointer; transition: all 0.3s ease; justify-content: center; font-size: 14px; }
        .file-upload-label:hover { border-color: var(--primary-color); background: var(--light-gray); }
        .file-upload-label i { color: var(--primary-color); font-size: 18px; }
        .current-photo { margin-top: 12px; text-align: center; }
        .current-photo img { border: 2px solid var(--primary-color); box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 80px; height: 80px; object-fit: cover; border-radius: 10px; }
        .current-document { background: #f0f7ff; border-radius: 10px; padding: 15px; margin-bottom: 15px; border-left: 4px solid var(--primary-color); display: flex; align-items: center; gap: 15px; }
        .document-preview { width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .document-preview i { color: white; font-size: 30px; }
        .document-info { flex: 1; }
        .document-name { font-weight: 500; margin-bottom: 5px; font-size: 14px; word-break: break-all; }
        .document-status { font-size: 12px; }
        .document-status.verified { color: var(--success); }
        .document-status.pending { color: var(--warning); }

        .form-actions { display: flex; gap: 15px; justify-content: center; margin-top: 30px; padding-top: 25px; border-top: 1px solid var(--medium-gray); }
        .btn-submit { background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%); color: var(--white); padding: 14px 32px; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(3,81,188,0.3); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(3,81,188,0.4); }
        .btn-cancel { background: var(--white); color: var(--dark-gray); padding: 14px 32px; border: 2px solid var(--medium-gray); border-radius: 10px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; font-size: 15px; }
        .btn-cancel:hover { background: var(--light-gray); border-color: var(--dark-gray); transform: translateY(-2px); }

        .error { color: var(--danger); font-size: 12px; margin-top: 6px; display: block; font-weight: 500; }
        .success-message { background: var(--success); color: var(--white); padding: 12px 16px; border-radius: 10px; margin: 20px 40px; text-align: center; font-weight: 500; font-size: 14px; }

        /* Alerte si aucune préférence (remplace la validation HTML5 native sur input caché) */
        .radio-required-msg {
            display: none;
            color: var(--danger);
            font-size: 12px;
            margin-top: 8px;
            font-weight: 500;
        }
        .radio-required-msg.show { display: block; }

        @media (max-width: 1024px) { .sidebar { width: 250px; } .main-content { margin-left: 250px; } }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column; }
            .radio-group { grid-template-columns: 1fr; }
            .profile-header, .profile-form { padding: 20px; }
            .current-document { flex-direction: column; text-align: center; }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboardUser') }}" style="text-decoration: none;">
                <div class="platform-logo">
                    <div class="logo-icon" style="background-color:#3948c9;color:white;padding:10px;border-radius:6px;font-weight:bold;">KP</div>
                    <div class="platform-name">Kopiao</div>
                </div>
            </a>
            <div class="platform-tagline">Votre plateforme éducative</div>
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr($user->firstname,0,1).substr($user->lastname,0,1)) }}</div>
                <div class="user-details">
                    <h4>{{ $user->firstname }} {{ $user->lastname }}</h4>
                    <p>
                        @if($user->role_id == 3) Tuteur
                        @elseif($user->role_id == 2) Apprenant
                        @else Administrateur @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="sidebar-stats">
            @if($user->role_id == 3 && $user->is_valid == 1)
                <center><div class="tutor-verified mb-2"><span class="verified-badge"><i class="fas fa-check-circle"></i> Tuteur vérifié</span></div></center>
            @endif
            <br>
            <div class="stat-item">
                <span class="stat-label">Profil complété</span>
                <span class="stat-value">{{ $profileCompletion }}%</span>
            </div>
            <div style="margin:20px 0;padding:15px;border-radius:8px;text-align:center;">
                @if($profileCompletion < 100)
                    <div style="background:#dd1525;color:#fff;padding:12px 20px;border-radius:8px;">Profil invalide !</div>
                @else
                    <div style="background:#149131;color:#fff;padding:12px 20px;border-radius:8px;">Profil complet !</div>
                @endif
            </div>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboardUser') }}" class="menu-item"><i class="fas fa-home"></i><span class="menu-text">Tableau de bord</span></a>
            <a href="{{ route('CompleterProfilUser.show') }}" class="menu-item active"><i class="fas fa-user-edit"></i><span class="menu-text">Mon profil</span></a>
        </div>
    </div>

    <div class="main-content">
        <div class="profile-edit-container">
            <div class="profile-header">
                <h1><i class="fas fa-user-edit"></i> Compléter mon profil</h1>
                <p>Optimisez votre expérience en complétant vos informations</p>
            </div>

            <div class="profile-banner">
                <div class="profile-banner-content">
                    <div class="profile-banner-icon"><i class="fas fa-user-edit"></i></div>
                    <div class="profile-banner-text">
                        <h3>Complétez votre profil</h3>
                        <p>Votre profil est complété à {{ $profileCompletion }}%.</p>
                        <div class="progress-bar">
                            <div class="progress-bar-fill" style="width:{{ $profileCompletion }}%;background:{{ $profileCompletion < 100 ? '#f44336' : '#4caf50' }};"></div>
                        </div>
                        <div class="progress-text" style="color:{{ $profileCompletion < 100 ? '#f44336' : '#4caf50' }};">{{ $profileCompletion }}% complété</div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="success-message"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <form action="{{ route('CompleterProfilUser.update') }}" method="POST" enctype="multipart/form-data" class="profile-form" id="profileForm">
                @csrf

                {{-- ── Informations personnelles ── --}}
                <div class="form-section">
                    <h2><i class="fas fa-user"></i> Informations personnelles</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="firstname">Prénom *</label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                            @error('firstname')<span class="error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="lastname">Nom *</label>
                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                            @error('lastname')<span class="error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')<span class="error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone *</label>
                            <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}" required>
                            @error('telephone')<span class="error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="city">Ville *</label>
                            <select id="city" name="city" required onchange="toggleCustomCity()">
                                <option value="">Sélectionnez votre ville</option>
                                @foreach(['Cotonou','Porto-Novo','Parakou','Abomey-Calavi'] as $v)
                                    <option value="{{ $v }}" {{ old('city', $user->city) == $v ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                                <option value="autre" {{ !in_array($user->city, ['Cotonou','Porto-Novo','Parakou','Abomey-Calavi']) && $user->city ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('city')<span class="error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group" id="customCityGroup" style="display:none;">
                            <label for="custom_city">Autre ville *</label>
                            <input type="text" id="custom_city" name="custom_city"
                                value="{{ old('custom_city', !in_array($user->city, ['Cotonou','Porto-Novo','Parakou','Abomey-Calavi']) ? $user->city : '') }}"
                                placeholder="Entrez votre ville">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bio">Biographie</label>
                        <textarea id="bio" name="bio" rows="3" placeholder="Présentez-vous brièvement...">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo de profil</label>
                        <div class="file-upload">
                            <label for="photo" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choisir une photo...</span>
                            </label>
                            <input type="file" id="photo" name="photo" accept="image/*" style="display:none;">
                        </div>
                        @if($user->photo_path)
                            <div class="current-photo"><img src="{{ Storage::url($user->photo_path) }}" alt="Photo actuelle"></div>
                        @endif
                        @error('photo')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- ── Informations professionnelles (Tuteur) ── --}}
                @if($user->role_id == 3)
                    <div class="form-section">
                        <h2><i class="fas fa-graduation-cap"></i> Informations professionnelles</h2>
                        <div class="form-group">
                            <label for="qualifications">Niveau d'études / Qualifications *</label>
                            <select id="qualifications" name="qualifications" required>
                                <option value="">Sélectionnez votre niveau</option>
                                @foreach($qualificationsList as $value => $label)
                                    <option value="{{ $value }}" {{ old('qualifications', $user->qualifications) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('qualifications')<span class="error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Matières enseignées *</label>
                            <div class="subject-search">
                                <input type="text" id="subject-search" placeholder="Rechercher une matière..." onkeyup="filterSubjects()">
                            </div>
                            <div class="subjects-select-container" id="subjects-container">
                                @php $userSubjectIds = $user->subjects->pluck('id')->toArray(); @endphp
                                @foreach($allSubjects as $subject)
                                    <div class="subject-checkbox" data-name="{{ strtolower($subject->nom) }}">
                                        <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}"
                                            {{ in_array($subject->id, old('subjects', $userSubjectIds)) ? 'checked' : '' }}>
                                        <label for="subject_{{ $subject->id }}">
                                            {{ $subject->nom }}
                                            @if($subject->description)<br><small>{{ Str::limit($subject->description, 50) }}</small>@endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="selected-count" id="selected-count">
                                <i class="fas fa-check-circle"></i>
                                <span id="selected-number">{{ count(old('subjects', $userSubjectIds)) }}</span> matière(s) sélectionnée(s)
                            </div>
                            @error('subjects')<span class="error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="rate_per_hour">Tarif horaire (FCFA) *</label>
                            <input type="number" id="rate_per_hour" name="rate_per_hour"
                                value="{{ old('rate_per_hour', $user->rate_per_hour) }}"
                                min="0" placeholder="5000" required>
                            @error('rate_per_hour')<span class="error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    {{-- Pièce d'identité --}}
                    <div class="form-group" style="padding: 0 0 20px;">
                        <label for="identity_document">Pièce d'identité *</label>
                        <p style="font-size:12px;color:var(--dark-gray);margin-bottom:8px;">
                            <i class="fas fa-info-circle"></i> Formats : PDF, JPG, PNG (max 10MB)
                        </p>
                        @if($user->identity_document_path)
                            <div class="current-document">
                                <div class="document-preview">
                                    @if(Str::endsWith($user->identity_document_path,['.pdf']))
                                        <i class="fas fa-file-pdf"></i>
                                    @else
                                        <i class="fas fa-image"></i>
                                    @endif
                                </div>
                                <div class="document-info">
                                    <div class="document-name">{{ basename($user->identity_document_path) }}</div>
                                    <div class="document-status {{ $user->identity_verified ? 'verified' : 'pending' }}">
                                        @if($user->identity_verified)
                                            <i class="fas fa-check-circle"></i> Vérifiée
                                        @else
                                            <i class="fas fa-clock"></i> En attente
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="file-upload">
                            <label for="identity_document" class="file-upload-label">
                                <i class="fas fa-file-upload"></i>
                                <span>{{ $user->identity_document_path ? "Remplacer la pièce d'identité..." : "Télécharger la pièce d'identité..." }}</span>
                            </label>
                            <input type="file" id="identity_document" name="identity_document" accept=".pdf,.jpg,.jpeg,.png" style="display:none;">
                        </div>
                        @error('identity_document')<span class="error">{{ $message }}</span>@enderror
                    </div>
                @endif

                {{-- ── Préférences d'apprentissage ── --}}
                @php
                    $preference = old('learning_preference', $user->learning_preference ?? '');
                @endphp

                <div class="form-section">
                    <h2><i class="fas fa-book-open"></i> Préférences d'apprentissage</h2>
                    <div class="form-group">
                        <label>Type de cours préféré *</label>

                        {{--
                            FIX : On ajoute un input hidden avec la valeur actuelle.
                            Si l'utilisateur ne change rien, la valeur existante est quand
                            même envoyée. Les radios ont la priorité si l'un est coché.
                        --}}
                        <input type="hidden" name="learning_preference" id="learning_preference_hidden" value="{{ $preference }}">

                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="pref_online" name="learning_preference_radio" value="online"
                                    {{ $preference === 'online' ? 'checked' : '' }}>
                                <label for="pref_online" class="radio-label">
                                    <i class="fas fa-laptop radio-icon"></i>
                                    <span class="radio-text">En ligne</span>
                                </label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="pref_inperson" name="learning_preference_radio" value="in_person"
                                    {{ $preference === 'in_person' ? 'checked' : '' }}>
                                <label for="pref_inperson" class="radio-label">
                                    <i class="fas fa-user-friends radio-icon"></i>
                                    <span class="radio-text">Présentiel</span>
                                </label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="pref_hybrid" name="learning_preference_radio" value="hybrid"
                                    {{ $preference === 'hybrid' ? 'checked' : '' }}>
                                <label for="pref_hybrid" class="radio-label">
                                    <i class="fas fa-blender-phone radio-icon"></i>
                                    <span class="radio-text">Hybride</span>
                                </label>
                            </div>
                        </div>

                        <div class="radio-required-msg" id="radio-error">
                            <i class="fas fa-exclamation-circle"></i> Veuillez sélectionner un type de cours préféré.
                        </div>

                        @error('learning_preference')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('dashboardUser') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Radios préférence d'apprentissage ──
            const hiddenPref = document.getElementById('learning_preference_hidden');
            const radios     = document.querySelectorAll('input[name="learning_preference_radio"]');

            function setActiveRadio(value) {
                // Retirer la classe active de tous les labels
                document.querySelectorAll('.radio-label').forEach(lbl => {
                    lbl.classList.remove('radio-label--active');
                });
                // Ajouter la classe active sur le bon label
                if (value) {
                    const target = document.querySelector(`input[name="learning_preference_radio"][value="${value}"]`);
                    if (target) {
                        target.checked = true;
                        target.nextElementSibling.classList.add('radio-label--active');
                    }
                }
            }

            // Au clic sur un label radio
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    hiddenPref.value = this.value;
                    setActiveRadio(this.value);
                    document.getElementById('radio-error').classList.remove('show');
                });
            });

            // Appliquer l'état actif dès le chargement (valeur depuis la BDD)
            setActiveRadio(hiddenPref.value);

            // ── Validation avant soumission ──
            document.getElementById('profileForm').addEventListener('submit', function (e) {
                if (!hiddenPref.value) {
                    e.preventDefault();
                    document.getElementById('radio-error').classList.add('show');
                    document.querySelector('.form-section:last-of-type').scrollIntoView({ behavior: 'smooth' });
                }
            });

            // ── Matières ──
            const checkboxes = document.querySelectorAll('input[name="subjects[]"]');
            checkboxes.forEach(cb => cb.addEventListener('change', updateSelectedCount));
            updateSelectedCount();

            // ── Ville personnalisée ──
            toggleCustomCity();

            // ── Fichiers ──
            const photoInput = document.getElementById('photo');
            if (photoInput) {
                photoInput.addEventListener('change', function () {
                    if (this.files.length > 0) this.previousElementSibling.querySelector('span').textContent = this.files[0].name;
                });
            }
            const idDoc = document.getElementById('identity_document');
            if (idDoc) {
                idDoc.addEventListener('change', function () {
                    if (this.files.length > 0) this.previousElementSibling.querySelector('span').textContent = this.files[0].name;
                });
            }
        });

        function updateSelectedCount() {
            const n = document.querySelectorAll('input[name="subjects[]"]:checked').length;
            const el = document.getElementById('selected-number');
            if (el) el.textContent = n;
        }

        function filterSubjects() {
            const term = document.getElementById('subject-search').value.toLowerCase();
            let visible = 0;
            document.querySelectorAll('.subject-checkbox').forEach(el => {
                const show = el.getAttribute('data-name').includes(term);
                el.style.display = show ? 'flex' : 'none';
                if (show) visible++;
            });
            const container = document.getElementById('subjects-container');
            let msg = document.getElementById('no-results-message');
            if (visible === 0) {
                if (!msg) {
                    msg = document.createElement('div');
                    msg.id = 'no-results-message';
                    msg.style.cssText = 'padding:20px;text-align:center;color:var(--dark-gray)';
                    msg.innerHTML = '<i class="fas fa-search"></i> Aucune matière trouvée';
                    container.appendChild(msg);
                }
            } else if (msg) msg.remove();
        }

        function toggleCustomCity() {
            const val = document.getElementById('city').value;
            const group = document.getElementById('customCityGroup');
            if (!group) return;
            group.style.display = val === 'autre' ? 'block' : 'none';
            if (val !== 'autre') document.getElementById('custom_city').value = '';
        }
    </script>
</body>
</html>
