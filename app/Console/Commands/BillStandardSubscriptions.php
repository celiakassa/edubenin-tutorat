<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\SubscriptionBillingService;
use Illuminate\Console\Command;

final class BillStandardSubscriptions extends Command
{
    protected $signature = 'subscriptions:bill-standard';

    protected $description = 'Facture les élèves en offre Standard (fin de mois)';

    public function handle(SubscriptionBillingService $billing): int
    {
        $result = $billing->billStandardUsers();

        $this->info(json_encode($result));

        return self::SUCCESS;
    }
}
