<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\User\Domain\User;

class UserMapper
{
    public static function ArrayToUser(array $user): User {
        return new User(
          $user['id'],
          $user['username'],
          $user['password'],
          $user['showname'],
          $user['active'],
        );
    }

    public static function ObjectToUser(object $user): User {
        return new User(
            $user->id,
            $user->username,
            $user->password,
            $user->showname,
            $user->active,
        );
    }
}
