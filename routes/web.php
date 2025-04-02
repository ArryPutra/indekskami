<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KelolaPertanyaanController;
use App\Http\Controllers\Admin\KelolaRespondenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Responden\DashboardController as RespondenDashboardController;
use App\Http\Controllers\Responden\Evaluasi\IKategoriSEController;
use App\Http\Controllers\Responden\Evaluasi\RedirectEvaluasiController;
use App\Http\Controllers\Responden\Evaluasi\IdentitasRespondenController;
use App\Http\Controllers\Responden\Evaluasi\NonaktifEvaluasiController;
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

Route::middleware(['auth', 'akunAktif'])->group(function () {
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/kelola-responden', KelolaRespondenController::class);
        // Kelola Pertanyaan
        Route::resource('/kelola-pertanyaan', KelolaPertanyaanController::class);
        Route::post('/kelola-pertanyaan/{areaEvaluasi:id}/update-pertanyaan', [KelolaPertanyaanController::class, 'updatePertanyaan'])->name('kelola-pertanyaan.update-pertanyaan');
    });
    Route::prefix('responden')->middleware('responden')->group(function () {
        Route::get('/dashboard', [RespondenDashboardController::class, 'index'])->name('responden.dashboard');

        Route::get('/redirect-evaluasi', [RedirectEvaluasiController::class, 'index'])->name('responden.redirect-evaluasi');
        Route::prefix('evaluasi')->group(function () {
            Route::get('/nonaktif-evaluasi', [NonaktifEvaluasiController::class, 'index'])->name('responden.nonaktif-evaluasi');
            Route::middleware('aktifEvaluasi')->group(function () {
                Route::get('/identitas-responden/{hasilEvaluasi:id}', [IdentitasRespondenController::class, 'create'])
                    ->name('responden.identitas-responden');
                Route::post('/identitas-responden/simpan', [IdentitasRespondenController::class, 'simpan'])
                    ->name('responden.identitas-responden.simpan');
                // Route::resource('/identitas-responden', IdentitasRespondenController::class)
                //     ->except(['index', 'show', 'destroy'])
                //     ->names('responden.identitas-responden');

                Route::middleware('mengerjakanEvaluasi')->group(function () {
                    Route::get('/i-kategori-se/{hasilEvaluasi:id}', [IKategoriSEController::class, 'index'])->name('responden.evaluasi.i-kategori-se');
                    Route::post('/i-kategori-se/simpan', [IKategoriSEController::class, 'simpan'])
                        ->name('responden.evaluasi.i-kategori-se.simpan');
                });
            });
        });

        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('responden.riwayat');
        Route::get('/profil', [RespondenProfilController::class, 'index'])->name('responden.profil');
    });
});
