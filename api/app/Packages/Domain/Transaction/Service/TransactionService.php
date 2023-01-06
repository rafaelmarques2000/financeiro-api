<?php

namespace App\Packages\Domain\Transaction\Service;

use App\Packages\Domain\Transaction\Exception\TransactionNotFoundException;
use App\Packages\Domain\Transaction\Model\Transaction;
use App\Packages\Domain\Transaction\Model\TransactionCriteria;
use App\Packages\Domain\Transaction\Model\TransactionResult;
use App\Packages\Domain\Transaction\Model\TransactionSearch;
use App\Packages\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TransactionService implements TransactionServiceInterface
{
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function findAll(string $userId, string $accountId, TransactionSearch $transactionSearch): TransactionResult
    {
        return $this->transactionRepository->findAll($userId, $accountId, $transactionSearch);
    }

    public function findById(string $userId, string $accountId, string $transactionId): Transaction
    {
        if (!$this->hasTransaction($userId, $accountId, $transactionId)) {
            throw new TransactionNotFoundException('Transação não encontrada');
        }
        return $this->transactionRepository->findById($userId, $accountId, $transactionId);
    }

    public function findByCriteria(string $userId, TransactionCriteria $criteria): Collection
    {
        return $this->transactionRepository->findByCriteria($userId, $criteria);
    }

    public function create(string $userId, string $accountId, Transaction $transaction): Transaction | Collection
    {
        if (! $transaction->isInstallments()) {
            return $this->transactionRepository->create($userId, $accountId, $transaction);
        }

        $amount = $transaction->getAmount() / $transaction->getAmountInstallments();
        $transactions = collect([]);

        for ($i = 1; $i <= $transaction->getAmountInstallments(); $i++) {
            $date = $this->generateInstallmentsPeriod($i, $transaction);
            $transactions->add(new Transaction(
                Str::uuid()->toString(),
                $transaction->getDescription(),
                $date,
                $transaction->getTransactionType(),
                $transaction->getAccount(),
                $transaction->getTransactionCategory(),
                $amount,
                $transaction->getCreatedAt(),
                $transaction->getUpdatedAt(),
                $transaction->isInstallments(),
                $transaction->getAmountInstallments(),
                $i
            ));
        }

        return $this->transactionRepository->createInCollection($userId, $accountId, $transactions);
    }

    public function update(string $userId, string $accountId, Transaction $transaction): Transaction
    {
        if (!$this->hasTransaction($userId, $accountId, $transaction->getId())) {
            throw new TransactionNotFoundException('Transação não encontrada');
        }
        return $this->transactionRepository->update($userId, $accountId, $transaction);
    }

    public function delete(string $userId, string $accountId, string $transactionId): void
    {
        if (!$this->hasTransaction($userId, $accountId, $transactionId)) {
            throw new TransactionNotFoundException('Transação não encontrada');
        }
        $this->transactionRepository->delete($userId, $accountId, $transactionId);
    }

    private function generateInstallmentsPeriod(int $i, Transaction $transaction): Carbon
    {
        return $i == 1 ? Carbon::createFromDate($transaction->getDate()) : Carbon::createFromDate($transaction->getDate())->addMonths($i - 1);
    }

    private function hasTransaction(string $userId, string $accountId, string $transactionId): bool
    {
        return $this->transactionRepository->findById($userId, $accountId, $transactionId) != null;
    }

    public function getBalanceByAccount(string $userId, string $accountId, string $initialDate, string $endDate): Collection
    {
        return $this->transactionRepository->getBalanceByAccount($userId, $accountId, $initialDate, $endDate);
    }
}
