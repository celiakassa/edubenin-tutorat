@extends('emails.layout')

@section('title', 'Confirmez votre adresse email - Kopiao')
@section('preheader', 'Un dernier clic pour activer votre compte Kopiao.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Bonjour {{ $user->firstname }},
    </p>

    <p style="margin: 0 0 16px;">
        Merci de vous être inscrit sur <strong>Kopiao</strong> ! Il ne reste qu'une étape avant de pouvoir profiter
        pleinement de la plateforme : confirmer votre adresse email.
    </p>

    <p style="margin: 0 0 16px;">
        Cliquez sur le bouton ci-dessous pour activer votre compte.
    </p>

    @include('emails.components.button', ['url' => $url, 'text' => 'Activer mon compte'])

    <p style="margin: 0 0 16px; font-size: 13px; color: #6b7280;">
        Ce lien est valable 60 minutes. Si le bouton ne fonctionne pas, copiez-collez cette adresse dans votre navigateur :<br>
        <a href="{{ $url }}" style="color:#0B69F1; word-break: break-all;">{{ $url }}</a>
    </p>

    <p style="margin: 24px 0 0; font-size: 13px; color: #6b7280;">
        Vous n'êtes pas à l'origine de cette inscription ? Vous pouvez ignorer cet email en toute sécurité.
    </p>
@endsection
