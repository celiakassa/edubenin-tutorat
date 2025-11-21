@extends('layouts.welcomeLayout')

@section('content')
<br><br><br><br>

<style>
    .reset-password-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 40px 30px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .marquee-banner {
        background: linear-gradient(135deg, #0351BC 0%, #023a8a 100%);
        color: white;
        padding: 15px 0;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(3, 81, 188, 0.3);
        overflow: hidden;
    }

    .marquee-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
    }

    .marquee-icon {
        font-size: 16px;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-5px);}
        60% {transform: translateY(-3px);}
    }

    .reset-password-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .reset-password-icon {
        font-size: 48px;
        color: #0351BC;
        margin-bottom: 15px;
    }

    .reset-password-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 10px;
    }

    .reset-password-subtitle {
        color: #718096;
        font-size: 14px;
        line-height: 1.5;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        text-align: left;
        margin-bottom: 8px;
        font-weight: 600;
        color: #4a5568;
    }

    .form-input {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        border-color: #0351BC;
        box-shadow: 0 0 0 3px rgba(3, 81, 188, 0.1);
        outline: none;
    }

    .reset-password-btn {
        width: 100%;
        background: linear-gradient(135deg, #0351BC 0%, #023a8a 100%);
        color: white;
        border: none;
        padding: 15px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .reset-password-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(3, 81, 188, 0.3);
    }

    .back-to-login {
        text-align: center;
        margin-top: 25px;
    }

    .back-link {
        color: #0351BC;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #023a8a;
        text-decoration: underline;
    }

    .error-message {
        color: #e53e3e;
        font-size: 14px;
        margin-top: 5px;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .password-requirements {
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
    }

    .requirements-title {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .requirements-list {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 12px;
        color: #718096;
    }

    .requirements-list li {
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>

<div class="reset-password-container">
    <!-- Marquee Banner -->
    <div class="marquee-banner">
        <marquee behavior="scroll" direction="left" scrollamount="3" class="marquee-content">

            <i class="fas fa-lock marquee-icon"></i>
            {{ __('Créez un nouveau mot de passe sécurisé pour votre compte. Assurez-vous qu il est fort et unique.') }}
        </marquee>
    </div>

    <!-- Header Section -->


    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">
                <i class="fas fa-envelope"></i> Adresse Email
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                required
                autofocus
                autocomplete="username"
                class="form-input"
                placeholder="votre@email.com"
            >
            @error('email')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">
                <i class="fas fa-key"></i> Nouveau mot de passe
            </label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="form-input"
                placeholder="Entrez votre nouveau mot de passe"
            >
            @error('password')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-key"></i> Confirmer le mot de passe
            </label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="form-input"
                placeholder="Confirmez votre nouveau mot de passe"
            >
            @error('password_confirmation')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password Requirements -->
        <div class="password-requirements">
            <div class="requirements-title">
                <i class="fas fa-info-circle"></i> Exigences du mot de passe
            </div>
            <ul class="requirements-list">
                <li><i class="fas fa-check"></i> Minimum 8 caractères</li>
               
            </ul>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="reset-password-btn">
            <i class="fas fa-sync-alt"></i> Réinitialiser le mot de passe
        </button>
    </form>

    <!-- Back to Login -->
    <div class="back-to-login">
        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Retour à la connexion
        </a>
    </div>
</div>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<br><br><br><br>
@endsection
