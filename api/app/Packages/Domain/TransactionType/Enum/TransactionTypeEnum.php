<?php

namespace App\Packages\Domain\TransactionType\Enum;

enum TransactionTypeEnum: string
{
    case RECEITA = 'Receita';
    case DESPESA = 'Despesa';
}
