<?php

namespace App\Packages\Domain\User\Repository;

use App\Packages\Domain\User\Domain\User;

interface UserRepositoryInterface
{
    public function list();
    public function findById(string $id);
    public function save(User $user);
    public function update(User $user);
    public function delete(string $id);
}
