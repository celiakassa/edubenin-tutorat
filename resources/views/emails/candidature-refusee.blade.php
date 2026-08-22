@extends('emails.layout')

@section('title', 'Mise à jour de votre candidature - Kopiao')
@section('preheader', 'Mise à jour concernant votre candidature Kopiao.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Bonjour {{ $tuteur->firstname }},
    </p>

    <p style="margin: 0 0 16px;">
        Votre candidature pour l'annonce « <strong>{{ $annonce->domaine }}</strong> » n'a pas été retenue par l'élève cette fois-ci.
    </p>

    <p style="margin: 0 0 10px;">Ne vous découragez pas ! Voici quelques conseils pour augmenter vos chances :</p>
    <ul style="margin: 0 0 16px; padding-left: 20px;">
        <li style="margin-bottom: 6px;">Complétez votre profil avec vos qualifications et expériences</li>
        <li style="margin-bottom: 6px;">Personnalisez vos messages de candidature</li>
        <li style="margin-bottom: 6px;">Postulez rapidement aux nouvelles annonces</li>
        <li>Définissez un taux horaire compétitif</li>
    </ul>

    <p style="margin: 0 0 16px;">
        <strong>Continuez à postuler à d'autres annonces qui correspondent à vos compétences.</strong>
    </p>

    @include('emails.components.button', ['url' => route('annonces.index'), 'text' => 'Voir d\'autres annonces'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
