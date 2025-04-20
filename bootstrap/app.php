<?php

use App\Http\Middleware\Admin\AdminMiddleware;
use App\Http\Middleware\Admin\SesiAreaEvaluasiIdMiddleware;
use App\Http\Middleware\Admin\SesiAreaEvaluasiMiddleware;
use App\Http\Middleware\AdminVerifikatorMiddleware;
use App\Http\Middleware\AkunAktifMiddleware;
use App\Http\Middleware\Responden\AktifEvaluasiMiddleware;
use App\Http\Middleware\Responden\BelumEvaluasiMiddleware;
use App\Http\Middleware\Responden\KepemilikanHasilEvaluasiMiddleware;
use App\Http\Middleware\Responden\MengerjakanEvaluasiMiddleware;
use App\Http\Middleware\Responden\RespondenMiddleware;
use App\Http\Middleware\Verifikator\VerifikatorMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'akunAktif' => AkunAktifMiddleware::class,
            // Admin
            'admin' => AdminMiddleware::class,
            'sesiAreaEvaluasiId' => SesiAreaEvaluasiIdMiddleware::class,
            // Verifikator
            'verifikator' => VerifikatorMiddleware::class,
            // Responden
            'responden' => RespondenMiddleware::class,
            'aktifEvaluasi' => AktifEvaluasiMiddleware::class,
            'belumEvaluasi' => BelumEvaluasiMiddleware::class,
            'kepemilikanHasilEvaluasi' => KepemilikanHasilEvaluasiMiddleware::class,
            'mengerjakanEvaluasi' => MengerjakanEvaluasiMiddleware::class,
            // Pemantau
            // Costum
            'adminVerifikator' => AdminVerifikatorMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
