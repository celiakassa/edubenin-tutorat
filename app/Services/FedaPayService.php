<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use FedaPay\Customer;
use FedaPay\FedaPay;
use FedaPay\Transaction;

final class FedaPayService
{
    public function __construct()
    {
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.mode'));
    }

    /**
     * Créer une transaction FedaPay
     */
    public function createTransaction($amount, $user, $annonce, $callbackUrl): array
    {
        try {
            // Créer ou récupérer le client
            $customer = Customer::create([
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'phone_number' => $user->telephone ?: '22900000000',
            ]);

            // Créer la transaction
            $transaction = Transaction::create([
                'description' => 'Acompte pour annonce: '.$annonce->domaine,
                'amount' => $amount,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => $callbackUrl,
                'customer' => $customer,
                'metadata' => [
                    'annonce_id' => $annonce->id,
                    'user_id' => $user->id,
                    'type' => 'acompte_annonce',
                ],
            ]);

            // Générer le token de paiement
            $token = $transaction->generateToken();

            return [
                'success' => true,
                'transaction_id' => $transaction->id,
                'transaction_reference' => $transaction->reference,
                'payment_url' => $token->url,
                'customer' => $customer,
            ];

        } catch (Exception $exception) {
            return [
                'success' => false,
                'error' => $exception->getMessage(),
            ];
        }
    }

    /**
     * Vérifier le statut d'une transaction
     */
    public function verifyTransaction($transactionId): array
    {
        try {
            $transaction = Transaction::retrieve($transactionId);

            return [
                'success' => true,
                'transaction' => $transaction,
                'status' => $transaction->status,
                'paid' => $transaction->status === 'approved',
            ];

        } catch (Exception $exception) {
            return [
                'success' => false,
                'error' => $exception->getMessage(),
            ];
        }
    }

    /**
     * Rembourser une transaction
     */
    public function refundTransaction($transactionId, $amount = null): array
    {
        try {
            $transaction = Transaction::retrieve($transactionId);

            $refund = $amount ? $transaction->refund(['amount' => $amount]) : $transaction->refund();

            return [
                'success' => true,
                'refund' => $refund,
            ];

        } catch (Exception $exception) {
            return [
                'success' => false,
                'error' => $exception->getMessage(),
            ];
        }
    }
}
