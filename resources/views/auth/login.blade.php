@extends('layouts.welcomeLayout')
@section('content')
    <br><br>

    <style>
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(99, 102, 241, 0.3);
        }

        a:hover {
            color: #1e3a8a;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: white;
            color: #444;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-top: 15px;
        }

        .google-btn:hover {
            background-color: #f8f8f8;
            border-color: #0B69F1;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .separator {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #777;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .separator span {
            padding: 0 10px;
        }
    </style>

    <div class="login-container"
        style="max-width:510px; margin:50px auto; padding:40px 30px;
            background: linear-gradient(135deg, #f8fcff, #ffffff);
            border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.15);
            animation: fadeIn 1s ease;">

        @if (session('status'))
            <div
                style="background:#d1fae5; color:#065f46; padding:12px;
                    border-radius:6px; margin-bottom:20px; animation: fadeIn 1.2s;">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background:#fee2e2; color:#991b1b; padding:12px;
                    border-radius:6px; margin-bottom:20px; animation: fadeIn 1.2s;">
                {{ session('error') }}
            </div>
        @endif

        <!--  Formulaire de connexion -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div style="margin-bottom:18px;">
                <label for="email" style="display:block; margin-bottom:6px; font-weight:bold; color:#000000;">
                    Email
                </label>
                <input id="email" type="email" name="email" required autofocus
                    style="width:100%; padding:12px; border:1px solid #0B69F1;
                          border-radius:8px; transition: all 0.3s ease; outline:none;"
                    onfocus="this.style.borderColor='#0B69F1'; this.style.boxShadow='0 0 8px rgba(99,102,241,0.3)';"
                    onblur="this.style.borderColor='#0B69F1'; this.style.boxShadow='none';"
                    value="{{ old('email') }}">
                @error('email')
                    <span style="color:red; font-size:0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div style="margin-bottom:18px; position:relative;">
                <label for="password" style="display:block; margin-bottom:6px; font-weight:bold; color:#000000;">
                    Mot de passe
                </label>

                <input id="password" type="password" name="password" required
                    style="width:100%; padding:12px; border:1px solid #0B69F1;
               border-radius:8px; transition: all 0.3s ease; outline:none; padding-right:45px;"
                    onfocus="this.style.borderColor='#0B69F1'; this.style.boxShadow='0 0 8px rgba(99,102,241,0.3)';"
                    onblur="this.style.borderColor='#0B69F1'; this.style.boxShadow='none';">

                <!-- Bouton afficher/masquer -->
                <button type="button" onclick="togglePassword()"
                    style="position:absolute; right:10px; top:36px; background:none; border:none; cursor:pointer; color: #0B69F1; font-weight:bold;">
                    👁️
                </button>

                @error('password')
                    <span style="color:red; font-size:0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <script>
                function togglePassword() {
                    const passwordInput = document.getElementById('password');
                    const button = event.currentTarget;
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        button.textContent = '🚫';
                    } else {
                        passwordInput.type = 'password';
                        button.textContent = '👁️';
                    }
                }
            </script>

            <!-- Remember Me -->
            <div style="margin-bottom:20px;">
                <label style="display:flex; align-items:center; font-size:0.9rem; color: #0B69F1;">
                    <input type="checkbox" name="remember" style="margin-right:6px;">
                    Se souvenir de moi
                </label>
            </div>

            <div style="display:flex; flex-direction:column; gap:10px; margin-top:15px; align-items:center;">
                <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            style="color: #0B69F1; text-decoration:underline; font-size:0.9rem; transition: color 0.3s;">
                            Mot de passe oublié ?
                        </a>
                    @endif

                    <button type="submit"
                        style="background: linear-gradient(135deg, #0B69F1, #0B69F1);
                       color:white; padding:12px 25px; border:none;
                       border-radius:8px; cursor:pointer; font-weight:bold;
                       transition: all 0.3s;">
                        Se connecter
                    </button>
                </div>

                <!-- Séparateur -->
                <div class="separator" style="width:100%; margin:15px 0;">
                    <span>ou</span>
                </div>

                <!-- Bouton Google -->
                <a href="{{ route('google.login') }}" class="google-btn" style="display:flex; align-items:center; justify-content:center; gap:10px; width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; background-color:white; color:#444; font-weight:500; cursor:pointer; transition:all 0.3s ease; text-decoration:none;">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Se connecter avec Google
                </a>

                <!-- Lien inscription -->
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        style="color:#000000; text-decoration:underline; font-size:0.9rem; transition: color 0.3s; margin-top:10px;">
                        Pas encore de compte ? S’inscrire
                    </a>
                @endif
            </div>

        </form>
    </div>
@endsection
