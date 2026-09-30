@extends('emails.layout')

@section('title', 'Offre Premium expirée - Kopiao')
@section('preheader', 'Vous êtes repassé en offre Standard. Retrouvez le Premium en un clic.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Votre offre Premium a expiré, {{ $user->firstname }}
    </p>

    <p style="margin: 0 0 20px;">
        Nous n'avons pas reçu le renouvellement de votre abonnement : votre compte est repassé en offre <strong>Standard</strong>.
        Vos annonces et votre historique sont conservés.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 8px; background-color: #fff8e6; border-left: 4px solid #f5a300; border-radius: 6px;">
        <tr>
            <td style="padding: 14px 18px;">
                <p style="margin: 0 0 4px; font-weight: 700; color: #1b1535;">Retrouvez vos avantages Premium</p>
                <p style="margin: 0; color: #2a2541;">
                    {{ number_format(\App\Enums\SubscriptionPlan::Premium->price(), 0, ',', ' ') }} {{ config('plans.currency') }} / mois — l'abonnement redémarre dès le paiement.
                </p>
            </td>
        </tr>
    </table>

    @include('emails.components.button', ['url' => $renewalUrl, 'text' => 'Reprendre le Premium'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
