<?php

namespace Packages\Dashboard\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BaseFormRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $data = trans(Str::snake($this->packageName) . '::'. Str::snake($this->modelName) .'.attributes');

        // Articles\Requests\Article\FormRequest => Articles\Models\Article
        $modelNamespace = str_replace(['\\FormRequest', 'Requests'], ['', 'Models'], static::class);
        if (!class_exists($modelNamespace)) {
            return $data;
        }

        $modelInstance = resolve($modelNamespace);

        if (property_exists($modelInstance, 'translatedAttributes')) {


            foreach ($modelInstance->translatedAttributes as $attr) {
                foreach (config('translatable.locales') as $locale) {
                    $data[$locale . '.' . $attr] = $data[$attr];
                }
            }
        }

        return $data;
    }



}
