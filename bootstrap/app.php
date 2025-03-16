<?php

use App\Http\Middleware\Admin\AdminMiddleware;
use App\Http\Middleware\Responden\BelumEvaluasiMiddleware;
use App\Http\Middleware\Responden\MengerjakanEvaluasiMiddleware;
use App\Http\Middleware\Responden\RespondenMiddleware;
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
            // Admin
            'admin' => AdminMiddleware::class,
            // Verifikator
            // Responden
            'responden' => RespondenMiddleware::class,
            'belumEvaluasi' => BelumEvaluasiMiddleware::class,
            'mengerjakanEvaluasi' => MengerjakanEvaluasiMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
