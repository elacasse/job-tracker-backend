<?php

use App\Http\Middleware\AuthenticateApplication;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 🔐 Always require a valid application token
        $middleware->prepend(AuthenticateApplication::class);

        // CORS must run first so preflight OPTIONS requests are handled
        $middleware->prepend(HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
//        // Always render JSON (API-only backend)
//        $exceptions->shouldRenderJsonWhen(fn() => true);

        $exceptions->dontReport(
            \LaravelJsonApi\Core\Exceptions\JsonApiException::class,
        );

        $exceptions->render(
            \LaravelJsonApi\Exceptions\ExceptionParser::renderer(),
        );

//        // 401 - no / invalid Bearer token
//        $exceptions->render(function (AuthenticationException $e, Request $request) {
//            return response()->json([
//                'errors' => [
//                    [
//                        'status' => '401',
//                        'title' => 'Unauthenticated',
//                        'detail' => 'Authentication is required to access this resource.',
//                    ]
//                ],
//            ], 401);
//        });

//        // 403 - user authenticated but not allowed
//        $exceptions->render(function (AuthorizationException $e, Request $request) {
//            return response()->json([
//                'errors' => [
//                    [
//                        'status' => '403',
//                        'title' => 'Forbidden',
//                        'detail' => $e->getMessage() ?: 'You do not have permission to access this resource.',
//                    ]
//                ],
//            ], 403);
//        });
//
//        // 404 - missing model or route
//        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e, Request $request) {
//            return response()->json([
//                'errors' => [
//                    [
//                        'status' => '404',
//                        'title' => 'NotFound',
//                        'detail' => 'The requested resource could not be found.',
//                    ]
//                ],
//            ], 404);
//        });
//
//        // 422 - validation errors
//        $exceptions->render(function (ValidationException $e, Request $request) {
//            return response()->json([
//                'errors' => collect($e->errors())->flatMap(function ($messages, $field) {
//                    return collect($messages)->map(fn($message) => [
//                        'status' => '422',
//                        'title' => 'ValidationError',
//                        'detail' => $message,
//                        'source' => ['pointer' => $field],
//                    ]);
//                })->values(),
//            ], 422);
//        });
//
//        // 500 - anything else
//        $exceptions->render(function (Throwable $e, Request $request) {
//            return response()->json([
//                'errors' => [
//                    [
//                        'status' => '500',
//                        'title' => class_basename($e),
//                        'detail' => $e->getMessage(),
//                    ]
//                ],
//            ], 500);
//        });
    })
    ->create();
