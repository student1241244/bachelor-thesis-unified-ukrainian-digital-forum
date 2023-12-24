<?php

namespace App\Http\Requests\Thread;

use App\Http\Requests\BaseAjaxRequest;

class AddCommentRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'body' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:10000',
        ];
    }

    public function attributes()
    {
        $items = parent::attributes();
        $items['body'] = 'Comment';
        $items['image'] = 'Image';

        return $items;
    }

}