<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Mappers\AccountRequestMapper;
use App\Api\V1\Requests\AccountRequest;
use App\Api\V1\Responses\AccountResponse;
use App\Api\V1\Responses\AccountStatisticResponse;
use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Responses\SuccessResponse;
use App\Api\V1\Utils\HttpStatus;
use App\Http\Controllers\Controller;
use App\Packages\Domain\Account\Model\AccountSearch;
use App\Packages\Domain\Account\Model\AccountStatisticSearch;
use App\Packages\Domain\Account\Service\AccountServiceInterface;
use App\Packages\Domain\Account\Service\AccountStatisticServiceInterface;
use App\Packages\Domain\AccountType\Service\AccountTypeServiceInterface;
use App\Packages\Domain\General\Exceptions\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountStatisticController extends Controller
{
    private AccountStatisticServiceInterface $accountStatisticService;

    public function __construct(AccountStatisticServiceInterface $accountStatisticService)
    {
        $this->accountStatisticService = $accountStatisticService;
    }

    public function getPeriodResult(Request $request, string $userId): JsonResponse {

         try {
             $accountStatisticSearch = new AccountStatisticSearch(
                 $request->query('initial_date'),
                 $request->query('end_date'),
                 $request->query("account_types")
             );

             return response()->json(AccountStatisticResponse::parse($this->accountStatisticService
                 ->getByPeriod($userId, $accountStatisticSearch)));
         } catch (\Exception $exception) {
             return response()->json(
                 ErrorResponse::parseError($exception->getMessage()),
                 HttpStatus::INTERNAL_SERVER_ERROR->value
             );
         }
     }

    public function getPeriodResultByAccount(Request $request, string $userId, string $accountId): JsonResponse {

        try {
            $accountStatisticSearch = new AccountStatisticSearch(
                $request->query('initial_date'),
                $request->query('end_date'),
                $request->query("account_types")
            );

            return response()->json(AccountStatisticResponse::parseAccountBalance($this->accountStatisticService
                ->getByPeriodAndAccountId($userId, $accountId, $accountStatisticSearch)));
        } catch (\Exception $exception) {
            return response()->json(
                ErrorResponse::parseError($exception->getMessage()),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }
}
