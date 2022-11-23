<?php

namespace App\Packages\Domain\Dashboard\Repository;

use App\Packages\Domain\Dashboard\Model\DashboardSearch;
use Illuminate\Support\Collection;

interface DashboardRepositoryInterface
{
    public function getExpensePerCategory(string $userId, DashboardSearch $dashboardSearch): Collection;

}
