<?php

namespace App\Packages\Domain\User\Model;

class User
{
    private string $id;
    private string $username;
    private string $password;
    private string $showName;
    private bool $active;

    public function __construct(string $id, string $username, string $password, string $showName, bool $active)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->showName = $showName;
        $this->active = $active;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getShowName(): string
    {
        return $this->showName;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
