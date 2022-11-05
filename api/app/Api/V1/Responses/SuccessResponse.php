<?php

namespace App\Api\V1\Responses;

class SuccessResponse
{
    public static function parse(string $message, array $data): array
    {
        return [
            'message' => $message,
            'data' => $data,
        ];
    }
}
