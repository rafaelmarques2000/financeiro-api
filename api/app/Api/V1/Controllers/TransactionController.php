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
use App\Packages\Domain\Transaction\Model\TransactionSearch;
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

    public function index(Request $request, string $userId, string $accountId): JsonResponse
    {
        try {
            $accountSearch = new TransactionSearch(
                $request->query('description'),
                $request->query('page'),
                $request->query('limit'),
                $request->query('initial_date'),
                $request->query('end_date'),
            );

            return response()->json(TransactionResponse::parseTransactionList($this->transactionService->findAll($userId,$accountId,$accountSearch)));
        } catch (\Exception $exception) {
            return response()->json(
                ErrorResponse::parseError($exception->getMessage()),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }

    public function show(Request $request, string $userId, string $accountId, string $transactionId): JsonResponse
    {
        try {
            return response()->json(TransactionResponse::parseTransaction($this->transactionService->findById($userId, $accountId, $transactionId)));
        } catch (NotFoundException $exception) {
            return response()->json(
                ErrorResponse::parseError($exception->getMessage()),
                HttpStatus::NOT_FOUND->value
            );
        } catch (Exception $exception) {
            return response()->json(
                ErrorResponse::parseError('Falha interna do servido, tente novamente ou contate o administrador'),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }

    public function store(Request $request, string $userId, string $accountId): JsonResponse
    {
        try {
            $transactionCreated = $this->transactionService->create(
                $userId,
                $accountId,
                TransactionRequestMapper::requestToTransaction($userId, $accountId, $request->all())
            );

            $parserTransaction = $this->formatTransactionResponse($transactionCreated);

            return response()->json(SuccessResponse::parse('Transação criada com sucesso', $parserTransaction));
        } catch (NotFoundException $exception) {
            return response()->json(
                ErrorResponse::parseError($exception->getMessage()),
                HttpStatus::NOT_FOUND->value
            );
        } catch (Exception $exception) {
            return response()->json(
                ErrorResponse::parseError('Falha interna do servido, tente novamente ou contate o administrador'),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }

    public function update(Request $request, string $userId, string $accountId, string $transactionId): JsonResponse
    {
        try {
            $transactionUpdated = $this->transactionService->update(
                $userId,
                $accountId,
                TransactionRequestMapper::requestToTransaction($userId, $accountId, $request->all(), $transactionId)
            );
            return response()->json(SuccessResponse::parse('Transação atualizada com sucesso', TransactionResponse::parseTransaction($transactionUpdated)));
        } catch (NotFoundException $exception) {
            return response()->json(
                ErrorResponse::parseError($exception->getMessage()),
                HttpStatus::NOT_FOUND->value
            );
        } catch (Exception $exception) {
            return response()->json(
                ErrorResponse::parseError('Falha interna do servido, tente novamente ou contate o administrador'),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }

    public function destroy(Request $request, string $userId, string $accountId, string $transactionId): JsonResponse
    {
        try {
            $this->transactionService->delete($userId, $accountId, $transactionId);

            return response()->json('', HttpStatus::NOT_CONTENT->value);
        } catch (NotFoundException $exception) {
            return response()->json(
                ErrorResponse::parseError($exception->getMessage()),
                HttpStatus::NOT_FOUND->value
            );
        } catch (Exception $exception) {
            return response()->json(
                ErrorResponse::parseError('Falha interna do servido, tente novamente ou contate o administrador'),
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
