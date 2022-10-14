<?php

namespace App\Packages\Domain\AccountType\Repository;

use App\Packages\Domain\AccountType\Model\AccountType;
use Illuminate\Support\Collection;

interface AccountTypeRepositoryInterface
{
    public function list() : Collection;
    public function findById(string $id) : ?AccountType;
    public function findBySlugname(string $slugname) : ?AccountType;
    public function create(AccountType $accountType) :  AccountType;
}
