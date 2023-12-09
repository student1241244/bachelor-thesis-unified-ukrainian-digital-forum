<?php

namespace Packages\Dashboard\App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class BladeBootstrapDirectivesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->forms();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function forms()
    {
        Blade::directive('form',
            function ($action) {
                return '<form action="' . $action . '">';
            });

        Blade::directive('endform',
            function () {
                return '</form>';
            });

        Blade::directive('config',
            function ($config) {
                return "<?php echo config({$config}); ?>";
            });
    }

    protected function renderAttributes($attributes)
    {

    }
}
