<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Account\Model\AccountGeneralStatistic;
use App\Packages\Domain\Account\Model\AccountTransactionsStatistic;

class AccountStatisticResponse
{
    public static function parse(AccountGeneralStatistic $accountGeneralStatistic): array
    {
         return [
             'period_amount' => $accountGeneralStatistic->getPeriodBalance()
         ];
    }

    public static function parseAccountBalance(AccountTransactionsStatistic $accountTransactionsStatistic): array
    {
        $revenue = $accountTransactionsStatistic->getRevenue();
        $expense = $accountTransactionsStatistic->getExpense();
        $amount = $accountTransactionsStatistic->getAmount();

        return [
           [
               'description' => 'Receita',
               'amount' => $revenue / 100
           ],
           [
                'description' => 'Despesa',
                'amount' => $expense / 100
           ],
           [
                'description' => 'Saldo',
                'amount' => $amount / 100
           ]
        ];
    }

}
