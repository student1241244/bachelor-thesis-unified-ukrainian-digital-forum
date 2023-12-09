<?php

/**
 * @package     Dashboard
 * @version     0.1.0
 * @author      LLC Studio <hello@digitalp.co>
 * @license     MIT
 * @copyright   2015, LLC
 * @link        https://digitalp.com
 */

namespace Packages\Dashboard\App\Services\Route;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BaseRouteService
{
    /**
     * @return string
     */
    public static function getPrefix(): string
    {
        $locale =  LaravelLocalization::setLocale();
        $parts = [];
        if ($locale) {
            $parts[] = $locale;
        }
        $parts[] = config('tpx_dashboard.route.prefix');

        return implode('/', $parts);
    }
}
