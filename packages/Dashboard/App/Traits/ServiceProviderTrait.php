<?php

namespace Packages\Dashboard\App\Traits;

use Illuminate\Support\Str;
use Packages\Dashboard\App\Services\Config\ConfigService;

trait ServiceProviderTrait
{
    protected function getLocalPath(string $dir = null)
    {
        $segments = explode('\\', static::class);

        $path =  base_path() . '/packages/' . $segments[1];

        if ($dir) {
            $path.= '/' . $dir;
        }

        return $path;
    }

    protected function getPackageName()
    {
        return explode('\\', __CLASS__)[1];
    }


    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        $package_name = Str::snake($this->getPackageName());

        // web routes
        $routePath = $this->getLocalPath('App') . '/routes.php';

        if (is_file($routePath)) {
            $this->loadRoutesFrom($routePath);
        }

        $routePath = $this->getLocalPath('App/Controllers/Api') . '/routes.php';

        if (is_file($routePath)) {
            $this->loadRoutesFrom($routePath);
        }

        // views
        $defaultTheme = config('tpx_dashboard.default_template', 'default');
        $localDefaultTheme = $this->getLocalPath('themes/' . $defaultTheme) . '/views';

        if (is_dir($localDefaultTheme)) {
            $this->loadViewsFrom($localDefaultTheme . '/', 'tpx_' . $package_name);
        }

        // translations.
        $localLangPath = $this->getLocalPath('lang');

        if (is_dir($localLangPath) ) {
            $this->loadTranslationsFrom($localLangPath, $package_name);
        }

        //migrations
        $localMigrationsPath = $this->getLocalPath('database/migrations');
        if (is_dir($localMigrationsPath)) {
            $this->loadMigrationsFrom($localMigrationsPath);
        }
    }
}
