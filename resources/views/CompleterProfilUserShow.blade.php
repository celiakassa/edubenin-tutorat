@extends('layouts.dashboard')

@section('title', 'Mon Profil')
@section('page-title', 'Mon profil')

@push('styles')
    <style>
        .settings { max-width: 900px; margin: 0 auto; }

        /* En-tête */
        .settings__head { padding-bottom: 6px; }
        .settings__head h2 { font-size: var(--kp-fs-base); font-weight: 800; letter-spacing: .7px; text-transform: uppercase; color: var(--kp-ink); margin: 0 0 5px; }
        .settings__head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }
        .settings__progress { display: flex; align-items: center; gap: 10px; margin-top: 14px; }
        .settings__progress .bar { flex: 1; max-width: 260px; height: 6px; background: var(--kp-border); border-radius: 6px; overflow: hidden; }
        .settings__progress .bar span { display: block; height: 100%; background: var(--kp-blue); border-radius: 6px; transition: width .5s; }
        .settings__progress .txt { font-size: var(--kp-fs-xs); font-weight: 600; color: var(--kp-muted); }

        .settings__alert { background: #e7f6ee; color: #1d7a48; padding: 12px 16px; border-radius: 12px; font-weight: 500; font-size: var(--kp-fs-base); margin: 16px 0; display: flex; align-items: center; gap: 9px; }

        /* Ligne de réglage */
        .srow { display: grid; grid-template-columns: 1fr 380px; gap: 28px; align-items: start; padding: 20px 0; border-top: 1px solid var(--kp-border); }
        .srow__info h3 { font-size: var(--kp-fs-md); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .srow__info p { color: var(--kp-muted); font-size: var(--kp-fs-sm); margin: 0; line-height: 1.45; }
        .srow__ctrl { display: flex; flex-direction: column; gap: 8px; align-items: stretch; }

        .s-input { width: 100%; padding: 10px 14px; border: 1.5px solid var(--kp-border); border-radius: 10px; font-size: var(--kp-fs-base); font-family: inherit; background: #fff; color: var(--kp-ink); transition: border-color .2s, box-shadow .2s; }
        .s-input:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }
        textarea.s-input { resize: vertical; min-height: 84px; }
        .s-error { color: #c0392b; font-size: var(--kp-fs-xs); }

        /* Photo */
        .s-photo { display: flex; align-items: center; gap: 12px; justify-content: flex-end; }
        .s-photo__avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 1px solid var(--kp-border); }
        .s-import { display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; border: 1.5px solid var(--kp-border); border-radius: 10px; background: #fff; color: var(--kp-ink); font-weight: 600; font-size: var(--kp-fs-base); cursor: pointer; transition: all .2s; }
        .s-import:hover { border-color: var(--kp-blue); color: var(--kp-blue); }

        .s-verified { align-self: flex-end; display: inline-flex; align-items: center; gap: 5px; background: #1d7a48; color: #fff; padding: 3px 12px; border-radius: var(--kp-radius-pill); font-size: var(--kp-fs-2xs); font-weight: 700; }

        /* Préférence (radios) */
        .s-radios { display: grid; grid-template-columns: repeat(3, 1fr); gap: 9px; }
        .s-radio input { position: absolute; opacity: 0; pointer-events: none; }
        .s-radio label { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 13px 6px; border: 1.5px solid var(--kp-border); border-radius: 11px; cursor: pointer; transition: all .2s; text-align: center; }
        .s-radio label i { font-size: var(--kp-fs-xl); color: var(--kp-muted); }
        .s-radio label span { font-size: var(--kp-fs-xs); font-weight: 600; color: var(--kp-text); }
        .s-radio label:hover { border-color: var(--kp-blue); }
        .s-radio.is-active label { border-color: var(--kp-blue); background: var(--kp-blue-soft); }
        .s-radio.is-active label i, .s-radio.is-active label span { color: var(--kp-blue); }

        /* Matières */
        .s-subjects { border: 1.5px solid var(--kp-border); border-radius: 10px; max-height: 220px; overflow-y: auto; padding: 6px; }
        .s-subject { display: flex; align-items: center; gap: 10px; padding: 8px 10px; border-radius: 8px; cursor: pointer; }
        .s-subject:hover { background: var(--kp-surface); }
        .s-subject input { width: 16px; height: 16px; accent-color: var(--kp-blue); flex-shrink: 0; }
        .s-subject label { font-size: var(--kp-fs-sm); color: var(--kp-text); cursor: pointer; margin: 0; }
        .s-count { align-self: flex-start; display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: var(--kp-blue-soft); color: var(--kp-blue); border-radius: var(--kp-radius-pill); font-size: var(--kp-fs-xs); font-weight: 600; }

        /* Pièce d'identité */
        .s-file { display: flex; align-items: center; gap: 9px; padding: 11px 14px; border: 1.5px dashed var(--kp-border); border-radius: 10px; cursor: pointer; justify-content: center; font-size: var(--kp-fs-sm); color: var(--kp-text); transition: all .2s; }
        .s-file:hover { border-color: var(--kp-blue); background: var(--kp-surface); }
        .s-file i { color: var(--kp-blue); }
        .s-doc { display: flex; align-items: center; gap: 11px; padding: 11px 13px; background: var(--kp-surface); border-radius: 10px; }
        .s-doc__ico { width: 38px; height: 38px; border-radius: 9px; background: var(--kp-blue); color: #fff; display: flex; align-items: center; justify-content: center; font-size: var(--kp-fs-lg); flex-shrink: 0; }
        .s-doc__name { font-size: var(--kp-fs-sm); font-weight: 600; color: var(--kp-ink); word-break: break-all; }
        .s-doc__status { font-size: var(--kp-fs-2xs); font-weight: 600; }
        .s-doc__status.ok { color: #1d7a48; }
        .s-doc__status.wait { color: #b8860b; }

        /* Pied : enregistrer (bouton jaune) */
        .settings__foot { display: flex; justify-content: flex-end; padding-top: 22px; border-top: 1px solid var(--kp-border); }
        .s-save { background: var(--kp-yellow); color: #1a1a1a; border: none; }
        .s-save:hover { background: #e0a800; color: #1a1a1a; }

        @media (max-width: 680px) {
            .srow { grid-template-columns: 1fr; gap: 10px; padding: 18px 0; }
            .s-photo { justify-content: flex-start; }
            .s-verified { align-self: flex-start; }
            .settings__foot .kp-btn { width: 100%; justify-content: center; }
        }
    </style>
@endpush

@section('content')
    @php
        $photo = $user->photo_path ? asset('storage/' . $user->photo_path) : asset('images/profill_default.webp');
        $cities = ['Cotonou', 'Porto-Novo', 'Parakou', 'Abomey-Calavi'];
        $preference = old('learning_preference', $user->learning_preference ?? '');
    @endphp

    <form action="{{ route('CompleterProfilUser.update') }}" method="POST" enctype="multipart/form-data" id="profileForm" class="settings">
        @csrf

        <div class="settings__head">
            <h2>Profil</h2>
            <p>Vos informations personnelles, visibles par les autres membres.</p>
            <div class="settings__progress">
                <div class="bar"><span style="width: {{ $profileCompletion }}%;"></span></div>
                <span class="txt">{{ $profileCompletion }}% complété</span>
            </div>
        </div>

        {{-- Photo --}}
        <div class="srow">
            <div class="srow__info">
                <h3>Photo de profil</h3>
                <p>Minimum 400×400px, JPG, PNG ou WebP.</p>
            </div>
            <div class="srow__ctrl">
                <div class="s-photo">
                    <img src="{{ $photo }}" id="pfAvatarImg" alt="Photo" class="s-photo__avatar">
                    <label class="s-import"><i class="bi bi-upload"></i> Importer
                        <input type="file" name="photo" id="photo" accept="image/*" hidden>
                    </label>
                </div>
                @error('photo')<span class="s-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Prénom --}}
        <div class="srow">
            <div class="srow__info">
                <h3>Prénom</h3>
                <p>Votre prénom tel qu'il apparaît dans l'app.</p>
            </div>
            <div class="srow__ctrl">
                <input type="text" class="s-input" name="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                @error('firstname')<span class="s-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Nom --}}
        <div class="srow">
            <div class="srow__info">
                <h3>Nom</h3>
                <p>Votre nom visible par les autres membres.</p>
            </div>
            <div class="srow__ctrl">
                <input type="text" class="s-input" name="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                @error('lastname')<span class="s-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Email --}}
        <div class="srow">
            <div class="srow__info">
                <h3>Adresse e-mail</h3>
                <p>Votre adresse de connexion et de contact.</p>
            </div>
            <div class="srow__ctrl">
                <input type="email" class="s-input" name="email" value="{{ old('email', $user->email) }}" required>
                @if ($user->email_verified_at)
                    <span class="s-verified"><i class="bi bi-patch-check-fill"></i> Vérifié</span>
                @endif
                @error('email')<span class="s-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Téléphone --}}
        <div class="srow">
            <div class="srow__info">
                <h3>Téléphone</h3>
                <p>Optionnel — pour les notifications urgentes.</p>
            </div>
            <div class="srow__ctrl">
                <input type="tel" class="s-input" name="telephone" value="{{ old('telephone', $user->telephone) }}" placeholder="+229 XX XX XX XX" required>
                @error('telephone')<span class="s-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Ville --}}
        <div class="srow">
            <div class="srow__info">
                <h3>Ville</h3>
                <p>Votre ville pour des cours à proximité.</p>
            </div>
            <div class="srow__ctrl">
                <select class="s-input" id="city" name="city" required onchange="toggleCustomCity()">
                    <option value="">Sélectionnez votre ville</option>
                    @foreach ($cities as $v)
                        <option value="{{ $v }}" {{ old('city', $user->city) == $v ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                    <option value="autre" {{ !in_array($user->city, $cities) && $user->city ? 'selected' : '' }}>Autre</option>
                </select>
                <input type="text" class="s-input" id="custom_city" name="custom_city" placeholder="Entrez votre ville" style="display:none;"
                    value="{{ old('custom_city', !in_array($user->city, $cities) ? $user->city : '') }}">
                @error('city')<span class="s-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Bio --}}
        <div class="srow">
            <div class="srow__info">
                <h3>Bio</h3>
                <p>Quelques mots à votre sujet, visibles par les autres.</p>
            </div>
            <div class="srow__ctrl">
                <textarea class="s-input" name="bio" rows="3" placeholder="Quelques mots à votre sujet...">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')<span class="s-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- ===== Tuteur ===== --}}
        @if ($user->role_id == 3)
            <div class="srow">
                <div class="srow__info">
                    <h3>Niveau d'études</h3>
                    <p>Votre plus haut diplôme obtenu.</p>
                </div>
                <div class="srow__ctrl">
                    <select class="s-input" name="qualifications" required>
                        <option value="">Sélectionnez votre niveau</option>
                        @foreach ($qualificationsList as $value => $label)
                            <option value="{{ $value }}" {{ old('qualifications', $user->qualifications) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('qualifications')<span class="s-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="srow">
                <div class="srow__info">
                    <h3>Tarif horaire</h3>
                    <p>Votre tarif par heure, en FCFA.</p>
                </div>
                <div class="srow__ctrl">
                    <input type="number" class="s-input" name="rate_per_hour" min="0" placeholder="5000" value="{{ old('rate_per_hour', $user->rate_per_hour) }}" required>
                    @error('rate_per_hour')<span class="s-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="srow">
                <div class="srow__info">
                    <h3>Matières enseignées</h3>
                    <p>Sélectionnez les matières que vous enseignez.</p>
                </div>
                <div class="srow__ctrl">
                    <input type="text" class="s-input" id="subject-search" placeholder="Rechercher une matière..." onkeyup="filterSubjects()">
                    <div class="s-subjects" id="subjects-container">
                        @php $userSubjectIds = $user->subjects->pluck('id')->toArray(); @endphp
                        @foreach ($allSubjects as $subject)
                            <div class="s-subject" data-name="{{ strtolower($subject->nom) }}">
                                <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}"
                                    {{ in_array($subject->id, old('subjects', $userSubjectIds)) ? 'checked' : '' }} onchange="updateCount()">
                                <label for="subject_{{ $subject->id }}">{{ $subject->nom }}</label>
                            </div>
                        @endforeach
                    </div>
                    <span class="s-count"><i class="bi bi-check-circle"></i> <span id="selected-number">{{ count(old('subjects', $userSubjectIds)) }}</span> matière(s)</span>
                    @error('subjects')<span class="s-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="srow">
                <div class="srow__info">
                    <h3>Pièce d'identité</h3>
                    <p>Pour vérifier votre identité (PDF, JPG, PNG).</p>
                </div>
                <div class="srow__ctrl">
                    @if ($user->identity_document_path)
                        <div class="s-doc">
                            <div class="s-doc__ico"><i class="bi bi-{{ \Illuminate\Support\Str::endsWith($user->identity_document_path, ['.pdf']) ? 'file-pdf' : 'file-image' }}"></i></div>
                            <div>
                                <div class="s-doc__name">{{ basename($user->identity_document_path) }}</div>
                                <div class="s-doc__status {{ $user->identity_verified ? 'ok' : 'wait' }}">{{ $user->identity_verified ? '✓ Vérifiée' : '⏳ En attente' }}</div>
                            </div>
                        </div>
                    @endif
                    <label for="identity_document" class="s-file">
                        <i class="bi bi-upload"></i>
                        <span id="idDocLabel">{{ $user->identity_document_path ? "Remplacer la pièce..." : "Téléverser un document" }}</span>
                    </label>
                    <input type="file" id="identity_document" name="identity_document" accept=".pdf,.jpg,.jpeg,.png" hidden>
                    @error('identity_document')<span class="s-error">{{ $message }}</span>@enderror
                </div>
            </div>
        @endif

        {{-- Préférence --}}
        <div class="srow">
            <div class="srow__info">
                <h3>Préférence d'apprentissage</h3>
                <p>Comment préférez-vous suivre les cours ?</p>
            </div>
            <div class="srow__ctrl">
                <input type="hidden" name="learning_preference" id="learning_preference_hidden" value="{{ $preference }}">
                <div class="s-radios">
                    <div class="s-radio" data-value="online">
                        <input type="radio" name="lp_radio" id="lp_online" value="online" {{ $preference === 'online' ? 'checked' : '' }}>
                        <label for="lp_online"><i class="bi bi-laptop"></i> <span>En ligne</span></label>
                    </div>
                    <div class="s-radio" data-value="in_person">
                        <input type="radio" name="lp_radio" id="lp_inperson" value="in_person" {{ $preference === 'in_person' ? 'checked' : '' }}>
                        <label for="lp_inperson"><i class="bi bi-people"></i> <span>Présentiel</span></label>
                    </div>
                    <div class="s-radio" data-value="hybrid">
                        <input type="radio" name="lp_radio" id="lp_hybrid" value="hybrid" {{ $preference === 'hybrid' ? 'checked' : '' }}>
                        <label for="lp_hybrid"><i class="bi bi-shuffle"></i> <span>Hybride</span></label>
                    </div>
                </div>
                @error('learning_preference')<span class="s-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="settings__foot">
            <button type="submit" class="kp-btn kp-btn--lg s-save"><i class="bi bi-check-lg"></i> Enregistrer les modifications</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.getElementById('photo').addEventListener('change', function () {
            if (this.files && this.files[0]) {
                document.getElementById('pfAvatarImg').src = URL.createObjectURL(this.files[0]);
            }
        });

        function toggleCustomCity() {
            const val = document.getElementById('city').value;
            const custom = document.getElementById('custom_city');
            custom.style.display = val === 'autre' ? 'block' : 'none';
            if (val !== 'autre') custom.value = '';
        }
        toggleCustomCity();

        const idDoc = document.getElementById('identity_document');
        if (idDoc) {
            idDoc.addEventListener('change', function () {
                if (this.files.length) document.getElementById('idDocLabel').textContent = this.files[0].name;
            });
        }

        function filterSubjects() {
            const term = document.getElementById('subject-search').value.toLowerCase();
            document.querySelectorAll('.s-subject').forEach(el => {
                el.style.display = el.getAttribute('data-name').includes(term) ? 'flex' : 'none';
            });
        }
        function updateCount() {
            const n = document.querySelectorAll('input[name="subjects[]"]:checked').length;
            const el = document.getElementById('selected-number');
            if (el) el.textContent = n;
        }

        (function () {
            const hidden = document.getElementById('learning_preference_hidden');
            function setActive(value) {
                document.querySelectorAll('.s-radio').forEach(r => r.classList.toggle('is-active', r.dataset.value === value));
            }
            document.querySelectorAll('input[name="lp_radio"]').forEach(radio => {
                radio.addEventListener('change', function () { hidden.value = this.value; setActive(this.value); });
            });
            if (hidden.value) setActive(hidden.value);
        })();
    </script>
@endpush
