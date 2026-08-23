<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Repond par mots-cles quand Gemini est indisponible (quota, erreur, cle absente),
 * en s'appuyant sur les donnees reelles de la plateforme fournies dans $context.
 *
 * La detection tolere les fautes de frappe courantes : le message est normalise
 * (minuscules, accents retires, ponctuation supprimee) puis chaque mot est compare
 * aux racines de mots-cles par prefixe et par distance de Levenshtein, plutot
 * qu'une simple recherche de sous-chaine exacte.
 */
final class LiaFallbackService
{
    public function reply(string $message, array $context): string
    {
        $text = $this->normalize($message);

        if ($this->hasKeyword($text, ['bonjour', 'bonsoir', 'salut', 'hello', 'coucou'])) {
            return "Bonjour ! Je suis Lia, l'assistante de Kopiao. Je peux vous renseigner sur nos tuteurs, nos matières ou la façon de vous inscrire.";
        }

        if ($this->hasKeyword($text, ['combien', 'nombre']) && $this->hasKeyword($text, ['tuteur', 'professeur', 'prof'])) {
            $count = $context['tutors_count'] ?? 0;

            return "Kopiao compte actuellement {$count} tuteur(s) actif(s) et validé(s) sur la plateforme.";
        }

        if ($this->hasKeyword($text, ['combien', 'nombre']) && $this->hasKeyword($text, ['annonce', 'demande'])) {
            $count = $context['active_annonces_count'] ?? 0;

            return "Il y a actuellement {$count} annonce(s) active(s) publiée(s) sur Kopiao.";
        }

        if ($this->hasKeyword($text, ['devenir', 'inscri', 'rejoindre']) && $this->hasKeyword($text, ['tuteur', 'prof'])) {
            return 'Pour devenir tuteur : créez un compte tuteur, complétez votre profil (matières, tarif, disponibilités), '
                .'puis attendez la validation de notre équipe. Rendez-vous sur la page "Devenir tuteur" du menu principal.';
        }

        if ($this->hasKeyword($text, ['matiere', 'discipline'])) {
            $subjects = $context['subjects'] ?? [];
            if ($subjects !== []) {
                $list = implode(', ', array_slice($subjects, 0, 10));

                return "Les matières actuellement disponibles sur Kopiao sont : {$list}.";
            }

            return 'Kopiao propose des tuteurs dans de nombreuses matières, du primaire au supérieur.';
        }

        if ($this->hasKeyword($text, ['prix', 'tarif', 'cout'])) {
            return "Chaque tuteur fixe librement son tarif horaire. Le budget total apparaît directement sur chaque annonce publiée par l'élève.";
        }

        if ($this->hasKeyword($text, ['acompte', 'paiement', 'payer'])) {
            return "Un acompte de 30% du budget est versé par l'élève pour publier son annonce ; il est reversé au tuteur après la première séance, le solde se réglant directement entre l'élève et le tuteur.";
        }

        if ($this->hasKeyword($text, ['contact', 'support', 'aide', 'probleme'])) {
            return 'Vous pouvez contacter notre support via le formulaire de la page "Comment ça marche ?", ou par email à support@kopiao.com.';
        }

        if ($this->hasKeyword($text, ['annonce', 'demande'])) {
            return 'Les annonces publiées par les élèves sont consultables sur la page "Annonces". Les tuteurs abonnés peuvent y postuler selon leurs matières.';
        }

        if ($this->hasKeyword($text, ['merci'])) {
            return "Avec plaisir ! N'hésitez pas si vous avez d'autres questions sur Kopiao.";
        }

        return 'Je n\'ai pas assez d\'informations pour répondre précisément à cette question. '
            .'Vous pouvez consulter la page "Comment ça marche ?" ou contacter notre support pour plus de détails.';
    }

    /**
     * Minuscules, accents retires (Str::ascii translittere é -> e, etc.) et
     * ponctuation remplacee par des espaces, pour une comparaison mot a mot fiable.
     */
    private function normalize(string $text): string
    {
        $ascii = Str::ascii($text);
        $clean = preg_replace('/[^a-z0-9]+/', ' ', Str::lower($ascii)) ?? '';

        return trim(preg_replace('/\s+/', ' ', $clean) ?? '');
    }

    /**
     * Vrai si un mot du texte correspond a l'une des racines, par prefixe
     * (pluriels : "annonce" matche "annonces") ou par distance de Levenshtein
     * relative pour tolerer les fautes de frappe (ex: "dnnoncess" matche
     * "annonce"). Deux garde-fous evitent les faux positifs :
     * - le prefixe "racine commence par le mot" exige un mot d'au moins 3
     *   lettres (sinon un simple "c" de "c'est" matche n'importe quelle
     *   racine commencant par "c", comme "coucou") ;
     * - la tolerance Levenshtein est relative a la longueur ("distance / plus
     *   long des deux <= 30 %"), pas un nombre fixe d'erreurs : un seuil
     *   absolu de 3 sur "combien" (7 lettres) matcherait aussi "comment" a la
     *   meme distance, ce que le ratio evite.
     *
     * @param  string[]  $roots
     */
    private function hasKeyword(string $normalizedText, array $roots): bool
    {
        if ($normalizedText === '') {
            return false;
        }

        $words = explode(' ', $normalizedText);

        foreach ($words as $word) {
            if ($word === '') {
                continue;
            }

            foreach ($roots as $root) {
                if (str_starts_with($word, $root)) {
                    return true;
                }

                if (strlen($word) >= 3 && str_starts_with($root, $word)) {
                    return true;
                }

                if (strlen($root) >= 5 && strlen($word) >= 4) {
                    $maxLen = max(strlen($word), strlen($root));
                    if (levenshtein($word, $root) / $maxLen <= 0.34) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
