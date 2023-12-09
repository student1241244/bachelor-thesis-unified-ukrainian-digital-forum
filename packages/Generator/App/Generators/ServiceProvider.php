<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class ServiceProvider extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
        ];

        $this->viewToPackageFile('service_provider', $data, 'App/Providers/' . $this->getPackageName() . 'ServiceProvider');
    }
}
