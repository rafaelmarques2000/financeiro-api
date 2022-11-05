<?php

namespace App\Packages\Domain\TransactionCategory\Service;

use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use Illuminate\Support\Collection;

interface TransactionCategoryServiceInterface
{
    function findAll(): Collection;
    function findByTransactionTypeAndCategoryId(string $transactionType,  string $categoryId): ? TransactionCategory;
}
