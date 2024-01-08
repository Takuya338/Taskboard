<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TaskBoardRepositoryInterface;
use App\Repositories\TaskBoardRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // サービスコンテナ
        $this->app->bind(
            'App\Repositories\TaskBoardRepositoryInterface',
            'App\Repositories\TaskBoardRepository'
        );
        $this->app->bind(
            'App\Repositories\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );
        $this->app->bind(
            'App\Services\UserServiceInterface',
            'App\Services\UserService'
        );
        $this->app->bind(
            'App\Services\TaskboardServiceInterface',
            'App\Services\TaskboardService'
        );
        $this->app->bind(
            'App\Services\LoginServiceInterface',
            'App\Services\LoginService'
        );
    }
}
