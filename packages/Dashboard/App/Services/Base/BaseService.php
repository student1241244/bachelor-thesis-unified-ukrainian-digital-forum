<?php

namespace Packages\Dashboard\App\Services\Base;

use Illuminate\Support\Facades\Validator;
use Packages\Dashboard\App\Exceptions\FormValidationException;

class BaseService
{
    /**
     * Global rules to use for validation.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Validate the form submission.
     *
     * @param array $data
     *
     * @throws FormValidationException
     */
    protected function validate(array $data)
    {
        $validator = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            throw new FormValidationException('Fix errors in the form below.', $validator);
        }
    }
}
