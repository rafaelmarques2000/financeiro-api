<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use App\Packages\Domain\TransactionType\Model\TransactionType;

class TransactionCategoryMapper
{
    public static function ObjectToTransactionCategory(object $transactionCategory): TransactionCategory
    {
       $transactionType = new TransactionType(
           $transactionCategory->type_transaction_id,
           $transactionCategory->type_transaction_description,
           $transactionCategory->type_transaction_slugname,
       );

       return new TransactionCategory(
           $transactionCategory->id,
           $transactionCategory->description,
           $transactionCategory->slug_name,
           $transactionType
       );
    }
}
