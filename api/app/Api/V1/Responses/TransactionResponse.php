<?php

namespace App\Api\V1\Responses;

use App\Packages\Domain\Transaction\Model\TransactionResult;
use App\Packages\Domain\Transaction\Model\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TransactionResponse
{
    public static function parseTransactionList(TransactionResult $transactionResult): array
    {
        return [
            'total_pages' => $transactionResult->getTotalPages(),
            'total_rows' => $transactionResult->getTotalRows(),
            'current_page' => $transactionResult->getCurrentPage(),
            'items_per_page' => $transactionResult->getItemPerPage(),
            'items' => $transactionResult->getItems()->map(function (Transaction $transaction) {
                return self::parseTransaction($transaction);
            })->toArray(),
            'statistic' => self::formatStatistic($transactionResult->getTransactionStatistic())
        ];
    }

    private static function formatStatistic(Collection $statistic) : array {
        if($statistic->isEmpty()) {
            return [
                [
                    "description" => "Receita",
                    "total" => 0
                ],
                [
                    "description" => "Despesa",
                    "total" => 0
                ]
            ];
        }
        if($statistic->count() == 1) {
            $st = $statistic->first();
            $newCollection = collect([]);
            if($st->description == "Receita") {
                $newCollection->add($st);
                $newCollection->add(
                    [
                        "description" => "Despesa",
                        "total" => 0
                    ]
                );
            }else{
                $newCollection->add(
                    [
                        "description" => "Receita",
                        "total" => 0
                    ]
                );
                $newCollection->add($st);
            }
            return $newCollection->toArray();
        }
        return $statistic->toArray();
    }

    public static function parseTransactionInstallments(Collection $transactionList): array
    {
        return $transactionList->map(function (Transaction $transaction) {
            return [
                'id' => $transaction->getId(),
                'current_installment' => $transaction->getCurrentInstallment(),
            ];
        })->toArray();
    }

    public static function parseTransaction(Transaction $transaction): array
    {
        return [
            'id' => $transaction->getId(),
            'description' => $transaction->getDescription(),
            'date' => $transaction->getDate()->format("d/m/Y"),
            'transaction_type' => [
                'id' => $transaction->getTransactionType()?->getId(),
                'description' => $transaction->getTransactionType()?->getDescription(),
                'slug_name' => $transaction->getTransactionType()?->getSlugName()
            ],
            'account' => [
                'id' => $transaction->getAccount()?->getId(),
                'description' => $transaction->getAccount()?->getDescription(),
                'account_type' => [
                    'id' => $transaction->getAccount()->getAccountType()->getId(),
                    'description' => $transaction->getAccount()->getAccountType()->getDescription(),
                    'slug_name' => $transaction->getAccount()->getAccountType()->getSlugName(),
                ]
            ],
            'category' => [
                'id' => $transaction->getTransactionCategory()->getId(),
                'description' => $transaction->getTransactionCategory()->getDescription(),
            ],
            'amount' => $transaction->getAmount() / 100,
            'created_at' => Carbon::createFromDate($transaction->getCreatedAt())->format("d/m/Y H:m"),
            'updated_at' => Carbon::createFromDate($transaction->getUpdatedAt())->format("d/m/Y H:m"),
            'installment' => $transaction->isInstallments(),
            'amount_installment' => $transaction->getAmountInstallments(),
            'current_installment' => $transaction->getCurrentInstallment()
        ];
    }
}
