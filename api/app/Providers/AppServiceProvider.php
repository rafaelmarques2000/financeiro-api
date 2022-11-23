<?php

namespace App\Providers;

use App\Packages\Domain\Account\Repository\AccountRepositoryInterface;
use App\Packages\Domain\Account\Service\AccountService;
use App\Packages\Domain\Account\Service\AccountServiceInterface;
use App\Packages\Domain\Account\Service\AccountStatisticService;
use App\Packages\Domain\Account\Service\AccountStatisticServiceInterface;
use App\Packages\Domain\AccountType\Repository\AccountTypeRepositoryInterface;
use App\Packages\Domain\AccountType\Service\AccountTypeService;
use App\Packages\Domain\AccountType\Service\AccountTypeServiceInterface;
use App\Packages\Domain\Auth\Service\AuthService;
use App\Packages\Domain\Auth\Service\AuthServiceInterface;
use App\Packages\Domain\Dashboard\Repository\DashboardRepositoryInterface;
use App\Packages\Domain\Dashboard\Service\DashboardService;
use App\Packages\Domain\Dashboard\Service\DashboardServiceInterface;
use App\Packages\Domain\Transaction\Repository\TransactionRepositoryInterface;
use App\Packages\Domain\Transaction\Service\TransactionService;
use App\Packages\Domain\Transaction\Service\TransactionServiceInterface;
use App\Packages\Domain\TransactionCategory\Repository\TransactionCategoryRepositoryInterface;
use App\Packages\Domain\TransactionCategory\Service\TransactionCategoryService;
use App\Packages\Domain\TransactionCategory\Service\TransactionCategoryServiceInterface;
use App\Packages\Domain\TransactionType\Repository\TransactionTypeRepositoryInterface;
use App\Packages\Domain\TransactionType\Service\TransactionTypeService;
use App\Packages\Domain\TransactionType\Service\TransactionTypeServiceInterface;
use App\Packages\Domain\User\Repository\UserRepositoryInterface;
use App\Packages\Domain\User\Service\UserService;
use App\Packages\Domain\User\Service\UserServiceInterface;
use App\Packages\Infra\Repository\AccountRepository;
use App\Packages\Infra\Repository\AccountTypeRepository;
use App\Packages\Infra\Repository\DashboardRepository;
use App\Packages\Infra\Repository\TransactionCategoryRepository;
use App\Packages\Infra\Repository\TransactionRepository;
use App\Packages\Infra\Repository\TransactionTypeRepository;
use App\Packages\Infra\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadProductionBindsInterfaces();
    }


    public function loadProductionBindsInterfaces(): void
    {
        $this->app->bind(UserRepositoryInterface::class, function () {
            return new UserRepository();
        });

        $this->app->bind(UserServiceInterface::class, function ($app) {
            return new UserService($app->make(UserRepository::class));
        });

        $this->app->bind(AuthServiceInterface::class, function ($app) {
            return new AuthService($app->make(UserService::class));
        });

        $this->app->bind(AccountRepositoryInterface::class, function ($app) {
            return new AccountRepository();
        });

        $this->app->bind(AccountServiceInterface::class, function ($app) {
            return new AccountService(
                $app->make(AccountRepository::class),
                $app->make(TransactionService::class),
            );
        });

        $this->app->bind(AccountTypeRepositoryInterface::class, function () {
            return new AccountTypeRepository();
        });

        $this->app->bind(AccountTypeServiceInterface::class, function ($app) {
            return new AccountTypeService($app->make(AccountTypeRepository::class));
        });

        $this->app->bind(TransactionTypeRepositoryInterface::class, function () {
            return new TransactionTypeRepository();
        });

        $this->app->bind(TransactionTypeServiceInterface::class, function ($app) {
            return new TransactionTypeService($app->make(TransactionTypeRepository::class));
        });

        $this->app->bind(TransactionCategoryRepositoryInterface::class, function () {
            return new TransactionCategoryRepository();
        });

        $this->app->bind(TransactionCategoryServiceInterface::class, function ($app) {
            return new TransactionCategoryService($app->make(TransactionCategoryRepository::class));
        });

        $this->app->bind(TransactionRepositoryInterface::class, function () {
            return new TransactionRepository();
        });

        $this->app->bind(TransactionServiceInterface::class, function ($app) {
            return new TransactionService($app->make(TransactionRepository::class));
        });

        $this->app->bind(AccountStatisticServiceInterface::class, function ($app) {
            return new AccountStatisticService($app->make(AccountService::class));
        });

        $this->app->bind(DashboardRepositoryInterface::class, function ($app) {
            return new DashboardRepository();
        });

        $this->app->bind(DashboardServiceInterface::class, function ($app) {
            return new DashboardService($app->make(DashboardRepository::class));
        });

    }
}
