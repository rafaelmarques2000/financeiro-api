<?php

namespace App\Packages\Domain\User\Service;

use App\Packages\Domain\User\Repository\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list(): Collection
    {
        return $this->userRepository->list();
    }
}
