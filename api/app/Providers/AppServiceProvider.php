<?php

namespace App\Providers;

use App\Packages\Domain\Account\Repository\AccountRepositoryInterface;
use App\Packages\Domain\Account\Service\AccountService;
use App\Packages\Domain\Account\Service\AccountServiceInterface;
use App\Packages\Domain\AccountType\Repository\AccountTypeRepositoryInterface;
use App\Packages\Domain\AccountType\Service\AccountTypeService;
use App\Packages\Domain\AccountType\Service\AccountTypeServiceInterface;
use App\Packages\Domain\Auth\Service\AuthService;
use App\Packages\Domain\Auth\Service\AuthServiceInterface;
use App\Packages\Domain\User\Repository\UserRepositoryInterface;
use App\Packages\Domain\User\Service\UserService;
use App\Packages\Domain\User\Service\UserServiceInterface;
use App\Packages\Infra\Repository\AccountRepository;
use App\Packages\Infra\Repository\AccountTypeRepository;
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
        $this->app->bind(UserRepositoryInterface::class, function () {
            return new UserRepository();
        });

        $this->app->bind(UserServiceInterface::class, function ($app) {
            return new UserService($app->make(UserRepository::class));
        });

        $this->app->bind(AuthServiceInterface::class, function ($app) {
            return new AuthService($app->make(UserService::class));
        });

        $this->app->bind(AccountRepositoryInterface::class, function () {
            return new AccountRepository();
        });

        $this->app->bind(AccountServiceInterface::class, function ($app) {
            return new AccountService($app->make(AccountRepository::class));
        });

        $this->app->bind(AccountTypeRepositoryInterface::class, function () {
            return new AccountTypeRepository();
        });

        $this->app->bind(AccountTypeServiceInterface::class, function ($app) {
            return new AccountTypeService($app->make(AccountTypeRepository::class));
        });
    }
}
