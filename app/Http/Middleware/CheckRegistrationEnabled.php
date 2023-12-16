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
        // Retrieve the 'user_registration_enabled' setting from the database
        $registrationEnabled = \App\Models\Setting::where('key', 'user_registration_enabled')->value('value');
    
        // Check if the setting is '1' (enabled)
        if ($registrationEnabled != '1') {
            // If registration is disabled, redirect to a specific page or show an error message
            return redirect('path-to-redirect')->with('error', 'User registration is currently disabled.');
        }
    
        return $next($request);
    }
}
