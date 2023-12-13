<?php

namespace App\Providers;
use Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
    }
}
