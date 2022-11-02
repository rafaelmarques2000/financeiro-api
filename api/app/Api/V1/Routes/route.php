<?php

use App\Api\V1\Controllers\AccountTypeController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [\App\Api\V1\Controllers\AuthController::class, 'auth']);
Route::post('/check-token', [\App\Api\V1\Controllers\AuthController::class, 'checkJWTToken']);

//Route::middleware(\App\Http\Middleware\JwtAuthGuard::class)->group(function () {
Route::resources([
    'users' => \App\Api\V1\Controllers\UserController::class,
    'users.accounts' => \App\Api\V1\Controllers\AccountController::class,
]);
Route::resource('account-types', AccountTypeController::class)->only([
    'index',
]);
//});
