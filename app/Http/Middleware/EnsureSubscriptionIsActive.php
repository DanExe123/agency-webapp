<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || !$user->hasActiveSubscription()) {
            return redirect()
                ->route('pricingpage')
                ->with('error', 'You need an active subscription.');
        }

        return $next($request);
    }

}
