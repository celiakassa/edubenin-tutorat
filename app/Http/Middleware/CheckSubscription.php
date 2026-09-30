<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // DÉSACTIVÉ — Les tuteurs ne paient plus sur la plateforme (2026-09-27).
        // Ancien contrôle d'abonnement commenté ci-dessous : accès libre pour tous les tuteurs.
        // $user = $request->user();
        // if (! $user || ! $user->isSubscribed()) {
        //     return to_route('subscription.user')
        //         ->with('warning', 'Votre abonnement est inexistant ou expiré. Veuillez souscrire pour continuer.');
        // }

        return $next($request);
    }
}
