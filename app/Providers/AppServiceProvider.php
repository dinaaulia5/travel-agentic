<?php

namespace App\Providers;

use App\Models\FlightStatus;
use App\Observers\FlightStatusObserver;
use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);
        FlightStatus::observe(FlightStatusObserver::class);
    }
}
