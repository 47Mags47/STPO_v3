<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\CurrentDivisionMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Access\AuthorizationException;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Inertia\Inertia;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__.'/../routes/channels.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class
        ]);

        $middleware->alias([
            'current.division' => CurrentDivisionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, $request) {
            // 403
            if (
                $e instanceof AuthorizationException ||
                ($e instanceof HttpException && $e->getStatusCode() === 403)
            ) {
                return Inertia::render('httpErrors/403')
                    ->toResponse($request)
                    ->setStatusCode(403);
            }

            return null;
        });
    })->create();
