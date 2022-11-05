<?php

namespace App\Packages\Domain\Transaction\Service;

use App\Packages\Domain\Transaction\Model\Transaction;
use Illuminate\Support\Collection;


interface TransactionServiceInterface
{
    function create(string $userId, string $accountId, Transaction $transaction): Transaction | Collection;

}
