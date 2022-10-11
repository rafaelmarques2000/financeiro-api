<?php

namespace App\Api\V1\Responses;

class ErrorResponse
{
     public static function parserError(string $message): array {
         return [
             "message" => $message
         ];
     }
}
