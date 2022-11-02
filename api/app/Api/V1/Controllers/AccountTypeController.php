<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Responses\AccountTypeResponse;
use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Utils\HttpStatus;
use App\Http\Controllers\Controller;
use App\Packages\Domain\Account\Service\AccountServiceInterface;
use App\Packages\Domain\AccountType\Service\AccountTypeServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    private AccountTypeServiceInterface $accountTypeService;

    public function __construct(AccountServiceInterface $accountService, AccountTypeServiceInterface $accountTypeService)
    {
        $this->accountTypeService = $accountTypeService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json(AccountTypeResponse::parseAccountTypeList($this->accountTypeService->list()));
        } catch (\Exception $exception) {
            return response()->json(
                ErrorResponse::parseError('Falha interna do servidor, tente novamente ou contate o administrador'),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }
}
