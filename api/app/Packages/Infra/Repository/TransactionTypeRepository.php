<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\TransactionType\Model\TransactionType;
use App\Packages\Domain\TransactionType\Repository\TransactionTypeRepositoryInterface;
use App\Packages\Infra\Mapper\TransactionTypeMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionTypeRepository implements TransactionTypeRepositoryInterface
{
    function findAll(): Collection
    {
       return collect(DB::select("SELECT * FROM type_transaction"))->map(function ($transactionType) {
           return TransactionTypeMapper::ObjectToTransactionType($transactionType);
       });
    }

    function findById(string $id): ?TransactionType
    {
        $query =  DB::select("SELECT * FROM type_transaction WHERE id=?", [$id]);
        if(count($query) > 0) {
            return TransactionTypeMapper::ObjectToTransactionType($query[0]);
        }
        return null;
    }
}
