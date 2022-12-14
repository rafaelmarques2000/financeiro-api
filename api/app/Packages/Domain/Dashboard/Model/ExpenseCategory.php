<?php

namespace App\Packages\Domain\Dashboard\Model;

class ExpenseCategory
{
    private string $description;
    private int $amount;
    private ?float $percentage;

    public function __construct(string $description, int $amount, ?float $percentage = null)
    {
        $this->description = $description;
        $this->amount = $amount;
        $this->percentage = $percentage;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }
}
