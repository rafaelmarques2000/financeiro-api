<?php

namespace App\Providers;

use App\Packages\Domain\Auth\Service\AuthService;
use App\Packages\Domain\Auth\Service\AuthServiceInterface;
use App\Packages\Domain\User\Repository\UserRepositoryInterface;
use App\Packages\Domain\User\Service\UserService;
use App\Packages\Domain\User\Service\UserServiceInterface;
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
        $this->app->bind(UserRepositoryInterface::class, function(){
             return new UserRepository();
        });

        $this->app->bind(UserServiceInterface::class, function($app) {
            return new UserService($app->make(UserRepository::class));
        });

        $this->app->bind(AuthServiceInterface::class, function($app) {
            return new AuthService($app->make(UserService::class));
        });
    }
}
