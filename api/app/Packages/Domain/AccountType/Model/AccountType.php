<?php

namespace App\Packages\Domain\AccountType\Model;

class AccountType
{
    private string $id;
    private string $description;
    private string $slugName;

    public function __construct(string $id, string $description, string $slugName)
    {
        $this->id = $id;
        $this->description = $description;
        $this->slugName = $slugName;
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
}
