<?php

namespace App\Packages\Domain\TransactionCategory\Repository;

use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use Illuminate\Support\Collection;

interface TransactionCategoryRepositoryInterface
{
    public function findAll(): Collection;

    public function findByTransactionTypeAndCategoryId(string $transactionType, string $categoryId): ?TransactionCategory;
}
