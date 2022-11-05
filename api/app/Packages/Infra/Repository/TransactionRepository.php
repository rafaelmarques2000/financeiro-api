<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\Transaction\Model\Transaction;
use App\Packages\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class TransactionRepository implements TransactionRepositoryInterface
{
    function create(string $userId, string $accountId, Transaction $transaction): Transaction
    {
        DB::insert("INSERT INTO transaction (id, description, date, category_id, account_id, amount, installments,
                                amount_installments, current_installment, transaction_type_id, created_at, updated_at)
                                VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?,?)",
            [
                $transaction->getId(),
                $transaction->getDescription(),
                $transaction->getDate(),
                $transaction->getTransactionCategory()->getId(),
                $transaction->getAccount()->getId(),
                $transaction->getAmount(),
                $transaction->isInstallments(),
                $transaction->getAmountInstallments(),
                NULL,
                $transaction->getTransactionType()->getId(),
                $transaction->getCreatedAt(),
                $transaction->getUpdatedAt()
            ]
        );
        return $transaction;
    }

    function createInCollection(string $userId, string $accountId, Collection $transactions): Collection
    {
        DB::beginTransaction();
        try{
            $transactions->each(function (Transaction $transaction) use($userId, $accountId) {
                DB::insert("INSERT INTO transaction (id, description, date, category_id, account_id, amount, installments,
                                amount_installments, current_installment, transaction_type_id, created_at, updated_at)
                                VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?,?)",
                    [
                        $transaction->getId(),
                        $transaction->getDescription(),
                        $transaction->getDate(),
                        $transaction->getTransactionCategory()->getId(),
                        $transaction->getAccount()->getId(),
                        $transaction->getAmount(),
                        $transaction->isInstallments(),
                        $transaction->getAmountInstallments(),
                        $transaction->getCurrentInstallment(),
                        $transaction->getTransactionType()->getId(),
                        $transaction->getCreatedAt(),
                        $transaction->getUpdatedAt()
                    ]
                );
            });
            DB::commit();
            return $transactions;
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
