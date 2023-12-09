<?php

namespace Packages\Dashboard\App\Requests\Api\Media;

use Packages\Dashboard\App\Requests\BaseAjaxRequest;

class BaseUploadRequest extends BaseAjaxRequest
{
    public function rules()
    {
        return [
            'file' => [
                'required',
                'file',
                'mimetypes:' . implode(',', [
                    'video/mp4',
                    'video/avi',
                    'video/3gp',
                    'video/mov',
                    'video/wmv',
                    'video/flv',
                    'image/png',
                    'image/jpeg',
                    'image/gif',
                ]),
            ],
        ];
    }
}
