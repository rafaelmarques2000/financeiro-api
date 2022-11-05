<?php

namespace App\Packages\Domain\Transaction\Model;

use Illuminate\Support\Collection;

class TransactionResult
{
    private int $totalPages;

    private int $totalRows;

    private int $currentPage;

    private int $itemPerPage;

    private Collection $items;

    public function __construct(int $totalPages, int $totalRows, int $currentPage, int $itemPerPage, Collection $items)
    {
        $this->totalPages = $totalPages;
        $this->totalRows = $totalRows;
        $this->currentPage = $currentPage;
        $this->itemPerPage = $itemPerPage;
        $this->items = $items;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getTotalRows(): int
    {
        return $this->totalRows;
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

    public function calculateTotalTransactions(): ?float
    {
        return $this->items->reduce((function($carry, Transaction $value){
            $total = 0;
            if($value->getTransactionType()->getSlugName() == "receita") {
                $total+=$value->getAmount();
                dump('receita', $total);
            }

            if($value->getTransactionType()->getSlugName() == "despesa") {
                $total-=$value->getAmount();
                dump('despesa', $total);
            }
            return ($total) / 100;
        }));
    }
}
