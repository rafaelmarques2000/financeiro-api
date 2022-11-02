<?php

namespace App\Packages\Domain\Account\Repository;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountResult;
use App\Packages\Domain\Account\Model\AccountSearch;

interface AccountRepositoryInterface
{
    public function list(string $userId, AccountSearch $accountSearch): AccountResult;

    public function findById(string $userId, string $id): ?Account;

    public function create(string $userId, Account $account): Account;

    public function update(string $userId, Account $account): Account;

    public function delete(string $userId, Account $account): void;
}
