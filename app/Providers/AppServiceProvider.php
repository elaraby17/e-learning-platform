<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
         if (app()->environment('production')) {
        URL::forceHttps();
    }
        Paginator::useTailwind();

        RateLimiter::for('login', function ($request) {
            return Limit::perMinute(5)->by(
                strtolower($request->input('email')) . '|' . $request->ip()
            );
        });
    }
}
