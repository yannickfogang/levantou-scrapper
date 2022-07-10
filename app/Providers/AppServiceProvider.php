<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Module\Auth\useCases\Login\AuthRepository;
use Module\Infrastructure\Auth\AuthRepositoryEloquent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthRepository::class, AuthRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
