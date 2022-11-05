<?php

namespace App\Packages\Domain\Transaction\Service;

use App\Packages\Domain\Transaction\Model\TransactionResult;
use App\Packages\Domain\Transaction\Model\Transaction;
use App\Packages\Domain\Transaction\Model\TransactionSearch;
use Illuminate\Support\Collection;

interface TransactionServiceInterface
{
    public function findAll(string $userId, string $accountId, TransactionSearch $transactionSearch): TransactionResult;

    public function findById(string $userId, string $accountId, string $transactionId): Transaction;

    public function create(string $userId, string $accountId, Transaction $transaction): Transaction | Collection;

    public function update(string $userId, string $accountId, Transaction $transaction): Transaction;

    public function delete(string $userId, string $accountId, string $transactionId): void;
}
