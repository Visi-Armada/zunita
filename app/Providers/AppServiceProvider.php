<?php

namespace App\Providers;

use App\Models\Contribution;
use App\Observers\ContributionObserver;
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
        // Register observers
        Contribution::observe(ContributionObserver::class);
    }
}
