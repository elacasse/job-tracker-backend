<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

// Catch root requests and return a JSON message
Route::get('/', function (): JsonResponse {
    return response()->json([
        'name' => config('app.name', 'Job Tracker API'),
        'version' => 'v1',
        'status' => 'ok'
    ]);
});

