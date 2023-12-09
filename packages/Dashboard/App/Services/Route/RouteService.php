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

use Packages\Dashboard\App\Models\Language;

class RouteService extends BaseRouteService
{
    /*
     * @return string
     */
    public static function getPrefix(): string
    {
        return '/admin';
    }

    public static function getFrontPrefix(): string
    {
        $parts = explode('/', request()->path());
        $languages = array_keys(Language::getList());

        if ($parts[0] !== 'en' && in_array($parts[0], $languages)) {
            app()->setLocale($parts[0]);
            return "/{$parts[0]}";
        }

        return '';
    }
}
