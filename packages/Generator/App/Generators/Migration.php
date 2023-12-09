<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class Migration extends Base
{
    public function handle()
    {
        $hasTranslation = count($this->getTranslatableAttributes());

        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'tableName' => $this->getTableName(),
            'tableNameTranslation' => $this->getTableNameTranslation(),
            'className' => $this->getClassName(),
            'upContent' => $this->getUpContent(),
            'upContentTranslation' => $this->getUpContentTranslation(),
            'hasTranslation' => $hasTranslation,
            'dropFunction' => $hasTranslation ? 'dropWithTranslations' : 'drop',
            'foreignField' => $this->getForeignField(),
            'withTimestamps' => $this->getWithTimestamps() ? 'true' : 'false',
            'withSluggable' => $this->getWithSluggable() ? 'true' : 'false',
            'withIncrements' => $this->getWithIncrements() ? 'true' : 'false',
        ];

        $this->viewToPackageFile('migration', $data, 'database/migrations/' . $this->getFileName());

        foreach ($this->getMultipleMigrations() as $item) {
            $this->viewToPackageFile('migration_vs_multiple', $item, 'database/migrations/' . $item['file_name']);
        }
    }

    /**
     * @return string
     */
    public function getBaseFileName(): string
    {
        return date('Y') . '_' . date('m') . '_' . date('d') . '_' . $this->getMigrationNextFileName();
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->getBaseFileName() . '_' . Str::snake($this->getClassName());
    }

    public function getClassName(): string
    {
        return 'Create' . Str::studly($this->getTableName()) . 'Table';
    }

    /**
     * @return string
     */
    function getUpContent(): string
    {
        $data = '';

        foreach ($this->getMainFields() as $field) {
            if (in_array($field['type'], [self::FIELD_TYPE_IMAGE, self::FIELD_TYPE_VS_MULTIPLE]) ||
                $field['name'] === 'slug' ||
                array_get($field, 'foreign')
            ) {
                continue;
            }

            $default = array_get($field, 'default');
            $fieldRules = array_get($field, 'rules', []);
            $required = array_get($fieldRules, 'required', true);

            $data.= self::TAB3 . '$table->';

            if ($field['type'] === self::FIELD_TYPE_FOREIGN) {
                $data.= 'foreignId(\''.$field['name'].'\')';
            }
            if ($field['type'] === self::FIELD_TYPE_BOOLEAN) {
                $data.= 'boolean(\''.$field['name'].'\')';
            }
            if ($field['type'] === self::FIELD_TYPE_DOUBLE) {
                $data.= 'double(\''.$field['name'].'\', 8, 2)';
            }
            if ($field['type'] === self::FIELD_TYPE_INTEGER) {
                $data.= 'integer(\''.$field['name'].'\')';
            }
            if ($field['type'] === self::FIELD_TYPE_CHECKBOX) {
                $data .= 'boolean(\'' . $field['name'] . '\')';
            }
            if ($field['type'] === self::FIELD_TYPE_EDITOR) {
                $data.= 'longText(\''.$field['name'].'\')';
            }
            if ($field['type'] === self::FIELD_TYPE_TEXTAREA) {
                $data.= 'text(\''.$field['name'].'\')';
            }
            if ($field['type'] === self::FIELD_TYPE_TEXT) {
                $data.= 'string(\''.$field['name'].'\')';
            }
            if ($field['type'] === self::FIELD_TYPE_TIMESTAMP) {
                $data.= 'timestamp(\''.$field['name'].'\')';
            }
            if ($field['type'] === self::FIELD_TYPE_DATE) {
                $data.= 'date(\''.$field['name'].'\')';
            }

            if ($default === null && !$required) {
                $data.= '->nullable()';
            }
            if ($default !== null) {
                $data.= '->default(\'' . $default . '\')';
            }

            $data.= ';' . self::ENTER;
        }

        $data.= self::ENTER;

        foreach ($this->getMainFields() as $field) {
            if ($field['type'] === self::FIELD_TYPE_FOREIGN) {
                $default = array_get($field, 'default');
                $fieldRules = array_get($field, 'rules', []);
                $required = array_get($fieldRules, 'required', true);

                $defaultOnDelete = 'CASCADE';
                if ($default === null && !$required) {
                    $defaultOnDelete = 'SET NULL';
                }

                $on_delete = array_get($field, 'relation.on_delete', $defaultOnDelete);
                $table = array_get($field, 'relation.table');
                $data.= self::TAB3 . '$table->foreign(\''.$field['name'].'\')->references(\'id\')->on(\''.$table.'\')->onDelete(\''.$on_delete.'\');' . self::ENTER;;
            }
        }
        $data.= self::ENTER;

        return $data;
    }

    /**
     * @return string
     */
    function getUpContentTranslation(): string
    {
        $data = '';

        foreach ($this->getTranslatableFields() as $field) {
            if ($field['type'] === self::FIELD_TYPE_IMAGE) {
                continue;
            }

            $default = array_get($field, 'default');
            $fieldRules = array_get($field, 'rules', []);
            $required = array_get($fieldRules, 'required', true);

            $data.= self::TAB3 . '$table->';

            if ($field['type'] === self::FIELD_TYPE_EDITOR) {
                $data.= 'longText(\''.$field['name'].'\')';
            }
            if ($field['type'] === self::FIELD_TYPE_TEXTAREA) {
                $data.= 'text(\''.$field['name'].'\')';
            }
            if ($field['type'] === self::FIELD_TYPE_TEXT) {
                $data.= 'string(\''.$field['name'].'\')';
            }

            if ($default === null && !$required) {
                $data.= '->nullable()';
            }
            if ($default !== null) {
                $data.= '->default(\'' . $default . '\')';
            }

            $data.= ';' . self::ENTER;
        }

        return $data;
    }

    public function getMultipleMigrations(): array
    {
        $items = [];

        foreach ($this->getMainFields() as $field) {
            if ($field['type'] == self::FIELD_TYPE_VS_MULTIPLE) {
                $rel = $field['relation'];
                $file_name = 'create_' . $rel['vs_table'] . '_table';
                $class_name = Str::studly($file_name);
                $items[] = [
                    'table_name' => $rel['vs_table'],
                    'file_name' => $this->getBaseFileName() . '_' . $file_name,
                    'class_name' => $class_name,
                    'self_id' => $rel['self_id'],
                    'self_table' => $this->getTableName(),
                    'rel_id' => $rel['rel_id'],
                    'rel_table' => $rel['rel_table'],
                ];
            }
        }



        return $items;
    }
}

