<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

/**
 * Paramètres des offres : valeurs de config/plans.php surchargées par ceux
 * enregistrés en base par l'administrateur.
 */
final class PlanSettings
{
    private const KEY = 'subscription_plans';

    /**
     * @return array{renewal_day: int, reminder_days_before: int, plans: array<string, array<string, mixed>>}
     */
    public function all(): array
    {
        $defaults = [
            'renewal_day' => (int) config('plans.renewal_day', 1),
            'reminder_days_before' => (int) config('plans.reminder_days_before', 5),
            'plans' => config('plans.plans'),
        ];

        return array_replace_recursive($defaults, $this->stored());
    }

    /**
     * @return array<string, mixed>
     */
    public function plan(string $key): array
    {
        return $this->all()['plans'][$key];
    }

    public function renewalDay(): int
    {
        return max(1, min(28, $this->all()['renewal_day']));
    }

    public function reminderDays(): int
    {
        return $this->all()['reminder_days_before'];
    }

    /**
     * @param  array<string, mixed>  $values
     */
    public function save(array $values): void
    {
        Setting::updateOrCreate(['key' => self::KEY], ['value' => $values]);
    }

    /**
     * @return array<string, mixed>
     */
    private function stored(): array
    {
        if (! Schema::hasTable('settings')) {
            return [];
        }

        return Setting::where('key', self::KEY)->value('value') ?? [];
    }
}
