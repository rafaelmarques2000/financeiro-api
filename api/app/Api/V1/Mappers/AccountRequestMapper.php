<?php

namespace App\Api\V1\Mappers;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\AccountType\Model\AccountType;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AccountRequestMapper
{
    public static function requestToAccount(array $body, AccountType $accountType): Account
    {
        return new Account(
            Str::uuid()->toString(),
            $body['description'],
            $accountType
        );
    }

    public static function requestToAccountUpdated(
        array $body,
        string $accountId,
        AccountType $accountType
    ): Account {
        return new Account(
            $accountId,
            $body['description'],
            $accountType,
            null,
            Carbon::now()->toDateTimeString()
        );
    }
}
