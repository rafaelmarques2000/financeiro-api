<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\AccountType\Model\AccountType;

class AccountRowMapper
{
    public static function ObjectToAccount(object $account): Account {
        $accountType = new AccountType(
            $account->account_type_id,
            $account->account_type_description,
            $account->account_type_slug_name,
        );
        return new Account(
            $account->id,
            $account->description,
            $accountType,
            $account->created_at,
            $account->updated_at,
        );
    }
}
