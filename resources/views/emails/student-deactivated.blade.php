<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Compte désactivé - Kopiao</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #e74c3c;">Notification importante</h2>

        <p>Bonjour {{ $user->firstname }},</p>

        <p>Votre compte étudiant sur Kopiao a été désactivé.</p>

        @if(!empty($reason))
        <div style="background-color: #fde8e8; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #e74c3c;">
            <p><strong>Raison :</strong></p>
            <p>{{ $reason }}</p>
        </div>
        @endif

        <p>Cela signifie que :</p>
        <ul>
            <li>Vous ne pouvez plus vous connecter à votre compte</li>
            <li>Vous ne pouvez plus réserver de cours</li>
            <li>Vous ne recevrez plus de notifications</li>
        </ul>

        <p>Pour plus d'informations ou pour contester cette décision, veuillez nous contacter.</p>

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
