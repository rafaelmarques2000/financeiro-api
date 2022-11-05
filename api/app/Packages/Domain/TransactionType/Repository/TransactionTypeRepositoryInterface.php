<?php

namespace App\Packages\Domain\TransactionType\Repository;

use App\Packages\Domain\TransactionType\Model\TransactionType;
use Illuminate\Support\Collection;

interface TransactionTypeRepositoryInterface
{
    public function findAll(): Collection;

    public function findById(string $id): ?TransactionType;
}
