<!DOCTYPE html>
<html>
<head>
    <title>Candidature Acceptée</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #0351BC 0%, #4a7fd4 100%); 
                  color: white; padding: 30px; text-align: center; border-radius: 10px; }
        .content { background: #f8fafc; padding: 30px; border-radius: 10px; margin-top: 20px; }
        .btn { display: inline-block; padding: 12px 24px; background: #10b981; 
               color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .contact-info { background: white; padding: 20px; border-radius: 8px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Félicitations {{ $tuteur->firstname }} !</h1>
            <p>Votre candidature a été acceptée</p>
        </div>
        
        <div class="content">
            <h2>Détails de l'annonce</h2>
            <p><strong>Domaine :</strong> {{ $annonce->domaine }}</p>
            <p><strong>Description :</strong> {{ Str::limit($annonce->description, 200) }}</p>
            <p><strong>Budget :</strong> {{ number_format($annonce->budget, 0, ',', ' ') }} FCFA</p>
            <p><strong>Date souhaitée :</strong> {{ $annonce->disponibilite->format('d/m/Y H:i') }}</p>
            <p><strong>Format :</strong> 
                @if($annonce->format == 'presentiel')
                    Présentiel
                @elseif($annonce->format == 'en_ligne')
                    En ligne
                @else
                    Hybride
                @endif
            </p>
            
            <div class="contact-info">
                <h3>📞 Contactez votre étudiant</h3>
                <p><strong>Nom :</strong> {{ $etudiant->firstname }} {{ $etudiant->lastname }}</p>
                <p><strong>Email :</strong> {{ $etudiant->email }}</p>
                @if($etudiant->telephone)
                    <p><strong>Téléphone :</strong> {{ $etudiant->telephone }}</p>
                @endif
                @if($etudiant->city)
                    <p><strong>Ville :</strong> {{ $etudiant->city }}</p>
                @endif
            </div>
            
            <p style="margin-top: 20px;">
                <strong>Important :</strong> Contactez rapidement l'étudiant pour organiser votre première session.
                L'acompte de {{ number_format($annonce->acompte, 0, ',', ' ') }} FCFA sera libéré 
                dès que l'étudiant confirmera le début du cours.
            </p>
            
            <a href="{{ route('dashboardUser') }}" class="btn">
                Aller à mon tableau de bord
            </a>
            
            <p style="margin-top: 30px; font-size: 12px; color: #64748b;">
                Cet email a été envoyé par Kopiao - Plateforme de mise en relation étudiant/tuteur
            </p>
        </div>
    </div>
</body>
</html>