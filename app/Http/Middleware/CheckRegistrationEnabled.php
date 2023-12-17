<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRegistrationEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $registrationEnabled = \App\Models\Setting::where('setting_name', 'user_registration_enabled')->value('setting_status');

        if ($registrationEnabled != 'on') {
            // Redirect to the home page or a custom error page
            // Make sure this page does not use the CheckRegistrationEnabled middleware
            return redirect('/signin')->with('error', 'User registration is currently disabled. Only login to the already created accounts is allowed.');
        }
    
        return $next($request);
    }
}
