@extends('emails.layout')

@section('title', 'Votre candidature a été acceptée - Kopiao')
@section('preheader', 'Bonne nouvelle, votre candidature a été acceptée !')

@section('content')
    <p style="margin: 0 0 18px; font-size: 18px; font-weight: 700; color: #1b1535;">
        Félicitations {{ $tuteur->firstname }} ! 🎉
    </p>

    <p style="margin: 0 0 20px;">
        Votre candidature vient d'être acceptée. Voici les informations pour organiser votre prochaine session.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 20px; background-color: #f7f8fa; border: 1px solid #e5e7eb; border-radius: 8px;">
        <tr><td style="padding: 18px 20px;">
            <p style="margin: 0 0 10px; font-weight: 700; color: #1b1535;">Détails de l'annonce</p>
            <p style="margin: 0 0 6px;"><strong>Domaine :</strong> {{ $annonce->domaine }}</p>
            <p style="margin: 0 0 6px;"><strong>Description :</strong> {{ Str::limit($annonce->description, 200) }}</p>
            <p style="margin: 0 0 6px;"><strong>Budget :</strong> {{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</p>
            <p style="margin: 0 0 6px;"><strong>Date souhaitée :</strong> {{ $annonce->disponibilite->format('d/m/Y H:i') }}</p>
            <p style="margin: 0;">
                <strong>Format :</strong>
                @if ($annonce->format == 'presentiel')
                    Présentiel
                @elseif ($annonce->format == 'en_ligne')
                    En ligne
                @else
                    Hybride
                @endif
            </p>
        </td></tr>
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 0 0 20px; background-color: #e7f0ff; border-radius: 8px;">
        <tr><td style="padding: 18px 20px;">
            <p style="margin: 0 0 10px; font-weight: 700; color: #1b1535;">📞 Contactez votre élève</p>
            <p style="margin: 0 0 6px;"><strong>Nom :</strong> {{ $etudiant->firstname }} {{ $etudiant->lastname }}</p>
            <p style="margin: 0 0 6px;"><strong>Email :</strong> {{ $etudiant->email }}</p>
            @if ($etudiant->telephone)
                <p style="margin: 0 0 6px;"><strong>Téléphone :</strong> {{ $etudiant->telephone }}</p>
            @endif
            @if ($etudiant->city)
                <p style="margin: 0;"><strong>Ville :</strong> {{ $etudiant->city }}</p>
            @endif
        </td></tr>
    </table>

    <p style="margin: 0 0 16px;">
        <strong>Important :</strong> contactez rapidement l'élève pour organiser votre première session.
        L'acompte de {{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA sera libéré
        dès que l'élève confirmera le début du cours.
    </p>

    @include('emails.components.button', ['url' => route('dashboardUser'), 'text' => 'Aller à mon tableau de bord'])

    <p style="margin: 24px 0 0;">
        Cordialement,<br>
        <strong>L'équipe Kopiao</strong>
    </p>
@endsection
