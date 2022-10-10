<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Responses\UserResponse;
use App\Http\Controllers\Controller;
use App\Packages\Domain\User\Service\UserServiceInterface;
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

    public function show(Request $request): JsonResponse {
        return response()->json(UserResponse::parserUserList($this->userService->list()));
    }
}
