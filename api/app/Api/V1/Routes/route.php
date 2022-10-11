<?php

use Illuminate\Support\Facades\Route;

Route::post("/auth", [\App\Api\V1\Controllers\AuthController::class, 'auth']);

Route::middleware(\App\Http\Middleware\JwtAuthGuard::class)->group(function () {
    Route::resources( [
        "users" => \App\Api\V1\Controllers\UserController::class,
        "users.accounts" => \App\Api\V1\Controllers\AccountController::class
    ]);
});
