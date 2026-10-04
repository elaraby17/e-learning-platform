<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceHttps();
        }

        Paginator::useTailwind();

        // 5 محاولات دخول في الدقيقة لكل (إيميل + IP)
        RateLimiter::for('login', function ($request) {
            return Limit::perMinute(5)->by(
                strtolower((string) $request->input('email')) . '|' . $request->ip()
            );
        });
    }
}
