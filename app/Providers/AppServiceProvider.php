<?php

namespace App\Providers;

use App\Repository\BookingRepository;
use App\Repository\Contracts\BookingRepositoryContract;
use App\Repository\Contracts\SeatRepositoryContract;
use App\Repository\SeatRepository;
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
        $this->app->bind(SeatRepositoryContract::class, SeatRepository::class);
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
