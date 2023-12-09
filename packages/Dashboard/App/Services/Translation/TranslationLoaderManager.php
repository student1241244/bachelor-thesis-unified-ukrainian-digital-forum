<?php

namespace Packages\Dashboard\App\Services\Translation;

use Spatie\TranslationLoader\TranslationLoaderManager as BaseTranslationLoaderManager;

class TranslationLoaderManager extends BaseTranslationLoaderManager
{
    /**
     * Load the messages for the given locale.
     *
     * @param string $locale
     * @param string $group
     * @param string $namespace
     *
     * @return array
     */
    public function load($locale, $group, $namespace = null): array
    {
        $fileTranslations = parent::load($locale, $group, $namespace);

        if (! is_null($namespace) && $namespace !== '*') {
            $group = "$namespace::$group";
            $namespace = '*';
        }

        $loaderTranslations = $this->getTranslationsForTranslationLoaders($locale, $group, $namespace);

        return array_replace_recursive($fileTranslations, $loaderTranslations);
    }

}
