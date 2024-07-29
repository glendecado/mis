<?php

use App\Http\Middleware\Auth;
use App\Http\Middleware\Mis;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:
        [
        __DIR__ . '/../routes/web.php',
        __DIR__ . '/../routes/cache.php',
        ], 
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'Auth' => Auth::class,
            'Mis' => Mis::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
