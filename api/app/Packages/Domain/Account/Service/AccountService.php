<?php

namespace App\Packages\Domain\Account\Service;

use App\Packages\Domain\Account\Exception\AccountNotFoundException;
use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Repository\AccountRepositoryInterface;
use Illuminate\Support\Collection;

class AccountService implements AccountServiceInterface
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function list(string $userId): Collection
    {
        return $this->accountRepository->list($userId);
    }

    public function findById(string $userId, string $accountId): Account
    {
        $account = $this->accountRepository->findById($userId, $accountId);
        if(!$account) {
            throw new AccountNotFoundException("conta não encontrada na base");
        }
        return $account;
    }

    public function create(string $userId, Account $account): Account
    {
        // TODO: Implement create() method.
    }

    public function update(string $userId, Account $account): Account
    {
        // TODO: Implement update() method.
    }

    public function delete(string $userId, Account $account): void
    {
        // TODO: Implement delete() method.
    }
}
