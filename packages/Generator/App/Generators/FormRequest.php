<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class FormRequest extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'modelName' => $this->getModelName(),
            'modelNameVar' => Str::camel($this->getModelName()),
            'rules' => $this->getRules(),
            'uses' => $this->getUses(),
        ];

        if ($this->hasAction('create') || $this->hasAction('update')) {
            $this->viewToPackageFile('form_request', $data, 'App/Requests/' . $this->getModelName() . '/FormRequest');
        }
    }

    /**
     * @return array|string[]
     */
    public function getUses(): array
    {
        $items = [
            'Packages\Dashboard\App\Requests\BaseFormRequest',
        ];

        return $items;
    }


    /**
     * @return string
     */
    public function getRules(): string
    {
        $data = '$rules = [' . self::ENTER;

        foreach ($this->getModelConfig()['fields'] as $field) {

            if (in_array($field['type'], [self::FIELD_TYPE_TIMESTAMP])) {
                continue;
            }

            if (in_array($field['type'], [self::FIELD_TYPE_VS_MULTIPLE])) {
                $data .= $this->getVsMultipleRulesData($field);
                continue;
            }

            if (!array_get($field, 'translatable', false)) {
                $rules = $this->getFieldRules($field);

                $data.= self::TAB3 . "'" . $field['name'] . "' => [" . self::ENTER;
                foreach ($rules as $rule) {
                    $data.= self::TAB4 . "'$rule'," . self::ENTER;
                }
                $data.= self::TAB3 . '],' . self::ENTER;
            }
        }
        $data.= self::TAB2 . "];";

        if (count($this->getTranslatableFields())) {
            $data.= self::ENTER2 . self::TAB2 . 'foreach (config(\'translatable.locales\') as $locale) {';
            foreach ($this->getTranslatableFields() as $field) {
                $rules = $this->getFieldRules($field);

                $data.= self::ENTER . self::TAB3 . '$rules[$locale . \'.'.$field['name'] . '\'] = [';
                foreach ($rules as $rule) {
                    $data.= self::ENTER . self::TAB4 . "'$rule',";
                }
                $data.= self::ENTER . self::TAB3 . '];';
            }
            $data.= self::ENTER . self::TAB2 . '}';
        }

        $data.= self::ENTER2 . self::TAB2 . 'return $rules';

        return $data;
    }

    /**
     * @param array $filed
     * @return string
     */
    public function getVsMultipleRulesData(array $field): string
    {
        $required = array_get($field, 'rules.required', true);

        $data = self::TAB3 . "'" . $field['name'] . "' => [" . self::ENTER;
        $data.= self::TAB4 . "'" . ($required ? 'required' : 'nullable') . "'," . self::ENTER;
        $data.= self::TAB4 . "'array'," . self::ENTER;
        $data.= self::TAB3 . '],' . self::ENTER;

        $data.= self::TAB3 . "'" . $field['name'] . ".*' => [" . self::ENTER;
        $data.= self::TAB4 . "'required'," . self::ENTER;
        $data.= self::TAB4 . "'integer'," . self::ENTER;
        $data.= self::TAB3 . '],' . self::ENTER;

        return $data;
    }

    /**
     * @param array $field
     * @return array
     */
    public function getFieldRules(array $field): array
    {
        $fieldRules = array_get($field, 'rules', []);
        $required = array_get($fieldRules, 'required', true);

        $rules = [];

        if ($field['type'] !== self::FIELD_TYPE_IMAGE) {
            $rules = [
                $required ? 'required' : 'nullable',
            ];
        } else {
            $rules = [
                'nullable',
            ];
        }

        if (in_array($field['type'], [self::FIELD_TYPE_TEXT, self::FIELD_TYPE_TEXTAREA, self::FIELD_TYPE_EDITOR])) {
            $rules[] = 'string';
        } elseif ($field['type'] === self::FIELD_TYPE_INTEGER) {
            $rules[] = 'integer';
        } elseif ($field['type'] === self::FIELD_TYPE_DOUBLE) {
            $rules[] = 'numeric';
        } elseif ($field['type'] === self::FIELD_TYPE_IMAGE) {
            $rules[] = 'mimes:jpeg,png';
        } elseif ($field['type'] === self::FIELD_TYPE_BOOLEAN) {
            $rules[] = 'in:0,1';
        }

        return $rules;
    }

}
