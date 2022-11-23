<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Responses\DashboardResponse;
use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Utils\HttpStatus;
use App\Http\Controllers\Controller;
use App\Packages\Domain\Dashboard\Model\DashboardSearch;
use App\Packages\Domain\Dashboard\Service\DashboardServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private DashboardServiceInterface $dashboardService;

    public function __construct(DashboardServiceInterface $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }


    public function getExpensePerCategory(Request $request, string $userId): JsonResponse {
        try{
            $dashboardSearch = new DashboardSearch(
               $request->query('initial_date'),
               $request->query('end_date')
            );

            return response()->json(DashboardResponse::parseExpensePerCategory($this
                ->dashboardService
                ->getExpensePerCategory($userId, $dashboardSearch)));
        }catch (\Exception $exception) {
            return response()->json(
                ErrorResponse::parseError('Falha interna do servidor, tente novamente ou contate o administrador'),
                HttpStatus::INTERNAL_SERVER_ERROR->value
            );
        }
    }
}
