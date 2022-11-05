<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use App\Packages\Domain\TransactionCategory\Repository\TransactionCategoryRepositoryInterface;
use App\Packages\Infra\Mapper\TransactionCategoryMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionCategoryRepository implements TransactionCategoryRepositoryInterface
{
    private const SELECT_TRANSACTION_CATEGORY = "
        SELECT tc.id,
               tc.description,
               tc.slug_name,
               tt.id as type_transaction_id,
               tt.description as type_transaction_description,
               tt.slug_name as type_transaction_slugname
            from transaction_categories tc join type_transaction
            tt on tc.type_transaction_id = tt.id
    ";

    function findAll(): Collection
    {
       return collect(DB::select(self::SELECT_TRANSACTION_CATEGORY))->map(function ($transactionCategory) {
           return TransactionCategoryMapper::ObjectToTransactionCategory($transactionCategory);
       });
    }

    function findByTransactionTypeAndCategoryId(string $transactionType, string $categoryId): ?TransactionCategory
    {
        $query = DB::select(self::SELECT_TRANSACTION_CATEGORY. " WHERE tt.id = ? AND tc.id = ?", [$transactionType, $categoryId]);
        if(count($query) > 0) {
            return TransactionCategoryMapper::ObjectToTransactionCategory($query[0]);
        }
        return null;
    }
}
