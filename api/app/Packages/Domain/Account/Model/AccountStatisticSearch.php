<?php

namespace App\Packages\Domain\Account\Model;

class AccountStatisticSearch
{
    private string $initialDate;
    private string $endDate;

    public function __construct(string $initialDate, string $endDate)
    {
        $this->initialDate = $initialDate;
        $this->endDate = $endDate;
    }

    public function getInitialDate(): string
    {
        return $this->initialDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }
}
