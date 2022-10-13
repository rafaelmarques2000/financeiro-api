<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\User\Model\User;
use Illuminate\Support\Collection;

class UserResponse
{
    public static function parserUserList(Collection $userList): array {
        return $userList->map(function (User $user) {
            return self::formatUserResponse($user);
        })->toArray();
    }

    public static function parserUser(User $user): array {
        return self::formatUserResponse($user);
    }

    private static function formatUserResponse(User $user): array
    {
        return [
            "id" => $user->getId(),
            "username" => $user->getUsername(),
            "show_name" => $user->getShowName()
        ];
    }
}
