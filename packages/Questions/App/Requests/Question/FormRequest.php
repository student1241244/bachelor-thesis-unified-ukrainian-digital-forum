<?php
namespace Packages\Questions\App\Requests\Question;

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
			'title' => [
				'required',
				'string',
			],
			'body' => [
				'required',
				'string',
			],
		];

		return $rules;
    }

}
