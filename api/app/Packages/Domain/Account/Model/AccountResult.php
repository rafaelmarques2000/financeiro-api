<?php

namespace App\Packages\Domain\Account\Model;

use Illuminate\Support\Collection;

class AccountResult
{
    private int $totalPages;
    private int $currentPage;
    private int $itemPerPage;
    private Collection $items;

    public function __construct(int $totalPages, int $currentPage, int $itemPerPage, Collection $items)
    {
        $this->totalPages = $totalPages;
        $this->currentPage = $currentPage;
        $this->itemPerPage = $itemPerPage;
        $this->items = $items;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getItemPerPage(): int
    {
        return $this->itemPerPage;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }
}
