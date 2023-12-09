<?php

namespace Packages\Dashboard\App\Middleware;

use Closure;
use Illuminate\Support\Str;

class UserActiveMiddleware
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
        //if (auth()->check() && !auth()->user()->is_active) {
        if (false) {
            if ($request->ajax()) {
                return response('User not active', 403);
            } else {
                abort(403);
            }
        }

        return $next($request);
    }
}
