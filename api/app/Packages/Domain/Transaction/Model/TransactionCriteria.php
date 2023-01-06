<?php

namespace App\Packages\Domain\Transaction\Model;

class TransactionCriteria
{
     private ?string $initialDate;
     private ?string $endDate;
     private ?string $categoryId;

    public function __construct(?string $initialDate, ?string $endDate, ?string $categoryId)
    {
        $this->initialDate = $initialDate;
        $this->endDate = $endDate;
        $this->categoryId = $categoryId;
    }

    public function getInitialDate(): ?string
    {
        return $this->initialDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }
}
