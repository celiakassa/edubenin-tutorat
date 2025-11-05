@extends('layouts.welcomeLayout')

@section('content')
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white py-4 rounded-top-3">
                        <h2 class="text-center mb-0">Vérifiez votre adresse email</h2>
                    </div>

                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <i class="bi bi-envelope-check display-1 text-primary"></i>
                        </div>

                        <h4 class="mb-3">Merci pour votre inscription !</h4>

                        <p class="mb-4">
                            Un lien de vérification a été envoyé à l'adresse <strong>{{ Auth::user()->email }}</strong>.<br>
                            Veuillez cliquer sur le lien dans cet email pour activer votre compte.
                        </p>

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            Si vous n'avez pas reçu l'email, vérifiez votre dossier spam ou demandez un nouvel envoi.
                        </div>

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send me-2"></i>Renvoyer l'email de vérification
                            </button>
                        </form>

                        <div class="mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
