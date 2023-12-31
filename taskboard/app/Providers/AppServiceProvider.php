<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
            'App\Repositories\TaskboardRepositoryInterface',
            'App\Repositories\TaskboardRepository'
        );
        $this->app->bind(
            'App\Repositories\TaskRepositoryInterface',
            'App\Repositories\TaskRepository'
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
               
    }
}
