<?php

namespace App\Packages\Domain\Account\Service;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountGeneralStatistic;
use App\Packages\Domain\Account\Model\AccountResult;
use App\Packages\Domain\Account\Model\AccountSearch;
use App\Packages\Domain\Account\Model\AccountStatisticSearch;
use App\Packages\Domain\Account\Model\AccountTransactionsStatistic;

interface AccountStatisticServiceInterface
{
    public function getByPeriod(string $userId, AccountStatisticSearch $accountStatisticSearch): AccountGeneralStatistic;
    public function getByPeriodAndAccountId(string $userId, string $accountId, AccountStatisticSearch $accountStatisticSearch): AccountTransactionsStatistic;
}
