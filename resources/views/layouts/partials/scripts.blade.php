<script>
    // Script pour gérer l'interactivité du dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du bouton "Compléter mon profil"
        const completeProfileBtn = document.querySelector('.btn-complete-profile');

        // Gestion des boutons de session
        const sessionButtons = document.querySelectorAll('.session-actions .btn');
        sessionButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (this.textContent.includes('Rejoindre')) {
                    alert('Connexion à la session de cours...');
                } else if (this.textContent.includes('Détails')) {
                    alert('Affichage des détails de la session...');
                } else if (this.textContent.includes('Message')) {
                    alert('Ouverture de la messagerie...');
                } else if (this.textContent.includes('Reporter')) {
                    alert('Ouverture du calendrier pour reporter la session...');
                }
            });
        });

        // Simulation de données dynamiques (pourrait être remplacé par des appels API)
        function updateStats() {
            // Cette fonction pourrait être utilisée pour mettre à jour les statistiques en temps réel
            console.log('Mise à jour des statistiques...');
        }

        // Mettre à jour les stats toutes les 30 secondes (simulation)
        setInterval(updateStats, 30000);
    });
</script>