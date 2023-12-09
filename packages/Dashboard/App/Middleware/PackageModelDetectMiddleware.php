<?php

namespace Packages\Dashboard\App\Middleware;

use Closure;
use Illuminate\Support\Str;

class PackageModelDetectMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param string|null $packageName
     * @param string|null $modelName
     * @return mixed
     */
    public function handle($request, Closure $next, string $packageName = null, string $modelName = null)
    {
        $parts = explode('\\', get_class(request()->route()->getController()));

        if (count($parts) === 5) {
            $request->merge([
                'packageName' => $parts[1],
                'modelName' => Str::beforeLast($parts[4], 'Controller'),
            ]);
        } else {
            $request->merge([
                'packageName' => $packageName,
                'modelName' => $modelName,
            ]);
        }

        return $next($request);
    }
}
