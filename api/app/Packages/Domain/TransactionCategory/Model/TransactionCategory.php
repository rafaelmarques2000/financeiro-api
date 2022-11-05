<?php

namespace App\Packages\Domain\TransactionCategory\Model;

use App\Packages\Domain\TransactionType\Model\TransactionType;

class TransactionCategory
{
    private string $id;
    private string $description;
    private string $slugName;
    private TransactionType $transactionType;

    public function __construct(string $id, string $description, string $slugName, TransactionType $transactionType)
    {
        $this->id = $id;
        $this->description = $description;
        $this->slugName = $slugName;
        $this->transactionType = $transactionType;
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

    public function getTransactionType(): TransactionType
    {
        return $this->transactionType;
    }
}
