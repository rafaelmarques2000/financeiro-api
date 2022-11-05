<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\TransactionType\Model\TransactionType;
use Illuminate\Support\Collection;

class TransactionTypeResponse
{
    public static function parseTransactionTypeList(Collection $transactionTypeCollection): array
    {
        return $transactionTypeCollection->map(function (TransactionType $transactionType) {
            return [
               'id' => $transactionType->getId(),
               'description' => $transactionType->getDescription(),
               'slug_name' => $transactionType->getSlugName()
            ];
        })->toArray();
    }
}
