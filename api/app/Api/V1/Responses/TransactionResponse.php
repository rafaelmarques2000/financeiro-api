<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Transaction\Model\Transaction;
use Illuminate\Support\Collection;

class TransactionResponse
{
    public static function parseTransactionList(Collection $transactionList): array
    {
        return [];
    }

    public static function parseTransactionInstallments(Collection $transactionList): array {
        return $transactionList->map(function (Transaction $transaction) {
            return [
                'id' => $transaction->getId(),
                'current_installment' => $transaction->getCurrentInstallment()
            ];
        })->toArray();
    }

    public static function parseTransaction(Transaction $transaction): array
    {
        return [
            'id' => $transaction->getId()
        ];
    }
}
