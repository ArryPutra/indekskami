<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KelolaEvaluasiController;
use App\Http\Controllers\Admin\KelolaPertanyaan\KelolaAreaEvaluasi;
use App\Http\Controllers\Admin\KelolaPertanyaan\KelolaAreaEvaluasiController;
use App\Http\Controllers\Admin\KelolaPertanyaan\KelolaJudulTemaPertanyaanController;
use App\Http\Controllers\Admin\KelolaPertanyaan\KelolaPertanyaanController;
use App\Http\Controllers\Admin\KelolaPertanyaan\KelolaPertanyaanEvaluasiController;
use App\Http\Controllers\Admin\KelolaRespondenController;
use App\Http\Controllers\Admin\KelolaVerifikatorController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\AdminVerifikator\KelolaEvaluasi\MengerjakanController;
use App\Http\Controllers\AdminVerifikator\KelolaEvaluasi\SelesaiController;
use App\Http\Controllers\AdminVerifikator\KelolaEvaluasi\VerifikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Evaluasi\AksesFileController;
use App\Http\Controllers\Evaluasi\BukaDokumenController;
use App\Http\Controllers\Evaluasi\DashboardController as EvaluasiDashboardController;
use App\Http\Controllers\Evaluasi\EvaluasiController;
use App\Http\Controllers\Evaluasi\EvaluasiUtamaController;
use App\Http\Controllers\Evaluasi\FileController;
use App\Http\Controllers\Evaluasi\IKategoriSEController;
use App\Http\Controllers\Responden\DashboardController as RespondenDashboardController;
use App\Http\Controllers\Responden\Evaluasi\RedirectEvaluasiController;
use App\Http\Controllers\Evaluasi\IdentitasRespondenController;
use App\Http\Controllers\Evaluasi\IITataKelolaController;
use App\Http\Controllers\Evaluasi\KepemilikanDokumenController;
use App\Http\Controllers\Evaluasi\PertanyaanController;
use App\Http\Controllers\Responden\Evaluasi\NonaktifEvaluasiController;
use App\Http\Controllers\Responden\ProfilController as RespondenProfilController;
use App\Http\Controllers\Responden\RiwayatController;
use App\Http\Controllers\Verifikator\DashboardController as VerifikatorDashboardController;
use App\Http\Controllers\Verifikator\ProfilController as VerifikatorProfilController;
use App\Models\KepemilikanDokumen;
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
    // # PERAN: Admin #
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        // Kelola Evaluasi
        Route::get('/kelola-evaluasi', [KelolaEvaluasiController::class, 'index'])->name('admin.kelola-evaluasi');
        // Kelola Responden
        Route::resource('/kelola-responden', KelolaRespondenController::class);
        // Kelola Verifikator
        Route::resource('/kelola-verifikator', KelolaVerifikatorController::class);
        // Kelola Pertanyaan
        Route::get('/kelola-pertanyaan', [KelolaPertanyaanController::class, 'index'])->name('admin.kelola-pertanyaan');
        // --> Kelola Pertanyaan: Kelola Area Evaluasi
        Route::resource('kelola-pertanyaan/kelola-area-evaluasi', KelolaAreaEvaluasiController::class)->only(['edit', 'update']);
        Route::middleware('sesiAreaEvaluasiId')->group(function () {
            // --> Kelola Pertanyaan: Kelola Judul Tema Pertanyaan
            Route::resource('/kelola-pertanyaan/kelola-judul-tema-pertanyaan', KelolaJudulTemaPertanyaanController::class)->except(['show']);
            // --> Kelola Pertanyaan: Kelola Pertanyaan
            Route::resource('/kelola-pertanyaan/kelola-pertanyaan-evaluasi', KelolaPertanyaanEvaluasiController::class)->except(['show']);
        });
        // Profil
        Route::get('/profil', [ProfilController::class, 'index'])->name('admin.profil');
        Route::post('/profil/perbarui-password', [ProfilController::class, 'perbaruiPassword'])->name('admin.profil.perbarui-password');
    });
    // # PERAN: Verifikator #
    Route::prefix('verifikator')->middleware('verifikator')->group(function () {
        Route::get('/dashboard', [VerifikatorDashboardController::class, 'index'])->name('verifikator.dashboard');
        Route::get('/profil', [VerifikatorProfilController::class, 'index'])->name('verifikator.profil');
    });
    // # PERAN: Admin atau Verifikator #
    Route::prefix('admin-verifikator')->middleware('adminVerifikator')->group(function () {
        Route::prefix('kelola-evaluasi')->group(function () {
            Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('admin-verifikator.kelola-evaluasi.verifikasi');
            Route::get('/mengerjakan', [MengerjakanController::class, 'index'])->name('admin-verifikator.kelola-evaluasi.mengerjakan');
            Route::get('/selesai', [SelesaiController::class, 'index'])->name('admin-verifikator.kelola-evaluasi.selesai');

            Route::get('/evaluasi-responden', fn() => 1);
        });
    });
    // # PERAN: Responden #
    Route::prefix('responden')->middleware('responden')->group(function () {
        Route::get('/dashboard', [RespondenDashboardController::class, 'index'])->name('responden.dashboard');

        Route::get('/redirect-evaluasi', [RedirectEvaluasiController::class, 'index'])->name('responden.redirect-evaluasi');
        Route::prefix('evaluasi')->group(function () {
            Route::get('/nonaktif-evaluasi', [NonaktifEvaluasiController::class, 'index'])->name('responden.nonaktif-evaluasi');
            Route::middleware('aktifEvaluasi')->group(function () {
                Route::resource('/identitas-responden', IdentitasRespondenController::class)
                    ->only(['create', 'store', 'edit', 'update'])
                    ->names('responden.evaluasi.identitas-responden');

                Route::middleware(['mengerjakanEvaluasi', 'kepemilikanHasilEvaluasi'])->group(function () {
                    // Route::get('/i-kategori-se/{hasilEvaluasi:id}', [IKategoriSEController::class, 'index'])->name('responden.evaluasi.i-kategori-se');
                    // Route::post('/i-kategori-se/simpan/{hasilEvaluasi:id}', [IKategoriSEController::class, 'simpan'])
                    //     ->name('responden.evaluasi.i-kategori-se.simpan');

                    // Route::get('/evaluasi-utama/{hasilEvaluasi}/{areaEvaluasi}', [EvaluasiUtamaController::class, 'index'])->name('responden.evaluasi.evaluasi-utama');
                    // Route::post('/evaluasi-utama/simpan/{hasilEvaluasi}/{areaEvaluasi}', [EvaluasiUtamaController::class, 'simpan'])->name('responden.evaluasi.evaluasi-utama.simpan');

                    Route::get('/evaluasi/{areaEvaluasi}/{hasilEvaluasi}', [PertanyaanController::class, 'index'])->name('responden.evaluasi.pertanyaan');
                    Route::post('/evaluasi/simpan/{areaEvaluasi}/{hasilEvaluasi}', [PertanyaanController::class, 'simpan'])->name('responden.evaluasi.pertanyaan.simpan');

                    Route::get('/dashboard/{hasilEvaluasi:id}', [EvaluasiDashboardController::class, 'index'])->name('responden.evaluasi.dashboard');
                });
            });
        });

        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('responden.riwayat');
        Route::get('/profil', [RespondenProfilController::class, 'index'])->name('responden.profil');
    });
    // Akses File Evaluasi
    Route::get('/file/{path}', [BukaDokumenController::class, 'index'])->where('path', '.*');
});
