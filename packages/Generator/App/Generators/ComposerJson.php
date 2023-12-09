<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class ComposerJson extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameKebab' => $this->getPackageNameKebab(),
            'config' => $this->getConfig(),
        ];

        //$this->viewToPackageFile('composer_json', $data, 'composer', ['fileExt' => '.json']);
    }
}
