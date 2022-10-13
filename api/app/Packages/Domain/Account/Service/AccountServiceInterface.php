<?php

namespace App\Packages\Domain\Account\Service;

use App\Packages\Domain\Account\Model\Account;
use Illuminate\Support\Collection;

interface AccountServiceInterface
{
    public function list(string $userId) : Collection;
    public function findById(string $userId,string $accountId) : Account;
    public function create(string $userId, Account $account) : Account;
    public function update(string $userId, Account $account) : Account;
    public function delete(string $userId, string $accountId) : void;
}
