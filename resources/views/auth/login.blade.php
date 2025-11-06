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

        <!--  Formulaire de connexion -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div style="margin-bottom:18px;">
                <label for="email" style="display:block; margin-bottom:6px; font-weight:bold; color:#000000;">
                    Email
                </label>
                <input id="email" type="email" name="email" required autofocus
                    style="width:100%; padding:12px; border:1px solid #a5b4fc;
                          border-radius:8px; transition: all 0.3s ease; outline:none;"
                    onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 8px rgba(99,102,241,0.3)';"
                    onblur="this.style.borderColor='#a5b4fc'; this.style.boxShadow='none';">
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
                    style="width:100%; padding:12px; border:1px solid #a5b4fc;
               border-radius:8px; transition: all 0.3s ease; outline:none; padding-right:45px;"
                    onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 8px rgba(99,102,241,0.3)';"
                    onblur="this.style.borderColor='#a5b4fc'; this.style.boxShadow='none';">

                <!-- Bouton afficher/masquer -->
                <button type="button" onclick="togglePassword()"
                    style="position:absolute; right:10px; top:36px; background:none; border:none; cursor:pointer; color:#6366f1; font-weight:bold;">
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
                <label style="display:flex; align-items:center; font-size:0.9rem; color:#1e40af;">
                    <input type="checkbox" name="remember" style="margin-right:6px;">
                    Se souvenir de moi
                </label>
            </div>

            <div style="display:flex; flex-direction:column; gap:10px; margin-top:15px; align-items:center;">
                <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            style="color:#6366f1; text-decoration:underline; font-size:0.9rem; transition: color 0.3s;">
                            Mot de passe oublié ?
                        </a>
                    @endif

                    <button type="submit"
                        style="background: linear-gradient(135deg, #6366f1, #4f46e5);
                       color:white; padding:12px 25px; border:none;
                       border-radius:8px; cursor:pointer; font-weight:bold;
                       transition: all 0.3s;">
                        Se connecter
                    </button>
                </div>

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
