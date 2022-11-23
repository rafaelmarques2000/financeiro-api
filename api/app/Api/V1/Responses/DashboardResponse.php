<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Dashboard\Model\ExpenseCategory;
use Illuminate\Support\Collection;

class DashboardResponse
{
      public static function parseExpensePerCategory(Collection $expenseCategories): array {
        return $expenseCategories->map(fn(ExpenseCategory $expenseCategory) => [
            'description' => $expenseCategory->getDescription(),
            'amount' => $expenseCategory->getAmount(),
            'percentage' => $expenseCategory->getPercentage()
        ])->toArray();
      }
}
