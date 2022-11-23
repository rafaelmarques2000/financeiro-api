<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\Dashboard\Model\ExpenseCategory;

class DashboardRowMapper
{
     public static function objectToExpenseCategory(object $expenseCategory): ExpenseCategory {
          return new ExpenseCategory(
              $expenseCategory->description,
              $expenseCategory->amount / 100
          );
     }
}
