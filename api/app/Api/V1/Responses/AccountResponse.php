<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Account\Model\Account;
use Illuminate\Support\Collection;

class AccountResponse
{
    public static function parseAccountList(Collection $accountList): array {
        return $accountList->map(function (Account $account) {
            return [
                "id" => $account->getId(),
                "description" => $account->getDescription(),
                "created_at" => $account->getCreatedAt()
            ];
        })->toArray();
    }

    public static function parseAccount(Account $account): array {
        return [
                "id" => $account->getId(),
                "description" => $account->getDescription(),
                "created_at" => $account->getCreatedAt()
              ];
    }
}
