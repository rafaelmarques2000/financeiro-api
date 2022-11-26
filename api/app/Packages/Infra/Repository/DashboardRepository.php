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

    public const SELECT_INVOICE_REPORT = "WITH report AS (
       SELECT t.month, t.year, sum(t.amount) as expense,
                   (SELECT sum(t2.amount)
                   FROM transaction t2
                            join transaction_categories tc2 on t2.category_id = tc2.id
                            join type_transaction tt2 on tc2.type_transaction_id = tt2.id
                            join accounts a2 on t2.account_id = a2.id
                            join user_accounts ua2 on a2.id = ua2.account_id
                            join account_types at2 on at2.id = a2.account_type_id
                            join users u2 on ua2.user_id = u2.id
                     where tt2.slug_name = 'receita'
                     and t2.deleted_at is null
                     and at2.slug_name = 'conta_corrente'
                     and u2.id = ?
                     and t2.month = t.month
                     and t2.year = t.year
                     ) as revenue
       FROM transaction t
                            join transaction_categories tc on t.category_id = tc.id
                            join type_transaction tt on tc.type_transaction_id = tt.id
                            join accounts a on t.account_id = a.id
                            join user_accounts ua on a.id = ua.account_id
                            join account_types at2 on at2.id = a.account_type_id
                            join users u on ua.user_id = u.id
                   where tt.slug_name = 'despesa'
                     and t.deleted_at is null
                     and at2.slug_name = 'cartao_credito'
                     and u.id = ?
       group by t.month, t.year), invoice AS (
                        select month, year, (revenue - expense) as total from report
                   )SELECT * from invoice
    ";

    public function getExpensePerCategory(string $userId, DashboardSearch $dashboardSearch): Collection
    {
         return collect(DB::select(self::SELECT_EXPENSE_PER_CATEGORY, [
            $dashboardSearch->getInitialDate(),
            $dashboardSearch->getEndDate(),
            $userId
         ]))->map(fn($item) => DashboardRowMapper::objectToExpenseCategory($item));
    }

    public function getInvoiceReport(string $userId, DashboardSearch $dashboardSearch): Collection
    {
        return collect(DB::select(self::SELECT_INVOICE_REPORT, [
            $userId,
            $userId
        ]))->map(fn($item) => DashboardRowMapper::objectToInvoiceReport($item));
    }
}
