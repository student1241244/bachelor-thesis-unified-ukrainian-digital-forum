<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class Index extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'modelName' => $this->getModelName(),
            'modelNameSnake' => $this->getModelNameSnake(),
            'modelNameForRoute' => $this->getNameRouteController(),
            'rawColumns' => $this->getRawColumns(),

        ];

        $this->viewToPackageFile('index', $data, 'themes/default/views/' . Str::snake($this->getModelName()) . '/index.blade');
    }

    public function getRawColumns(): string
    {
        $raw = '';

        $raw.= "\t\t\t\t{\n";
        $raw.= "\t\t\t\t\tname: \"id\",\n";
        $raw.= "\t\t\t\t\tlabel: \"#\",\n";
        $raw.= "\t\t\t\t},\n";

        foreach ($this->getModelConfig()['fields'] as $field) {
            if (array_get($field, 'index', true)) {
                $fieldName = $field['name'];
                if ($field['type'] === self::FIELD_TYPE_FOREIGN) {
                    $fieldName = str_replace('_id', '_title', $field['name']);
                }


                $raw.= "\t\t\t\t{\n";
                $raw.= "\t\t\t\t\tname: \"{$fieldName}\",\n";

                $raw.= "\t\t\t\t\tlabel: \"{{ __('".$this->getPackageNameSnake()."::".$this->getModelNameSnake().".attributes.{$field['name']}') }}\",\n";

                if ($field['type'] === self::FIELD_TYPE_CHECKBOX) {
                    $raw.= "\t\t\t\t\tfilter: {\n";
                    $raw.= "\t\t\t\t\t\ttype: \"select\",\n";
                    $raw.= "\t\t\t\t\t\toptions: {!!  json_encode(\Packages\Dashboard\App\Helpers\CrudHelper::getYesNoList()) !!},\n";
                    $raw.= "\t\t\t\t\t}\n";
                }

                if ($field['type'] === self::FIELD_TYPE_IMAGE) {
                    $raw.= "\t\t\t\t\tfilter: false,\n";
                    $raw.= "\t\t\t\t\tsortable: false,\n";
                    $raw.= "\t\t\t\t\trender: function(value) {\n";
                    $raw.= "\t\t\t\t\t\treturn aGridExt.renderImage(value)\n";
                    $raw.= "\t\t\t\t\t}\n";
                }

                $raw.= "\t\t\t\t},\n";
            }
        }

        return $raw;
    }
}
