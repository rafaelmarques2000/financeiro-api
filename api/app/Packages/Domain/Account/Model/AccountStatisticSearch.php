<?php

namespace App\Packages\Domain\Account\Model;

class AccountStatisticSearch extends AbstractAccountSearch
{
    public function __construct(?string $initialDate, ?string $endDate, ?array $accountTypes)
    {
        parent::__construct($initialDate, $endDate, $accountTypes);
    }
}
