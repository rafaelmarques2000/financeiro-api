<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\User\Model\User;

class AccountRowMapper
{
    public static function ObjectToAccount(object $account): Account {
        return new Account(
            $account->id,
            $account->description,
            $account->created_at,
            $account->updated_at,
        );
    }
}
