<?php

namespace App\Http\Requests\Report;

use App\Http\Requests\BaseAjaxRequest;

class CleanRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'type' => 'required',
            'id' => 'required|integer',
        ];
    }
}
