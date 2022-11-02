<?php

namespace App\Api\V1\Requests;

class AuthRequest extends BaseRequest
{
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
            'username.required' => 'O campo username é obrigatorio',
            'password.required' => 'O campo password é obrigatorio',
        ];
    }
}
