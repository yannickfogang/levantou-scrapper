<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Module\Auth\useCases\Login\AuthRepository;
use Module\Auth\useCases\Login\PasswordProvider;
use Module\Infrastructure\Auth\AuthRepositoryEloquent;
use Module\Infrastructure\Auth\PasswordProviderLaravel;

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
        $this->app->bind(PasswordProvider::class, PasswordProviderLaravel::class);
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
