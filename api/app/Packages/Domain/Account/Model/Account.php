<?php

namespace App\Packages\Domain\Account\Model;

use App\Packages\Domain\AccountType\Model\AccountType;
use Carbon\Carbon;

class Account
{
    private string $id;
    private string $description;
    private ?string $createdAt;
    private ?string $updatedAt;
    private ?string $deletedAt;
    private AccountType $accountType;

    public function __construct(
        string $id,
        string $description,
        AccountType $accountType,
        ?string $createdAt = null,
        ?string $updatedAt = null,
        ?string $deletedAt = null,
    )
    {
        $this->id = $id;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
        $this->accountType = $accountType;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    public function getAccountType(): AccountType
    {
        return $this->accountType;
    }

    public function markDeleted() {
        $this->deletedAt = Carbon::now()->toDateTimeString();
    }

}
