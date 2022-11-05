<?php

namespace App\Packages\Domain\Transaction\Service;

use App\Packages\Domain\Transaction\Model\Transaction;
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

    function create(string $userId, string $accountId, Transaction $transaction): Transaction | Collection
    {
         if(!$transaction->isInstallments()) {
            return $this->transactionRepository->create($userId, $accountId, $transaction);
         }

         $amount = $transaction->getAmount() / $transaction->getAmountInstallments();
         $transactions = collect([]);

         for($i=1; $i <= $transaction->getAmountInstallments();$i++) {
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

    private function generateInstallmentsPeriod(int $i, Transaction $transaction): Carbon
    {
        return $i == 1 ? Carbon::createFromDate($transaction->getDate()) : Carbon::createFromDate($transaction->getDate())->addMonths($i - 1);
    }
}
