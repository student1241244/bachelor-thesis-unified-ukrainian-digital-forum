<?php

namespace Packages\Dashboard\App\Requests\Role;

use Illuminate\Validation\Rule;
use Packages\Dashboard\App\Requests\BaseFormRequest as FormRequest;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug' => [
                'required',
                Rule::unique('roles')->ignore($this->role),
            ],
            'title' => [
                'required',
                Rule::unique('roles')->ignore($this->role),
            ],
            'permissions' => [
                'nullable',
                'array',
            ],
            'permissions.*' => [
                'required',
                'integer',
            ],
        ];
    }

}
