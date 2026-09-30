<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

/**
 * Passerelle de paiement des abonnements.
 */
interface SubscriptionGateway
{
    /**
     * Débit automatique d'un moyen de paiement enregistré (false si indisponible).
     */
    public function chargeSavedMethod(User $user, int $amount): bool;

    /**
     * @param  array<string, string>  $metadata
     * @return array{id: string, checkout_url: string}
     */
    public function createCheckout(User $user, int $amount, string $description, string $returnUrl, array $metadata): array;

    public function isPaid(string $paymentId): bool;
}
