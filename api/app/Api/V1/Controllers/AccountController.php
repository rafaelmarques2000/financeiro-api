<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Mappers\AccountRequestMapper;
use App\Api\V1\Requests\AccountRequest;
use App\Api\V1\Responses\AccountResponse;
use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Responses\SuccessResponse;
use App\Api\V1\Utils\HttpStatus;
use App\Http\Controllers\Controller;
use App\Packages\Domain\Account\Model\AccountSearch;
use App\Packages\Domain\Account\Service\AccountServiceInterface;
use App\Packages\Domain\AccountType\Service\AccountTypeServiceInterface;
use App\Packages\Domain\General\Exceptions\NotFoundException;
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
            $accountSearch = new AccountSearch(
                $request->query("description"),
                $request->query("page"),
                $request->query("limit"),
            );
            return response()->json(AccountResponse::parseAccountList($this->accountService->list($userId,$accountSearch)));
        }catch (\Exception $exception) {
            return response()->json(ErrorResponse::parseError("Falha interna do servidor, tente novamente ou contate o administrador"),
                HttpStatus::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function show(Request $request, string $userId, string $accountId) : JsonResponse{
        try {
            return response()->json(AccountResponse::parseAccount($this->accountService->findById($userId, $accountId)));
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parseError($exception->getMessage()), HttpStatus::NOT_FOUND->value);
        }
        catch (\Exception $exception) {
            return response()->json(ErrorResponse::parseError("Falha interna do servidor, tente novamente ou contate o administrador"),
                HttpStatus::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function store(AccountRequest $request, string $userId): JsonResponse {
        try {
            $accountType = $this->accountTypeService->findById($request->get("account_type_id"));
            $accountModel = AccountRequestMapper::requestToAccount($request->all(), $accountType);
            $accountCreated = $this->accountService->create($userId, $accountModel);
            return response()->json(SuccessResponse::parse("Conta criada com sucesso", $accountCreated));
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parseError($exception->getMessage()), HttpStatus::NOT_FOUND->value);
        }
        catch (\Exception $exception) {
            return response()->json(ErrorResponse::parseError("Falha interna do servidor, tente novamente ou contate o administrador"),
                HttpStatus::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function update(Request $request, string $userId, string $accountId): JsonResponse {
        try {
            $accountType = $this->accountTypeService->findById($accountId);
            $accountModel = AccountRequestMapper::requestToAccountUpdated($request->all(),$accountId, $accountType);
            $accountUpdated = $this->accountService->update($userId, $accountModel);
            return response()->json(SuccessResponse::parse("Conta atualizada com sucesso", $accountUpdated));
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parseError($exception->getMessage()), HttpStatus::NOT_FOUND->value);
        }
        catch (\Exception $exception) {
            return response()->json(ErrorResponse::parseError("Falha interna do servidor, tente novamente ou contate o administrador"),
                HttpStatus::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function destroy(Request $request, string $userId, string $accountId): JsonResponse {
        try {
            $this->accountService->delete($userId, $accountId);
            return response()->json("", HttpStatus::NOT_CONTENT->value);
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parseError($exception->getMessage()), HttpStatus::NOT_FOUND->value);
        }
        catch (\Exception $exception) {
            return response()->json(ErrorResponse::parseError("Falha interna do servidor, tente novamente ou contate o administrador"),
                HttpStatus::INTERNAL_SERVER_ERROR->value);
        }
    }
}
