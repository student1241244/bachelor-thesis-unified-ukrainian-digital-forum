<?php

namespace Packages\Dashboard\App\Requests\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseSendRequest extends FormRequest
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
                'string',
                'email',
                Rule::exists('users', 'email'),
            ],
        ];
    }
}
