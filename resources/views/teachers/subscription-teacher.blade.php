@extends('layouts.welcomeLayout')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-9 col-lg-7 mb-3">

            {{-- Affichage des messages flash --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card border-0 shadow-lg pricing-card mx-auto d-flex flex-column justify-content-between">
                <div class="card-body p-4 p-md-5 text-center d-flex flex-column justify-content-between h-100">

                    <div>
                        <div class="icon-box-circle mb-4">
                            <i class="fas fa-user-check"></i>
                        </div>

                        <h2 class="font-weight-bold text-navy mb-3">Abonnez-vous en tant que tuteur</h2>
                        <p class="text-muted-dark mb-4">
                            Accédez à toutes les opportunités ! Consultez les annonces, postulez librement, recevez des notifications en temps réel, débloquez les contacts après sélection et laissez des avis pour développer votre réputation sur la plateforme.
                        </p>

                        <ul class="list-unstyled text-left mb-4 px-md-4">
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-bullhorn text-primary-blue mr-3"></i>
                                <span>Voir toutes les annonces disponibles</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-paper-plane text-primary-blue mr-3"></i>
                                <span>Postuler sans limitation</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-bell text-primary-blue mr-3"></i>
                                <span>Recevoir des notifications instantanées</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-unlock-alt text-primary-blue mr-3"></i>
                                <span>Débloquer les contacts après sélection</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="fas fa-star text-primary-blue mr-3"></i>
                                <span>Laisser des avis et renforcer votre crédibilité</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <div class="price-tag mb-3">
                            <span class="h1 font-weight-bold text-navy">6 500</span>
                            <span class="text-muted font-weight-bold">FCFA / mois</span>
                        </div>

                        <button type="button"
                                class="btn btn-primary-gradient btn-block py-3 font-weight-bold shadow btn-pay-subscription"
                                id="pay-button">
                            <span class="spinner-border spinner-border-sm d-none" id="pay-spinner"></span>
                            <span id="pay-text">S'abonner maintenant</span>
                        </button>

                        <p class="small text-muted mt-3 mb-0">
                            <i class="fas fa-shield-alt mr-1"></i> Paiement sécurisé par Moneroo
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --navy: #1a2b4b;
            --primary-blue: #0061f2;
            --soft-blue: #f0f7ff;
        }

        body { background-color: #f4f7fa; }

        .pricing-card {
            border-radius: 25px;
            border-top: 8px solid var(--primary-blue) !important;
            max-width: 760px;
            min-height: 400px;
        }

        .text-navy { color: var(--navy); }

        .text-muted-dark {
            color: #5a6a85;
            line-height: 1.7;
            font-size: 1.05rem;
        }

        .icon-box-circle {
            width: 90px;
            height: 90px;
            background-color: var(--soft-blue);
            color: var(--primary-blue);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.3rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .price-tag {
            background-color: var(--soft-blue);
            padding: 18px;
            border-radius: 15px;
            width: 100%;
        }

        .btn-primary-gradient {
            background: linear-gradient(135deg, #0061f2 0%, #002d72 100%);
            color: white;
            border: none;
            border-radius: 15px;
            transition: 0.3s;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary-gradient:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 97, 242, 0.25);
            color: white;
        }

        .btn-primary-gradient:disabled {
            opacity: 0.8;
            cursor: not-allowed;
        }

        #pay-spinner {
            margin-right: 10px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('pay-button').addEventListener('click', async function () {
            @auth
            const btn = this;
            const spinner = document.getElementById('pay-spinner');
            const text = document.getElementById('pay-text');

            // Désactiver le bouton et afficher le spinner
            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.innerText = 'Initialisation du paiement...';

            try {
                const res = await fetch("{{ route('paiement.init') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({})
                });

                if (!res.ok) {
                    throw new Error(`Erreur HTTP: ${res.status}`);
                }

                const data = await res.json();

                if (data.success && data.checkout_url) {
                    text.innerText = 'Redirection...';
                    // Redirection vers la page de paiement Moneroo
                    window.location.href = data.checkout_url;
                } else {
                    throw new Error(data.message || "URL de paiement non reçue");
                }
            } catch (err) {
                console.error('Erreur paiement:', err);

                // Afficher l'erreur à l'utilisateur
                alert("Une erreur est survenue lors de l'initialisation du paiement. Veuillez réessayer.");

                // Réactiver le bouton
                btn.disabled = false;
                spinner.classList.add('d-none');
                text.innerText = "S'abonner maintenant";
            }
            @else
                window.location.href = "{{ route('login') }}";
            @endauth
        });
    </script>
@endpush
