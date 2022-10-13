<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Responses\ValidationErrorResponse;
use App\Api\V1\Responses\UserResponse;
use App\Api\V1\Utils\HttpStatus;
use App\Http\Controllers\Controller;
use App\Packages\Domain\User\Service\UserServiceInterface;
use App\Packages\General\Exceptions\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse {
        try {
            return response()->json(UserResponse::parseUserList($this->userService->list()));
        }catch (\Exception $exception) {
            return response()->json(ErrorResponse::parseError("Falha interna do servidor, tente novamente ou contate o administrador"),
                HttpStatus::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function show(Request $request, string $userId): JsonResponse {
        try {
            return response()->json(UserResponse::parseUser($this->userService->findById(
                $userId
            )));
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parseError($exception->getMessage()), HttpStatus::NOT_FOUND->value);
        }catch (\Exception $exception) {
            return response()->json(ErrorResponse::parseError("Falha interna do servidor, tente novamente ou contate o administrador"),
                HttpStatus::INTERNAL_SERVER_ERROR->value);
        }
    }
}
