<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\Transaction\Model\Transaction;
use App\Packages\Domain\Transaction\Model\TransactionResult;
use App\Packages\Domain\Transaction\Model\TransactionSearch;
use App\Packages\Domain\Transaction\Repository\TransactionRepositoryInterface;
use App\Packages\Infra\Mapper\TransactionMapper;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends AbstractPaginatedRepository implements TransactionRepositoryInterface
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
            join user_accounts ua on a.id = ua.account_id
    ";

    protected string $countQuery = "
        SELECT
            COUNT(t.id) as total
            FROM transaction t
            join transaction_categories tc on t.category_id = tc.id
            join accounts a on t.account_id = a.id
            join type_transaction tt on tc.type_transaction_id = tt.id
            join user_accounts ua on a.id = ua.account_id
            WHERE t.account_id = ? AND t.deleted_at is null
    ";

    private const SELECT_AMOUNT_PER_TYPE = "
            SELECT
            tt.description,
            sum(t.amount) as total
        FROM transaction t
                 join transaction_categories tc on t.category_id = tc.id
                 join accounts a on t.account_id = a.id
                 join type_transaction tt on t.transaction_type_id = tt.id
                 join account_types at on a.account_type_id = at.id
                 join user_accounts ua on a.id = ua.account_id
        WHERE t.account_id = ?
          AND ua.user_id = ?
          AND t.deleted_at is null
          AND t.date BETWEEN ? AND ?
        group by tt.description
        ORDER BY tt.description DESC
        ;
    ";

    public function findAll(string $userId, string $accountId, TransactionSearch $transactionSearch): TransactionResult
    {
        $query = self::SELECT_QUERY. "WHERE t.account_id= ? AND ua.user_id=? AND t.deleted_at is null";

        if ($transactionSearch->getDescription() != null) {
            $query .= " AND t.description ILIKE '%".$transactionSearch->getDescription()."%'";
            $this->countQuery .= " AND t.description ILIKE '%".$transactionSearch->getDescription()."%'";
        }

        if ($transactionSearch->getInitialDate() != null && $transactionSearch->getEndDate() != null) {
            $query .= " AND t.date BETWEEN '".$transactionSearch->getInitialDate()."' AND '".$transactionSearch->getEndDate()."'";
            $this->countQuery .= " AND t.date BETWEEN '".$transactionSearch->getInitialDate()."' AND '".$transactionSearch->getEndDate()."'";
        }

        $totalLimitRange = $this->calculateLimitOffset($transactionSearch->getLimit(), $transactionSearch->getPage());
        $limit = $transactionSearch->getLimit();

        $query .= ' ORDER BY t.date ASC LIMIT '.$limit.' OFFSET '.$totalLimitRange;

        $result = collect(DB::select($query, [$accountId, $userId]))->map(function ($transaction) use ($userId) {
            return TransactionMapper::ObjectToTransaction($userId, $transaction);
        });



        return new TransactionResult(
            $this->calculateTotalPages($accountId, $transactionSearch->getLimit()),
            $this->calculateTotalRows($accountId),
            $transactionSearch->getPage(),
            $transactionSearch->getLimit(),
            $result
        );
    }

    public function findById(string $userId, string $accountId, string $transactionId): ?Transaction
    {
        $query = DB::select(self::SELECT_QUERY.' WHERE t.account_id = ? AND ua.user_id=? AND t.id = ? AND t.deleted_at is null', [$accountId, $userId, $transactionId]);

        if (count($query) > 0) {
            return TransactionMapper::ObjectToTransaction($userId, $query[0]);
        }

        return null;
    }

    public function create(string $userId, string $accountId, Transaction $transaction): Transaction
    {
        DB::insert(
            'INSERT INTO transaction (id, description, date, category_id, account_id, amount, installments,
                                amount_installments, current_installment, transaction_type_id, created_at, updated_at, month, year)
                                VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?,?,?,?)',
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
                $transaction->getDate()->format('m'),
                $transaction->getDate()->format('Y'),
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
                                amount_installments, current_installment, transaction_type_id, created_at, updated_at, month, year)
                                VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?,?,?,?)',
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
                        $transaction->getDate()->format('m'),
                        $transaction->getDate()->format('Y')
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
        $updateAt = Carbon::now();

        $query = DB::update("UPDATE transaction SET
                       description=?,
                       date=?,
                       category_id=?,
                       account_id=?,
                       amount = ?,
                       transaction_type_id = ?,
                       updated_at = ?,
                       month = ?,
                       year = ?
                       WHERE account_id = ? AND id = ?
                       ", [
                           $transaction->getDescription(),
                           $transaction->getDate(),
                           $transaction->getTransactionCategory()->getId(),
                           $transaction->getAccount()->getId(),
                           $transaction->getAmount(),
                           $transaction->getTransactionType()->getId(),
                           $updateAt,
                           $transaction->getDate()->format('m'),
                           $transaction->getDate()->format('Y'),
                           $accountId,
                           $transaction->getId()
                          ]);
        return $this->findById($userId, $accountId, $transaction->getId());
    }

    public function delete(string $userId, string $accountId, string $transactionId): void
    {
        DB::update('UPDATE transaction SET deleted_at = ? WHERE  account_id = ? AND id = ?', [
            Carbon::now(),
            $accountId,
            $transactionId,
        ]);
    }

    public function getBalanceByAccount(string $userId, ?string $accountId = null, ?string $initialDate = null, ?string $endDate = null): Collection
    {
         return collect(DB::select(self::SELECT_AMOUNT_PER_TYPE, [
             $accountId,
             $userId,
             $initialDate ?? Carbon::now()->startOfMonth()->format('Y-m-d') ,
             $endDate ?? Carbon::now()->endOfMonth()->format('Y-m-d')
         ]));
    }
}
