<?php

namespace Packages\Dashboard\App\Helpers;

use Illuminate\Support\ViewErrorBag;

class I18NHelper
{
    public static function getActiveTab(ViewErrorBag $errors, $order = ['en', 'ru', 'ua'])
    {
        if (!$errors->count()) {
            return $order[0];
        }

        foreach ($order AS $locale) {
            foreach ($errors->keys() AS $key) {
                if (strpos($key, $locale . '.') !== false) {
                    return $locale;
                }
            }
        }

        return $order[0];
    }
}
