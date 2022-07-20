<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Module\Domain\Auth\AuthRepository;
use Module\Domain\Auth\PasswordProvider;
use Module\Domain\Product\AsinRepository;
use Module\Domain\Product\ProductRepository;
use Module\Domain\Product\ScrapperApi;
use Module\Infrastructure\Auth\AuthRepositoryEloquent;
use Module\Infrastructure\Auth\PasswordProviderLaravel;
use Module\Infrastructure\Product\AsinEloquentRepository;
use Module\Infrastructure\Product\ProductRepositoryEloquent;
use Module\Infrastructure\Scrapper\ScrapperWebScrappingApi;

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
        $this->app->bind(ProductRepository::class, ProductRepositoryEloquent::class);
        $this->app->bind(ScrapperApi::class, ScrapperWebScrappingApi::class);
        $this->app->bind(AsinRepository::class, AsinEloquentRepository::class);

        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
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
