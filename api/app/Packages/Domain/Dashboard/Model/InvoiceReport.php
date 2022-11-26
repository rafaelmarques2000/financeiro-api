<?php

namespace App\Packages\Domain\Dashboard\Model;

class InvoiceReport
{
    private int $month;
    private int $year;
    private int $total;

    public function __construct(int $month, int $year, int $total)
    {
        $this->month = $month;
        $this->year = $year;
        $this->total = $total;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getShortNameMonth(): string
    {
        $months = [
            1 => "Janeiro",
            2 => "Fevereiro",
            3 => "Março",
            4 => "Abril",
            5 => "Maio",
            6 => "Junho",
            7 => "Julho",
            8 => "Agosto",
            9 => "Setembro",
            10 => "Outubro",
            11 => "Novembro",
            12 => "Dezembro"
        ];
        return $months[$this->getMonth()];
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
