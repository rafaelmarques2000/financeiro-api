<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Dashboard\Model\ExpenseCategory;
use App\Packages\Domain\Dashboard\Model\InvoiceReport;
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

    public static function parseInvoiceReport(Collection $invoice): array {
        return $invoice->map(fn(InvoiceReport $invoiceReport) => [
            'month' => $invoiceReport->getShortNameMonth(),
            'amount' => $invoiceReport->getTotal()
        ])->toArray();
    }
}
