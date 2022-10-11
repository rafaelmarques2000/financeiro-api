<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Responses\UserResponse;
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
         return response()->json(UserResponse::parserUserList($this->userService->list()));
    }

    public function show(Request $request, string $userId): JsonResponse {
        try {
            return response()->json(UserResponse::parserUser($this->userService->findById(
                $userId
            )));
        }catch (NotFoundException $exception) {
            return response()->json(ErrorResponse::parserError($exception->getMessage()), 404);
        }catch (\Exception $exception) {
            return response()->json(ErrorResponse::parserError("Falha interna do servidor, tente novamente ou contate o administrador"), 500);
        }
    }
}
