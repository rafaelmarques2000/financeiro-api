<?php

namespace App\Packages\Domain\TransactionCategory\Service;

use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use App\Packages\Domain\TransactionCategory\Model\TransactionCategorySearch;
use Illuminate\Support\Collection;

interface TransactionCategoryServiceInterface
{
    public function findAll(TransactionCategorySearch $transactionCategorySearch): Collection;

    public function findByTransactionTypeAndCategoryId(string $transactionType, string $categoryId): ?TransactionCategory;
}
