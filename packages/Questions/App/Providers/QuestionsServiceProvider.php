<?php
namespace Packages\Questions\App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Dashboard\App\Traits\ServiceProviderTrait;

class QuestionsServiceProvider extends ServiceProvider
{
    use ServiceProviderTrait;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->prepareResources();
    }

    /**
     * @return void
     */
    public function register()
    {
    }
}
