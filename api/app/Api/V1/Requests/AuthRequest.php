<?php

namespace App\Api\V1\Requests;

use App\Api\V1\Responses\ValidationErrorResponse;
use App\Api\V1\Utils\HttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            "username.required" => "O campo username é obrigatorio",
            "password.required" => "O campo password é obrigatorio"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json(
          ValidationErrorResponse::parse("Falha ao validar dados", $validator->errors()->getMessages()),
           HttpStatus::BAD_REQUEST->value
       ));
    }
}
