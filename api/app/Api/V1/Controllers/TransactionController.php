<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Mappers\TransactionRequestMapper;
use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Responses\SuccessResponse;
use App\Api\V1\Responses\TransactionResponse;
use App\Api\V1\Utils\HttpStatus;
use App\Http\Controllers\Controller;
use App\Packages\Domain\General\Exceptions\NotFoundException;
use App\Packages\Domain\Transaction\Model\Transaction;
use App\Packages\Domain\Transaction\Service\TransactionServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TransactionController extends Controller
{
    private TransactionServiceInterface $transactionService;

    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }


    public function store(Request $request, string $userId, string $accountId): JsonResponse
    {
        try {
            $transactionCreated = $this->transactionService->create(
                $userId,
                $accountId,
                TransactionRequestMapper::requestToTransaction($userId, $accountId,$request->all())
            );

            $parserTransaction = $this->formatTransactionResponse($transactionCreated);

            return response()->json(SuccessResponse::parse("Transação criada com sucesso", $parserTransaction));
        }catch (NotFoundException $exception) {
            return response()->json(
                ErrorResponse::parseError($exception->getMessage()),
                HttpStatus::NOT_FOUND->value
            );
        } catch (Exception $exception) {
            return response()->json(
                ErrorResponse::parseError("Falha interna do servido, tente novamente ou contate o administrador"),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }

    public function formatTransactionResponse(Transaction|Collection $transactionCreated): array
    {
        if ($transactionCreated instanceof Collection) {
            return TransactionResponse::parseTransactionInstallments($transactionCreated);
        }
        return TransactionResponse::parseTransaction($transactionCreated);
    }
}
