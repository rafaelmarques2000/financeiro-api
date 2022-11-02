<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Auth\Model\AuthUser;

class AuthResponse
{
    public static function parseAuthUser(AuthUser $authUser, string $token): array
    {
        return [
            'user_id' => $authUser->getId(),
            'show_name' => $authUser->getShowName(),
            'token' => $token,
        ];
    }
}
