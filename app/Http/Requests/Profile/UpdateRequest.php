<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseAjaxRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'avatar' => 'mimes:jpeg,jpg,png|max:10000',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->user()->id),
            ],
            'password' => [
                !empty($this->password_confirmation) ? 'required' : 'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
            'password_confirmation' => [
                !empty($this->password) ? 'required' : 'nullable',
                'string',
                'min:6',
            ]
        ];
    }
}
