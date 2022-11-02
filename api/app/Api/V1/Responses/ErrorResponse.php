<?php

namespace App\Api\V1\Responses;

class ErrorResponse
{
    public static function parseError(string $message): array
    {
        return [
            'message' => $message,
        ];
    }
}
