@extends('layouts.dashboard')

@section('title', 'Abonnement - Kopiao')
@section('page-title', 'Abonnement')

@push('styles')
    <style>
        .sub-page { max-width: 900px; margin: 0 auto; }
        .sub-back { display: inline-flex; align-items: center; gap: 8px; color: var(--kp-muted); text-decoration: none; font-weight: 600; font-size: var(--kp-fs-base); margin-bottom: 18px; transition: color .2s; }
        .sub-back:hover { color: var(--kp-blue); }
        .sub-head { margin-bottom: 24px; }
        .sub-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 800; color: var(--kp-ink); margin: 0 0 5px; }
        .sub-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .sub-grid { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; }
        @media (max-width: 820px) { .sub-grid { grid-template-columns: 1fr; } }

        /* Bénéfices — lignes épurées, sans fond blanc */
        .sub-benefits__title { font-family: var(--kp-font-title); font-size: var(--kp-fs-md); font-weight: 700; color: var(--kp-ink); margin: 0 0 6px; display: flex; align-items: center; gap: 9px; }
        .sub-benefits__title i { color: var(--kp-blue); }
        .sub-feature { display: flex; align-items: flex-start; gap: 14px; padding: 15px 0; border-bottom: 1px solid var(--kp-border); }
        .sub-feature:last-child { border-bottom: none; }
        .sub-feature__ico { width: 42px; height: 42px; border-radius: 12px; background: var(--kp-blue-soft); color: var(--kp-blue); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: var(--kp-fs-base); }
        .sub-feature__txt strong { display: block; color: var(--kp-ink); font-size: var(--kp-fs-base); font-weight: 700; margin-bottom: 2px; }
        .sub-feature__txt span { color: var(--kp-muted); font-size: var(--kp-fs-sm); line-height: 1.5; }

        /* Carte tarif (bleue, CTA jaune) */
        .sub-plan { background: linear-gradient(160deg, var(--kp-blue), var(--kp-blue-darker)); border-radius: 20px; padding: 26px 24px; color: #fff; text-align: center; position: sticky; top: 84px; box-shadow: var(--kp-shadow); }
        .sub-plan__tag { display: inline-block; background: rgba(255, 255, 255, .18); padding: 5px 14px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 16px; }
        .sub-plan__price { font-family: var(--kp-font-title); font-size: 2.4rem; font-weight: 800; line-height: 1; }
        .sub-plan__per { font-size: var(--kp-fs-sm); opacity: .85; margin-top: 4px; }
        .sub-plan__divider { height: 1px; background: rgba(255, 255, 255, .2); margin: 18px 0; }
        .sub-plan__note { font-size: var(--kp-fs-xs); opacity: .9; display: flex; align-items: center; justify-content: center; gap: 7px; }
        .sub-plan__btn { width: 100%; height: 52px; margin-top: 18px; border: none; border-radius: var(--kp-radius-pill); background: var(--kp-yellow); color: #1a1a1a; font-weight: 700; font-size: var(--kp-fs-base); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 9px; transition: all .2s; }
        .sub-plan__btn:hover:not(:disabled) { background: #fff; transform: translateY(-2px); }
        .sub-plan__btn:disabled { opacity: .8; cursor: not-allowed; }
        .sub-spinner { width: 16px; height: 16px; border: 2px solid rgba(26, 26, 26, .3); border-top-color: #1a1a1a; border-radius: 50%; display: inline-block; animation: subspin .7s linear infinite; }
        @keyframes subspin { to { transform: rotate(360deg); } }
        .sub-secure { font-size: var(--kp-fs-2xs); opacity: .85; margin: 12px 0 0; }
        .sub-error { margin-top: 14px; background: #fee2e2; color: #991b1b; border-radius: 12px; padding: 11px 14px; font-size: var(--kp-fs-sm); font-weight: 600; text-align: center; }
    </style>
@endpush

@section('content')
    <div class="sub-page">
        <a href="{{ url()->previous() }}" class="sub-back"><i class="fas fa-arrow-left"></i> Retour</a>

        <div class="sub-head">
            <h2>Devenez tuteur Premium</h2>
            <p>Débloquez toutes les opportunités de Kopiao et développez votre activité.</p>
        </div>

        <div class="sub-grid">
            {{-- Bénéfices --}}
            <div>
                <h3 class="sub-benefits__title"><i class="fas fa-gift"></i> Ce que débloque votre abonnement</h3>

                <div class="sub-feature">
                    <div class="sub-feature__ico"><i class="fas fa-bullhorn"></i></div>
                    <div class="sub-feature__txt"><strong>Voir toutes les annonces</strong><span>Accédez à l'intégralité des missions disponibles dans vos domaines.</span></div>
                </div>
                <div class="sub-feature">
                    <div class="sub-feature__ico"><i class="fas fa-paper-plane"></i></div>
                    <div class="sub-feature__txt"><strong>Postuler sans limitation</strong><span>Candidatez à autant de missions que vous le souhaitez.</span></div>
                </div>
                <div class="sub-feature">
                    <div class="sub-feature__ico"><i class="fas fa-bell"></i></div>
                    <div class="sub-feature__txt"><strong>Notifications instantanées</strong><span>Soyez alerté dès qu'une mission correspond à votre profil.</span></div>
                </div>
                <div class="sub-feature">
                    <div class="sub-feature__ico"><i class="fas fa-unlock-alt"></i></div>
                    <div class="sub-feature__txt"><strong>Débloquer les contacts</strong><span>Obtenez les coordonnées de l'apprenant après sélection.</span></div>
                </div>
                <div class="sub-feature">
                    <div class="sub-feature__ico"><i class="fas fa-star"></i></div>
                    <div class="sub-feature__txt"><strong>Laisser des avis</strong><span>Renforcez votre réputation et votre crédibilité sur la plateforme.</span></div>
                </div>
            </div>

            {{-- Carte tarif --}}
            <div>
                <div class="sub-plan">
                    <span class="sub-plan__tag">Abonnement mensuel</span>
                    <div class="sub-plan__price">6 500 <span style="font-size: var(--kp-fs-md); font-weight: 700;">FCFA</span></div>
                    <div class="sub-plan__per">par mois, sans engagement</div>

                    <button type="button" class="sub-plan__btn" id="pay-button">
                        <span class="sub-spinner d-none" id="pay-spinner"></span>
                        <span id="pay-text"><i class="fas fa-bolt"></i> S'abonner maintenant</span>
                    </button>

                    <div class="sub-plan__divider"></div>
                    <p class="sub-plan__note"><i class="fas fa-shield-alt"></i> Paiement sécurisé par Moneroo</p>
                    <div id="pay-error" class="sub-error" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('pay-button').addEventListener('click', async function () {
            @auth
            const btn = this;
            const spinner = document.getElementById('pay-spinner');
            const text = document.getElementById('pay-text');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.innerText = 'Initialisation...';

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
                    window.location.href = data.checkout_url;
                } else {
                    throw new Error(data.message || "URL de paiement non reçue");
                }
            } catch (err) {
                console.error('Erreur paiement:', err);
                const errBox = document.getElementById('pay-error');
                if (errBox) {
                    errBox.textContent = "Une erreur est survenue lors de l'initialisation du paiement. Veuillez réessayer.";
                    errBox.style.display = 'block';
                }
                btn.disabled = false;
                spinner.classList.add('d-none');
                text.innerHTML = '<i class="fas fa-bolt"></i> S\'abonner maintenant';
            }
            @else
                window.location.href = "{{ route('login') }}";
            @endauth
        });
    </script>
@endpush
