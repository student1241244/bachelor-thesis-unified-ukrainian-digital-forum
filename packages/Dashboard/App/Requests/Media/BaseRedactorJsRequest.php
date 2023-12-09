<?php
namespace Packages\Dashboard\App\Requests\Media;

use Packages\Dashboard\App\Requests\BaseAjaxRequest;

class BaseRedactorJsRequest extends BaseAjaxRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'array',
            'file.*' => 'image',
        ];
    }

}
