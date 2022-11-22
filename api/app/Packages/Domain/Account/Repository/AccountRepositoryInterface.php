<?php

namespace App\Packages\Domain\Account\Repository;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\Account\Model\AccountResult;
use App\Packages\Domain\Account\Model\AccountSearch;
use Illuminate\Support\Collection;

interface AccountRepositoryInterface
{
    public function findAllByUserId(string $userId, string $initialDate, string $endDate): Collection;

    public function findAll(string $userId, AccountSearch $accountSearch): AccountResult;

    public function findById(string $userId, string $id): ?Account;

    public function create(string $userId, Account $account): Account;

    public function update(string $userId, Account $account): Account;

    public function delete(string $userId, Account $account): void;
}
