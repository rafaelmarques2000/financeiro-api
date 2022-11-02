<?php

namespace App\Packages\Domain\User\Service;

use App\Packages\Domain\User\Model\User;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    public function list(): Collection;

    public function findById(string $id): User;

    public function findByUsernameAndPassword(string $username, string $password): ?User;
}
