<?php

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
            'akunAktif' => App\Http\Middleware\AkunAktifMiddleware::class,
            // Role
            'role' => App\Http\Middleware\RoleMiddleware::class,
            // Super Admin
            'superadmin' => App\Http\Middleware\SuperadminMiddleware::class,
            // Admin
            'admin' => App\Http\Middleware\Admin\AdminMiddleware::class,
            'sesiAreaEvaluasiId' => App\Http\Middleware\Admin\SesiAreaEvaluasiIdMiddleware::class,
            // Verifikator
            'verifikator' => App\Http\Middleware\VerifikatorMiddleware::class,
            // Responden
            'responden' => App\Http\Middleware\Responden\RespondenMiddleware::class,
            'aktifEvaluasi' => App\Http\Middleware\Responden\AktifEvaluasiMiddleware::class,
            'kepemilikanHasilEvaluasi' =>  App\Http\Middleware\Responden\KepemilikanHasilEvaluasiMiddleware::class,
            'mengerjakanEvaluasi' => App\Http\Middleware\Responden\MengerjakanEvaluasiMiddleware::class,
            'statusEvaluasiDikerjakan' => App\Http\Middleware\Evaluasi\StatusEvaluasiDikerjakanMiddleware::class,
            'statusEvaluasiDitinjau' => App\Http\Middleware\Evaluasi\StatusEvaluasiDitinjauMiddleware::class,
            // Manajemen
            'manajemen' => App\Http\Middleware\ManajemenMiddleware::class,
            // Kostum
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
