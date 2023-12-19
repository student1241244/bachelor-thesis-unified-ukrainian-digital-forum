<?php
namespace Packages\Settings\App\Requests\Settings;

use Packages\Dashboard\App\Requests\BaseFormRequest;

class FormRequest extends BaseFormRequest
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
        $rules = [
			'user_id' => [
				'nullable',
			],
			'body' => [
				'required',
				'string',
			],
		];

		return $rules;
    }

}
