<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\AccountRequestMapper;
use App\Api\V1\Responses\AccountResponse;
use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Responses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Packages\Domain\Account\Service\AccountServiceInterface;
use App\Packages\Domain\AccountType\Service\AccountTypeServiceInterface;
use App\Packages\General\Exceptions\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private AccountServiceInterface $accountService;
    private AccountTypeServiceInterface $accountTypeService;

    public function __construct(AccountServiceInterface $accountService, AccountTypeServiceInterface $accountTypeService)
    {
        $this->accountService = $accountService;
        $this->accountTypeService = $accountTypeService;
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

    public function store(Request $request, string $userId): JsonResponse {
        try {
            $accountType = $this->accountTypeService->findById($request->get("account_type_id"));
            $accountModel = AccountRequestMapper::requestToAccount($request->all(), $accountType);
            $accountCreated = $this->accountService->create($userId, $accountModel);
            return response()->json(SuccessResponse::parse("Conta criada com sucesso", $accountCreated));
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parserError($exception->getMessage()), 404);
        }
        catch (\Exception $exception) {
            return response()->json(ErrorResponse::parserError("Falha interna do servidor, tente novamente ou contate o administrador"), 500);
        }
    }

    public function update(Request $request, string $userId, string $accountId): JsonResponse {
        try {
            $accountType = $this->accountTypeService->findById($request->get("account_type_id"));
            $accountModel = AccountRequestMapper::requestToAccountUpdated($request->all(),$accountId, $accountType);
            $accountUpdated = $this->accountService->update($userId, $accountModel);
            return response()->json(SuccessResponse::parse("Conta atualizada com sucesso", $accountUpdated));
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parserError($exception->getMessage()), 404);
        }
        catch (\Exception $exception) {
            return response()->json(ErrorResponse::parserError("Falha interna do servidor, tente novamente ou contate o administrador"), 500);
        }
    }

    public function destroy(Request $request, string $userId, string $accountId): JsonResponse {
        try {
            $this->accountService->delete($userId, $accountId);
            return response()->json("", 204);
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parserError($exception->getMessage()), 404);
        }
        catch (\Exception $exception) {
            return response()->json(ErrorResponse::parserError("Falha interna do servidor, tente novamente ou contate o administrador"), 500);
        }
    }
}
