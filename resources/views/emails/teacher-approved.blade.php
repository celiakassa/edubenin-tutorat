<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Compte approuvé - Kopiao</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #1E63C4;">Félicitations {{ $teacher->firstname }} !</h2>

        <p>Votre compte professeur sur Kopiao a été approuvé avec succès.</p>

        @if(!empty($reason))
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0;">
            <p><strong>Message de l'administrateur :</strong></p>
            <p>{{ $reason }}</p>
        </div>
        @endif

        <p>Vous pouvez maintenant :</p>
        <ul>
            <li>Recevoir des demandes de cours</li>
            <li>Compléter votre profil pour être plus visible</li>
            <li>Définir vos disponibilités</li>
        </ul>

        <p style="margin-top: 30px;">
            <a href="{{ url('/login') }}" style="background-color: #1E63C4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Accéder à mon compte
            </a>
        </p>

        <p style="color: #666; font-size: 14px; margin-top: 30px;">
            Cordialement,<br>
            L'équipe Kopiao
        </p>
    </div>
</body>
</html>
