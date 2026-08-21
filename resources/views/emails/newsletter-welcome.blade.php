<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenue - Kopiao</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #1E63C4;">Bienvenue dans la newsletter Kopiao !</h2>

        <p>Merci de vous être abonné avec l'adresse {{ $email }}.</p>

        <p>Vous recevrez désormais nos actualités : nouvelles fonctionnalités, conseils pour trouver le bon tuteur
            ou pour bien démarrer en tant que tuteur, et offres spéciales.</p>

        <p style="margin-top: 30px;">
            <a href="{{ url('/') }}" style="background-color: #1E63C4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Découvrir Kopiao
            </a>
        </p>

        <p style="color: #666; font-size: 14px; margin-top: 30px;">
            Cordialement,<br>
            L'équipe Kopiao
        </p>
    </div>
</body>
</html>
