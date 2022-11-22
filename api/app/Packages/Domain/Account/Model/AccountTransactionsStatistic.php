<?php

namespace App\Packages\Domain\Account\Model;

class AccountTransactionsStatistic
{
    private int $revenue;
    private int $expense;
    private int $amount;

    public function __construct(int $revenue, int $expense, int $amount)
    {
        $this->revenue = $revenue;
        $this->expense = $expense;
        $this->amount = $amount;
    }

    public function getRevenue(): int
    {
        return $this->revenue;
    }

    public function getExpense(): int
    {
        return $this->expense > 0 ? ($this->expense * -1): $this->expense;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
