<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Repond par mots-cles quand Gemini est indisponible (quota, erreur, cle absente),
 * en s'appuyant sur les donnees reelles de la plateforme fournies dans $context.
 */
final class LiaFallbackService
{
    public function reply(string $message, array $context): string
    {
        $text = Str::lower($message);

        if (Str::contains($text, ['bonjour', 'bonsoir', 'salut', 'hello', 'coucou'])) {
            return "Bonjour ! Je suis Lia, l'assistante de Kopiao. Je peux vous renseigner sur nos tuteurs, nos matières ou la façon de vous inscrire.";
        }

        if (Str::contains($text, ['combien', 'nombre']) && Str::contains($text, ['tuteur', 'professeur', 'prof'])) {
            $count = $context['tutors_count'] ?? 0;

            return "Kopiao compte actuellement {$count} tuteur(s) actif(s) et validé(s) sur la plateforme.";
        }

        if (Str::contains($text, ['devenir tuteur', 'devenir prof', 'inscription tuteur', 'rejoindre'])) {
            return 'Pour devenir tuteur : créez un compte tuteur, complétez votre profil (matières, tarif, disponibilités), '
                .'puis attendez la validation de notre équipe. Rendez-vous sur la page "Devenir tuteur" du menu principal.';
        }

        if (Str::contains($text, ['matiere', 'matière', 'discipline']) || (Str::contains($text, ['cours']) && Str::contains($text, ['quel', 'quelle', 'liste']))) {
            $subjects = $context['subjects'] ?? [];
            if ($subjects !== []) {
                $list = implode(', ', array_slice($subjects, 0, 10));

                return "Les matières actuellement disponibles sur Kopiao sont : {$list}.";
            }

            return 'Kopiao propose des tuteurs dans de nombreuses matières, du primaire au supérieur.';
        }

        if (Str::contains($text, ['prix', 'tarif', 'cout', 'coût', 'combien ça coute', 'combien coute'])) {
            return "Chaque tuteur fixe librement son tarif horaire. Le budget total apparaît directement sur chaque annonce publiée par l'élève.";
        }

        if (Str::contains($text, ['acompte', 'paiement', 'payer'])) {
            return "Un acompte de 30% du budget est versé par l'élève pour publier son annonce ; il est reversé au tuteur après la première séance, le solde se réglant directement entre l'élève et le tuteur.";
        }

        if (Str::contains($text, ['contact', 'support', 'aide', 'probleme', 'problème'])) {
            return 'Vous pouvez contacter notre support via le formulaire de la page "Comment ça marche ?", ou par email à support@kopiao.com.';
        }

        if (Str::contains($text, ['annonce', 'demande'])) {
            return 'Les annonces publiées par les élèves sont consultables sur la page "Annonces". Les tuteurs abonnés peuvent y postuler selon leurs matières.';
        }

        if (Str::contains($text, ['merci'])) {
            return "Avec plaisir ! N'hésitez pas si vous avez d'autres questions sur Kopiao.";
        }

        return 'Je n\'ai pas assez d\'informations pour répondre précisément à cette question. '
            .'Vous pouvez consulter la page "Comment ça marche ?" ou contacter notre support pour plus de détails.';
    }
}
