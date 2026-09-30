<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\MonerooSubscriptionGateway;
use App\Services\SubscriptionGateway;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SubscriptionGateway::class, MonerooSubscriptionGateway::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pagination stylisée (design system) par défaut partout
        Paginator::defaultView('pagination.kopiao');
        Paginator::defaultSimpleView('pagination.kopiao');

        // Politique de mot de passe robuste (F-001) : longueur minimale + complexité
        Password::defaults(fn (): Password => Password::min(8)
            ->mixedCase()
            ->numbers()
            ->symbols());
    }
}
