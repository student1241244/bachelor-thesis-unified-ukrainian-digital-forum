<?php

namespace Packages\Dashboard\App\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BaseFormRequest
 * @package App\Http\Requests
 */
abstract class BaseAjaxRequest extends FormRequest
{
    /**
     * Get the failed validation response for the request.
     *
     * @param   Validator $validator
     * @return  HttpResponseException
     */
    protected function failedValidation(Validator $validator) : HttpResponseException
    {
        $errors = $validator->errors()->toArray();

        //dd($errors);

        if (isset($errors['g-recaptcha-response'])) {
            $errors['g-recaptcha-response'] = [trans('front.errors.recaptcha')];
        }

        throw new HttpResponseException(
            response()->json([
                'errors'  => $errors,
            ], 422)
        );
    }

}
