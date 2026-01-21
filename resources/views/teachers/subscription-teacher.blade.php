@extends('layouts.welcomeLayout')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-9 col-lg-7 mb-3">
        
        <div class="card border-0 shadow-lg pricing-card mx-auto d-flex flex-column justify-content-between">
            <div class="card-body p-4 p-md-5 text-center d-flex flex-column justify-content-between h-100">
                
                <div>
                    <div class="icon-box-circle mb-4">
                        <i class="fas fa-user-check"></i>
                    </div>

                    <h2 class="font-weight-bold text-navy mb-3">Tuteur Abonné</h2>
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
                            data-amount="6500"
                            data-title="Abonnement Tuteur">
                        S'abonner maintenant
                    </button>

                    <p class="small text-muted mt-3 mb-0">
                        <i class="fas fa-shield-alt mr-1"></i> Paiement sécurisé par FedaPay
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
        min-height: 400px; /* ✅ Augmente la longueur (hauteur) */
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
    }

    .btn-primary-gradient:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 10px 20px rgba(0, 97, 242, 0.25); 
        color: white; 
    }
</style>
@endpush

@push('scripts')
    {{-- Le script FedaPay reste le même --}}
    <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @auth
            const payButton = document.querySelector('.btn-pay-subscription');
            
            if (payButton) {
                payButton.addEventListener('click', function () {
                    const amount = this.dataset.amount;
                    const title = this.dataset.title;

                    const widget = FedaPay.init({
                        public_key: '{{ config("services.fedapay.public_key") }}',
                        transaction: {
                            amount: amount,
                            description: title
                        },
                        customer: {
                            email: '{{ auth()->user()->email }}',
                            firstname: '{{ auth()->user()->firstname }}',
                            lastname: '{{ auth()->user()->lastname }}'
                        },
                        onComplete(resp) {
                            if (resp.reason === 'CHECKOUT COMPLETE') {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '{{route("paiement.callback") }}';

                                const csrf = document.createElement('input');
                                csrf.type = 'hidden';
                                csrf.name = '_token';
                                csrf.value = '{{ csrf_token() }}';
                                form.appendChild(csrf);

                                const transactionInput = document.createElement('input');
                                transactionInput.type = 'hidden';
                                transactionInput.name = 'id';
                                transactionInput.value = resp.transaction.id;
                                form.appendChild(transactionInput);

                                const typeInput = document.createElement('input');
                                typeInput.type = 'hidden';
                                typeInput.name = 'payment_type';
                                typeInput.value = 'subscription';
                                form.appendChild(typeInput);

                                document.body.appendChild(form);
                                form.submit();
                            }
                        }
                    });
                    widget.open();
                });
            }
            @else
            document.querySelector('.btn-pay-subscription').addEventListener('click', function() {
                window.location.href = '{{ route("login") }}';
            });
            @endauth
        });
    </script>
@endpush