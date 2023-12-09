<?php

namespace App\Http\Requests\QA;

use App\Http\Requests\BaseAjaxRequest;

class PostAnswerRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'body' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'mimes:jpeg,jpg,png|max:10000',
        ];
    }
}
