<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\User\Domain\User;
use Illuminate\Support\Collection;

class UserResponse
{
    public static function parserUserList(Collection $userList): array {
        return $userList->map(function (User $user) {
            return [
                "id" => $user->getId(),
                "username" => $user->getUsername(),
                "show_name" => $user->getShowName()
            ];
        })->toArray();
    }
}
