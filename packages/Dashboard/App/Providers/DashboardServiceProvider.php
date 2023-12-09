<?php

namespace Packages\Dashboard\App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;
use Astrotomic\Translatable\TranslatableServiceProvider;
use Collective\Html\HtmlServiceProvider;
use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Packages\Dashboard\App\Console\FreshCommand;
use Packages\Dashboard\App\Console\MediaTempClearCommand;
use Packages\Dashboard\App\Console\PublishConfigCommand;
use Packages\Dashboard\App\Console\TpxSyncCommand;
use Packages\Dashboard\App\Helpers\NavHelper;
use Packages\Dashboard\App\Helpers\I18NHelper;
use Packages\Dashboard\App\Middleware\DashboardAuthMiddleware;
use Packages\Dashboard\App\Middleware\PackageModelDetectMiddleware;
use Laracasts\Flash\Flash;
use Laracasts\Flash\FlashServiceProvider;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use AdamWathan\BootForms\BootFormsServiceProvider;
use AdamWathan\BootForms\Facades\BootForm;
use AdamWathan\Form\Facades\Form;
use AdamWathan\Form\FormServiceProvider;

use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;

use Packages\Dashboard\App\Middleware\PermissionMiddleware;
use Packages\Dashboard\App\Middleware\UserActiveMiddleware;
use Packages\Dashboard\App\Models\Language;
use Packages\Dashboard\App\Services\Config\ConfigService;
use Packages\Dashboard\App\Traits\ServiceProviderTrait;
use Packages\Dashboard\App\Console\MigrationCommand;
use Spatie\TranslationLoader\TranslationServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    use ServiceProviderTrait;


    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            Request::setTrustedProxies(
                [$_SERVER['HTTP_CF_CONNECTING_IP']],
                Request::HEADER_X_FORWARDED_FOR
            );
        }

        $this->setupFacades();
        $this->setupProviders();

        $this->prepareResources();
        $this->setupMiddleware($router);
        $this->setupModules();

        if ($this->app->runningInConsole() || config('app.force_console')) {
            $this->commands([
                MigrationCommand::class,
                PublishConfigCommand::class,
                TpxSyncCommand::class,
                MediaTempClearCommand::class,
                FreshCommand::class,
            ]);
        }

        if (class_exists('\Packages\Dashboard\App\Models\Language')) {
            config()->set('translatable.locales', Language::getLocales());
            config()->set('laravellocalization.supportedLocales', Language::getSupportedLocales());
        } else {
            config()->set('laravellocalization.supportedLocales', [
                'en' => [
                    'name' => 'English',
                    'native' => 'English',
                    'script' => 'Cyrl',
                ],
            ]);
        }
    }

    /**
    ide-helper:generate     *
     * @return void
     */
    public function register()
    {
        $this->setupHelpers();
    }

    /**
     * Register the middleware to the application
     *
     * Register the following middleware:
     * - \Packages\Dashboard\App\Middleware\LaravelLocalizationRedirectFilter
     * - \Packages\Dashboard\App\Middleware\PackageModelDetectMiddleware
     */
    protected function setupMiddleware($router)
    {
        $router->aliasMiddleware('dashboardAuth', DashboardAuthMiddleware::class);
        $router->aliasMiddleware('userActive', UserActiveMiddleware::class);
        $router->aliasMiddleware('permission', PermissionMiddleware::class);
        $router->aliasMiddleware('packageModelDetect', PackageModelDetectMiddleware::class);

        $router->aliasMiddleware('localize', LaravelLocalizationRoutes::class);
        $router->aliasMiddleware('localizationRedirect', LaravelLocalizationRedirectFilter::class);
        $router->aliasMiddleware('localeSessionRedirect', LocaleSessionRedirect::class);
        $router->aliasMiddleware('localeViewPath', LaravelLocalizationViewPath::class);
    }

    /**
     * Bind the helpers to the application.
     *
     * This will register packages that this package is dependent on.
     *
     * Bind the following helpers:
     * - NavHelper
     * - I18NHelper
     */
    protected function setupHelpers()
    {
        $this->app->bind(
            'Packages\Dashboard\App\Helpers\NavHelper'
        );

        $this->app->bind(
            'Packages\Dashboard\App\Helpers\I18NHelper'
        );

        require_once(__DIR__ . '/../Helpers/helpers.php');
    }

    /**
     * Register the providers to the application.
     *
     * This will register packages that this package is dependent on.
     *
     * Register the following providers:
     * - Flash
     * - Form
     * - BootForms
     * - ViewComposer
     * - Baum
     * - BladeBootstrapDirectives
     */
    protected function setupProviders()
    {
        $this->app->register(DashboardEventServiceProvider::class);
        $this->app->register(ImageServiceProvider::class);
        $this->app->register(LaravelLocalizationServiceProvider::class);
        $this->app->register(TranslatableServiceProvider::class);
        $this->app->register(ServiceProvider::class);
        $this->app->register(FlashServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(BootFormsServiceProvider::class);
        $this->app->register(ViewComposerServiceProvider::class);
        $this->app->register(BladeBootstrapDirectivesServiceProvider::class);
        $this->app->register(HtmlServiceProvider::class);
        $this->app->register(TranslationServiceProvider::class);
    }

    /**
     * Register the Providers and Facades to the application.
     */
    protected function setupModules()
    {
        foreach ((new ConfigService())->getServiceProviders() as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register the Facades to the application.
     *
     * Registers the following facades:
     * - Flash
     * - Form
     * - BootForm
     * - NavHelper
     * - I18NHelper
     */
    protected function setupFacades()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('Image', Image::class);
        $loader->alias('I18N', LaravelLocalization::class);
        $loader->alias('Form', FormFacade::class);
        $loader->alias('Html', HtmlFacade::class);
        $loader->alias('Flash', Flash::class);
        $loader->alias('Form', Form::class);
        $loader->alias('BootForm', BootForm::class);
        $loader->alias('NavHelper', NavHelper::class);
        $loader->alias('I18NHelper', I18NHelper::class);

    }

}
