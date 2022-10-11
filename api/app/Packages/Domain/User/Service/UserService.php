<?php

namespace App\Packages\Domain\User\Service;

use App\Packages\Domain\User\Exception\UserNotFoundException;
use App\Packages\Domain\User\Model\User;
use App\Packages\Domain\User\Exception\AccountNotFoundException;
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


    public function findById(string $id): User
    {
        $user = $this->userRepository->findById($id);
        if(!$user) {
            throw new UserNotFoundException("Usuário não encontrado na base");
        }
        return $user;
    }

    public function findByUsernameAndPassword(string $username, string $password): ?User
    {
        return $this->userRepository->findByUsernameAndPassword($username, $password);
    }
}
