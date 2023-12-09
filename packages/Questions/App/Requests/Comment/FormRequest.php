<?php
namespace Packages\Questions\App\Requests\Comment;

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
			'question_id' => [
				'nullable',
			],
			'user_id' => [
				'nullable',
			],
			'body' => [
				'required',
				'string',
			],
			'images' => [
				'nullable',
				'array',
			],
			'images.*' => [
				'required',
				'mimes:jpeg,png',
			],
		];

		return $rules;
    }

}
