@extends('layouts.auth')

@section('title', 'Mot de passe oublié')
@section('brand_text', 'Pas de panique. On vous aide à récupérer l\'accès à votre compte Kopiao.')

@section('content')
    <style>
        .auth-form__title { font-family: var(--kp-font-title); font-weight: 800; font-size: 1.6rem; color: var(--kp-ink); margin: 0 0 4px; }
        .auth-form__sub { color: var(--kp-muted); margin: 0 0 24px; line-height: 1.5; }
        .auth-group { margin-bottom: 16px; }
        .auth-group label { display: block; font-size: .85rem; font-weight: 600; color: var(--kp-text); margin-bottom: 6px; }
        .auth-field-wrap { position: relative; }
        .auth-field-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--kp-muted); font-size: 1rem; pointer-events: none; }
        .auth-error { color: #c0392b; font-size: .8rem; margin-top: 5px; display: block; }
        .auth-alert { padding: 12px 14px; border-radius: var(--kp-radius-sm); margin-bottom: 18px; font-size: .9rem; background: #e7f6ee; color: #1d7a48; }
        .auth-foot { text-align: center; margin-top: 20px; font-size: .9rem; }
        .auth-foot a { color: var(--kp-blue); font-weight: 600; text-decoration: none; }
        .auth-foot a:hover { text-decoration: underline; }
    </style>

    <h1 class="auth-form__title">Mot de passe oublié ?</h1>
    <p class="auth-form__sub">Indiquez votre adresse email et nous vous enverrons un lien de réinitialisation.</p>

    @if (session('status'))
        <div class="auth-alert"><i class="bi bi-check-circle"></i> {{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="auth-group">
            <label for="email">Adresse email</label>
            <div class="auth-field-wrap">
                <i class="bi bi-envelope auth-field-ico"></i>
                <input id="email" type="email" name="email" class="kp-field" value="{{ old('email') }}" required autofocus placeholder="votre@email.com" style="padding-left: 42px;">
            </div>
            @error('email')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="kp-btn kp-btn--primary kp-btn--block kp-btn--lg mt-2">
            <i class="bi bi-send"></i> Envoyer le lien
        </button>
    </form>

    <p class="auth-foot"><a href="{{ route('login') }}"><i class="bi bi-arrow-left"></i> Retour à la connexion</a></p>
@endsection
