<?php

namespace App\Packages\Domain\TransactionCategory\Repository;

use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use Illuminate\Support\Collection;

interface TransactionCategoryRepositoryInterface
{
    function findAll(): Collection;
    function findByTransactionTypeAndCategoryId(string $transactionType,  string $categoryId): ? TransactionCategory;
}
