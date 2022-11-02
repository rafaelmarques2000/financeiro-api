<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\User\Model\User;

class UserRowMapper
{
    public static function ObjectToUser(object $user): User
    {
        return new User(
            $user->id,
            $user->username,
            $user->password,
            $user->show_name,
            $user->active,
        );
    }
}
