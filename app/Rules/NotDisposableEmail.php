<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rejette les adresses e-mail provenant de fournisseurs jetables/temporaires (F-002).
 */
final class NotDisposableEmail implements ValidationRule
{
    /**
     * Domaines de messagerie jetable/temporaire les plus courants.
     *
     * @var list<string>
     */
    private const DISPOSABLE_DOMAINS = [
        'yopmail.com', 'yopmail.fr', 'yopmail.net',
        'mailinator.com', 'mailinator.net', 'mailinator.org',
        '10minutemail.com', '10minutemail.net', '10minutemail.co.uk',
        'guerrillamail.com', 'guerrillamail.net', 'guerrillamail.org', 'guerrillamail.biz', 'guerrillamail.de',
        'tempmail.com', 'temp-mail.org', 'tempmail.net', 'tempmail.dev', 'tempmail.plus',
        'throwawaymail.com', 'throwaway.email',
        'trashmail.com', 'trashmail.net', 'trashmail.me',
        'getnada.com', 'nada.email',
        'fakeinbox.com', 'fakemailgenerator.com',
        'sharklasers.com', 'grr.la', 'guerrillamailblock.com',
        'dispostable.com',
        'maildrop.cc',
        'mintemail.com',
        'mytemp.email',
        'moakt.com', 'moakt.cc',
        'emailondeck.com',
        'spam4.me', 'spamgourmet.com',
        'mailcatch.com',
        'mohmal.com',
        'crazymailing.com',
        'discard.email', 'discardmail.com',
        '33mail.com',
        'anonbox.net',
        'burnermail.io',
        'inboxbear.com',
        'mailnesia.com',
        'emailfake.com',
        'tempinbox.com',
        'harakirimail.com',
        'jetable.org',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! str_contains($value, '@')) {
            return;
        }

        $domain = mb_strtolower(mb_trim(mb_substr($value, mb_strrpos($value, '@') + 1)));

        if (in_array($domain, self::DISPOSABLE_DOMAINS, true)) {
            $fail("Les adresses e-mail temporaires ou jetables ne sont pas acceptées. Veuillez utiliser une adresse e-mail permanente.");
        }
    }
}
