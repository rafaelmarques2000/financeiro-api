<?php

namespace App\Packages\Domain\Account\Model;

class AccountSearch
{
    private ?string $description;

    private int $page;

    private int $limit;

    private ?string $initialDate;

    private ?string $endDate;

    public function __construct(?string $description, int $page, int $limit, ?string $initialDate, ?string $endDate)
    {
        $this->description = $description;
        $this->page = $page;
        $this->limit = $limit;
        $this->initialDate = $initialDate;
        $this->endDate = $endDate;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getInitialDate(): ?string
    {
        return $this->initialDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }
}
