@extends('emails.layout')

@section('title', 'Votre compte a été validé - Kopiao')
@section('preheader', 'Votre compte élève Kopiao est validé.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Compte validé, {{ $user->firstname }} ! 🎉
    </p>

    <p style="margin: 0 0 16px;">
        Votre compte élève <strong>Kopiao</strong> a été validé avec succès.
    </p>

    @if (!empty($reason))
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 16px; background-color: #f0fdf4; border-left: 4px solid #16a34a; border-radius: 6px;">
            <tr><td style="padding: 14px 18px;">
                <p style="margin: 0 0 4px; font-weight: 700; color: #1b1535;">Message</p>
                <p style="margin: 0; color: #2a2541;">{{ $reason }}</p>
            </td></tr>
        </table>
    @endif

    <p style="margin: 0 0 10px;">Vous pouvez dès à présent :</p>
    <ul style="margin: 0 0 16px; padding-left: 20px;">
        <li style="margin-bottom: 6px;">Vous connecter à votre compte</li>
        <li style="margin-bottom: 6px;">Rechercher des tuteurs</li>
        <li style="margin-bottom: 6px;">Réserver des cours</li>
        <li>Accéder à votre historique d'apprentissage</li>
    </ul>

    @include('emails.components.button', ['url' => route('login'), 'text' => 'Me connecter'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
