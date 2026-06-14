@extends('layouts.auth')

@section('title', 'Confirmer le mot de passe')
@section('brand_text', 'Zone sécurisée. Confirmez votre identité pour continuer.')

@section('content')
    <style>
        .auth-form__title { font-family: var(--kp-font-title); font-weight: 800; font-size: 1.6rem; color: var(--kp-ink); margin: 0 0 4px; }
        .auth-form__sub { color: var(--kp-muted); margin: 0 0 24px; line-height: 1.5; }
        .auth-group { margin-bottom: 16px; }
        .auth-group label { display: block; font-size: .85rem; font-weight: 600; color: var(--kp-text); margin-bottom: 6px; }
        .auth-field-wrap { position: relative; }
        .auth-field-ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--kp-muted); font-size: 1rem; pointer-events: none; }
        .auth-error { color: #c0392b; font-size: .8rem; margin-top: 5px; display: block; }
    </style>

    <h1 class="auth-form__title">Zone sécurisée</h1>
    <p class="auth-form__sub">Veuillez confirmer votre mot de passe avant de continuer.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="auth-group">
            <label for="password">Mot de passe</label>
            <div class="auth-field-wrap">
                <i class="bi bi-lock auth-field-ico"></i>
                <input id="password" type="password" name="password" class="kp-field" required autocomplete="current-password" placeholder="••••••••" style="padding-left: 42px;">
            </div>
            @error('password')<span class="auth-error">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="kp-btn kp-btn--primary kp-btn--block kp-btn--lg mt-2">
            <i class="bi bi-shield-check"></i> Confirmer
        </button>
    </form>
@endsection
