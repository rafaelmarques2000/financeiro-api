<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Responses\TransactionCategoryResponse;
use App\Api\V1\Utils\HttpStatus;
use App\Http\Controllers\Controller;
use App\Packages\Domain\TransactionCategory\Service\TransactionCategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    private TransactionCategoryServiceInterface $transactionCategoryService;

    public function __construct(TransactionCategoryServiceInterface $transactionCategoryService)
    {
        $this->transactionCategoryService = $transactionCategoryService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            return response()->json(TransactionCategoryResponse::parseTransactionCategoryList($this->transactionCategoryService->findAll()));
        } catch (\Exception $exception) {
            return response()->json(
                ErrorResponse::parseError('Falha interna do servidor, tente novamente ou contate o administrador'),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }
}
