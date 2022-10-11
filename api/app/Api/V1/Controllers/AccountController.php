<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Responses\AccountResponse;
use App\Api\V1\Responses\ErrorResponse;
use App\Http\Controllers\Controller;
use App\Packages\Domain\Account\Service\AccountServiceInterface;
use App\Packages\General\Exceptions\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private AccountServiceInterface $accountService;

    public function __construct(AccountServiceInterface $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index(Request $request, string $userId) : JsonResponse{
        try {
            return response()->json(AccountResponse::parseAccountList($this->accountService->list($userId)));
        }catch (\Exception $exception) {
            return response()->json(ErrorResponse::parserError("Falha interna do servidor, tente novamente ou contate o administrador"), 500);
        }
    }

    public function show(Request $request, string $userId, string $accountId) : JsonResponse{
        try {
            return response()->json(AccountResponse::parseAccount($this->accountService->findById($userId, $accountId)));
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parserError($exception->getMessage()), 404);
        }
        catch (\Exception $exception) {
            return response()->json(ErrorResponse::parserError("Falha interna do servidor, tente novamente ou contate o administrador"), 500);
        }
    }

    public function store(Request $request, string $userId) {
        try {

        }catch (\Exception $exception) {
            return response()->json(ErrorResponse::parserError("Falha interna do servidor, tente novamente ou contate o administrador"), 500);
        }
    }

}
