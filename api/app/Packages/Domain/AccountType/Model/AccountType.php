<?php

namespace App\Packages\Domain\AccountType\Model;

class AccountType
{
    private string $id;

    private string $description;

    private string $slugName;

    private string $color;

    public function __construct(string $id, string $description, string $slugName, string $color)
    {
        $this->id = $id;
        $this->description = $description;
        $this->slugName = $slugName;
        $this->color = $color;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSlugName(): string
    {
        return $this->slugName;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}
