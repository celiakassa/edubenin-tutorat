<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Compte réactivé - Kopiao</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #27ae60;">Bonne nouvelle !</h2>

        <p>Bonjour {{ $user->firstname }},</p>

        <p>Votre compte sur Kopiao a été réactivé avec succès.</p>

        @if(!empty($reason))
        <div style="background-color: #d4edda; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #27ae60;">
            <p><strong>Message :</strong></p>
            <p>{{ $reason }}</p>
        </div>
        @endif

        <p>Vous pouvez maintenant vous reconnecter et accéder à toutes les fonctionnalités de votre compte.</p>

        <p style="margin-top: 30px;">
            <a href="{{ url('/login') }}" style="background-color: #1E63C4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Se connecter
            </a>
        </p>

        <p style="color: #666; font-size: 14px; margin-top: 30px;">
            Cordialement,<br>
            L'équipe Kopiao
        </p>
    </div>
</body>
</html>
