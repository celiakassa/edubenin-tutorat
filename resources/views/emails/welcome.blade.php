@extends('emails.layout')

@section('title', 'Bienvenue sur Kopiao !')
@section('preheader', 'Votre compte est activé, voici comment démarrer sur Kopiao.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Bienvenue {{ $user->firstname }} ! 🎉
    </p>

    <p style="margin: 0 0 16px;">
        Votre adresse email est confirmée et votre compte <strong>Kopiao</strong> est désormais actif.
        Nous sommes ravis de vous compter parmi nous.
    </p>

    @if ($user->role_id === 3)
        <p style="margin: 0 0 16px;">
            En tant que tuteur, la prochaine étape consiste à compléter votre profil : matières enseignées,
            qualifications, tarif horaire et disponibilités. Un profil complet est la meilleure façon
            d'être repéré rapidement par les élèves.
        </p>

        @include('emails.components.button', ['url' => route('CompleterProfilUser.edit'), 'text' => 'Compléter mon profil'])
    @else
        <p style="margin: 0 0 16px;">
            Vous pouvez dès maintenant publier votre première annonce pour recevoir des candidatures
            de tuteurs qualifiés dans la matière de votre choix.
        </p>

        @include('emails.components.button', ['url' => route('annonces.create'), 'text' => 'Publier une annonce'])
    @endif

    <p style="margin: 24px 0 0;">
        Une question ? Notre équipe reste disponible pour vous accompagner à chaque étape.
    </p>

    <p style="margin: 16px 0 0;">
        À très vite,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
