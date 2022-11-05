<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Responses\TransactionTypeResponse;
use App\Api\V1\Utils\HttpStatus;
use App\Http\Controllers\Controller;
use App\Packages\Domain\TransactionType\Service\TransactionTypeServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionTypeController extends Controller
{
    private TransactionTypeServiceInterface $transactionTypeService;

    public function __construct(TransactionTypeServiceInterface $transactionTypeService)
    {
        $this->transactionTypeService = $transactionTypeService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json(TransactionTypeResponse::parseTransactionTypeList($this->transactionTypeService->findAll()));
        } catch (\Exception $exception) {
            return response()->json(
                ErrorResponse::parseError('Falha interna do servidor, tente novamente ou contate o administrador'),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }
}
