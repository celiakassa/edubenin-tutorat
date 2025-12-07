<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Compte rejeté - Kopiao</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #e74c3c;">Notification importante</h2>

        <p>Bonjour {{ $teacher->firstname }},</p>

        <p>Votre demande de création de compte professeur sur Kopiao a été examinée.</p>

        <div style="background-color: #fde8e8; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #e74c3c;">
            <p><strong>Raison du rejet :</strong></p>
            <p>{{ $reason }}</p>
        </div>

        <p>Vous pouvez :</p>
        <ul>
            <li>Corriger les problèmes mentionnés ci-dessus</li>
            <li>Soumettre à nouveau votre demande</li>
            <li>Nous contacter si vous avez des questions</li>
        </ul>

        <p style="margin-top: 30px;">
            <a href="{{ url('/contact') }}" style="background-color: #1E63C4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Nous contacter
            </a>
        </p>

        <p style="color: #666; font-size: 14px; margin-top: 30px;">
            Cordialement,<br>
            L'équipe Kopiao
        </p>
    </div>
</body>
</html>
