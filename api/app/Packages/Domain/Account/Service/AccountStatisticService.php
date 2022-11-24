<?php

namespace App\Packages\Domain\Account\Service;

use App\Packages\Domain\Account\Enum\AccountTypeEnum;
use App\Packages\Domain\Account\Model\AbstractAccountSearch;
use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountGeneralStatistic;
use App\Packages\Domain\Account\Model\AccountSearch;
use App\Packages\Domain\Account\Model\AccountStatisticSearch;
use App\Packages\Domain\Account\Model\AccountTransactionsStatistic;
use App\Packages\Domain\TransactionType\Enum\TransactionTypeEnum;

class AccountStatisticService implements AccountStatisticServiceInterface
{
    private AccountServiceInterface $accountService;

    public function __construct(AccountServiceInterface $accountService)
    {
        $this->accountService = $accountService;
    }

    public function getByPeriod(string $userId, AbstractAccountSearch $accountStatisticSearch): AccountGeneralStatistic
    {
        $accounts = $this->accountService->findAllByUserId($userId, $accountStatisticSearch);

        $revenue = 0;
        $expense = 0;
        $accounts->each(function(Account $account) use(&$revenue, &$expense) {
              $filterRevenue = $account->getBalance()->filter(fn($item) => $item->description == TransactionTypeEnum::RECEITA->value)->first();
              $filterExpense = $account->getBalance()->filter(fn($item) => $item->description == TransactionTypeEnum::DESPESA->value)->first();

              if ($filterRevenue != null) {
                  $revenue += $filterRevenue->total;
              }

              if ($filterExpense != null) {
                  $expense += $filterExpense->total;
              }
        });

        $amount = $revenue - $expense;
        return new AccountGeneralStatistic($amount);
    }

    public function getByPeriodAndAccountId(string $userId, string $accountId, AccountStatisticSearch $accountStatisticSearch): AccountTransactionsStatistic
    {
        $balance = $this->accountService->getBalanceById($userId, $accountId, $accountStatisticSearch->getInitialDate(), $accountStatisticSearch->getEndDate());

        $revenue = 0;
        $expense = 0;
        $balance->each(function(Object $balance) use(&$revenue, &$expense) {

            if($balance->description == TransactionTypeEnum::RECEITA->value) {
                $revenue+=$balance->total;
            }

            if($balance->description == TransactionTypeEnum::DESPESA->value) {
                $expense+=$balance->total;
            }
        });
        $amount = $revenue - $expense;
        return new AccountTransactionsStatistic($revenue, $expense, $amount);
    }
}
