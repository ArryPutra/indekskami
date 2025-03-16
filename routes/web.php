<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KelolaRespondenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Responden\Evaluasi\IKategoriSEController;
use App\Http\Controllers\Responden\IdentitasRespondenController;
use App\Http\Controllers\Responden\ProfilController as RespondenProfilController;
use App\Http\Controllers\Responden\RedirectController;
use App\Http\Controllers\Responden\RiwayatController;
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

        Route::middleware('belumEvaluasi')->group(function () {
            Route::get('/identitas-responden', [IdentitasRespondenController::class, 'index'])->name('responden.identitas-responden');
            Route::post('/identitas-responden/tambah', [IdentitasRespondenController::class, 'store'])->name('responden.identitas-responden.store');
        });

        Route::prefix('evaluasi')->middleware('mengerjakanEvaluasi')->group(function () {
            Route::get('/i-kategori-se', [IKategoriSEController::class, 'index'])->name('responden.evaluasi.i-kategori-se');
        });

        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('responden.riwayat');
        Route::get('/profil', [RespondenProfilController::class, 'index'])->name('responden.profil');
    });
});
