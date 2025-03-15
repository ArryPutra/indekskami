<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KelolaRespondenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Responden\DaftarIdentitasController;
use App\Http\Controllers\Responden\RedirectController;
use App\Http\Middleware\Admin\AdminMiddleware;
use App\Http\Middleware\Responden\RespondenMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index']);

// Ketika terdapat request ke /login
Route::get('/login', function () {
    // kembalikan ke halaman login
    return redirect('/');
});
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/kelola-responden', KelolaRespondenController::class);
    });
    Route::prefix('responden')->middleware('responden')->group(function () {
        Route::get('/redirect', [RedirectController::class, 'index'])->name('responden.redirect');
        Route::get('/daftar-identitas', [DaftarIdentitasController::class, 'index'])->name('responden.daftar-identitas');
    });
});
