<?php

declare(strict_types=1);

namespace App\Enums;

use App\Services\PlanSettings;

enum SubscriptionPlan: string
{
    case Standard = 'standard';
    case Premium = 'premium';

    public function label(): string
    {
        return (string) $this->settings()['label'];
    }

    public function price(): int
    {
        return (int) $this->settings()['price'];
    }

    public function maxAnnonces(): ?int
    {
        return $this->settings()['max_annonces'] === null ? null : (int) $this->settings()['max_annonces'];
    }

    public function allows(string $feature): bool
    {
        return (bool) ($this->settings()['features'][$feature] ?? false);
    }

    /**
     * @return array<string, mixed>
     */
    private function settings(): array
    {
        return resolve(PlanSettings::class)->plan($this->value);
    }
}
