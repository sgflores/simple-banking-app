<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Services\AccountServices\AccountService;
use App\Http\Services\AccountServices\AccountInterface;
use App\Http\Services\CurrencyServices\CurrencyService;
use App\Http\Services\CurrencyServices\CurrencyInterface;
use App\Http\Services\TransactionServices\TransactionInterface;
use App\Http\Services\TransactionServices\TransactionService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // remove wrapping of data in resources
        JsonResource::withoutWrapping();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->app->bind(AccountInterface::class, AccountService::class);
        $this->app->bind(CurrencyInterface::class, CurrencyService::class);
        $this->app->bind(TransactionInterface::class, TransactionService::class);
        
    }
}
