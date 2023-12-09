<?php

namespace Packages\Generator\App\Generators;

use Illuminate\Support\Str;

class Lang extends Base
{
    public function handle()
    {
        $data = [
            'packageName' => $this->getPackageName(),
            'packageNameSnake' => $this->getPackageNameSnake(),
            'modelName' => $this->getModelName(),
            'modelNameSingular' => $this->getModelNameSingular(),
            'modelNamePlural' => $this->getModelNamePlural(),
            'attributesLabels' => $this->getAttributesLabels(),
        ];

        foreach (config('translatable.locales') as $locale) {
            $this->viewToPackageFile(
                'lang',
                $data,
                'lang/' . $locale . '/' . Str::snake($this->getModelName())
            );
        }
    }

    /**
     * @return array
     */
    public function getAttributesLabels(): array
    {
        $data = ['id' => '#'];
        foreach ($this->getModelConfig()['fields'] as $field) {
            $data[$field['name']] = isset($field['label'])
                ? $field['label']
                : str_replace('_', ' ', ucfirst($field['name']));
        }

        return $data;
    }
}
