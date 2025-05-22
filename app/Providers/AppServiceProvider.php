<?php

namespace App\Providers;

use App\Models\Peran;
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
        // Super Admin
        Gate::define('superadmin', function ($user) {
            return $user->peran_id === Peran::PERAN_SUPERADMIN_ID;
        });
        // Admin
        Gate::define('admin', function ($user) {
            return $user->peran_id === Peran::PERAN_ADMIN_ID;
        });
        // Responden
        Gate::define('responden', function ($user) {
            return $user->peran_id === Peran::PERAN_RESPONDEN_ID;
        });
        // Verifikator
        Gate::define('verifikator', function ($user) {
            return $user->peran_id === Peran::PERAN_VERIFIKATOR_ID;
        });
    }
}
