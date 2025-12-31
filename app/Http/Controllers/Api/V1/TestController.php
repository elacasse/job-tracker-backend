<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $app = $request->attributes->get('application');

        return response()->json([
            'data' => [
                'type' => 'test',
                'id' => $app->id,
                'attributes' => [
                    'application_name' => $app->name,
                    'message' => 'Application token is valid.',
                ],
            ]
        ]);
    }
}
