@extends('layouts.dashboard')

@section('title', 'Abonnements - Administration')
@section('page-title', 'Abonnements')

@push('styles')
    <style>
        .ap-head { margin-bottom: 18px; }
        .ap-head h2 { font-family: var(--kp-font-title); font-size: var(--kp-fs-xl); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .ap-head p { color: var(--kp-muted); font-size: var(--kp-fs-base); margin: 0; }

        .ap-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 18px; margin-bottom: 18px; }
        .ap-card { background: #fff; border: 1px solid var(--kp-border); border-radius: 16px; padding: 22px; }
        .ap-card--premium { border-color: var(--kp-blue); }
        .ap-card__title { display: flex; align-items: center; gap: 10px; font-family: var(--kp-font-title); font-size: var(--kp-fs-lg); font-weight: 700; color: var(--kp-ink); margin: 0 0 4px; }
        .ap-card__title i { width: 38px; height: 38px; border-radius: 11px; background: var(--kp-blue-soft); color: var(--kp-blue); display: inline-flex; align-items: center; justify-content: center; font-size: var(--kp-fs-base); }
        .ap-card__hint { color: var(--kp-muted); font-size: var(--kp-fs-xs); margin: 0 0 16px; }

        .ap-field { margin-bottom: 14px; }
        .ap-field label { display: block; font-size: var(--kp-fs-xs); font-weight: 700; color: var(--kp-ink); margin-bottom: 6px; }
        .ap-field small { display: block; color: var(--kp-muted); font-size: var(--kp-fs-2xs); margin-top: 4px; }
        .ap-field input[type="text"], .ap-field input[type="number"] { width: 100%; height: 46px; padding: 0 14px; border: 1.5px solid var(--kp-border); border-radius: 12px; font-size: var(--kp-fs-base); background: #fff; }
        .ap-field input:focus { outline: none; border-color: var(--kp-blue); box-shadow: 0 0 0 3px var(--kp-blue-soft); }

        .ap-check { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-top: 1px solid var(--kp-border); font-size: var(--kp-fs-base); color: var(--kp-ink); cursor: pointer; }
        .ap-check input { width: 18px; height: 18px; accent-color: var(--kp-blue); }

        .ap-err { color: #e02c18; font-size: var(--kp-fs-2xs); font-weight: 600; margin-top: 4px; display: block; }
        .ap-actions { display: flex; justify-content: flex-end; }
        .ap-save { height: 46px; padding: 0 26px; border: none; border-radius: var(--kp-radius-pill); background: var(--kp-blue); color: #fff; font-weight: 700; font-size: var(--kp-fs-base); cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: background .2s; }
        .ap-save:hover { background: var(--kp-blue-darker); }
        @media (max-width: 520px) { .ap-actions, .ap-save { width: 100%; justify-content: center; } }
    </style>
@endpush

@section('content')
    <div class="ap-head">
        <h2>Offres Standard et Premium</h2>
        <p>Prix, limites, fonctionnalités et calendrier de facturation des élèves et parents.</p>
    </div>

    <form method="POST" action="{{ route('admin.plans.update') }}">
        @csrf
        @method('PUT')

        <div class="ap-grid">
            @foreach ($settings['plans'] as $key => $plan)
                <div class="ap-card {{ $key === 'premium' ? 'ap-card--premium' : '' }}">
                    <h3 class="ap-card__title">
                        <i class="fas {{ $key === 'premium' ? 'fa-crown' : 'fa-user' }}"></i>
                        {{ $plan['label'] }}
                    </h3>
                    <p class="ap-card__hint">
                        {{ $key === 'premium' ? 'Payé le jour de renouvellement, débit automatique.' : 'Facturé en fin de mois (si le prix est supérieur à 0).' }}
                    </p>

                    <div class="ap-field">
                        <label for="label_{{ $key }}">Nom affiché</label>
                        <input type="text" id="label_{{ $key }}" name="plans[{{ $key }}][label]" value="{{ old("plans.$key.label", $plan['label']) }}" required>
                        @error("plans.$key.label")<span class="ap-err">{{ $message }}</span>@enderror
                    </div>

                    <div class="ap-field">
                        <label for="price_{{ $key }}">Prix mensuel ({{ config('plans.currency') }})</label>
                        <input type="number" min="0" id="price_{{ $key }}" name="plans[{{ $key }}][price]" value="{{ old("plans.$key.price", $plan['price']) }}" required>
                        @error("plans.$key.price")<span class="ap-err">{{ $message }}</span>@enderror
                    </div>

                    <div class="ap-field">
                        <label for="max_{{ $key }}">Nombre maximum d'annonces</label>
                        <input type="number" min="0" id="max_{{ $key }}" name="plans[{{ $key }}][max_annonces]" value="{{ old("plans.$key.max_annonces", $plan['max_annonces']) }}" placeholder="Illimité">
                        <small>Laisser vide pour un nombre illimité.</small>
                        @error("plans.$key.max_annonces")<span class="ap-err">{{ $message }}</span>@enderror
                    </div>

                    @foreach ($featureLabels as $feature => $featureLabel)
                        <label class="ap-check">
                            <input type="checkbox" name="plans[{{ $key }}][features][{{ $feature }}]" value="1"
                                   {{ old("plans.$key.features.$feature", $plan['features'][$feature] ?? false) ? 'checked' : '' }}>
                            {{ $featureLabel }}
                        </label>
                    @endforeach
                </div>
            @endforeach

            <div class="ap-card">
                <h3 class="ap-card__title"><i class="fas fa-calendar-alt"></i> Calendrier</h3>
                <p class="ap-card__hint">Renouvellement automatique et rappels par email.</p>

                <div class="ap-field">
                    <label for="renewal_day">Jour du mois du renouvellement Premium</label>
                    <input type="number" min="1" max="28" id="renewal_day" name="renewal_day" value="{{ old('renewal_day', $settings['renewal_day']) }}" required>
                    <small>Entre 1 et 28. Ce jour-là (00h10), les Premium échus sont renouvelés ; en cas d'échec du débit, l'élève repasse en Standard et reçoit un lien pour se réabonner.</small>
                    @error('renewal_day')<span class="ap-err">{{ $message }}</span>@enderror
                </div>

                <div class="ap-field">
                    <label for="reminder_days_before">Rappel avant la fin (en jours)</label>
                    <input type="number" min="1" max="28" id="reminder_days_before" name="reminder_days_before" value="{{ old('reminder_days_before', $settings['reminder_days_before']) }}" required>
                    <small>Un email est envoyé à l'élève ce nombre de jours avant la fin de son Premium.</small>
                    @error('reminder_days_before')<span class="ap-err">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="ap-actions">
            <button type="submit" class="ap-save"><i class="fas fa-save"></i> Enregistrer</button>
        </div>
    </form>
@endsection
