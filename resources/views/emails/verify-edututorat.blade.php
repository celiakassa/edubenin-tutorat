<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification d'adresse e-mail - EduTutorat</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: #007bff;
            text-align: center;
            color: #fff;
            padding: 30px 20px;
        }
        .header img.logo {
            width: 80px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 600;
        }
        .header p {
            font-size: 14px;
            margin-top: 5px;
            color: #dbe9ff;
        }
        .body {
            padding: 35px 25px;
            text-align: center;
        }
        .icon {
            width: 60px;
            margin-bottom: 15px;
        }
        .body h2 {
            color: #007bff;
            margin-bottom: 10px;
        }
        .body p {
            line-height: 1.7;
            font-size: 15px;
            color: #555;
        }
        .verify-btn {
            display: inline-block;
            margin-top: 25px;
            background-color: #007bff;
            color: white !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
        }
        .verify-btn:hover {
            background-color: #0056b3;
        }
        .footer {
            background: #f0f0f0;
            text-align: center;
            padding: 20px 10px;
            font-size: 13px;
            color: #777;
        }
        .footer strong {
            color: #007bff;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .signature {
            margin-top: 30px;
            color: #007bff;
            font-weight: 600;
            font-size: 14px;
        }
        @media only screen and (max-width: 480px) {
            .container {
                width: 95% !important;
                margin: 20px auto;
            }
            .header img.logo {
                width: 60px !important;
            }
            .verify-btn {
                width: 90% !important;
                padding: 12px 0 !important;
            }
        }

    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <!-- 🎓 Icône étudiant (dans le header) -->
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" alt="Icône étudiant EduTutorat" class="logo">
        <h1>EduTutorat</h1>
        <p>Ensemble pour la réussite 🎓</p>
    </div>

    <div class="body">
        <h2>Bienvenue, {{ $user->firstname ?? 'Cher utilisateur' }} 👋</h2>
        <p>Merci de t’être inscrit sur <strong>EduTutorat</strong>.<br>
            Pour activer ton compte et accéder à toutes les fonctionnalités, clique sur le bouton ci-dessous :</p>

        <a href="{{ $url }}" class="verify-btn">Vérifier mon adresse e-mail</a>

        <p style="margin-top: 25px;">
            Ce lien expirera dans 60 minutes.<br>
            Si tu n’as pas créé de compte, ignore simplement cet e-mail.
        </p>

        <div class="signature">
            — L’équipe EduTutorat 💙
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} <strong>EduTutorat</strong>. Tous droits réservés.<br>
        <a href="{{ config('app.url') }}">Visiter le site</a>
    </div>
</div>
</body>
</html>
