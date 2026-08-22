@extends('emails.layout')

@section('title', 'Votre compte professeur a été rejeté - Kopiao')
@section('preheader', 'Mise à jour concernant votre demande de compte tuteur Kopiao.')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Bonjour {{ $teacher->firstname }},
    </p>

    <p style="margin: 0 0 16px;">
        Votre demande de création de compte tuteur sur <strong>Kopiao</strong> a été examinée par notre équipe.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 16px; background-color: #fef2f2; border-left: 4px solid #dc2626; border-radius: 6px;">
        <tr><td style="padding: 14px 18px;">
            <p style="margin: 0 0 4px; font-weight: 700; color: #1b1535;">Raison du rejet</p>
            <p style="margin: 0; color: #2a2541;">{{ $reason }}</p>
        </td></tr>
    </table>

    <p style="margin: 0 0 10px;">Vous pouvez :</p>
    <ul style="margin: 0 0 16px; padding-left: 20px;">
        <li style="margin-bottom: 6px;">Corriger les éléments mentionnés ci-dessus</li>
        <li style="margin-bottom: 6px;">Soumettre à nouveau votre demande</li>
        <li>Nous contacter si vous avez des questions</li>
    </ul>

    @include('emails.components.button', ['url' => 'mailto:'.config('mail.from.address'), 'text' => 'Nous contacter'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
