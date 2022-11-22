<?php

namespace App\Packages\Domain\Account\Model;

class AccountGeneralStatistic
{
    private int $periodBalance;

    public function __construct(int $periodBalance)
    {
        $this->periodBalance = $periodBalance;
    }

    public function getPeriodBalance(): int
    {
        return $this->periodBalance;
    }
}
