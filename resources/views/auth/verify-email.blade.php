@extends('layouts.auth')

@section('title', 'Vérifiez votre email')
@section('brand_text', 'Une dernière étape avant de profiter de Kopiao : confirmez votre adresse email.')

@section('content')
    <style>
        .verify-ico {
            width: 76px; height: 76px; margin: 0 auto 18px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--kp-blue-soft); color: var(--kp-blue); font-size: 2rem;
        }
        .verify-title { font-family: var(--kp-font-title); font-weight: 800; font-size: 1.5rem; color: var(--kp-ink); margin: 0 0 8px; }
        .verify-text { color: var(--kp-text); font-size: .95rem; line-height: 1.6; margin: 0 0 18px; }
        .verify-text strong { color: var(--kp-ink); }
        .verify-alert { padding: 12px 14px; border-radius: var(--kp-radius-sm); font-size: .88rem; margin-bottom: 18px; text-align: left; }
        .verify-alert--ok { background: #e7f6ee; color: #1d7a48; }
        .verify-alert--info { background: var(--kp-blue-soft); color: var(--kp-blue); }
        .verify-logout { background: none; border: none; color: var(--kp-muted); font-size: .9rem; cursor: pointer; margin-top: 14px; text-decoration: underline; }
        .verify-logout:hover { color: var(--kp-blue); }
    </style>

    <div class="text-center">
        <div class="verify-ico"><i class="bi bi-envelope-check"></i></div>
        <h1 class="verify-title">Vérifiez votre email</h1>
        <p class="verify-text">
            Merci pour votre inscription ! Un lien de vérification a été envoyé à
            <strong>{{ Auth::user()->email }}</strong>. Cliquez sur ce lien pour activer votre compte.
        </p>

        @if (session('success'))
            <div class="verify-alert verify-alert--ok"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="verify-alert verify-alert--info">
            <i class="bi bi-info-circle"></i> Pas reçu l'email ? Vérifiez vos spams ou demandez un nouvel envoi.
        </div>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="kp-btn kp-btn--primary kp-btn--block kp-btn--lg">
                <i class="bi bi-send"></i> Renvoyer l'email de vérification
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="verify-logout">Se déconnecter</button>
        </form>
    </div>
@endsection
