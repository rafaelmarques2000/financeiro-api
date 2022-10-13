<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Account\Model\Account;
use Illuminate\Support\Collection;

class AccountResponse
{
    public static function parseAccountList(Collection $accountList): array {
        return $accountList->map(function (Account $account) {
            return self::formatAccountResponse($account);
        })->toArray();
    }

    public static function parseAccount(Account $account): array {
        return self::formatAccountResponse($account);
    }

    public static function formatAccountResponse(Account $account): array
    {
        $accountType = $account->getAccountType();
        return [
            "id" => $account->getId(),
            "description" => $account->getDescription(),
            "accountType" => [
                "id" => $accountType->getId(),
                "description" => $accountType->getDescription(),
                "slug_name" => $accountType->getSlugName(),
            ],
            "created_at" => $account->getCreatedAt(),
            "updated_at" => $account->getUpdatedAt()
        ];
    }
}
