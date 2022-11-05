<?php

use App\Api\V1\Controllers\AccountController;
use App\Api\V1\Controllers\AccountTypeController;
use App\Api\V1\Controllers\AuthController;
use App\Api\V1\Controllers\TransactionCategoryController;
use App\Api\V1\Controllers\TransactionController;
use App\Api\V1\Controllers\TransactionTypeController;
use App\Api\V1\Controllers\UserController;
use App\Http\Middleware\JwtAuthGuard;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/check-token', [AuthController::class, 'checkJWTToken']);

//Route::middleware(JwtAuthGuard::class)->group(function () {
Route::resources([
    'users' => UserController::class,
    'users.accounts' => AccountController::class,
    'users.accounts.transactions' => TransactionController::class,
]);
Route::resource('account-types', AccountTypeController::class)->only([
    'index',
]);
Route::resource('transaction-types', TransactionTypeController::class)->only([
    'index',
]);

Route::resource('transaction-categories', TransactionCategoryController::class)->only([
    'index', 'show',
]);
//});
