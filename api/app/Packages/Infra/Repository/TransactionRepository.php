<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\Transaction\Model\Transaction;
use App\Packages\Domain\Transaction\Repository\TransactionRepositoryInterface;
use App\Packages\Infra\Mapper\TransactionMapper;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryInterface
{
    private const SELECT_QUERY = "
        SELECT
                t.id,
                t.description,
                t.date,
                t.account_id,
                t.transaction_type_id,
                t.category_id,
                t.created_at,
                t.updated_at,
                t.amount,
                t.installments,
                t.amount_installments,
                t.current_installment
            FROM transaction t
            join transaction_categories tc on t.category_id = tc.id
            join accounts a on t.account_id = a.id
            join type_transaction tt on tc.type_transaction_id = tt.id
    ";

    public function findById(string $userId, string $accountId, string $transactionId): ?Transaction
    {
        $query = DB::select(self::SELECT_QUERY.' WHERE t.account_id = ? AND t.id = ? AND t.deleted_at is null', [$accountId, $transactionId]);

        if (count($query) > 0) {
            return TransactionMapper::ObjectToTransaction($userId, $query[0]);
        }

        return null;
    }

    public function create(string $userId, string $accountId, Transaction $transaction): Transaction
    {
        DB::insert(
            'INSERT INTO transaction (id, description, date, category_id, account_id, amount, installments,
                                amount_installments, current_installment, transaction_type_id, created_at, updated_at)
                                VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?,?)',
            [
                $transaction->getId(),
                $transaction->getDescription(),
                $transaction->getDate(),
                $transaction->getTransactionCategory()->getId(),
                $transaction->getAccount()->getId(),
                $transaction->getAmount(),
                $transaction->isInstallments(),
                $transaction->getAmountInstallments(),
                null,
                $transaction->getTransactionType()->getId(),
                $transaction->getCreatedAt(),
                $transaction->getUpdatedAt(),
            ]
        );

        return $transaction;
    }

    public function createInCollection(string $userId, string $accountId, Collection $transactions): Collection
    {
        DB::beginTransaction();
        try {
            $transactions->each(function (Transaction $transaction) {
                DB::insert(
                    'INSERT INTO transaction (id, description, date, category_id, account_id, amount, installments,
                                amount_installments, current_installment, transaction_type_id, created_at, updated_at)
                                VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?,?)',
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
                        $transaction->getUpdatedAt(),
                    ]
                );
            });
            DB::commit();

            return $transactions;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    public function update(string $userId, string $accountId, Transaction $transaction): Transaction
    {
        // TODO: Implement update() method.
    }

    public function delete(string $userId, string $accountId, string $transactionId): void
    {
        DB::update('UPDATE transaction SET deleted_at = ? WHERE  account_id = ? AND id = ?', [
            Carbon::now(),
            $accountId,
            $transactionId,
        ]);
    }
}
