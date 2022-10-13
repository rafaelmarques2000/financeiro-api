<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\AuthRequest;
use App\Api\V1\Responses\AuthResponse;
use App\Api\V1\Responses\ErrorResponse;
use App\Api\V1\Responses\ValidationErrorResponse;
use App\Api\V1\Utils\HttpStatus;
use App\Http\Controllers\Controller;
use App\Packages\Domain\Auth\Service\AuthServiceInterface;
use App\Packages\General\Exceptions\AuthFailedException;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function auth(AuthRequest $request) : JsonResponse {
         try {
            $authUser = $this->authService->authenticateByUserAndPassword(
                $request->post("username"),
                $request->post("password")
            );

            $payload = [
                'sub' => $authUser->getId(),
                'exp' => Carbon::now()->getTimestamp() + env("JWT_TTL")
            ];

             $token = JWT::encode($payload, env("JWT_SECRET"), env("JWT_ALGO"));

             return response()->json(AuthResponse::parseAuthUser($authUser, $token));
         }catch (AuthFailedException $exception) {
            return response()->json(ErrorResponse::parseError($exception->getMessage()), HttpStatus::BAD_REQUEST->value);
         }catch (\Exception $exception) {
             return response()->json(ErrorResponse::parseError($exception->getMessage()), HttpStatus::INTERNAL_SERVER_ERROR->value);
         }
    }
}
