<?php

namespace App\Packages\Domain\TransactionType\Service;

use App\Packages\Domain\TransactionType\Exception\TransactionTypeNotFound;
use App\Packages\Domain\TransactionType\Model\TransactionType;
use App\Packages\Domain\TransactionType\Repository\TransactionTypeRepositoryInterface;
use Illuminate\Support\Collection;

class TransactionTypeService implements TransactionTypeServiceInterface
{
    private TransactionTypeRepositoryInterface $transactionTypeRepository;

    public function __construct(TransactionTypeRepositoryInterface $transactionTypeRepository)
    {
        $this->transactionTypeRepository = $transactionTypeRepository;
    }

    public function findAll(): Collection
    {
        return $this->transactionTypeRepository->findAll();
    }

    public function findById(string $id): ?TransactionType
    {
        $transactionType = $this->transactionTypeRepository->findById($id);
        if ($transactionType === null) {
            throw new TransactionTypeNotFound('Tipo de transação não encontrada');
        }

        return $transactionType;
    }
}
