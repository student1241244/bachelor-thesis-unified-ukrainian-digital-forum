<?php

namespace Packages\Dashboard\App\Helpers;

use Route;
use Illuminate\Support\Str;

class NavHelper
{
    public static function isActive(array $item): bool
    {
        return Str::beforeLast($item['route'], '.') === Str::beforeLast(Route::currentRouteName(), '.');
    }
}
