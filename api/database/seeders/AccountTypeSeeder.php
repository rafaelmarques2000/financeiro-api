<?php

namespace Database\Seeders;

use App\Packages\Domain\AccountType\Service\AccountTypeServiceInterface;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    private AccountTypeServiceInterface $accountTypeService;

    public function __construct(AccountTypeServiceInterface $accountTypeService)
    {
        $this->accountTypeService = $accountTypeService;
    }

    public function run()
    {

    }
}
