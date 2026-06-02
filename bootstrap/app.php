<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Daftarkan alias middleware untuk IsAdmin dan IsPelanggan agar bisa digunakan di route dengan nama 'admin' dan 'pelanggan'
        $middleware->alias([
            'admin' => App\Http\Middleware\IsAdmin::class,
            'pelanggan' => App\Http\Middleware\IsPelanggan::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
