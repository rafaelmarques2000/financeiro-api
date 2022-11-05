<?php

namespace App\Packages\Domain\TransactionType\Service;

use App\Packages\Domain\TransactionType\Model\TransactionType;
use Illuminate\Support\Collection;

interface TransactionTypeServiceInterface
{
    function findAll(): Collection;
    function findById(string $id): ?TransactionType;
}
