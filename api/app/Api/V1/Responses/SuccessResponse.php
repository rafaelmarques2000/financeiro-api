<?php

namespace App\Api\V1\Responses;

class SuccessResponse
{
     public static function parse(string $message, object $data): array {
         return [
             "message" => $message,
             "data" => AccountResponse::parseAccount($data)
         ];
     }
}
