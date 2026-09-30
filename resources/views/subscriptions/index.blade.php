@extends('layouts.dashboard')

@section('title', 'Mon abonnement - Kopiao')
@section('page-title', 'Mon abonnement')

@push('styles')
    <style>
        .ms-page { max-width: 900px; margin: 0 auto; }
        .ms-head { margin-bottom: 22px; }
        .ms-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-2xl); font-weight: 800; color: var(--kp-ink); margin: 0 0 5px; }
        .ms-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }
        .ms-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; align-items: stretch; }
        .ms-card { background: #fff; border: 1px solid var(--kp-border); border-radius: 20px; padding: 26px 24px; display: flex; flex-direction: column; }
        .ms-card--premium { background: linear-gradient(160deg, var(--kp-blue), var(--kp-blue-darker)); color: #fff; border: none; box-shadow: var(--kp-shadow); }
        .ms-card__tag { align-self: flex-start; background: var(--kp-blue-soft); color: var(--kp-blue); padding: 5px 14px; border-radius: 20px; font-size: var(--kp-fs-2xs); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 14px; }
        .ms-card--premium .ms-card__tag { background: rgba(255, 255, 255, .18); color: #fff; }
        .ms-card__price { font-family: var(--kp-font-title); font-size: 2.2rem; font-weight: 800; line-height: 1; color: var(--kp-ink); }
        .ms-card--premium .ms-card__price { color: #fff; }
        .ms-card__price small { font-size: var(--kp-fs-sm); font-weight: 600; opacity: .8; }
        .ms-list { list-style: none; padding: 0; margin: 18px 0; flex: 1; }
        .ms-list li { display: flex; align-items: center; gap: 10px; padding: 8px 0; font-size: var(--kp-fs-base); }
        .ms-list li .fa-check { color: #16a34a; }
        .ms-list li .fa-times { color: var(--kp-muted); }
        .ms-card--premium .ms-list li .fa-check { color: var(--kp-yellow); }
        .ms-card--premium .ms-list li .fa-times { color: rgba(255, 255, 255, .6); }
        .ms-btn { width: 100%; height: 52px; border: none; border-radius: var(--kp-radius-pill); background: var(--kp-yellow); color: #1a1a1a; font-weight: 700; font-size: var(--kp-fs-base); cursor: pointer; transition: all .2s; }
        .ms-btn:hover { background: #fff; transform: translateY(-2px); }
        .ms-current { text-align: center; font-weight: 700; padding: 14px 0; color: var(--kp-blue); }
        .ms-card--premium .ms-current { color: #fff; }
    </style>
@endpush

@section('content')
    <div class="ms-page">
        <div class="ms-head">
            <h2>Offre actuelle : {{ $plan->label() }}</h2>
            @if ($subscription)
                <p>Valable jusqu'au {{ $subscription->date_fin->translatedFormat('d F Y') }}. Vous recevrez un email avec un lien pour la renouveler.</p>
            @else
                <p>Passez au Premium pour publier plus d'annonces et profiter de tous les avantages.</p>
            @endif
        </div>

        <div class="ms-grid">
            @foreach ($plans as $key => $definition)
                <div class="ms-card {{ $key === 'premium' ? 'ms-card--premium' : '' }}">
                    <span class="ms-card__tag">{{ $definition['label'] }}</span>
                    <div class="ms-card__price">
                        {{ number_format($definition['price'], 0, ',', ' ') }} <small>{{ config('plans.currency') }} / mois</small>
                    </div>
                    <ul class="ms-list">
                        <li><i class="fas fa-check"></i> {{ $definition['max_annonces'] === null ? 'Annonces illimitées' : $definition['max_annonces'].' annonces' }}</li>
                        @foreach (config('plans.feature_labels') as $feature => $featureLabel)
                            <li>
                                <i class="fas {{ ($definition['features'][$feature] ?? false) ? 'fa-check' : 'fa-times' }}"></i>
                                {{ $featureLabel }}
                            </li>
                        @endforeach
                    </ul>
                    @if ($plan->value === $key)
                        <div class="ms-current"><i class="fas fa-check-circle"></i> Votre offre actuelle</div>
                        @if ($key === 'premium')
                            <form method="POST" action="{{ route('subscriptions.premium.subscribe') }}">
                                @csrf
                                <button type="submit" class="ms-btn">Renouveler maintenant</button>
                            </form>
                        @endif
                    @elseif ($key === 'premium')
                        <form method="POST" action="{{ route('subscriptions.premium.subscribe') }}">
                            @csrf
                            <button type="submit" class="ms-btn">Passer au Premium</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
