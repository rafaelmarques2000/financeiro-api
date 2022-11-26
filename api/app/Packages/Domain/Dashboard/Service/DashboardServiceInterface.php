<?php

namespace App\Packages\Domain\Dashboard\Service;

use App\Packages\Domain\Dashboard\Model\DashboardSearch;
use Illuminate\Support\Collection;

interface DashboardServiceInterface
{
    public function getExpensePerCategory(string $userId, DashboardSearch $dashboardSearch): Collection;
    public function getInvoiceReport(string $userId, DashboardSearch $dashboardSearch): Collection;

}
