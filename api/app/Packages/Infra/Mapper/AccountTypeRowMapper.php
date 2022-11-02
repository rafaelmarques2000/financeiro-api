<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\AccountType\Model\AccountType;

class AccountTypeRowMapper
{
    public static function ObjectToAccountType(object $accountType): AccountType
    {
        return new AccountType(
            $accountType->id,
            $accountType->description,
            $accountType->slug_name,
            $accountType->color
        );
    }
}
