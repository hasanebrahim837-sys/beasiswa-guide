<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        // Assistance requests (with file uploads): at most 5 per hour from the same connection,
        // so nobody can flood the admin panel or fill the server's disk.
        RateLimiter::for('assistance', function (Request $request) {
            return Limit::perHour(5)->by($request->ip())->response(function () {
                return back()->withInput()->with('error', __('You have sent too many requests. Please try again later or contact us on WhatsApp.'));
            });
        });
    }
}
