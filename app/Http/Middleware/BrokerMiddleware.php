<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BrokerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'broker'])) {
            return $next($request);
        }

        abort(403, 'Access denied. Broker privileges required.');
    }
}
