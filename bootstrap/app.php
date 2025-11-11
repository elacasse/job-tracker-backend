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
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Always return JSON for API or JSON requests
        $exceptions->render(function (Throwable $e, $request) {
            // Always force JSON, regardless of path or headers
            $status = method_exists($e, 'getStatusCode')
                ? $e->getStatusCode()
                : 500;

            return response()->json([
                'errors' => [[
                    'status' => (string) $status,
                    'title'  => class_basename($e),
                    'detail' => $e->getMessage() ?: 'An unexpected error occurred.',
                ]]
            ], $status);
        });
    })->create();
