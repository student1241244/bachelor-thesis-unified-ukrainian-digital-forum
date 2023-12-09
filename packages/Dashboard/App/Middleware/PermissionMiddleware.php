<?php

namespace Packages\Dashboard\App\Middleware;

use Closure;
use Illuminate\Support\Str;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && !can($request->route()->getName())) {
            if ($request->ajax()) {
                return response('Forbidden', 403);
            } else {
                abort(403);
            }
        }

        return $next($request);
    }
}
