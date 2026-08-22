@extends('emails.layout')

@section('title', 'Votre compte a été réactivé - Kopiao')
@section('preheader', 'Bonne nouvelle, votre compte Kopiao est de nouveau actif.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Bonne nouvelle, {{ $user->firstname }} !
    </p>

    <p style="margin: 0 0 16px;">
        Votre compte <strong>Kopiao</strong> a été réactivé avec succès.
    </p>

    @if (!empty($reason))
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 16px; background-color: #f0fdf4; border-left: 4px solid #16a34a; border-radius: 6px;">
            <tr><td style="padding: 14px 18px;">
                <p style="margin: 0 0 4px; font-weight: 700; color: #1b1535;">Message</p>
                <p style="margin: 0; color: #2a2541;">{{ $reason }}</p>
            </td></tr>
        </table>
    @endif

    <p style="margin: 0 0 16px;">
        Vous pouvez dès à présent vous reconnecter et retrouver toutes les fonctionnalités de votre compte.
    </p>

    @include('emails.components.button', ['url' => route('login'), 'text' => 'Me connecter'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
