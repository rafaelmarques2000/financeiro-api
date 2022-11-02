<?php

namespace App\Packages\Domain\User\Repository;

interface UserRepositoryInterface
{
    public function list();

    public function findById(string $id);

    public function findByUsernameAndPassword(string $username, string $password);
}
