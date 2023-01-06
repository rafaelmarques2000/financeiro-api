<?php

use App\Api\V1\Controllers\AccountController;
use App\Api\V1\Controllers\AccountStatisticController;
use App\Api\V1\Controllers\AccountTypeController;
use App\Api\V1\Controllers\AuthController;
use App\Api\V1\Controllers\DashboardController;
use App\Api\V1\Controllers\TransactionCategoryController;
use App\Api\V1\Controllers\TransactionController;
use App\Api\V1\Controllers\TransactionTypeController;
use App\Api\V1\Controllers\UserController;
use App\Http\Middleware\JwtAuthGuard;
use Illuminate\Support\Facades\Route;

//auth
Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/check-token', [AuthController::class, 'checkJWTToken']);


//Route::middleware(JwtAuthGuard::class)->group(function () {

    //account statistics
    Route::get("/users/{user}/accounts/statistics", [AccountStatisticController::class, 'getPeriodResult']);
    Route::get("/users/{user}/accounts/{account}/statistics", [AccountStatisticController::class, 'getPeriodResultByAccount']);

    //dashboard
    Route::get("/users/{user}/dashboard/expense-per-category", [DashboardController::class, 'getExpensePerCategory']);
    Route::get("/users/{user}/dashboard/invoice-report", [DashboardController::class, 'getInvoiceReport']);

    Route::resources([
        'users' => UserController::class,
        'users.accounts' => AccountController::class,
        'users.accounts.transactions' => TransactionController::class,
    ]);

    Route::get("/users/{user}/transactions/{categoryId}", [TransactionController::class, 'listByCategory']);

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
