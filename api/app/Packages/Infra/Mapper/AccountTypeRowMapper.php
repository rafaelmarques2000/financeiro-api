<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\AccountType\Model\AccountType;
use App\Packages\Domain\User\Model\User;

class AccountTypeRowMapper
{
    public static function ObjectToAccountType(object $accountType): AccountType {
        return new AccountType(
            $accountType->id,
            $accountType->description,
            $accountType->slug_name,
        );
    }
}
