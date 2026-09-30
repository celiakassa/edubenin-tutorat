<?php

declare(strict_types=1);

use App\Services\PlanSettings;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Abonnements élèves/parents (voir config/plans.php)
Schedule::command('subscriptions:send-reminders')->dailyAt('09:00');
Schedule::command('subscriptions:renew-premium')->dailyAt('00:10')->when(fn (): bool => now()->day === resolve(PlanSettings::class)->renewalDay());
Schedule::command('subscriptions:bill-standard')->dailyAt('18:00')->when(fn (): bool => now()->isLastOfMonth());
