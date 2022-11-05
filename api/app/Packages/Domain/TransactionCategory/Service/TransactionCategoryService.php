<?php

namespace App\Packages\Domain\TransactionCategory\Service;

use App\Packages\Domain\TransactionCategory\Exception\TransactionCategoryNotFoundException;
use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use App\Packages\Domain\TransactionCategory\Repository\TransactionCategoryRepositoryInterface;
use Illuminate\Support\Collection;

class TransactionCategoryService implements TransactionCategoryServiceInterface
{
    private TransactionCategoryRepositoryInterface $transactionCategoryRepository;

    public function __construct(TransactionCategoryRepositoryInterface $transactionCategoryRepository)
    {
        $this->transactionCategoryRepository = $transactionCategoryRepository;
    }


    function findAll(): Collection
    {
        return $this->transactionCategoryRepository->findAll();
    }

    function findByTransactionTypeAndCategoryId(string $transactionType, string $categoryId): ?TransactionCategory
    {
        $transactionCategory = $this->transactionCategoryRepository->findByTransactionTypeAndCategoryId($transactionType, $categoryId);
        if($transactionCategory == null) {
            throw new TransactionCategoryNotFoundException("Categoria não encontrada");
        }
        return $transactionCategory;
    }
}
