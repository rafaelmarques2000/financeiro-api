<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\User\Model\User;
use App\Packages\Domain\User\Repository\UserRepositoryInterface;
use App\Packages\Infra\Mapper\UserMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function list(): Collection
    {
        return collect(DB::select("SELECT * from users"))->map(function ($user) {
            return UserMapper::ObjectToUser($user);
        });
    }

    public function findById(string $id): ?User
    {
        $user = DB::select("SELECT * FROM users WHERE id=? AND active=true",[$id]);
        if(count($user) == 0) {
            return null;
        }
        return UserMapper::ObjectToUser($user[0]);
    }

    public function findByUsernameAndPassword(string $username, string $password): ?User
    {
        $user = DB::select("SELECT * FROM users WHERE username=? AND password = ? AND active=true",[
            $username,
            $password
        ]);
        if(count($user) == 0) {
            return null;
        }
        return UserMapper::ObjectToUser($user[0]);
    }

}
