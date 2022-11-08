<?php

namespace App\Packages\Domain\TransactionCategory\Model;

class TransactionCategorySearch
{
    private ?string $transactionTypeId;

    public function __construct(?string $transactionTypeId)
    {
        $this->transactionTypeId = $transactionTypeId;
    }

    public function getTransactionTypeId(): ?string
    {
        return $this->transactionTypeId;
    }
}
