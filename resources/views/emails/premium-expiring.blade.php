@extends('emails.layout')

@section('title', $isLastDay ? 'Dernier jour de votre offre Premium - Kopiao' : 'Votre offre Premium se termine bientôt - Kopiao')
@section('preheader', $isLastDay ? 'Renouvelez aujourd\'hui pour conserver vos avantages Premium.' : 'Renouvelez en un clic pour conserver vos avantages Premium.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        {{ $isLastDay ? 'Dernier jour pour renouveler' : 'Votre Premium arrive à échéance' }}, {{ $user->firstname }}
    </p>

    <p style="margin: 0 0 20px;">
        @if ($isLastDay)
            Votre offre <strong>Premium</strong> se termine <strong>aujourd'hui</strong>. Renouvelez-la maintenant pour ne perdre aucun de vos avantages.
        @else
            Votre offre <strong>Premium</strong> se termine le <strong>{{ $subscription->date_fin->translatedFormat('d F Y') }}</strong>. Renouvelez-la en un clic pour continuer à en profiter sans interruption.
        @endif
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 8px; background-color: #f5f8ff; border: 1px solid #dbe6fb; border-radius: 10px;">
        <tr>
            <td style="padding: 18px 20px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding: 4px 0; color: #6b6785; font-size: 14px;">Offre</td>
                        <td align="right" style="padding: 4px 0; font-weight: 700; color: #1b1535;">{{ \App\Enums\SubscriptionPlan::Premium->label() }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #6b6785; font-size: 14px;">Fin de l'abonnement actuel</td>
                        <td align="right" style="padding: 4px 0; font-weight: 700; color: #1b1535;">{{ $subscription->date_fin->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #6b6785; font-size: 14px;">Montant du renouvellement</td>
                        <td align="right" style="padding: 4px 0; font-weight: 700; color: #0B69F1;">{{ number_format(\App\Enums\SubscriptionPlan::Premium->price(), 0, ',', ' ') }} {{ config('plans.currency') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @include('emails.components.button', ['url' => $renewalUrl, 'text' => 'Renouveler mon Premium'])

    <p style="margin: 0 0 12px; font-size: 14px; color: #6b6785;">
        Le renouvellement prolonge votre abonnement à la suite de la période en cours : vous ne perdez aucun jour.
        Sans renouvellement, votre compte repassera automatiquement en offre Standard.
    </p>

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
