<?php

namespace App\Api\V1\Responses;

class ValidationErrorResponse
{
    public static function parse(string $message, array $errors): array
    {
        return [
            'message' => $message,
            'errors' => $errors,
        ];
    }
}
