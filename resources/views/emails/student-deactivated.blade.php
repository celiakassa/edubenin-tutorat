@extends('emails.layout')

@section('title', 'Votre compte a été désactivé - Kopiao')
@section('preheader', 'Votre compte élève Kopiao a été désactivé.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Bonjour {{ $user->firstname }},
    </p>

    <p style="margin: 0 0 16px;">
        Nous vous informons que votre compte élève <strong>Kopiao</strong> a été désactivé.
    </p>

    @if (!empty($reason))
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 16px; background-color: #fef2f2; border-left: 4px solid #dc2626; border-radius: 6px;">
            <tr><td style="padding: 14px 18px;">
                <p style="margin: 0 0 4px; font-weight: 700; color: #1b1535;">Raison</p>
                <p style="margin: 0; color: #2a2541;">{{ $reason }}</p>
            </td></tr>
        </table>
    @endif

    <p style="margin: 0 0 10px;">Concrètement, cela signifie que :</p>
    <ul style="margin: 0 0 16px; padding-left: 20px;">
        <li style="margin-bottom: 6px;">Vous ne pouvez plus vous connecter à votre compte</li>
        <li style="margin-bottom: 6px;">Vous ne pouvez plus publier ou réserver de cours</li>
        <li>Vous ne recevrez plus de notifications</li>
    </ul>

    <p style="margin: 0 0 16px;">
        Si vous pensez qu'il s'agit d'une erreur ou souhaitez contester cette décision, contactez notre équipe.
    </p>

    @include('emails.components.button', ['url' => 'mailto:'.config('mail.from.address'), 'text' => 'Nous contacter'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
