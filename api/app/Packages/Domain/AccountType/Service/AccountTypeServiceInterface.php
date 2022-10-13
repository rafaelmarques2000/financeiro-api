<?php

namespace App\Packages\Domain\AccountType\Service;

use App\Packages\Domain\AccountType\Model\AccountType;
use Illuminate\Support\Collection;

interface AccountTypeServiceInterface
{
    public function list(): Collection;
    public function findById(string $id) : AccountType;
}
