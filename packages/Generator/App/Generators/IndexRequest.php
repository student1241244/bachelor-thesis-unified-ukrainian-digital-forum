<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class IndexRequest extends Base
{
    public $extraWhere = [];

    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'modelName' => $this->getModelName(),
            'modelNameVar' => Str::camel($this->getModelName()),
            'sortableFields' => $this->getSortableFields(),
            'filterableFields' => $this->getFilterableFields(),
            'indexFields' => $this->getIndexFields(),
            'tableName' => $this->getTableName(),
            'tableNameTranslation' => $this->getTableNameTranslation(),
            'translatableAttributes' => $this->getTranslatableAttributes(),
            'selectAttributes' => $this->getSelectAttributes(),
            'leftJoins' => $this->getLeftJoins(),
            'extraWhere' => $this->extraWhere,
            'filterConditions' => $this->getFilterConditions(),
        ];

        $this->viewToPackageFile('index_request', $data, 'App/Requests/' . $this->getModelName() . '/IndexRequest');
    }

    /**
     * @return string[]
     */
    public function getSortableFields(): array
    {
        $items = ['id'];

        foreach ($this->getModelConfig()['fields'] as $field) {
            if (array_get($field, 'sortable', true) && $field['type'] === self::FIELD_TYPE_FOREIGN) {
                $items[] = str_replace('_id', '_title', $field['name']);

            } elseif (array_get($field, 'sortable', true) && !in_array($field['type'], [self::FIELD_TYPE_IMAGE, self::FIELD_TYPE_VS_MULTIPLE])) {
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
                $fieldKey = $field['name'];

                if ($field['type'] === self::FIELD_TYPE_IMAGE) {
                    $val = '$row->getImageOrNull(\'image\', \'100x100\')';
                }

                if ($field['name'] === 'title') {
                    $val = '\'<a href="\'.route(\''.$this->getPackageNameSnake().'.'.Str::snake($this->getModelNamePlural()).'.edit\', $row->id).\'">\'.$row->'.$field['name'].'.\'</a>\'';
                }

                if ($field['type'] === self::FIELD_TYPE_CHECKBOX) {
                    $val = '$row->'.$field['name'].' ? \'<span class="badge badge-success">yes</span>\': \'<span class="badge">no</span>\'';
                }

                if ($field['type'] === self::FIELD_TYPE_FOREIGN) {
                    $fieldName = str_replace('_id', '_title', $field['name']);
                    $val = '$row->' . $fieldName;
                    $fieldKey = $fieldName;
                }

                if ($field['type'] === self::FIELD_TYPE_VS_MULTIPLE) {
                    $val = '$row->'.$field['name'].' ? BaseFilter::formatMultipleRelation($row->'.$field['name'].') : null';
                }

                $items[$fieldKey] = $val;
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
            if (array_get($field, 'index', true) && in_array($field['type'], [self::FIELD_TYPE_FOREIGN])) {

                $rel = $field['relation'];
                $label = array_get($rel, 'label', 'title');

                $table = in_array($field['name'], $translatableAttributes) ? $this->getTableNameTranslation() : $this->getTableName();
                $items[] = "{$table}.{$field['name']}";

                $relTable = array_get($rel, 'rel_translatable', false) ? $rel['table'] . '_translation' : $rel['table'];
                $fieldName = str_replace('_id', '_title', $field['name']);
                $items[] = "{$relTable}.{$label} AS {$fieldName}";

            } elseif (array_get($field, 'index', true) && !in_array($field['type'], [self::FIELD_TYPE_IMAGE, self::FIELD_TYPE_VS_MULTIPLE])) {
                $table = in_array($field['name'], $translatableAttributes) ? $this->getTableNameTranslation() : $this->getTableName();
                $items[] = "{$table}.{$field['name']}";
            } elseif ($field['type'] === self::FIELD_TYPE_VS_MULTIPLE) {
                $rel = $field['relation'];
                $table = array_get($rel, 'rel_translatable', false) ? $rel['rel_table'] . '_translation' : $field['name'];
                $label = array_get($rel, 'label', 'title');
                $items[] = 'GROUP_CONCAT('.$table.'.'.$label.' SEPARATOR ",") AS ' . $field['name'];
            }
        }

        return $items;
    }

    public function getLeftJoins(): array
    {
        $items = [];

        foreach ($this->getModelConfig()['fields'] as $field) {
            if ($field['type'] === self::FIELD_TYPE_VS_MULTIPLE) {
                $rel = $field['relation'];
                $items[] = "->leftJoin('".$rel['vs_table']."', '".$rel['vs_table'].".".$rel['self_id']."', '".$this->getTableName().".id')";
                $items[] = "->leftJoin('".$rel['rel_table']."', '".$rel['rel_table'].".id', '".$rel['vs_table'].".".$rel['rel_id']."')";

                if (array_get($rel, 'rel_translatable', false)) {
                    $items[] = "->leftJoin('".$rel['rel_table']."_translation', '".$rel['rel_table']."_translation.".$rel['rel_id']."', '".$rel['rel_table'].".id')";
                    $this->extraWhere[] = "->whereRaw('(".$rel['rel_table']."_translation.locale = \"'.app()->getLocale().'\" OR ".$rel['rel_table']."_translation.locale IS NULL)')";
                }
            }

            if ($field['type'] === self::FIELD_TYPE_FOREIGN) {
                $rel = $field['relation'];
                $items[] = "->leftJoin('".$rel['table']."', '".$rel['table'].".id', '".$this->getTableName().".".$field['name']."')";

                if (array_get($rel, 'rel_translatable', false)) {
                    $items[] = "->leftJoin('".$rel['table']."_translation', '".$rel['table']."_translation.".$field['name']."', '".$rel['table'].".id')";
                    $this->extraWhere[] = "->whereRaw('(".$rel['table']."_translation.locale = \"'.app()->getLocale().'\" OR ".$rel['table']."_translation.locale IS NULL)')";
                }
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
            if (array_get($field, 'sortable', true) && $field['type'] === self::FIELD_TYPE_FOREIGN) {
                $items[] = str_replace('_id', '_title', $field['name']);
            } elseif (array_get($field, 'filter', true) && !in_array($field['type'], [self::FIELD_TYPE_IMAGE, self::FIELD_TYPE_DATE])) {
                $items[] = $field['name'];
            }
        }

        return $items;
    }

    public function getFilterConditions(): string
    {
        $data = '';

        foreach ($this->getModelConfig()['fields'] as $field) {
            if (array_get($field, 'filter', true) && !in_array($field['type'], [self::FIELD_TYPE_IMAGE, self::FIELD_TYPE_DATE])) {
                if ($field['type'] == self::FIELD_TYPE_FOREIGN) {
                    $rel = $field['relation'];
                    $label = array_get($rel, 'label', 'title');

                    $relTable = array_get($rel, 'rel_translatable', false) ? $rel['table'] . '_translation' : $rel['table'];
                    $fieldName = str_replace('_id', '_title', $field['name']);

                    $data .= self::TAB2 . 'if ($this->' . $fieldName . ' !== null) {' . self::ENTER;
                    $data .= self::TAB3 . '$query->where("' . $relTable . '.'.$label.'", "like", "%{$this->' . $fieldName . '}%");' . self::ENTER;
                    $data .= self::TAB2 . '}' . self::ENTER2;
                } elseif ($field['type'] == self::FIELD_TYPE_VS_MULTIPLE) {
                    $rel = $field['relation'];
                    $data.= self::TAB2 . 'if ($this->'.$field['name'].' !== null) {' . self::ENTER;
                    $data.= self::TAB3 . '$query->having("'.$field['name'].'", "like", "%{$this->'.$field['name'].'}%");' . self::ENTER;
                    $data.= self::TAB2 . '}' . self::ENTER2;
                } else {
                    $table = array_get($field, 'translatable', false) ? $this->getTableNameTranslation() : $this->getTableName();
                    $data.= self::TAB2 . 'if ($this->'.$field['name'].' !== null) {' . self::ENTER;
                    $data.= self::TAB3 . '$query->where("'.$table.'.'.$field['name'].'", "like", "%{$this->'.$field['name'].'}%");' . self::ENTER;
                    $data.= self::TAB2 . '}' . self::ENTER2;
                }
            }
        }

        return $data;
    }
}
