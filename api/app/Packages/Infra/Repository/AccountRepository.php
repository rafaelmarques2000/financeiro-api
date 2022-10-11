<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Repository\AccountRepositoryInterface;
use App\Packages\Infra\Mapper\AccountRowMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AccountRepository implements AccountRepositoryInterface
{
    public function list(string $userId): Collection
    {
        return collect(DB::select("SELECT * from accounts a
                    JOIN user_accounts uc
                    ON a.id = uc.account_id
                    JOIN users u on uc.user_id = u.id
                    WHERE u.id = ? AND a.deleted_at is null
                    ",[$userId]))->map(function ($account) {
            return AccountRowMapper::ObjectToAccount($account);
        });
    }

    public function findById(string $userId, string $id): ?Account
    {
        $account = DB::select("SELECT * from accounts a
                    JOIN user_accounts uc
                    ON a.id = uc.account_id
                    JOIN users u on uc.user_id = u.id
                    WHERE u.id = ? AND a.deleted_at is null",[$id]);
        if(count($account) == 0) {
            return null;
        }
        return AccountRowMapper::ObjectToAccount($account[0]);
    }

    public function create(string $userId, Account $account): Account
    {

    }

    public function update(string $userId, Account $account): Account
    {
        // TODO: Implement update() method.
    }

    public function delete(string $userId, Account $account): void
    {
        // TODO: Implement delete() method.
    }

}
