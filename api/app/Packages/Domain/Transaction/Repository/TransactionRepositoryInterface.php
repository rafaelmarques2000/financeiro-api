<?php

namespace App\Packages\Domain\Transaction\Repository;

use App\Packages\Domain\Transaction\Model\Transaction;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
    public function findById(string $userId, string $accountId, string $transactionId): ?Transaction;

    public function create(string $userId, string $accountId, Transaction $transaction): Transaction;

    public function createInCollection(string $userId, string $accountId, Collection $transactions): Collection;

    public function update(string $userId, string $accountId, Transaction $transaction): Transaction;

    public function delete(string $userId, string $accountId, string $transactionId): void;
}