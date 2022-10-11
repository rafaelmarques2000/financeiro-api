<?php

namespace App\Http\Middleware;

use App\Api\V1\Responses\ErrorResponse;
use App\Packages\Domain\User\Exception\UserNotFoundException;
use App\Packages\Domain\User\Service\UserServiceInterface;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use UnexpectedValueException;

class JwtAuthGuard
{
    private string $AUTORIZATION_HEADER = "authorization";

    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(Request $request, Closure $next)
    {
        if(!$request->headers->has($this->AUTORIZATION_HEADER)) {
            return $this->unauthorizedResponse();
        }

        $token = explode(" ", $request->headers->get($this->AUTORIZATION_HEADER));

        if(count($token) < 2) {
            return $this->unauthorizedResponse();
        }

        try {
            $payload = JWT::decode($token[1], new Key(env("JWT_SECRET"), env("JWT_ALGO")));
            $this->userService->findById($payload->sub);
            return $next($request);
        }catch (UserNotFoundException|UnexpectedValueException $exception) {
            return $this->unauthorizedResponse();
        }
    }

    public function unauthorizedResponse(): \Illuminate\Http\JsonResponse
    {
        return response()->json(ErrorResponse::parserError("Não autorizado"), 401);
    }
}
