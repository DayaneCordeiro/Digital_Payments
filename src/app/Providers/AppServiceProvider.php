<?php

namespace App\Providers;

use App\Repositories\TransactionRepositoryInterface;
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
