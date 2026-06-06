@extends('layouts.auth')

@section('title', 'Inscription Tuteur')
@section('brand_text', 'Partagez votre savoir. Rejoignez nos tuteurs et accompagnez des apprenants partout au Bénin.')

@section('content')
    <style>
        .auth-form__title { font-family: var(--kp-font-title); font-weight: 800; font-size: 1.6rem; color: var(--kp-ink); margin: 0 0 4px; }
        .auth-form__sub { color: var(--kp-muted); margin: 0 0 24px; }
        .auth-group { margin-bottom: 16px; }
        .auth-group label { display: block; font-size: .85rem; font-weight: 600; color: var(--kp-text); margin-bottom: 6px; }
        .auth-group label .opt { color: var(--kp-muted); font-weight: 400; }
        .pw-wrap { position: relative; }
        .pw-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--kp-muted); cursor: pointer; padding: 4px; }
        .pw-toggle:hover { color: var(--kp-blue); }
        .auth-error { color: #c0392b; font-size: .8rem; margin-top: 5px; display: block; }
        .auth-strength { height: 5px; border-radius: 3px; background: var(--kp-border); overflow: hidden; margin-top: 8px; }
        .auth-strength__bar { height: 100%; width: 0; transition: width .3s ease, background .3s ease; }
        .password-weak { background: #c0392b; }
        .password-medium { background: var(--kp-yellow); }
        .password-strong { background: #1d7a48; }
        .auth-hint { font-size: .8rem; margin-top: 5px; display: block; }
        .auth-foot { text-align: center; margin-top: 20px; font-size: .9rem; color: var(--kp-muted); }
        .auth-foot a { color: var(--kp-blue); font-weight: 600; text-decoration: none; }
        .auth-foot a:hover { text-decoration: underline; }
    </style>

    <h1 class="auth-form__title">Devenir tuteur</h1>
    <p class="auth-form__sub">Créez votre compte en quelques secondes</p>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf
        <input type="hidden" name="role_id" value="3">

        <div class="row g-3">
            <div class="col-md-6 auth-group">
                <label for="firstname">Prénom</label>
                <input type="text" id="firstname" name="firstname" class="kp-field" value="{{ old('firstname') }}" required autofocus placeholder="Prénom">
                @error('firstname')<span class="auth-error">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6 auth-group">
                <label for="lastname">Nom</label>
                <input type="text" id="lastname" name="lastname" class="kp-field" value="{{ old('lastname') }}" required placeholder="Nom">
                @error('lastname')<span class="auth-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="auth-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="kp-field" value="{{ old('email') }}" required placeholder="exemple@email.com">
            @error('email')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <div class="auth-group">
            <label for="telephone">Téléphone <span class="opt">(optionnel)</span></label>
            <input type="tel" id="telephone" name="telephone" class="kp-field" value="{{ old('telephone') }}" placeholder="+229 XX XX XX XX">
            @error('telephone')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <div class="auth-group">
            <label for="password">Mot de passe</label>
            <div class="pw-wrap">
                <input type="password" id="password" name="password" class="kp-field" required placeholder="••••••••" style="padding-right: 42px;">
                <button type="button" class="pw-toggle" id="togglePassword" aria-label="Afficher"><i class="bi bi-eye" id="eyeIcon"></i></button>
            </div>
            <div class="auth-strength"><div class="auth-strength__bar" id="passwordStrengthBar"></div></div>
            <small id="passwordStrengthText" class="auth-hint"></small>
            @error('password')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <div class="auth-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <div class="pw-wrap">
                <input type="password" id="password_confirmation" name="password_confirmation" class="kp-field" required placeholder="••••••••" style="padding-right: 42px;">
                <button type="button" class="pw-toggle" id="togglePasswordConfirm" aria-label="Afficher"><i class="bi bi-eye" id="eyeIconConfirm"></i></button>
            </div>
            <small id="passwordMatchText" class="auth-hint"></small>
        </div>

        <button type="submit" class="kp-btn kp-btn--primary kp-btn--block kp-btn--lg mt-2">
            <i class="bi bi-check-circle"></i> Créer mon compte
        </button>

        <p class="auth-foot">Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
    </form>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const password = document.getElementById('password');
                const passwordConfirm = document.getElementById('password_confirmation');
                const strengthBar = document.getElementById('passwordStrengthBar');
                const strengthText = document.getElementById('passwordStrengthText');
                const matchText = document.getElementById('passwordMatchText');

                document.getElementById('togglePassword').addEventListener('click', function () {
                    const t = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', t);
                    document.getElementById('eyeIcon').className = t === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
                });
                document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
                    const t = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordConfirm.setAttribute('type', t);
                    document.getElementById('eyeIconConfirm').className = t === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
                });

                password.addEventListener('input', function () {
                    const val = password.value;
                    let strength = 0;
                    if (val.length >= 8) strength++;
                    if (val.match(/[a-z]+/)) strength++;
                    if (val.match(/[A-Z]+/)) strength++;
                    if (val.match(/[0-9]+/)) strength++;
                    if (val.match(/[$@#&!]+/)) strength++;

                    strengthBar.classList.remove('password-weak', 'password-medium', 'password-strong');
                    if (strength <= 2) {
                        strengthBar.style.width = '33%'; strengthBar.classList.add('password-weak');
                        strengthText.textContent = 'Mot de passe faible'; strengthText.style.color = '#c0392b';
                    } else if (strength <= 4) {
                        strengthBar.style.width = '66%'; strengthBar.classList.add('password-medium');
                        strengthText.textContent = 'Mot de passe moyen'; strengthText.style.color = '#b8860b';
                    } else {
                        strengthBar.style.width = '100%'; strengthBar.classList.add('password-strong');
                        strengthText.textContent = 'Mot de passe fort'; strengthText.style.color = '#1d7a48';
                    }
                    if (passwordConfirm.value) checkMatch();
                });

                passwordConfirm.addEventListener('input', checkMatch);
                function checkMatch() {
                    if (passwordConfirm.value === '') { matchText.textContent = ''; return; }
                    if (password.value === passwordConfirm.value) {
                        matchText.textContent = '✓ Les mots de passe correspondent'; matchText.style.color = '#1d7a48';
                    } else {
                        matchText.textContent = '✗ Les mots de passe ne correspondent pas'; matchText.style.color = '#c0392b';
                    }
                }

                document.getElementById('registerForm').addEventListener('submit', function (e) {
                    if (password.value !== passwordConfirm.value) {
                        e.preventDefault();
                        passwordConfirm.focus();
                        matchText.textContent = '✗ Les mots de passe ne correspondent pas'; matchText.style.color = '#c0392b';
                    }
                });
            });
        </script>
    @endpush
@endsection
