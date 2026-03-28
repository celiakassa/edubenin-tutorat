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
        $user = $request->user();

        // 1. Vérifier si l'utilisateur est connecté
        // 2. Utiliser la méthode isSubscribed() qu'on a créée dans le User
        if (! $user || ! $user->isSubscribed()) {
            return to_route('subscription.user')
                ->with('warning', 'Votre abonnement est inexistant ou expiré. Veuillez souscrire pour continuer.');
        }

        return $next($request);
    }
}
