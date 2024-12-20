<?php

namespace App\Domain\Shared\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HandlesFailedValidation
{
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            $errors = $validator->errors()->all()[0];
            throw new HttpResponseException(
                response()->json(['message' => $errors, 'status' => 'error_validate'], 422)
            );
        }
    }
}
