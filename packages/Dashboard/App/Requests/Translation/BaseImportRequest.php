<?php

namespace Packages\Dashboard\App\Requests\Translation;

use Packages\Dashboard\App\Requests\BaseFormRequest as FormRequest;

class BaseImportRequest extends FormRequest
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
        return [
            'file' => [
                'required',
                'mimes:csv,txt',
            ],
        ];
    }
}
