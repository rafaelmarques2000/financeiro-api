<?php

namespace App\Packages\Domain\TransactionCategory\Service;

use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use Illuminate\Support\Collection;

interface TransactionCategoryServiceInterface
{
    public function findAll(): Collection;

    public function findByTransactionTypeAndCategoryId(string $transactionType, string $categoryId): ?TransactionCategory;
}
