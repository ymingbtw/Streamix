<?php

use App\Http\Middleware\authorize;
use App\Http\Middleware\cors;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->append([]);
        $middleware->group('web', []);
        $middleware->group('api', []);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
