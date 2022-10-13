<?php

namespace App\Packages\Domain\AccountType\Repository;

use App\Packages\Domain\AccountType\Model\AccountType;

interface AccountTypeRepositoryInterface
{
    public function findById(string $id) : ?AccountType;
}
