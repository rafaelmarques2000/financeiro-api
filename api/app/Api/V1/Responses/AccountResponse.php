<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountResult;
use Illuminate\Support\Carbon;

class AccountResponse
{
    public static function parseAccountList(AccountResult $accountResult): array {
        return [
            "total_pages" => $accountResult->getTotalPages(),
            "current_page" => $accountResult->getCurrentPage(),
            "items_per_page" => $accountResult->getItemPerPage(),
            "items" => $accountResult->getItems()->map(function (Account $account) {
                return self::formatAccountResponse($account);
            })->toArray()
        ];
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
            "created_at" => Carbon::parse($account->getCreatedAt())->format("d/m/Y H:m"),
            "updated_at" => Carbon::parse($account->getUpdatedAt())->format("d/m/Y H:m")
        ];
    }
}
