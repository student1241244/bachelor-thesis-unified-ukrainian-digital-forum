<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class CrudService extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'modelName' => $this->getModelName(),
            'modelNameVar' => Str::camel($this->getModelName()),
            'imageAttributes' => $this->getImageAttributes(),
            'vsMultipleFields' => $this->getVsMultipleFields(),
        ];

        $this->viewToPackageFile('crud_service', $data, 'App/Services/Crud/' . $this->getModelName() . 'CrudService');
    }

    /**
     * @return string[]
     */
    public function getSortableFields(): array
    {
        $items = ['id'];

        foreach ($this->getModelConfig()['fields'] as $field) {
            if (array_get($field, 'sortable', true) && !in_array($field['type'], [self::FIELD_TYPE_IMAGE])) {
                $items[] = $field['name'];
            }
        }

        return $items;
    }

    /**
     * @return string[]
     */
    public function getFilterableFields(): array
    {
        $items = ['id'];

        foreach ($this->getModelConfig()['fields'] as $field) {
            if (array_get($field, 'filter', true) && !in_array($field['type'], [self::FIELD_TYPE_IMAGE, self::FIELD_TYPE_DATE])) {
                $items[] = $field['name'];
            }
        }

        return $items;
    }

    /**
     * @return string[]
     */
    public function getIndexFields(): array
    {
        $items = [];

        foreach ($this->getModelConfig()['fields'] as $field) {
            if (array_get($field, 'index', true)) {
                $val = '$row->' . $field['name'];

                if ($field['type'] === self::FIELD_TYPE_IMAGE) {
                    $val = '$row->getImageOrNull(\'image\', \'100x100\')';
                }

                if ($field['name'] === 'title') {
                    $val = '\'<a href="\'.route(\''.$this->getPackageNameSnake().'.'.Str::snake($this->getModelNamePlural()).'.edit\', $row->id).\'">\'.$row->'.$field['name'].'.\'</a>\'';
                }

                if ($field['type'] === self::FIELD_TYPE_CHECKBOX) {
                    $val = '$row->'.$field['name'].' ? \'<span class="badge badge-success">yes</span>\': \'<span class="badge">no</span>\'';
                }

                $items[$field['name']] = $val;
            }
        }

        return $items;
    }


    /**
     * @return string[]
     */
    public function getSelectAttributes(): array
    {
        $items = ["{$this->getTableName()}.id"];

        $translatableAttributes = $this->getTranslatableAttributes();

        foreach ($this->getModelConfig()['fields'] as $field) {
            if (array_get($field, 'index', true) && !in_array($field['type'], [self::FIELD_TYPE_IMAGE])) {
                $table = in_array($field['name'], $translatableAttributes) ? $this->getTableNameTranslation() : $this->getTableName();
                $items[] = "{$table}.{$field['name']}";
            }
        }

        return $items;
    }

}
