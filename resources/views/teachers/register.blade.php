@extends('layouts.welcomeLayout')
@section('content')

    <section class="register-section py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="register-card shadow-lg rounded-4 overflow-hidden" data-aos="fade-up" data-aos-duration="800">

                        <!-- Header avec icône -->
                        <div class="register-header text-center py-4 position-relative"
                             style="background: linear-gradient(135deg, #0d6efd, #004aad);">
                            <div class="icon-wrapper mx-auto mb-2"
                                 style="width: 70px; height: 70px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(0,0,0,0.2);">
                                <i class="bi bi-person-check-fill" style="font-size: 2rem; color: #0d6efd;"></i>
                            </div>
                            <h2 class="text-white fw-bold mb-1 fs-4">Devenir Tuteur</h2>
                            <p class="text-white-50 mb-0 small">Rejoignez notre communauté d'enseignants</p>
                        </div>

                        <!-- Formulaire -->
                        <div class="register-body p-4" style="background: #f8fbff;">
                            <form method="POST" action="{{ route('register') }}" id="registerForm">
                                @csrf
                                @method('POST')
                                <!-- Champ caché pour le rôle tuteur -->
                                <input type="hidden" name="role_id" value="3">

                                <!-- Prénom et Nom -->
                                <div class="row g-2 mb-3">
                                    <div class="col-md-6">
                                        <label for="firstname" class="form-label fw-semibold small">
                                            <i class="bi bi-person text-primary me-1"></i>Prénom
                                        </label>
                                        <input type="text"
                                               class="form-control rounded-pill px-3 py-2 @error('firstname') is-invalid @enderror"
                                               id="firstname"
                                               name="firstname"
                                               value="{{ old('firstname') }}"
                                               required
                                               autofocus
                                               placeholder="Prénom">
                                        @error('firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="lastname" class="form-label fw-semibold small">
                                            <i class="bi bi-person text-primary me-1"></i>Nom
                                        </label>
                                        <input type="text"
                                               class="form-control rounded-pill px-3 py-2 @error('lastname') is-invalid @enderror"
                                               id="lastname"
                                               name="lastname"
                                               value="{{ old('lastname') }}"
                                               required
                                               placeholder="Nom">
                                        @error('lastname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold small">
                                        <i class="bi bi-envelope text-primary me-1"></i>Email
                                    </label>
                                    <input type="email"
                                           class="form-control rounded-pill px-3 py-2 @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           placeholder="exemple@email.com">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Téléphone -->
                                <div class="mb-3">
                                    <label for="telephone" class="form-label fw-semibold small">
                                        <i class="bi bi-telephone text-primary me-1"></i>Téléphone <span class="text-muted">(optionnel)</span>
                                    </label>
                                    <input type="tel"
                                           class="form-control rounded-pill px-3 py-2 @error('telephone') is-invalid @enderror"
                                           id="telephone"
                                           name="telephone"
                                           value="{{ old('telephone') }}"
                                           placeholder="+229 XX XX XX XX">
                                    @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Mot de passe avec force indicator -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold small">
                                        <i class="bi bi-lock text-primary me-1"></i>Mot de passe
                                    </label>
                                    <div class="position-relative">
                                        <input type="password"
                                               class="form-control rounded-pill px-3 py-2 pe-5 @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               required
                                               placeholder="••••••••">
                                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                                                id="togglePassword" style="z-index: 10;">
                                            <i class="bi bi-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>

                                    <!-- Indicateur de force du mot de passe -->
                                    <div class="mt-2">
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" id="passwordStrengthBar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small id="passwordStrengthText" class="form-text"></small>
                                    </div>

                                    @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirmation mot de passe -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold small">
                                        <i class="bi bi-lock-fill text-primary me-1"></i>Confirmer le mot de passe
                                    </label>
                                    <div class="position-relative">
                                        <input type="password"
                                               class="form-control rounded-pill px-3 py-2 pe-5"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               required
                                               placeholder="••••••••">
                                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted"
                                                id="togglePasswordConfirm" style="z-index: 10;">
                                            <i class="bi bi-eye" id="eyeIconConfirm"></i>
                                        </button>
                                    </div>
                                    <small id="passwordMatchText" class="form-text"></small>
                                </div>

                                <!-- Bouton de soumission -->
                                <div class="d-grid gap-2 mb-3 mt-4">
                                    <button type="submit"
                                            class="btn btn-primary btn-lg rounded-pill py-2 fw-bold shadow-lg"
                                            style="background: linear-gradient(135deg, #0d6efd, #004aad); border: none;">
                                        <i class="bi bi-check-circle me-2"></i>Créer mon compte
                                    </button>
                                </div>

                                <!-- Lien vers connexion -->
                                <div class="text-center">
                                    <p class="text-muted mb-0 small">
                                        Déjà inscrit ?
                                        <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">
                                            Se connecter
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            . register-section {
                min-height: calc(100vh - 180px);
                background: linear-gradient(135deg, #f8fbff 0%, #e6f2ff 100%);
                padding-top: 2rem ! important;
                padding-bottom: 2rem ! important;
            }

            . register-card {
                background: white;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                max-width: 550px;
                margin: 0 auto;
            }

            .register-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 40px rgba(13, 110, 253, 0.15) !important;
            }

            .form-control {
                border: 2px solid #e3e8ef;
                transition: all 0.3s ease;
                font-size: 0.95rem;
            }

            . form-control:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
                background: white;
            }

            .form-control.is-invalid {
                border-color: #dc3545;
            }

            .form-control.is-valid {
                border-color: #28a745;
            }

            .form-label {
                color: #2c3e50;
                margin-bottom: 0.4rem;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3) !important;
            }

            .icon-wrapper {
                animation: float 3s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-8px);
                }
            }

            /* Styles pour l'indicateur de force */
            .password-weak {
                background-color: #dc3545 !important;
            }

            .password-medium {
                background-color: #ffc107 !important;
            }

            .password-strong {
                background-color: #28a745 !important;
            }

            /* Bouton œil */
            #togglePassword, #togglePasswordConfirm {
                padding: 0.25rem 0.75rem;
                text-decoration: none;
            }

            #togglePassword:hover, #togglePasswordConfirm:hover {
                color: #0d6efd ! important;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .register-header h2 {
                    font-size: 1.3rem;
                }

                .icon-wrapper {
                    width: 60px !important;
                    height: 60px ! important;
                }

                . icon-wrapper i {
                    font-size: 1.8rem ! important;
                }

                . register-body {
                    padding: 1. 5rem ! important;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const password = document.getElementById('password');
                const passwordConfirm = document.getElementById('password_confirmation');
                const strengthBar = document. getElementById('passwordStrengthBar');
                const strengthText = document. getElementById('passwordStrengthText');
                const matchText = document.getElementById('passwordMatchText');
                const togglePassword = document.getElementById('togglePassword');
                const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
                const eyeIcon = document.getElementById('eyeIcon');
                const eyeIconConfirm = document.getElementById('eyeIconConfirm');

                // Toggle visibility password
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    eyeIcon.classList. toggle('bi-eye');
                    eyeIcon.classList.toggle('bi-eye-slash');
                });

                togglePasswordConfirm.addEventListener('click', function() {
                    const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordConfirm.setAttribute('type', type);
                    eyeIconConfirm.classList.toggle('bi-eye');
                    eyeIconConfirm.classList.toggle('bi-eye-slash');
                });

                // Vérification de la force du mot de passe
                password.addEventListener('input', function() {
                    const val = password.value;
                    let strength = 0;

                    if (val.length >= 8) strength++;
                    if (val.match(/[a-z]+/)) strength++;
                    if (val.match(/[A-Z]+/)) strength++;
                    if (val.match(/[0-9]+/)) strength++;
                    if (val.match(/[$@#&!]+/)) strength++;

                    // Reset classes
                    strengthBar.classList.remove('password-weak', 'password-medium', 'password-strong');

                    switch(strength) {
                        case 0:
                        case 1:
                        case 2:
                            strengthBar.style.width = '33%';
                            strengthBar.classList.add('password-weak');
                            strengthText.textContent = '❌ Mot de passe faible';
                            strengthText.style.color = '#dc3545';
                            break;
                        case 3:
                        case 4:
                            strengthBar.style.width = '66%';
                            strengthBar. classList.add('password-medium');
                            strengthText.textContent = '⚠️ Mot de passe moyen';
                            strengthText.style.color = '#ffc107';
                            break;
                        case 5:
                            strengthBar.style.width = '100%';
                            strengthBar.classList.add('password-strong');
                            strengthText.textContent = '✅ Mot de passe fort';
                            strengthText.style.color = '#28a745';
                            break;
                    }

                    // Vérifier la correspondance si confirmation n'est pas vide
                    if (passwordConfirm.value) {
                        checkPasswordMatch();
                    }
                });

                // Vérification de la correspondance des mots de passe
                passwordConfirm.addEventListener('input', checkPasswordMatch);

                function checkPasswordMatch() {
                    if (passwordConfirm.value === '') {
                        matchText.textContent = '';
                        passwordConfirm.classList.remove('is-invalid', 'is-valid');
                        return;
                    }

                    if (password.value === passwordConfirm. value) {
                        matchText. textContent = '✅ Les mots de passe correspondent';
                        matchText.style.color = '#28a745';
                        passwordConfirm.classList.remove('is-invalid');
                        passwordConfirm.classList.add('is-valid');
                    } else {
                        matchText.textContent = '❌ Les mots de passe ne correspondent pas';
                        matchText.style.color = '#dc3545';
                        passwordConfirm.classList.remove('is-valid');
                        passwordConfirm.classList. add('is-invalid');
                    }
                }

                // Validation avant soumission
                document.getElementById('registerForm').addEventListener('submit', function(e) {
                    if (password.value !== passwordConfirm.value) {
                        e.preventDefault();
                        alert('Les mots de passe ne correspondent pas ! ');
                        passwordConfirm.focus();
                    }
                });
            });
        </script>
    @endpush

@endsection
