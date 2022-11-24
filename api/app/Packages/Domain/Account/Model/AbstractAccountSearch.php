<?php

namespace App\Packages\Domain\Account\Model;

abstract class AbstractAccountSearch
{
    private ?string $initialDate;
    private ?string $endDate;
    private ?array $accountTypes;

    public function __construct(
        ?string $initialDate,
        ?string $endDate,
        ?array $accountTypes
    )
    {
        $this->initialDate = $initialDate;
        $this->endDate = $endDate;
        $this->accountTypes = $accountTypes;
    }

    public function getInitialDate(): ?string
    {
        return $this->initialDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getAccountTypes(): ?array
    {
        return $this->accountTypes;
    }

    public function getAccountTypesFormatted():string {
        $arrayFormated = [];
        for($i=0; $i<count($this->getAccountTypes());$i++) {
            $arrayFormated[] = "'".$this->accountTypes[$i]."'";
        }
        return implode(',',$arrayFormated);
    }
}
