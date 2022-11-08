<?php

namespace App\Packages\Domain\TransactionCategory\Repository;

use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use App\Packages\Domain\TransactionCategory\Model\TransactionCategorySearch;
use Illuminate\Support\Collection;

interface TransactionCategoryRepositoryInterface
{
    public function findAll(TransactionCategorySearch $transactionCategorySearch): Collection;

    public function findByTransactionTypeAndCategoryId(string $transactionType, string $categoryId): ?TransactionCategory;
}
