<?php

namespace Packages\Dashboard\App\Services\Translation;

use Spatie\TranslationLoader\Exceptions\InvalidConfiguration;
use Spatie\TranslationLoader\TranslationLoaders\TranslationLoader;

class LoaderDb implements TranslationLoader
{
    /**
     * @param string $locale
     * @param string $group
     * @return array
     */
    public function loadTranslations(string $locale, string $group): array
    {
        $model = $this->getConfiguredModelClass();

        return $model::getTranslationsForGroup($locale, $group);
    }

    /**
     * @return string
     */
    protected function getConfiguredModelClass(): string
    {
        $modelClass = config('translation-loader.model');

        return $modelClass;
    }
}

