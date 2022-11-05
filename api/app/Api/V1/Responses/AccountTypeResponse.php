<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\AccountType\Model\AccountType;
use Illuminate\Support\Collection;

class AccountTypeResponse
{
    public static function parseAccountTypeList(Collection $accountList): array
    {
        return $accountList->map(function (AccountType $accountType) {
            return self::formatAccountResponse($accountType);
        })->toArray();
    }

    public static function formatAccountResponse(AccountType $accountType): array
    {
        return
          [
              'id' => $accountType->getId(),
              'description' => $accountType->getDescription(),
              'slug_name' => $accountType->getSlugName(),
              'color' => $accountType->getColor(),
          ];
    }
}
