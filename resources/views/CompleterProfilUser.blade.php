@extends('layouts.dashboard')

@section('title', 'Compléter mon profil')
@section('page-title', 'Compléter mon profil')

@push('styles')
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

        .profile-edit-container { background: var(--white); border: 1px solid var(--kp-border); border-radius: 18px; box-shadow: var(--kp-shadow); width: 100%; max-width: 900px; margin: 0 auto; overflow: hidden; }
        .profile-header { background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%); color: var(--white); padding: 28px 40px; text-align: center; }
        .profile-header h1 { font-size: 24px; margin-bottom: 6px; display: flex; align-items: center; justify-content: center; gap: 12px; }
        .profile-header p { font-size: 14px; opacity: 0.9; }

        .profile-banner { background: var(--white); border-radius: 15px; padding: 22px; margin: 22px 30px; box-shadow: 0 4px 14px rgba(0,0,0,0.06); border-left: 4px solid var(--primary-color); }
        .profile-banner-content { display: flex; align-items: center; gap: 20px; }
        .profile-banner-icon { width: 56px; height: 56px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%); color: var(--white); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
        .profile-banner-text { flex: 1; }
        .profile-banner-text h3 { color: var(--primary-color); margin-bottom: 6px; font-size: 17px; }
        .profile-banner-text p { color: var(--dark-gray); margin-bottom: 12px; font-size: 14px; }
        .progress-bar { background: var(--medium-gray); border-radius: 10px; height: 12px; width: 100%; overflow: hidden; }
        .progress-bar-fill { height: 100%; border-radius: 10px; transition: width 0.5s ease; }
        .progress-text { text-align: center; font-size: 12px; color: var(--dark-gray); margin-top: 8px; font-weight: 500; }

        .profile-form { padding: 0 30px 30px; }
        .form-section { margin-bottom: 22px; padding: 24px; border: 1px solid var(--medium-gray); border-radius: 16px; background: var(--white); transition: all 0.3s ease; }
        .form-section:hover { border-color: var(--primary-light); box-shadow: 0 6px 20px rgba(3,81,188,0.08); }
        .form-section h2 { color: var(--primary-color); margin-bottom: 18px; font-size: 17px; display: flex; align-items: center; gap: 8px; font-weight: 600; }
        .form-section h2 i { font-size: 17px; width: 24px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 18px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark); font-size: 14px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; border: 2px solid var(--medium-gray); border-radius: 10px; font-size: 14px; transition: all 0.3s ease; background: var(--white); font-family: inherit; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(3,81,188,0.1); }

        .subjects-select-container { border: 2px solid var(--medium-gray); border-radius: 10px; padding: 10px; max-height: 300px; overflow-y: auto; background: var(--white); }
        .subject-checkbox { display: flex; align-items: center; padding: 10px 12px; margin-bottom: 5px; border-radius: 8px; transition: all 0.2s ease; cursor: pointer; }
        .subject-checkbox:hover { background: var(--light-gray); }
        .subject-checkbox input[type="checkbox"] { width: 18px; height: 18px; margin-right: 12px; accent-color: var(--primary-color); cursor: pointer; }
        .subject-checkbox label { flex: 1; cursor: pointer; font-weight: 500; color: var(--text-dark); }
        .subject-checkbox small { color: var(--dark-gray); font-size: 11px; }
        .selected-count { margin-top: 10px; padding: 8px 12px; background: var(--light-gray); border-radius: 20px; font-size: 13px; color: var(--primary-color); font-weight: 500; display: inline-block; }
        .subject-search { margin-bottom: 15px; }
        .subject-search input { width: 100%; padding: 10px 15px; border: 2px solid var(--medium-gray); border-radius: 8px; font-size: 14px; }
        .subject-search input:focus { border-color: var(--primary-color); outline: none; }

        .radio-group { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; margin-top: 8px; }
        .radio-option { position: relative; }
        .radio-option input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; pointer-events: none; }
        .radio-label { display: flex; flex-direction: column; align-items: center; padding: 16px 12px; border: 2px solid var(--medium-gray); border-radius: 10px; background: var(--white); color: var(--text-dark); cursor: pointer; transition: all 0.25s ease; text-align: center; user-select: none; }
        .radio-label:hover { border-color: var(--primary-light); background: #f0f7ff; }
        .radio-label--active { border-color: var(--primary-color) !important; background: var(--primary-color) !important; color: var(--white) !important; box-shadow: 0 4px 12px rgba(3,81,188,0.25); }
        .radio-icon { font-size: 20px; margin-bottom: 8px; }
        .radio-text { font-weight: 500; font-size: 13px; }

        .file-upload { position: relative; display: inline-block; width: 100%; }
        .file-upload-label { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border: 2px dashed var(--medium-gray); border-radius: 10px; background: var(--white); cursor: pointer; transition: all 0.3s ease; justify-content: center; font-size: 14px; }
        .file-upload-label:hover { border-color: var(--primary-color); background: var(--light-gray); }
        .file-upload-label i { color: var(--primary-color); font-size: 18px; }
        .current-photo { margin-top: 12px; text-align: center; }
        .current-photo img { border: 2px solid var(--primary-color); box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 80px; height: 80px; object-fit: cover; border-radius: 10px; }
        .current-document { background: #f0f7ff; border-radius: 10px; padding: 15px; margin-bottom: 15px; border-left: 4px solid var(--primary-color); display: flex; align-items: center; gap: 15px; }
        .document-preview { width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .document-preview i { color: white; font-size: 30px; }
        .document-info { flex: 1; }
        .document-name { font-weight: 500; margin-bottom: 5px; font-size: 14px; word-break: break-all; }
        .document-status { font-size: 12px; }
        .document-status.verified { color: var(--success); }
        .document-status.pending { color: var(--warning); }

        .form-actions { display: flex; gap: 15px; justify-content: center; margin-top: 28px; padding-top: 24px; border-top: 1px solid var(--medium-gray); }
        .btn-submit { background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%); color: var(--white); padding: 13px 30px; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(3,81,188,0.3); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(3,81,188,0.4); }
        .btn-cancel { background: var(--white); color: var(--dark-gray); padding: 13px 30px; border: 2px solid var(--medium-gray); border-radius: 10px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease; font-size: 15px; }
        .btn-cancel:hover { background: var(--light-gray); border-color: var(--dark-gray); transform: translateY(-2px); }

        .error { color: var(--danger); font-size: 12px; margin-top: 6px; display: block; font-weight: 500; }
        .success-message { background: var(--success); color: var(--white); padding: 12px 16px; border-radius: 10px; margin: 0 30px 18px; text-align: center; font-weight: 500; font-size: 14px; }
        .radio-required-msg { display: none; color: var(--danger); font-size: 12px; margin-top: 8px; font-weight: 500; }
        .radio-required-msg.show { display: block; }

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column; }
            .radio-group { grid-template-columns: 1fr; }
            .profile-header { padding: 22px; }
            .profile-form { padding: 0 18px 22px; }
            .profile-banner { margin: 18px; }
            .current-document { flex-direction: column; text-align: center; }
        }
    </style>
@endpush

@section('content')
    <div class="profile-edit-container">
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hiddenPref = document.getElementById('learning_preference_hidden');
            const radios     = document.querySelectorAll('input[name="learning_preference_radio"]');

            function setActiveRadio(value) {
                document.querySelectorAll('.radio-label').forEach(lbl => lbl.classList.remove('radio-label--active'));
                if (value) {
                    const target = document.querySelector(`input[name="learning_preference_radio"][value="${value}"]`);
                    if (target) { target.checked = true; target.nextElementSibling.classList.add('radio-label--active'); }
                }
            }

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    hiddenPref.value = this.value;
                    setActiveRadio(this.value);
                    document.getElementById('radio-error').classList.remove('show');
                });
            });

            setActiveRadio(hiddenPref.value);

            document.getElementById('profileForm').addEventListener('submit', function (e) {
                if (!hiddenPref.value) {
                    e.preventDefault();
                    document.getElementById('radio-error').classList.add('show');
                    document.querySelector('.form-section:last-of-type').scrollIntoView({ behavior: 'smooth' });
                }
            });

            const checkboxes = document.querySelectorAll('input[name="subjects[]"]');
            checkboxes.forEach(cb => cb.addEventListener('change', updateSelectedCount));
            updateSelectedCount();

            toggleCustomCity();

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
@endpush
