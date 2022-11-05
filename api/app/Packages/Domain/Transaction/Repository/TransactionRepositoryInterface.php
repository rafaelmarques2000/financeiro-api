<?php

namespace App\Packages\Domain\Transaction\Repository;

use App\Packages\Domain\Transaction\Model\Transaction;
use Illuminate\Support\Collection;


interface TransactionRepositoryInterface
{
    function create(string $userId, string $accountId, Transaction $transaction) : Transaction;
    function createInCollection(string $userId, string $accountId, Collection $transactions) : Collection;
}
