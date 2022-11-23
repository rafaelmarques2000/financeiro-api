<?php

namespace Tests\Unit\Domain\Account\Service;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountGeneralStatistic;
use App\Packages\Domain\Account\Model\AccountStatisticSearch;
use App\Packages\Domain\Account\Model\AccountTransactionsStatistic;
use App\Packages\Domain\Account\Service\AccountService;
use App\Packages\Domain\Account\Service\AccountStatisticService;
use App\Packages\Domain\AccountType\Model\AccountType;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class AccountStatisticServiceTest extends TestCase
{
    public function testIfCorrectCalculateAccountGeneralStatistic() {

        $accountType = $this->createMock(AccountType::class);
        $balanceAccount = collect([]);

        $balanceAccount->add((Object)[
            'description' => 'Receita',
            'total' => 500000
        ]);

        $balanceAccount->add((Object)[
            'description' => 'Despesa',
            'total' => 50000
        ]);

        $renevue = 500000;
        $expense = 50000;
        $expectedAmount = $renevue - $expense;


        $account = new Account(
            id:Str::uuid()->toString(),
            description:'teste',
            accountType: $accountType,
            balance: $balanceAccount
        );

        $accounts = collect([]);
        $accounts->add($account);

        $userId = Str::uuid()->toString();
        $accountStatisticSearch = $this->createMock(AccountStatisticSearch::class);

        $mockAccountService = $this->createMock(AccountService::class);
        $mockAccountService->method('findAllByUserId')
            ->willReturn($accounts);

        $accountStatisticService = new AccountStatisticService($mockAccountService);

        $result = $accountStatisticService->getByPeriod($userId,$accountStatisticSearch);

        $this->assertInstanceOf(AccountGeneralStatistic::class , $result);
        $this->assertEquals($expectedAmount, $result->getPeriodBalance());

    }

    public function testIfCorrectCalculateAccountStatistic() {


        $balanceAccount = collect([]);

        $balanceAccount->add((Object)[
            'description' => 'Receita',
            'total' => 500000
        ]);

        $balanceAccount->add((Object)[
            'description' => 'Despesa',
            'total' => 50000
        ]);

        $renevue = 500000;
        $expense = 50000 * -1;
        $expectedAmount = $renevue + $expense;

        $userId = Str::uuid()->toString();
        $accountId = Str::uuid()->toString();
        $accountStatisticSearch = $this->createMock(AccountStatisticSearch::class);

        $mockAccountService = $this->createMock(AccountService::class);
        $mockAccountService->method('getBalanceById')
            ->willReturn($balanceAccount);

        $accountStatisticService = new AccountStatisticService($mockAccountService);

        $result = $accountStatisticService->getByPeriodAndAccountId($userId, $accountId, $accountStatisticSearch);

        $this->assertInstanceOf(AccountTransactionsStatistic::class , $result);
        $this->assertEquals($renevue, $result->getRevenue());
        $this->assertEquals($expense, $result->getExpense());
        $this->assertEquals($expectedAmount, $result->getAmount());
    }
}
