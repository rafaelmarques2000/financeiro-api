<?php

namespace App\Packages\Domain\Auth\Service;

use App\Packages\Domain\Auth\Exception\InvalidUserAndPasswordException;
use App\Packages\Domain\Auth\Model\AuthUser;
use App\Packages\Domain\User\Service\UserServiceInterface;

class AuthService implements AuthServiceInterface
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function authenticateByUserAndPassword(string $username, string $password): AuthUser
    {
         $user = $this->userService->findByUsernameAndPassword($username, $password);

         if(!$user) {
             throw new InvalidUserAndPasswordException("Credencias invalidas");
         }
         return new AuthUser($user->getId(), $user->getShowName());
    }
}
