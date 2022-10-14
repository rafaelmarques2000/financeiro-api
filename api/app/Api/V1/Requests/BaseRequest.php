<?php

namespace App\Api\V1\Requests;

use App\Api\V1\Responses\ValidationErrorResponse;
use App\Api\V1\Utils\HttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    public function authorize() {
         return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            ValidationErrorResponse::parse("Falha ao validar dados", $validator->errors()->getMessages()),
            HttpStatus::BAD_REQUEST->value
        ));
    }
}
