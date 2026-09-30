<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\SubscriptionBillingService;
use Illuminate\Console\Command;

final class RenewPremiumSubscriptions extends Command
{
    protected $signature = 'subscriptions:renew-premium';

    protected $description = 'Renouvelle les abonnements Premium échus (1er du mois) ou repasse en Standard';

    public function handle(SubscriptionBillingService $billing): int
    {
        $result = $billing->renewDuePremiums();

        $this->info(json_encode($result));

        return self::SUCCESS;
    }
}
