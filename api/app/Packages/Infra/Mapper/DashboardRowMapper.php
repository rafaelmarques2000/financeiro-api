<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\Dashboard\Model\ExpenseCategory;
use App\Packages\Domain\Dashboard\Model\InvoiceReport;

class DashboardRowMapper
{
     public static function objectToExpenseCategory(object $expenseCategory): ExpenseCategory {
          return new ExpenseCategory(
              $expenseCategory->id,
              $expenseCategory->description,
       $expenseCategory->amount / 100
          );
     }

    public static function objectToInvoiceReport(object $invoice): InvoiceReport {
        return new InvoiceReport(
            $invoice->month,
            $invoice->year,
            $invoice->total / 100
        );
    }
}
