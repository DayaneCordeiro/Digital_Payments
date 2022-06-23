<?php

namespace App\Providers;

use App\Repositories\Eloquent\WalletRepository;
use App\Repositories\TransactionRepositoryInterface;
use App\Repositories\WalletRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\TransactionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TransactionRepositoryInterface::class, function() {
            return new TransactionRepository();
        });

        $this->app->bind(WalletRepositoryInterface::class, function() {
            return new WalletRepository();
        });
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
