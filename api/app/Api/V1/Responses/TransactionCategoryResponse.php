<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use Illuminate\Support\Collection;

class TransactionCategoryResponse
{
    public static function parseTransactionCategoryList(Collection $transactionCategoriesList): array
    {
        return $transactionCategoriesList->map(function (TransactionCategory $transactionCategory) {
                return self::formatTransactionCategoryResponse($transactionCategory);
            })->toArray();
    }

    public static function parseTransactionCategory(TransactionCategory $transactionCategory): array
    {
        return self::formatTransactionCategoryResponse($transactionCategory);
    }

    public static function formatTransactionCategoryResponse(TransactionCategory $transactionCategory): array
    {
        $transactionType = $transactionCategory->getTransactionType();

        return [
            'id' => $transactionCategory->getId(),
            'description' => $transactionCategory->getDescription(),
            'slug_name' => $transactionCategory->getSlugName(),
            'transaction_type' => [
                'id' => $transactionType->getId(),
                'description' => $transactionType->getDescription(),
                'slug_name' => $transactionType->getSlugName(),
            ]
        ];
    }
}
