<?php

namespace Packages\Dashboard\App\Providers;

use Settings\Models\SiteSettings;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeDpConfig();
        $this->composeLogo();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function composeLogo()
    {
        view()->composer(
            [
                'tpx_dashboard::layouts.auth',
            ],
            function ($view) {
                $default = '/img/logo/main.png';

                $logo = $default;
                //$logo = SiteSettings::where('alias', 'logo')->first();
                //$logo = $logo && $logo->hasMedia() ? $logo->getImage() : $default;
                $view->with('logo', $logo);
            }
        );
    }

    private function composeDpConfig()
    {
        $config = config('tpx_dashboard');

        view()->composer(
            [
                'tpx_dashboard::global.footer',
                'tpx_dashboard::auth.login',
                'tpx_dashboard::auth.register',
                'tpx_dashboard::auth.register-success',
            ],
            function ($view) use ($config) {
                $view->with('dpConfig', $config);
            }
        );
    }
}
