<?php

use App\Http\Middleware\EditProfileMiddleware;
use App\Http\Middleware\RequestMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\UserActivity;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            // ... other middleware
            UserActivity::class,
        ]);

        $middleware->trustProxies(at: 
        ['68.183.225.118']);

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'request' => RequestMiddleware::class,
            'edit' => EditProfileMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
