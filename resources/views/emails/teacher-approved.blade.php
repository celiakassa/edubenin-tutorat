@extends('emails.layout')

@section('title', 'Votre compte professeur a été approuvé - Kopiao')
@section('preheader', 'Votre compte tuteur Kopiao est approuvé.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Félicitations {{ $teacher->firstname }} ! 🎉
    </p>

    <p style="margin: 0 0 16px;">
        Votre compte tuteur <strong>Kopiao</strong> a été approuvé avec succès.
    </p>

    @if (!empty($reason))
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 16px; background-color: #f0fdf4; border-left: 4px solid #16a34a; border-radius: 6px;">
            <tr><td style="padding: 14px 18px;">
                <p style="margin: 0 0 4px; font-weight: 700; color: #1b1535;">Message de l'équipe Kopiao</p>
                <p style="margin: 0; color: #2a2541;">{{ $reason }}</p>
            </td></tr>
        </table>
    @endif

    <p style="margin: 0 0 10px;">Vous pouvez dès à présent :</p>
    <ul style="margin: 0 0 16px; padding-left: 20px;">
        <li style="margin-bottom: 6px;">Recevoir des candidatures aux annonces</li>
        <li style="margin-bottom: 6px;">Compléter votre profil pour être plus visible</li>
        <li>Définir vos disponibilités</li>
    </ul>

    @include('emails.components.button', ['url' => route('login'), 'text' => 'Accéder à mon compte'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
