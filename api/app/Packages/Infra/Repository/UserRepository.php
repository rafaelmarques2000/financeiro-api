<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\User\Domain\User;
use App\Packages\Domain\User\Repository\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function list(): Collection
    {
        return collect(DB::select("SELECT * from users"))->map(function ($user) {
            return new User(
                $user->id,
                $user->username,
                $user->password,
                $user->showname,
                $user->active,
            );
        });
    }

    public function findById(string $id): User
    {
        // TODO: Implement findById() method.
    }

    public function save(User $user)
    {
        // TODO: Implement save() method.
    }

    public function update(User $user)
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id)
    {
        // TODO: Implement delete() method.
    }
}
