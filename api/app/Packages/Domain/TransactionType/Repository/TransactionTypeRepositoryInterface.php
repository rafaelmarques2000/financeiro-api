<?php

namespace App\Packages\Domain\TransactionType\Repository;

use App\Packages\Domain\TransactionType\Model\TransactionType;
use Illuminate\Support\Collection;

interface TransactionTypeRepositoryInterface
{
    function findAll(): Collection;
    function findById(string $id): ?TransactionType;
}
