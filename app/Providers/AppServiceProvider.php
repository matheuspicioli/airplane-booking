<?php

namespace App\Providers;

use App\Repository\BookingRepository;
use App\Repository\Contracts\BookingRepositoryContract;
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
        $this->app->bind(BookingRepositoryContract::class, BookingRepository::class);
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
