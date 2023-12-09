<?php

namespace App\Http\Requests\Report;

use App\Http\Requests\BaseAjaxRequest;

class StoreRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'type' => 'required',
            'id' => 'required|integer',
            'reason' => 'required|string',
        ];
    }
}
