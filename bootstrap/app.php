<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware kustom (dulunya di App\Http\Kernel::$routeMiddleware).
        $middleware->alias([
            'admin' => IsAdmin::class,
        ]);

        // Pengganti Authenticate::redirectTo() dan RedirectIfAuthenticated.
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo('/dashboard');

        // Dulunya 'throttle:api' ada di grup middleware 'api'.
        $middleware->throttleApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
