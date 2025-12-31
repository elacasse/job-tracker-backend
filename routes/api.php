<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TestController;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

Route::get('/v1/test', TestController::class);

// App must be valid, user not yet authenticated
Route::post('/v1/login', [AuthController::class, 'login']);

// App must be valid AND user must be authenticated via Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/v1/me', [AuthController::class, 'me']);
    Route::post('/v1/logout', [AuthController::class, 'logout']);

    JsonApiRoute::server('v1')->prefix('v1')->resources(function (ResourceRegistrar $server) {
        $server->resource('postings', JsonApiController::class)->readOnly();
    });
});
