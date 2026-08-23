@extends('emails.layout')

@section('title', 'Bienvenue dans la newsletter Kopiao')
@section('preheader', 'Merci de vous être abonné à la newsletter Kopiao.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Bienvenue dans la newsletter Kopiao !
    </p>

    <p style="margin: 0 0 16px;">
        Merci de vous être abonné avec l'adresse <strong>{{ $email }}</strong>.
    </p>

    <p style="margin: 0 0 16px;">
        Vous recevrez désormais nos actualités : nouvelles fonctionnalités, conseils pour trouver le bon tuteur
        ou pour bien démarrer en tant que tuteur, et offres spéciales.
    </p>

    @include('emails.components.button', ['url' => url('/'), 'text' => 'Découvrir Kopiao'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
