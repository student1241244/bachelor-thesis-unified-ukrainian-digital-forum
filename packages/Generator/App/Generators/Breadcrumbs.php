<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class Breadcrumbs extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'models' => array_keys($this->getConfig()['models']),
            'modelsConfig' => $this->getModelsConfig(),
        ];

        $this->viewToPackageFile('breadcrumbs', $data, 'App/breadcrumbs', [
            'prefixContent' => "<?php\n",
        ]);
    }

}
