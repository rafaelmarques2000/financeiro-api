<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\AccountType\Model\AccountType;
use App\Packages\Domain\AccountType\Repository\AccountTypeRepositoryInterface;
use App\Packages\Infra\Mapper\AccountTypeRowMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AccountTypeRepository implements AccountTypeRepositoryInterface
{
    public function findById(string $id): ?AccountType
    {
        $accountType = DB::select('SELECT * FROM account_types WHERE id=?', [$id]);
        if (count($accountType) == 0) {
            return null;
        }

        return AccountTypeRowMapper::ObjectToAccountType($accountType[0]);
    }

    public function list(): Collection
    {
        return collect(DB::select('SELECT * FROM account_types'))->map(function ($accountType) {
            return AccountTypeRowMapper::ObjectToAccountType($accountType);
        });
    }
}
