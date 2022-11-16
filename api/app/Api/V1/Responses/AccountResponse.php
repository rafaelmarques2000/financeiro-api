<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountResult;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class AccountResponse
{
    public static function parseAccountList(AccountResult $accountResult): array
    {
        return [
            'total_pages' => $accountResult->getTotalPages(),
            'total_rows' => $accountResult->getTotalRows(),
            'current_page' => $accountResult->getCurrentPage(),
            'items_per_page' => $accountResult->getItemPerPage(),
            'items' => $accountResult->getItems()->map(function (Account $account) {
                return self::formatAccountResponse($account);
            })->toArray(),
        ];
    }

    public static function parseAccount(Account $account): array
    {
        return self::formatAccountResponse($account);
    }

    public static function formatAccountResponse(Account $account): array
    {
        $accountType = $account->getAccountType();
        $balance = $account->getBalance();
        $amount = 0;

        if($balance != null) {

            if($balance->containsOneItem()) {
                $amount = ($balance->get(0)->description == "Receita" ? $balance->get(0)->total : ($balance->get(0)->total) * -1) /100 ;
            }

            if($balance->count() == 2){
                $receita = $balance->filter(fn($item) => $item->description == "Receita")->first()->total;
                $despesa = $balance->filter(fn($item) => $item->description == "Despesa")->first()->total;
                $amount = ($receita - $despesa) /100;
            }
        }

        return [
            'id' => $account->getId(),
            'description' => $account->getDescription(),
            'accountType' => [
                'id' => $accountType->getId(),
                'description' => $accountType->getDescription(),
                'slug_name' => $accountType->getSlugName(),
                'color' => $accountType->getColor(),
            ],
            'amount' => $amount,
            'created_at' => $account->getCreatedAt(),
            'updated_at' => $account->getUpdatedAt()
        ];
    }
}
