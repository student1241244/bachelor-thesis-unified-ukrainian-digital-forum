<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Illuminate\Http\Request;

class CheckContentCreationEnabled
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
        $contentCreationEnabled = Setting::where('setting_name', 'content_creation_enabled')->value('setting_status');

        if ($contentCreationEnabled != 'on') {
            return redirect('/qa-home')->with('error', 'Content creation is currently disabled because of maintenance work. Sorry for the inconvenience :(');
        }
    
        return $next($request);
    }
}