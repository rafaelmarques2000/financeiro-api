<?php

namespace App\Packages\Infra\Repository;

use App\Packages\Domain\Dashboard\Model\DashboardSearch;
use App\Packages\Domain\Dashboard\Repository\DashboardRepositoryInterface;
use App\Packages\Infra\Mapper\DashboardRowMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    public const SELECT_EXPENSE_PER_CATEGORY = "
        SELECT
            tc.description,
            sum(t.amount) as amount
            FROM transaction t
                join transaction_categories tc on t.category_id = tc.id
                join type_transaction tt on tc.type_transaction_id = tt.id
                join accounts a on t.account_id = a.id
                join user_accounts ua on a.id = ua.account_id
                join users u on ua.user_id = u.id
                where tt.slug_name = 'despesa' and t.deleted_at is null
                  and t.date between ? AND ? and u.id  = ?
            group by tc.description
            order by amount DESC
    ";


    public function getExpensePerCategory(string $userId, DashboardSearch $dashboardSearch): Collection
    {
         return collect(DB::select(self::SELECT_EXPENSE_PER_CATEGORY, [
            $dashboardSearch->getInitialDate(),
            $dashboardSearch->getEndDate(),
            $userId
         ]))->map(fn($item) => DashboardRowMapper::objectToExpenseCategory($item));
    }
}
