<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class ModelTranslation extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'modelName' => $this->getModelName(),
            'translatableAttributes' => $this->getTranslatableAttributes(),
            'uses' => $this->getUses(),
            'traits' => $this->getTraits(),
            'tableName' => $this->getTableNameTranslation(),
        ];

        if (count($this->getTranslatableAttributes())) {
            $this->viewToPackageFile('model_translation', $data, 'App/Models/' . $this->getModelName() . 'Translation');
        }
    }

    /**
     * @return array|string[]
     */
    public function getUses(): array
    {
        $items = ['Illuminate\Database\Eloquent\Model'];

        if ($this->existsInArrayColumnValue($this->getTranslatableFields(), 'name', 'slug')) {
            $items[] = 'Packages\Dashboard\App\Traits\Sluggable';
        }

        return $items;
    }

    /**
     * @return array|string[]
     */
    public function getTraits(): array
    {
        $items = [];
        if ($this->existsInArrayColumnValue($this->getTranslatableFields(), 'name', 'slug')) {
            $items[] = 'Sluggable';
        }

        return $items;
    }
}
