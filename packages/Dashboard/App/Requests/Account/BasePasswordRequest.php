<?php

namespace Packages\Dashboard\App\Requests\Account;

use Illuminate\Validation\Rule;
use Packages\Dashboard\App\Requests\BaseFormRequest;

class BasePasswordRequest extends BaseFormRequest
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
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:6',
            ]
        ];
    }

    public function attributes()
    {
        return trans('dashboard::user.attributes');
    }
}
