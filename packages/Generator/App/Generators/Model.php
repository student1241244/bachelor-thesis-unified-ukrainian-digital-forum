<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class Model extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'modelName' => $this->getModelName(),
            'functions' => array_get($this->getModelConfig(), 'functions.model', []),
            'fields' => $this->getMainFields(),
            'imageAttributes' => $this->getImageAttributes(),
            'translatableAttributes' => $this->getTranslatableAttributes(),
            'uses' => $this->getUses(),
            'fillable' => $this->getFillable(),
            'traits' => $this->getTraits(),
            'tableName' => $this->getTableName(),
            'signature' => $this->getClassSignature(),
            'imagesConversions' => $this->getImagesConversions(),
            'timestamps' => $this->getWithTimestamps(),
        ];

        $this->viewToPackageFile('model', $data, 'App/Models/' . $this->getModelName());
    }

    /**
     * @return array|string[]
     */
    public function getUses(): array
    {
        $items = ['Illuminate\Database\Eloquent\Model'];

        if ($this->existsInArrayColumnValue($this->getMainFields(), 'type', 'image')) {
            $items[] = 'Packages\Dashboard\App\Interfaces\HasMedia';
            $items[] = 'Packages\Dashboard\App\Traits\HasMediaTrait';
        }
        if (count($this->getTranslatableAttributes())) {
            $items[] = 'Packages\Dashboard\App\Traits\Translatable';
        }

        if ($this->existsInArrayColumnValue($this->getMainFields(), 'name', 'slug')) {
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
        if (count($this->getTranslatableAttributes())) {
            $items[] = 'Translatable';
        }
        if ($this->existsInArrayColumnValue($this->getMainFields(), 'name', 'slug')) {
            $items[] = 'Sluggable';
        }
        if ($this->existsInArrayColumnValue($this->getMainFields(), 'type', 'image')) {
            $items[] = 'HasMediaTrait';
        }

        return $items;
    }

    /**
     * @return array|string[]
     */
    public function getFillable(): array
    {
        $items = [];

        foreach ($this->getModelConfig()['fields'] as $field) {
            if (!array_get($field, 'translatable', false) && !in_array($field['type'], [self::FIELD_TYPE_IMAGE, self::FIELD_TYPE_VS_MULTIPLE])) {
                $items[] = $field['name'];
            }
        }

        return $items;
    }

    /**
     * @return string
     */
    public function getClassSignature(): string
    {
        $signature = 'class ' . $this->getModelName() . ' extends Model';
        if ($this->existsInArrayColumnValue($this->getMainFields(), 'type', 'image')) {
            $signature.= ' implements HasMedia';
        }
        return $signature;
    }

    /**
     * @return string
     */
    public function getImagesConversions(): string
    {
        $data = '';
        if ($this->existsInArrayColumnValue($this->getMainFields(), 'type', 'image')) {
            $data = self::TAB1 . 'protected $conversions = [' . self::ENTER;

            foreach ($this->getMainFields() as $field) {
                if ($field['type'] === 'image') {
                    $data.= self::TAB2 . '\'' . $field['name'] . '\' => [' . self::ENTER;
                    $data.= self::TAB3 . '\'100x100\',' . self::ENTER;
                    $data.= self::TAB2 . '],' . self::ENTER;
                }
            }

            $data.= self::TAB1 . '];';
        }

        return $data;
    }
}
