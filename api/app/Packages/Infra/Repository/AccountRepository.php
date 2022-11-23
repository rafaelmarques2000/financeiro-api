<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountResult;
use App\Packages\Domain\Account\Model\AccountSearch;
use App\Packages\Domain\Account\Repository\AccountRepositoryInterface;
use App\Packages\Domain\Transaction\Repository\TransactionRepositoryInterface;
use App\Packages\Infra\Mapper\AccountRowMapper;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AccountRepository extends AbstractPaginatedRepository implements AccountRepositoryInterface
{
    public const SELECT_ACCOUNT_QUERY = 'SELECT a.id,
                        a.description,
                        a.created_at,
                        a.updated_at,
                        t.id as account_type_id,
                        t.description as account_type_description,
                        t.slug_name as account_type_slug_name,
                        t.color as account_type_color
                        from accounts a
                        JOIN user_accounts uc
                        ON a.id = uc.account_id
                        JOIN users u on uc.user_id = u.id
                        JOIN account_types t on a.account_type_id = t.id
                        WHERE u.id = ? AND a.deleted_at is null
                    ';

    protected string $countQuery = 'SELECT
                        COUNT(a.id) as total
                        from accounts a
                        JOIN user_accounts uc
                        ON a.id = uc.account_id
                        JOIN users u on uc.user_id = u.id
                        JOIN account_types t on a.account_type_id = t.id
                        WHERE u.id = ? AND a.deleted_at is null
                    ';

    private TransactionRepositoryInterface $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = app(TransactionRepositoryInterface::class);
    }

    public function findAllByUserId(string $userId, string $initialDate, string $endDate): Collection
    {
        return collect(DB::select(self::SELECT_ACCOUNT_QUERY, [$userId]))->map(function ($account) use($userId, $initialDate, $endDate) {
            $balance = $this->transactionRepository
                ->getBalanceByAccount(
                    $userId,
                    $account->id,
                    $initialDate,
                    $endDate
                );
            return AccountRowMapper::ObjectToAccount($account, $balance);
        });
}
    public function findAll(string $userId, AccountSearch $accountSearch): AccountResult
    {
        $query = self::SELECT_ACCOUNT_QUERY;
        if ($accountSearch->getDescription() != null) {
            $query .= "AND a.description ILIKE '%".$accountSearch->getDescription()."%'";
            $this->countQuery .= "AND a.description ILIKE '%".$accountSearch->getDescription()."%'";
        }

        $totalLimitRange = $this->calculateLimitOffset($accountSearch->getLimit(), $accountSearch->getPage());
        $limit = $accountSearch->getLimit();

        $query .= 'LIMIT '.$limit.' OFFSET '.$totalLimitRange;

        $result = collect(DB::select($query, [$userId]))->map(function ($account) use($userId, $accountSearch) {
            $balance = $this->transactionRepository
                ->getBalanceByAccount(
                    $userId,
                    $account->id,
                    $accountSearch->getInitialDate(),
                    $accountSearch->getEndDate()
                );
            return AccountRowMapper::ObjectToAccount($account, $balance);
        });

        return new AccountResult(
            $this->calculateTotalPages($userId, $accountSearch->getLimit()),
            $this->calculateTotalRows($userId),
            $accountSearch->getPage(),
            $accountSearch->getLimit(),
            $result
        );
    }

    public function findById(string $userId, string $id): ?Account
    {
        $account = DB::select(self::SELECT_ACCOUNT_QUERY.'AND a.id = ?', [$userId, $id]);
        if (count($account) == 0) {
            return null;
        }

        return AccountRowMapper::ObjectToAccount($account[0]);
    }

    public function create(string $userId, Account $account): Account
    {
        DB::beginTransaction();
        try {
            DB::insert('INSERT INTO accounts(id, description, account_type_id,created_at, updated_at) VALUES (?, ?, ?, ?, ?)', [
                $account->getId(),
                $account->getDescription(),
                $account->getAccountType()->getId(),
                $account->getCreatedAt(),
                $account->getUpdatedAt()
            ]);
            DB::insert('INSERT INTO user_accounts(user_id, account_id) VALUES (?, ?)', [
                $userId,
                $account->getId(),
            ]);
            DB::commit();

            return $this->findById($userId, $account->getId());
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    public function update(string $userId, Account $account): Account
    {
        DB::update('UPDATE accounts SET description = ?, account_type_id=?, updated_at=? WHERE id=?', [
            $account->getDescription(),
            $account->getAccountType()->getId(),
            $account->getUpdatedAt(),
            $account->getId(),
        ]);

        return $this->findById($userId, $account->getId());
    }

    public function delete(string $userId, Account $account): void
    {
        DB::beginTransaction();
        try {
            DB::update('UPDATE accounts SET deleted_at = ? WHERE id=?', [
                $account->getDeletedAt(),
                $account->getId(),
            ]);

            DB::update('UPDATE transaction SET deleted_at = ? WHERE account_id=?', [
                $account->getDeletedAt(),
                $account->getId(),
            ]);
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
