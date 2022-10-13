<?php

namespace App\Packages\Domain\AccountType\Service;

use App\Packages\Domain\AccountType\Exception\AccountTypeNotFoundException;
use App\Packages\Domain\AccountType\Model\AccountType;
use App\Packages\Domain\AccountType\Repository\AccountTypeRepositoryInterface;
use Illuminate\Support\Collection;

class AccountTypeService implements AccountTypeServiceInterface
{
    private AccountTypeRepositoryInterface $accountTypeRepository;

    public function __construct(AccountTypeRepositoryInterface $accountTypeRepository)
    {
        $this->accountTypeRepository = $accountTypeRepository;
    }

    public function findById(string $id): AccountType
    {
        $accountType = $this->accountTypeRepository->findById($id);
        if(!$accountType) {
            throw new AccountTypeNotFoundException("Tipo de conta não encontrado");
        }
        return $accountType;
    }

    public function list(): Collection
    {
        return $this->accountTypeRepository->list();
    }
}
