<?php

namespace App\Http\Requests\Thread;

use App\Http\Requests\BaseAjaxRequest;

class StoreRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'title' => 'required',
            'category_id' => 'required|exists:threads_categories,id',
            'body' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:10000',
            'is_agree' => 'required',
            'g-captcha-response' => 'required',
        ];
    }

    public function attributes()
    {
        $items = parent::attributes();
        $items['title'] = 'Title';
        $items['body'] = 'Body';
        $items['image'] = 'Image';
        $items['category_id'] = 'Category';

        return $items;
    }

    public function messages()
    {
        $items = parent::messages();
        $items['is_agree.required'] = 'You must agree to the terms and conditions.';

        return $items;
    }
}
