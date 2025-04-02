<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        // Admin
        Gate::define('admin', function ($user) {
            return $user->peran_id === 1;
        });
        // Verifikator
        Gate::define('verifikator', function ($user) {
            return $user->peran_id === 2;
        });
        // Admin Or Verifikator
        Gate::define('adminOrVerifikator', function ($user) {
            return $user->peran_id === 1 || $user->peran_id === 2;
        });
        // Responden
        Gate::define('responden', function ($user) {
            return $user->peran_id === 3;
        });
    }
}
