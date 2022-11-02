<?php

namespace App\Api\V1\Requests;

class AccountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'account_type_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'O campo description é obrigatorio',
            'account_type_id.required' => 'O campo account_type_id é obrigatorio',
        ];
    }
}
