@extends('layouts.welcomeLayout')

@section('content')
<br><br><br><br>

<style>
    .forgot-password-container {
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

    .forgot-password-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .forgot-password-icon {
        font-size: 48px;
        color: #0351BC;
        margin-bottom: 15px;
    }

    .forgot-password-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 10px;
    }

    .forgot-password-subtitle {
        color: #718096;
        font-size: 14px;
        line-height: 1.5;
    }

    .email-input {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: white;
        margin-bottom: 5px;
    }

    .email-input:focus {
        border-color: #0351BC;
        box-shadow: 0 0 0 3px rgba(3, 81, 188, 0.1);
        outline: none;
    }

    .send-email-btn {
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
        margin-top: 20px;
    }

    .send-email-btn:hover {
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

    .alert-message {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        text-align: center;
    }

    .alert-info {
        background-color: #ebf8ff;
        color: #0351BC;
        border: 1px solid #bee3f8;
    }

    .error-message {
        color: #e53e3e;
        font-size: 14px;
        margin-top: 5px;
        text-align: left;
    }
</style>

<div class="forgot-password-container">
    <!-- Marquee Banner -->


    <!-- Header Section -->
    <div class="forgot-password-header">

            <div class="marquee-banner">
           
        <marquee behavior="scroll" direction="left" scrollamount="3" class="marquee-content">
            <i class="fas fa-info-circle marquee-icon"></i>

            <i class="fas fa-key marquee-icon"></i>
            {{ __('Mot de passe oublié ? Aucun problème. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation.') }}
        </marquee>
    </div>



    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Info Alert -->
    @if(session('status'))
        <div class="alert-message alert-info">
            <i class="fas fa-info-circle"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Input -->
        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; text-align: left; margin-bottom: 8px; font-weight: 600; color: #4a5568;">
                Adresse Email
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                class="email-input"
                placeholder="votre@email.com"
            >
            @error('email')
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="send-email-btn">
            <i class="fas fa-paper-plane"></i> Envoyer le lien de réinitialisation
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
