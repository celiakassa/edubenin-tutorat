@extends('layouts.auth')

@section('title', 'Connexion')
@section('brand_text', 'Content de vous revoir ! Connectez-vous pour accéder à votre espace Kopiao.')

@section('content')
    <style>
        .auth-form__title { font-family: var(--kp-font-title); font-weight: 800; font-size: 1.6rem; color: var(--kp-ink); margin: 0 0 4px; }
        .auth-form__sub { color: var(--kp-muted); margin: 0 0 24px; }
        .auth-group { margin-bottom: 16px; }
        .auth-group label { display: block; font-size: .85rem; font-weight: 600; color: var(--kp-text); margin-bottom: 6px; }
        .auth-field-wrap { position: relative; }
        .auth-field-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--kp-muted); font-size: 1rem; pointer-events: none; }
        .pw-wrap { position: relative; }
        .pw-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--kp-muted); cursor: pointer; padding: 4px; }
        .pw-toggle:hover { color: var(--kp-blue); }
        .auth-error { color: #c0392b; font-size: .8rem; margin-top: 5px; display: block; }
        .auth-alert { padding: 12px 14px; border-radius: var(--kp-radius-sm); margin-bottom: 18px; font-size: .9rem; }
        .auth-alert--ok { background: #e7f6ee; color: #1d7a48; }
        .auth-alert--err { background: #fdecea; color: #c0392b; }
        .auth-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 20px; }
        .auth-check { display: inline-flex; align-items: center; gap: 7px; font-size: .88rem; color: var(--kp-text); cursor: pointer; }
        .auth-check input { accent-color: var(--kp-blue); width: 15px; height: 15px; }
        .auth-link { color: var(--kp-blue); font-size: .88rem; text-decoration: none; }
        .auth-link:hover { text-decoration: underline; }
        .auth-sep { display: flex; align-items: center; gap: 12px; margin: 20px 0; color: var(--kp-muted); font-size: .85rem; }
        .auth-sep::before, .auth-sep::after { content: ''; flex: 1; height: 1px; background: var(--kp-border); }
        .google-btn {
            display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%;
            padding: 11px; border: 1px solid var(--kp-border); border-radius: var(--kp-radius-pill);
            background: var(--kp-white); color: var(--kp-text); font-weight: 600; font-size: .92rem;
            text-decoration: none; transition: var(--kp-transition);
        }
        .google-btn:hover { background: var(--kp-surface); border-color: var(--kp-blue); }
        .auth-foot { text-align: center; margin-top: 18px; font-size: .9rem; color: var(--kp-muted); }
        .auth-foot a { color: var(--kp-blue); font-weight: 600; text-decoration: none; }
        .auth-foot a:hover { text-decoration: underline; }
    </style>

    <h1 class="auth-form__title">Connexion</h1>
    <p class="auth-form__sub">Accédez à votre compte Kopiao</p>

    @if (session('status'))
        <div class="auth-alert auth-alert--ok">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="auth-alert auth-alert--err">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="auth-group">
            <label for="email">Email</label>
            <div class="auth-field-wrap">
                <i class="bi bi-envelope auth-field-ico"></i>
                <input type="email" id="email" name="email" class="kp-field" required autofocus
                    value="{{ old('email') }}" placeholder="exemple@email.com" style="padding-left: 42px;">
            </div>
            @error('email')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <div class="auth-group">
            <label for="password">Mot de passe</label>
            <div class="pw-wrap">
                <i class="bi bi-lock auth-field-ico"></i>
                <input type="password" id="password" name="password" class="kp-field" required
                    placeholder="Votre mot de passe" style="padding-left: 42px; padding-right: 42px;">
                <button type="button" class="pw-toggle" onclick="togglePassword()" aria-label="Afficher le mot de passe">
                    <i class="bi bi-eye" id="pwIcon"></i>
                </button>
            </div>
            @error('password')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <div class="auth-row">
            <label class="auth-check"><input type="checkbox" name="remember"> Se souvenir de moi</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Mot de passe oublié ?</a>
            @endif
        </div>

        <button type="submit" class="kp-btn kp-btn--primary kp-btn--block kp-btn--lg">Se connecter</button>
    </form>

    <div class="auth-sep"><span>ou</span></div>

    <a href="{{ route('google.login') }}" class="google-btn">
        <svg width="20" height="20" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        Se connecter avec Google
    </a>

    @if (Route::has('register'))
        <p class="auth-foot">Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
    @endif

    @push('scripts')
        <script>
            function togglePassword() {
                const input = document.getElementById('password');
                const icon = document.getElementById('pwIcon');
                if (input.type === 'password') { input.type = 'text'; icon.className = 'bi bi-eye-slash'; }
                else { input.type = 'password'; icon.className = 'bi bi-eye'; }
            }
        </script>
    @endpush
@endsection
