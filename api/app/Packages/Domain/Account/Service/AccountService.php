<?php

namespace App\Packages\Domain\Account\Service;

use App\Packages\Domain\Account\Exception\AccountNotFoundException;
use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountResult;
use App\Packages\Domain\Account\Model\AccountSearch;
use App\Packages\Domain\Account\Repository\AccountRepositoryInterface;

class AccountService implements AccountServiceInterface
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function list(string $userId, AccountSearch $accountSearch): AccountResult
    {
        return $this->accountRepository->list($userId, $accountSearch);
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

    public function hasAccount(string $userId, Account $account): ?Account
    {
        return $this->accountRepository->findById($userId, $account->getId());
    }
}
