<?php

namespace Tests\Unit\Domain\Account\Service;

use App\Packages\Domain\Account\Exception\AccountNotFoundException;
use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Service\AccountService;
use App\Packages\Domain\Transaction\Service\TransactionService;
use App\Packages\Infra\Repository\AccountRepository;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class AccountServiceTest extends TestCase
{
     public function testIfFindAccountByIdNotFoundException() {
            $accountRepository = $this->createMock(AccountRepository::class);
            $transactionService = $this->createMock(TransactionService::class);
            $userId = Str::uuid()->toString();
            $accountId = Str::uuid()->toString();

            $accountRepository->method("findById")
                ->willReturn(null);

            $this->expectException(AccountNotFoundException::class);
            $this->expectExceptionMessage("conta não encontrada na base");

            $accountService = new AccountService($accountRepository,$transactionService);
            $accountService->findById($userId,$accountId);
     }

    public function testIfUpdateAccountNotFoundException() {
        $accountRepository = $this->createMock(AccountRepository::class);
        $transactionService = $this->createMock(TransactionService::class);
        $userId = Str::uuid()->toString();
        $account = $this->createMock(Account::class);

        $accountRepository->method("findById")
            ->willReturn(null);

        $this->expectException(AccountNotFoundException::class);
        $this->expectExceptionMessage("conta não encontrada na base");

        $accountService = new AccountService($accountRepository,$transactionService);
        $accountService->update($userId, $account);
    }

    public function testIfDeleteAccountNotFoundException() {
        $accountRepository = $this->createMock(AccountRepository::class);
        $transactionService = $this->createMock(TransactionService::class);
        $userId = Str::uuid()->toString();
        $accountId = Str::uuid()->toString();

        $accountRepository->method("findById")
            ->willReturn(null);

        $this->expectException(AccountNotFoundException::class);
        $this->expectExceptionMessage("conta não encontrada na base");

        $accountService = new AccountService($accountRepository,$transactionService);
        $accountService->delete($userId, $accountId);
    }
}
