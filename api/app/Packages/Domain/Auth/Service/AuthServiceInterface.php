<?php

namespace App\Packages\Domain\Auth\Service;

interface AuthServiceInterface
{
    public function authenticateByUserAndPassword(string $username, string $password);
}
