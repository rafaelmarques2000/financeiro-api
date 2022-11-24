<?php

namespace App\Packages\Domain\Account\Service;

use App\Packages\Domain\Account\Model\AbstractAccountSearch;
use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountResult;
use App\Packages\Domain\Account\Model\AccountSearch;
use Illuminate\Support\Collection;

interface AccountServiceInterface
{
    public function getBalanceById(string $userId, string $accountId, string $initialDate, string $endDate): Collection;

    public function findAllByUserId(string $userId, AbstractAccountSearch $accountSearch): Collection;

    public function findAll(string $userId, AbstractAccountSearch $accountSearch): AccountResult;

    public function findById(string $userId, string $accountId): Account;

    public function create(string $userId, Account $account): Account;

    public function update(string $userId, Account $account): Account;

    public function delete(string $userId, string $accountId): void;
}
