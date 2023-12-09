<?php

namespace Packages\Dashboard\App\Requests\User;

use Illuminate\Validation\Rule;
use Packages\Dashboard\App\Models\User;
use Packages\Dashboard\App\Requests\BaseFormRequest;

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
            'role_id' => [
                'required',
                'integer',
            ],
            'ban_to' => [
                'nullable',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:now',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user),
            ],
            'username' => [
                'required',
                'max:255',
                Rule::unique('users')->ignore($this->user),
            ],
        ];

        if (empty($this->user->id)) {
            $rules['password'] = [
                'required',
                'string',
                'min:6',
                'confirmed',
            ];
            $rules['password_confirmation'] = [
                'required',
                'string',
                'min:6',
            ];
        } else {
            $rules['password'] = [
                !empty($this->password_confirmation) ? 'required' : 'nullable',
                'string',
                'min:6',
                'confirmed',
            ];
            $rules['password_confirmation'] = [
                !empty($this->password) ? 'required' : 'nullable',
                'string',
                'min:6',
            ];
        }

        return $rules;
    }

}
