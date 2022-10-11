<?php

namespace App\Packages\Domain\Account\Model;

use Carbon\Carbon;

class Account
{
    private string $id;
    private string $description;
    private string $createdAt;
    private string $updatedAt;
    private string $deletedAt;

    public function __construct(string $id, string $description, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): string
    {
        return $this->deletedAt;
    }

    public function markDeleted() {
        $this->deletedAt = Carbon::now();
    }
}
