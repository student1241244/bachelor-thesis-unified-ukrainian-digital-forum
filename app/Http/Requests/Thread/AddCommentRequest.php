<?php

namespace App\Http\Requests\Thread;

use App\Http\Requests\BaseAjaxRequest;

class AddCommentRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'body' => 'required',
        ];
    }

    public function attributes()
    {
        $items = parent::attributes();
        $items['body'] = 'Comment';

        return $items;
    }

}