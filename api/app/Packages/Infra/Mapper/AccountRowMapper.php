<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\AccountType\Model\AccountType;
use Illuminate\Support\Collection;

class AccountRowMapper
{
    public static function ObjectToAccount(object $account, ?Collection $balance = null): Account
    {
        $accountType = new AccountType(
            $account->account_type_id,
            $account->account_type_description,
            $account->account_type_slug_name,
            $account->account_type_color
        );

        return new Account(
            $account->id,
            $account->description,
            $accountType,
            $balance,
            $account->created_at,
            $account->updated_at,
        );
    }
}
