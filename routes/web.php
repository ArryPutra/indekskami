<?php

// Role: Superadmin [1]
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\KelolaAreaEvaluasiController;
use App\Http\Controllers\Superadmin\KelolaPertanyaanEvaluasiController;
use App\Http\Controllers\Superadmin\KelolaJudulTemaPertanyaanController;
use App\Http\Controllers\Superadmin\KelolaTingkatKematangan;
use App\Http\Controllers\Superadmin\KelolaAdminController;
use App\Http\Controllers\Superadmin\ProfilController as SuperadminProfilController;

// Role: Admin [2]
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
// Role: Responden [3]
use App\Http\Controllers\Responden\DashboardController as RespondenDashboardController;
use App\Http\Controllers\Responden\Evaluasi\RedirectEvaluasiController;
use App\Http\Controllers\Responden\Evaluasi\NonaktifEvaluasiController;
use App\Http\Controllers\Responden\Evaluasi\SelesaiEvaluasiController;
use App\Http\Controllers\Responden\Evaluasi\IdentitasRespondenController;
use App\Http\Controllers\Responden\RiwayatController;
use App\Http\Controllers\Responden\ProfilController as RespondenProfilController;

// Role: Verifikator [4]
use App\Http\Controllers\Verifikator\DashboardController as VerifikatorDashboardController;
use App\Http\Controllers\Verifikator\ProfilController as VerifikatorProfilController;
use App\Http\Controllers\Verifikator\KelolaEvaluasiController;

// Role: Manajemen [5]
use App\Http\Controllers\Manajemen\DashboardController as ManajemenDashboardController;
use App\Http\Controllers\Manajemen\ProfilController;


// Role: Superadmin & Admin [1 & 2]
use App\Http\Controllers\SuperadminAdmin\KelolaRespondenController;
use App\Http\Controllers\SuperadminAdmin\KelolaVerifikatorController;
use App\Http\Controllers\SuperadminAdmin\KelolaManajemenController;

// Evaluasi
use App\Http\Controllers\Evaluasi\PertanyaanController;
use App\Http\Controllers\Evaluasi\DashboardController as EvaluasiDashboardController;
use App\Http\Controllers\Evaluasi\BukaDokumenController;
use App\Http\Controllers\Evaluasi\CetakLaporanEvaluasiController;

// 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Responden\Evaluasi\PesanEvaluasiController;
use App\Http\Controllers\Superadmin\PengaturanEvaluasiController;
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
    # PERAN: Superadmin [ID: 1] #
    Route::prefix('superadmin')->middleware('superadmin')->group(function () {
        Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

        Route::resource('/pengaturan-evaluasi', PengaturanEvaluasiController::class)
            ->only('index', 'store');
        Route::resource('/kelola-area-evaluasi', KelolaAreaEvaluasiController::class);
        Route::resource('/kelola-pertanyaan-evaluasi', KelolaPertanyaanEvaluasiController::class);
        Route::resource('/kelola-judul-tema-pertanyaan', KelolaJudulTemaPertanyaanController::class);
        Route::resource('/kelola-tingkat-kematangan', KelolaTingkatKematangan::class);

        Route::resource('/kelola-admin', KelolaAdminController::class);

        Route::get('/profil', [SuperadminProfilController::class, 'index'])->name('superadmin.profil');
        Route::post('/profil/perbarui-password', [SuperadminProfilController::class, 'perbaruiPassword'])->name('superadmin.profil.perbarui-password');
    });

    // # PERAN: Admin [ID: 2] #
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');


        Route::get('/profil', [AdminProfilController::class, 'index'])->name('admin.profil');
    });

    Route::prefix('superadmin-admin')->middleware('role:Superadmin,Admin')->group(function () {
        Route::resource('/kelola-responden', KelolaRespondenController::class);
        Route::resource('/kelola-verifikator', KelolaVerifikatorController::class);
        Route::resource('/kelola-manajemen', KelolaManajemenController::class);

        Route::get('/cetak-laporan/{hasilEvaluasi:id}', [CetakLaporanEvaluasiController::class, 'index'])->name('superadminadmin.evaluasi.dashboard.cetak-laporan');
    });

    // # PERAN: Responden [ID: 3] #
    Route::prefix('responden')->middleware('responden')->group(function () {

        Route::get('/dashboard', [RespondenDashboardController::class, 'index'])->name('responden.dashboard');

        Route::get('/redirect-evaluasi', [RedirectEvaluasiController::class, 'index'])->name('responden.redirect-evaluasi');
        Route::prefix('evaluasi')->group(function () {
            Route::get('/pesan-evaluasi', [PesanEvaluasiController::class, 'index'])->name('responden.pesan-evaluasi');

            Route::middleware('kepemilikanHasilEvaluasi')->group(function () {
                Route::get('/pertanyaan/{areaEvaluasi}/{hasilEvaluasi}', [PertanyaanController::class, 'index'])->name('responden.evaluasi.pertanyaan');
                Route::get('/dashboard/{hasilEvaluasi:id}', [EvaluasiDashboardController::class, 'index'])->name('responden.evaluasi.dashboard');

                Route::get('/cetak-laporan/{hasilEvaluasi:id}', [CetakLaporanEvaluasiController::class, 'index'])->name('responden.evaluasi.dashboard.cetak-laporan');
            });

            Route::middleware('aktifEvaluasi')->group(function () {
                Route::resource('/identitas-responden', IdentitasRespondenController::class)
                    ->only(['create', 'store', 'edit', 'update'])
                    ->names('responden.evaluasi.identitas-responden')
                    ->middleware('statusEvaluasiDikerjakan');

                Route::middleware('kepemilikanHasilEvaluasi')->group(function () {
                    Route::middleware('statusEvaluasiDikerjakan')->group(function () {
                        Route::post('/pertanyaan/simpan-jawaban/{areaEvaluasi}/{hasilEvaluasi}', [PertanyaanController::class, 'simpanJawaban'])->name('responden.evaluasi.pertanyaan.simpan-jawaban');
                        Route::post('/dashboard/kirim-evaluasi/{hasilEvaluasi:id}', [EvaluasiDashboardController::class, 'kirimEvaluasi'])->name('responden.evaluasi.dashboard.kirim-evaluasi');
                    });
                });
            });
        });
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('responden.riwayat');
        Route::get('/profil', [RespondenProfilController::class, 'index'])->name('responden.profil');
    });

    // # PERAN: Verifikator [ID: 4] #
    Route::prefix('verifikator')->middleware('verifikator')->group(function () {
        Route::get('/dashboard', [VerifikatorDashboardController::class, 'index'])->name('verifikator.dashboard');

        Route::prefix('kelola-evaluasi')->group(function () {
            Route::get('/perlu-ditinjau', [KelolaEvaluasiController::class, 'perluDitinjau'])->name('verifikator.kelola-evaluasi.perlu-ditinjau');
            Route::get('/sedang-mengerjakan', [KelolaEvaluasiController::class, 'sedangMengerjakan'])->name('verifikator.kelola-evaluasi.sedang-mengerjakan');
            Route::get('/evaluasi-selesai', [KelolaEvaluasiController::class, 'evaluasiSelesai'])->name('verifikator.kelola-evaluasi.evaluasi-selesai');

            // Detail Evaluasi
            Route::prefix('detail-evaluasi')->group(function () {
                Route::get('/pertanyaan/{areaEvaluasi}/{hasilEvaluasi}', [PertanyaanController::class, 'index'])->name('verifikator.evaluasi.pertanyaan');

                Route::middleware('statusEvaluasiDitinjau')->group(function () {
                    Route::post('/pertanyaan/simpan-jawaban/{areaEvaluasi}/{hasilEvaluasi}', [PertanyaanController::class, 'simpanJawaban'])->name('verifikator.evaluasi.pertanyaan.simpan-jawaban');
                    Route::post('verifikasi-evaluasi/{hasilEvaluasi:id}', [EvaluasiDashboardController::class, 'verifikasiEvaluasi'])->name('verifikator.evaluasi.dashboard.verifikasi-evaluasi');
                });

                Route::get('/dashboard/{hasilEvaluasi:id}', [EvaluasiDashboardController::class, 'index'])->name('verifikator.evaluasi.dashboard');

                Route::post('revisi-evaluasi/{hasilEvaluasi:id}', [EvaluasiDashboardController::class, 'revisiEvaluasi'])->name('verifikator.evaluasi.dashboard.revisi-evaluasi');

                Route::get('/cetak-laporan/{hasilEvaluasi:id}', [CetakLaporanEvaluasiController::class, 'index'])->name('verifikator.evaluasi.dashboard.cetak-laporan');
            });
        });

        Route::get('/profil', [VerifikatorProfilController::class, 'index'])->name('verifikator.profil');
    });

    Route::prefix('manajemen')->middleware('manajemen')->group(function () {
        Route::get('/dashboard', [ManajemenDashboardController::class, 'index'])->name('manajemen.dashboard');
        Route::get('/cetak-laporan/{hasilEvaluasi:id}', [CetakLaporanEvaluasiController::class, 'index'])->name('manajemen.evaluasi.dashboard.cetak-laporan');

        Route::get('/profil', [ProfilController::class, 'index'])->name('manajemen.profil');
    });

    // Akses File Evaluasi
    Route::get('/file/{path}', [BukaDokumenController::class, 'index'])->where('path', '.*');
});

Route::get('/evaluasi/{hasilEvaluasi}/export-excel', [CetakLaporanEvaluasiController::class, 'exportExcel']);
