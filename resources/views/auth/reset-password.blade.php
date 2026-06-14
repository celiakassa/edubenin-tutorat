@extends('layouts.auth')

@section('title', 'Nouveau mot de passe')
@section('brand_text', 'Choisissez un nouveau mot de passe sécurisé pour votre compte Kopiao.')

@section('content')
    <style>
        .auth-form__title { font-family: var(--kp-font-title); font-weight: 800; font-size: 1.6rem; color: var(--kp-ink); margin: 0 0 4px; }
        .auth-form__sub { color: var(--kp-muted); margin: 0 0 24px; line-height: 1.5; }
        .auth-group { margin-bottom: 16px; }
        .auth-group label { display: block; font-size: .85rem; font-weight: 600; color: var(--kp-text); margin-bottom: 6px; }
        .auth-field-wrap { position: relative; }
        .auth-field-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--kp-muted); font-size: 1rem; pointer-events: none; }
        .auth-error { color: #c0392b; font-size: .8rem; margin-top: 5px; display: block; }
        .auth-foot { text-align: center; margin-top: 20px; font-size: .9rem; }
        .auth-foot a { color: var(--kp-blue); font-weight: 600; text-decoration: none; }
        .auth-foot a:hover { text-decoration: underline; }
    </style>

    <h1 class="auth-form__title">Nouveau mot de passe</h1>
    <p class="auth-form__sub">Créez un mot de passe sécurisé (minimum 8 caractères).</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-group">
            <label for="email">Adresse email</label>
            <div class="auth-field-wrap">
                <i class="bi bi-envelope auth-field-ico"></i>
                <input id="email" type="email" name="email" class="kp-field" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="votre@email.com" style="padding-left: 42px;">
            </div>
            @error('email')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <div class="auth-group">
            <label for="password">Nouveau mot de passe</label>
            <div class="auth-field-wrap">
                <i class="bi bi-lock auth-field-ico"></i>
                <input id="password" type="password" name="password" class="kp-field" required autocomplete="new-password" placeholder="••••••••" style="padding-left: 42px;">
            </div>
            @error('password')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <div class="auth-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <div class="auth-field-wrap">
                <i class="bi bi-lock-fill auth-field-ico"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" class="kp-field" required autocomplete="new-password" placeholder="••••••••" style="padding-left: 42px;">
            </div>
            @error('password_confirmation')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="kp-btn kp-btn--primary kp-btn--block kp-btn--lg mt-2">
            <i class="bi bi-arrow-repeat"></i> Réinitialiser le mot de passe
        </button>
    </form>

    <p class="auth-foot"><a href="{{ route('login') }}"><i class="bi bi-arrow-left"></i> Retour à la connexion</a></p>
@endsection
