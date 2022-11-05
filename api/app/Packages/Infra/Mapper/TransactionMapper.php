<?php

namespace App\Packages\Infra\Mapper;

use App\Packages\Domain\Account\Repository\AccountRepositoryInterface;
use App\Packages\Domain\Transaction\Model\Transaction;
use App\Packages\Domain\TransactionType\Repository\TransactionTypeRepositoryInterface;
use App\Packages\Infra\Repository\AccountRepository;
use App\Packages\Infra\Repository\TransactionCategoryRepository;
use App\Packages\Infra\Repository\TransactionTypeRepository;
use Carbon\Carbon;

class TransactionMapper
{
    public static function ObjectToTransaction(string $userId, object $transaction): Transaction
    {
        /** @var TransactionTypeRepository $transactionTypeRepository */
        $transactionTypeRepository = app(TransactionTypeRepositoryInterface::class);
        /** @var TransactionCategoryRepository $transactionCategoryRepository */
        $transactionCategoryRepository = app(TransactionCategoryRepository::class);
        /** @var AccountRepository $accountRepository */
        $accountRepository = app(AccountRepositoryInterface::class);

        return new Transaction(
            $transaction->id,
            $transaction->description,
            Carbon::createFromDate($transaction->date),
            $transactionTypeRepository->findById($transaction->transaction_type_id),
            $accountRepository->findById($userId, $transaction->account_id),
            $transactionCategoryRepository->findByTransactionTypeAndCategoryId($transaction->transaction_type_id, $transaction->category_id),
            $transaction->amount,
            Carbon::createFromDate($transaction->created_at),
            Carbon::createFromDate($transaction->updated_at),
            $transaction->installments,
            $transaction->amount_installments,
            $transaction->current_installment
        );
    }
}
