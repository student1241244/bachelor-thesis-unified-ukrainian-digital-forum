<?php

namespace Packages\Dashboard\App\Requests\Translation;

use Illuminate\Validation\Rule;
use Packages\Dashboard\App\Requests\BaseFormRequest;
use Packages\Dashboard\App\Models\Language;

class FormRequest extends BaseFormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'text' => [
                'required',
                'array',
            ],
        ];
        foreach (Language::getLocales() as $locale) {
            $rules['text.' . $locale] = [
                'required',
                'string',
            ];
        }

        return $rules;
    }

}
