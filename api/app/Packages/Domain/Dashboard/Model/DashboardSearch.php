<?php

namespace App\Packages\Domain\Dashboard\Model;

class DashboardSearch
{
    private ?string $initialDate;
    private ?string $endDate;
    private ?string $competenceYear;

    public function __construct(?string $initialDate, ?string $endDate, ?string $competenceYear = null)
    {
        $this->initialDate = $initialDate;
        $this->endDate = $endDate;
        $this->competenceYear = $competenceYear;
    }

    public function getInitialDate(): ?string
    {
        return $this->initialDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getCompetenceYear(): ?string
    {
        return $this->competenceYear;
    }
}
