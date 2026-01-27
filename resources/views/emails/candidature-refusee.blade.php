<!DOCTYPE html>
<html>
<head>
    <title>Candidature Refusée</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%); 
                  color: white; padding: 30px; text-align: center; border-radius: 10px; }
        .content { background: #f8fafc; padding: 30px; border-radius: 10px; margin-top: 20px; }
        .btn { display: inline-block; padding: 12px 24px; background: #0351BC; 
               color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bonjour {{ $tuteur->firstname }},</h1>
            <p>Mise à jour de votre candidature</p>
        </div>
        
        <div class="content">
            <p>Votre candidature pour l'annonce "<strong>{{ $annonce->domaine }}</strong>" 
            a été refusée par l'étudiant.</p>
            
            <p>Ne vous découragez pas ! Voici quelques conseils :</p>
            
            <ul>
                <li>Complétez votre profil avec vos qualifications et expériences</li>
                <li>Personnalisez vos messages de candidature</li>
                <li>Postulez rapidement aux nouvelles annonces</li>
                <li>Définissez un taux horaire compétitif</li>
            </ul>
            
            <p><strong>Continuez à postuler à d'autres annonces qui correspondent à vos compétences.</strong></p>
            
            <a href="{{ route('annonces.index') }}" class="btn">
                Voir d'autres annonces
            </a>
            
            <p style="margin-top: 30px; font-size: 12px; color: #64748b;">
                Cet email a été envoyé par Kopiao - Plateforme de mise en relation étudiant/tuteur
            </p>
        </div>
    </div>
</body>
</html>