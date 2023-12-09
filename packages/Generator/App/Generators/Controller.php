<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class Controller extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'modelName' => $this->getModelName(),
            'modelNameVar' => Str::camel($this->getModelName()),
            'actionCreate' => $this->hasAction('create'),
            'actionUpdate' => $this->hasAction('update'),
            'actionDestroy' => $this->hasAction('destroy'),
            'actionShow' => $this->hasAction('show'),
            'imageAttributes' => $this->getImageAttributes(),
            'uses' => $this->getUses(),
        ];

        $this->viewToPackageFile('controller', $data, 'App/Controllers/' . $this->getModelName() . 'Controller');
    }

    public function getUses(): array
    {
        $items = [
            'Packages\Dashboard\App\Controllers\BaseController',
            'Packages\\' . $this->getPackageName() . '\App\Models\\' . $this->getModelName(),
            'Packages\\' . $this->getPackageName() . '\App\Requests\\' . $this->getModelName() . '\\IndexRequest',
            'Packages\\' . $this->getPackageName() . '\App\Services\\Crud\\' . $this->getModelName() . 'CrudService',
        ];

        if ($this->hasAction('create') || $this->hasAction('update')) {
            $items[] = 'Packages\\' . $this->getPackageName() . '\App\Requests\\' . $this->getModelName() . '\\FormRequest';
        }

        return $items;
    }
}
