<?php

namespace App\Http\Requests\QA;

use App\Http\Requests\BaseAjaxRequest;

class PostAnswerRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'body' => 'required|max:1000',
            'images' => 'nullable|array|max:6',
            'images.*' => 'mimes:jpeg,jpg,png|max:2048',
        ];
    }
}
