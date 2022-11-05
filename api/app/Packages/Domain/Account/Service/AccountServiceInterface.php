<?php

namespace App\Packages\Domain\Account\Service;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountResult;
use App\Packages\Domain\Account\Model\AccountSearch;

interface AccountServiceInterface
{
    public function findAll(string $userId, AccountSearch $accountSearch): AccountResult;

    public function findById(string $userId, string $accountId): Account;

    public function create(string $userId, Account $account): Account;

    public function update(string $userId, Account $account): Account;

    public function delete(string $userId, string $accountId): void;
}
