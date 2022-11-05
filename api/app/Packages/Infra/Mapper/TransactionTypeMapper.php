<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\TransactionType\Model\TransactionType;

class TransactionTypeMapper
{
    public static function ObjectToTransactionType(object $transactionType): TransactionType
    {
        return new TransactionType(
            $transactionType->id,
            $transactionType->description,
            $transactionType->slug_name
        );
    }
}
