@extends('emails.layout')

@section('title', 'Réinitialisation de votre mot de passe - Kopiao')
@section('preheader', 'Vous avez demandé à réinitialiser votre mot de passe Kopiao.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Bonjour {{ $user->firstname }},
    </p>

    <p style="margin: 0 0 16px;">
        Vous avez demandé la réinitialisation du mot de passe associé à votre compte <strong>Kopiao</strong>.
        Cliquez sur le bouton ci-dessous pour choisir un nouveau mot de passe.
    </p>

    @include('emails.components.button', ['url' => $url, 'text' => 'Réinitialiser mon mot de passe'])

    <p style="margin: 0 0 16px; font-size: 13px; color: #6b7280;">
        Ce lien expirera dans {{ $expire }} minutes. Si le bouton ne fonctionne pas, copiez-collez cette adresse dans votre navigateur :<br>
        <a href="{{ $url }}" style="color:#0B69F1; word-break: break-all;">{{ $url }}</a>
    </p>

    <p style="margin: 24px 0 0; font-size: 13px; color: #6b7280;">
        Vous n'êtes pas à l'origine de cette demande ? Aucune action n'est nécessaire, votre mot de passe restera inchangé.
    </p>
@endsection
