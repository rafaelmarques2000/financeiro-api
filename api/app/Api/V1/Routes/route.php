<?php

use Illuminate\Support\Facades\Route;

Route::resources( [
    "users" => \App\Api\V1\Controllers\UserController::class,
    "accounts" => \App\Api\V1\Controllers\AccountController::class
]);
