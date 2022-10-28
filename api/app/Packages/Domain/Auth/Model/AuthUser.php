<?php

namespace App\Packages\Domain\Auth\Model;

class AuthUser
{
    private string $id;
    private string $showName;

    public function __construct(string $id, string $showName)
    {
        $this->id = $id;
        $this->showName = $showName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getShowName(): string
    {
        return $this->showName;
    }
}
