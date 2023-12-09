<?php

namespace App\Http\Requests\QA;

use App\Http\Requests\BaseAjaxRequest;

class UpdateAnswerRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'body' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'mimes:jpeg,jpg,png|max:10000',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'required|integer',
        ];
    }
}
