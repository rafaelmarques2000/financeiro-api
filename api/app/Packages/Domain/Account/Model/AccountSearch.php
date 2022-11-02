<?php

namespace App\Packages\Domain\Account\Model;

class AccountSearch
{
    private ?string $description;

    private int $page;

    private int $limit;

    public function __construct(?string $description, int $page, int $limit)
    {
        $this->description = $description;
        $this->page = $page;
        $this->limit = $limit;
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
}
