@extends('emails.layout')

@section('title', 'Facture mensuelle - Kopiao')
@section('preheader', 'Votre facture du mois.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Bonjour {{ $user->firstname }},
    </p>

    <p style="margin: 0 0 16px;">
        Votre abonnement <strong>Standard</strong> du mois est de <strong>{{ number_format($amount, 0, ',', ' ') }} {{ config('plans.currency') }}</strong>.
    </p>

    @include('emails.components.button', ['url' => $checkoutUrl, 'text' => 'Payer ma facture'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
