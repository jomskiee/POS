<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmployeeMiddleware
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
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'employee'])) {
            return $next($request);
        }

        abort(403, 'Access denied. Employee privileges required.');
    }
}
