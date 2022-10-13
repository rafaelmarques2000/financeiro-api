<?php

namespace App\Packages\Domain\AccountType\Service;

use App\Packages\Domain\AccountType\Model\AccountType;

interface AccountTypeServiceInterface
{
    public function findById(string $id) : AccountType;
}
