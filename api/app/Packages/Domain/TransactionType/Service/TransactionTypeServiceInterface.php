<?php

namespace App\Packages\Domain\TransactionType\Service;

use App\Packages\Domain\TransactionType\Model\TransactionType;
use Illuminate\Support\Collection;

interface TransactionTypeServiceInterface
{
    public function findAll(): Collection;

    public function findById(string $id): ?TransactionType;
}
