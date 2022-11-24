<?php

namespace App\Packages\Domain\Account\Service;

use App\Packages\Domain\Account\Exception\AccountNotFoundException;
use App\Packages\Domain\Account\Model\AbstractAccountSearch;
use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountResult;
use App\Packages\Domain\Account\Model\AccountSearch;
use App\Packages\Domain\Account\Repository\AccountRepositoryInterface;
use App\Packages\Domain\Transaction\Service\TransactionServiceInterface;
use Illuminate\Support\Collection;

class AccountService implements AccountServiceInterface
{
    private AccountRepositoryInterface $accountRepository;
    private TransactionServiceInterface $transactionService;

    public function __construct(AccountRepositoryInterface $accountRepository, TransactionServiceInterface $transactionService)
    {
        $this->accountRepository = $accountRepository;
        $this->transactionService = $transactionService;
    }


    public function getBalanceById(string $userId, string $accountId, string $initialDate, string $endDate): Collection
    {
        return $this->transactionService->getBalanceByAccount($userId, $accountId, $initialDate, $endDate);
    }

    public function findAllByUserId(string $userId, AbstractAccountSearch $accountSearch): Collection
    {
        return $this->accountRepository->findAllByUserId($userId, $accountSearch);
    }

    public function findAll(string $userId, AbstractAccountSearch $accountSearch): AccountResult
    {
        return $this->accountRepository->findAll($userId, $accountSearch);
    }

    public function findById(string $userId, string $accountId): Account
    {
        $account = $this->accountRepository->findById($userId, $accountId);
        if (! $account) {
            throw new AccountNotFoundException('conta não encontrada na base');
        }

        return $account;
    }

    public function create(string $userId, Account $account): Account
    {
        return $this->accountRepository->create($userId, $account);
    }

    public function update(string $userId, Account $account): Account
    {
        if (! $this->hasAccount($userId, $account)) {
            throw new AccountNotFoundException('conta não encontrada na base');
        }

        return $this->accountRepository->update($userId, $account);
    }

    public function delete(string $userId, string $accountId): void
    {
        $account = $this->accountRepository->findById($userId, $accountId);
        if (! $account) {
            throw new AccountNotFoundException('conta não encontrada na base');
        }
        $account->markDeleted();
        $this->accountRepository->delete($userId, $account);
    }

    private function hasAccount(string $userId, Account $account): ?Account
    {
        return $this->accountRepository->findById($userId, $account->getId());
    }
}
