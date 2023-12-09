<?php

namespace Packages\Dashboard\App\Requests\Account;

use Illuminate\Validation\Rule;
use Packages\Dashboard\App\Requests\BaseFormRequest;

class BaseUpdateRequest extends BaseFormRequest
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
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(auth()->user()),
            ],
            'username' => [
                'required',
                'max:255',
                Rule::unique('users')->ignore(auth()->user()),
            ],
        ];
    }

    public function attributes()
    {
        return trans('dashboard::user.attributes');
    }
}
