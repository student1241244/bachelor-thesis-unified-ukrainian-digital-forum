<?php

namespace Packages\Dashboard\App\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class DashboardAuthMiddleware extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!auth()->check()) {
            if (! $request->expectsJson()) {
                return redirect()->route('dashboard.login');
            } else {
                return response(null, 401);
            }
        }

        return $next($request);
    }

}
