<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Moneroo\Laravel\Payment as MonerooPayment;

/**
 * Passerelle Moneroo des abonnements.
 */
final class MonerooSubscriptionGateway implements SubscriptionGateway
{
    /**
     * Débit automatique d'un moyen de paiement enregistré.
     *
     * Non supporté pour l'instant : Moneroo exige une action du client (mobile money).
     * Tant que ce n'est pas branché, renvoie false → l'abonné est repassé en standard
     * et reçoit un lien pour se réabonner. À implémenter ici si un mandat devient disponible.
     */
    public function chargeSavedMethod(User $user, int $amount): bool
    {
        return false;
    }

    /**
     * Crée un paiement Moneroo et renvoie l'identifiant + le lien de paiement.
     *
     * @param  array<string, string>  $metadata
     * @return array{id: string, checkout_url: string}
     */
    public function createCheckout(User $user, int $amount, string $description, string $returnUrl, array $metadata): array
    {
        $payment = (new MonerooPayment())->init([
            'amount' => $amount,
            'currency' => (string) config('plans.currency'),
            'description' => $description,
            'return_url' => $returnUrl,
            'customer' => [
                'email' => $user->email,
                'first_name' => $user->firstname,
                'last_name' => $user->lastname,
                'phone' => $user->telephone ?? '',
            ],
            'metadata' => $metadata + ['user_id' => (string) $user->id],
        ]);

        return ['id' => (string) $payment->id, 'checkout_url' => (string) $payment->checkout_url];
    }

    public function isPaid(string $paymentId): bool
    {
        $payment = (new MonerooPayment())->get($paymentId);

        return mb_strtolower((string) ($payment->status ?? '')) === 'success';
    }
}
