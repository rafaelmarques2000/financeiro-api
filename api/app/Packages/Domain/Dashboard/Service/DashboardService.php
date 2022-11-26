<?php

namespace App\Packages\Domain\Dashboard\Service;

use App\Packages\Domain\Dashboard\Model\DashboardSearch;
use App\Packages\Domain\Dashboard\Model\ExpenseCategory;
use App\Packages\Domain\Dashboard\Repository\DashboardRepositoryInterface;
use Illuminate\Support\Collection;

class DashboardService implements DashboardServiceInterface
{
    private DashboardRepositoryInterface $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getExpensePerCategory(string $userId, DashboardSearch $dashboardSearch): Collection
    {
        $expenses = $this->dashboardRepository->getExpensePerCategory($userId, $dashboardSearch);
        $totalExpenses = 0;
        $expenses->each(function (ExpenseCategory $expenseCategory) use(&$totalExpenses){
            $totalExpenses +=$expenseCategory->getAmount();
        });

        return $expenses->map(function (ExpenseCategory $expenseCategory) use($totalExpenses){
             $percentage = ($expenseCategory->getAmount() / $totalExpenses) * 100;
             return new ExpenseCategory(
                 $expenseCategory->getDescription(),
                 $expenseCategory->getAmount(),
                 $percentage
             );
        });
    }

    public function getInvoiceReport(string $userId, DashboardSearch $dashboardSearch): Collection
    {
        return $this->dashboardRepository->getInvoiceReport($userId, $dashboardSearch);
    }
}
