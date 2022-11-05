<?php

namespace App\Api\V1\Mappers;

use App\Packages\Domain\Account\Service\AccountService;
use App\Packages\Domain\Account\Service\AccountServiceInterface;
use App\Packages\Domain\Transaction\Model\Transaction;
use App\Packages\Domain\TransactionCategory\Service\TransactionCategoryService;
use App\Packages\Domain\TransactionCategory\Service\TransactionCategoryServiceInterface;
use App\Packages\Domain\TransactionType\Service\TransactionTypeService;
use App\Packages\Domain\TransactionType\Service\TransactionTypeServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TransactionRequestMapper
{
    public static function requestToTransaction(string $userId, string $accountId, array $body): Transaction
    {
        /** @var TransactionTypeService $transactionTypeService */
        $transactionTypeService = app(TransactionTypeServiceInterface::class);
        /** @var TransactionCategoryService $transactionCategoryService */
        $transactionCategoryService = app(TransactionCategoryServiceInterface::class);
        /** @var AccountService $accountService */
        $accountService = app(AccountServiceInterface::class);

        $transactionType = $transactionTypeService->findById($body['transaction_type']);
        $transactionCategory = $transactionCategoryService->findByTransactionTypeAndCategoryId($body['transaction_type'], $body['transaction_category']);
        $account = $accountService->findById($userId, $accountId);

        return new Transaction(
            Str::uuid()->toString(),
            $body['description'],
            Carbon::createFromDate($body['date']),
            $transactionType,
            $account,
            $transactionCategory,
            $body['amount'],
            Carbon::now(),
            Carbon::now(),
            $body['installment'] ?? false,
            $body['amount_installments'] ?? null,
            null
        );
    }
}
