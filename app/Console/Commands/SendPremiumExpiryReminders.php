<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\SubscriptionBillingService;
use Illuminate\Console\Command;

final class SendPremiumExpiryReminders extends Command
{
    protected $signature = 'subscriptions:send-reminders';

    protected $description = "Envoie le rappel avant la fin de l'offre Premium";

    public function handle(SubscriptionBillingService $billing): int
    {
        $result = $billing->sendExpiryReminders();

        $this->info(json_encode($result));

        return self::SUCCESS;
    }
}
