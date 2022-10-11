<?php

namespace App\Packages\Domain\Account\Repository;

use App\Packages\Domain\Account\Model\Account;
use Illuminate\Support\Collection;

interface AccountRepositoryInterface
{
    public function list(string $userId) : Collection;
    public function findById(string $userId,string $id) : ?Account;
    public function create(string $userId, Account $account) : Account;
    public function update(string $userId, Account $account) : Account;
    public function delete(string $userId, Account $account) : void;
}
