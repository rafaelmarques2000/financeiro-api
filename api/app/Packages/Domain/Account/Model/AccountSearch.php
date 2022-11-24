<?php

namespace App\Packages\Domain\Account\Model;

class AccountSearch extends AbstractAccountSearch
{
    private int $page;
    private int $limit;
    private ?string $description;

    public function __construct(
        int $page,
        int $limit,
        ?string $description,
        ?string $initialDate,
        ?string $endDate,
        ?array $accountTypes
    )
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->description = $description;
        parent::__construct($initialDate, $endDate, $accountTypes);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
