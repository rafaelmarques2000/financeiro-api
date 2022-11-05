<?php

namespace App\Packages\Domain\Transaction\Model;

use App\Packages\Domain\Account\Model\Account;
use App\Packages\Domain\TransactionCategory\Model\TransactionCategory;
use App\Packages\Domain\TransactionType\Model\TransactionType;
use DateTime;

class Transaction
{
    private string $id;

    private string $description;

    private DateTime $date;

    private TransactionType $transactionType;

    private Account $account;

    private TransactionCategory $transactionCategory;

    private int $amount;

    private DateTime $createdAt;

    private DateTime $updatedAt;

    private ?bool $installments;

    private ?int $amountInstallments;

    private ?int $currentInstallment;

    public function __construct(
        string $id,
        string $description,
        DateTime $date,
        TransactionType $transactionType,
        Account $account,
        TransactionCategory $transactionCategory,
        int $amount,
        DateTime $createdAt,
        DateTime $updatedAt,
        ?bool $installments,
        ?int $amountInstallments,
        ?int $currentInstallment,
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->date = $date;
        $this->transactionType = $transactionType;
        $this->account = $account;
        $this->transactionCategory = $transactionCategory;
        $this->amount = $amount;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->installments = $installments;
        $this->amountInstallments = $amountInstallments;
        $this->currentInstallment = $currentInstallment;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getTransactionType(): TransactionType
    {
        return $this->transactionType;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function getTransactionCategory(): TransactionCategory
    {
        return $this->transactionCategory;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function isInstallments(): bool
    {
        return $this->installments;
    }

    public function getAmountInstallments(): ?int
    {
        return $this->amountInstallments;
    }

    public function getCurrentInstallment(): ?int
    {
        return $this->currentInstallment;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
