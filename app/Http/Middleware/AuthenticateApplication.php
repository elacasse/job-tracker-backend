<?php

namespace App\Http\Middleware;

use App\Models\Application;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApplication
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Read application token from custom header
        $token = $request->header('X-App-Token');

        if (!$token) {
            return $this->unauthorized();
        }

        // 2) Validate the token against stored application hashes
        $app = Application::all()->first(function (Application $app) use ($token) {
            return Hash::check($token, $app->token_hash);
        });

        if (!$app) {
            return $this->unauthorized();
        }

        // 3) Attach the authenticated application to the request
        $request->attributes->set('application', $app);

        // 4) Continue the pipeline
        return $next($request);
    }

    private function unauthorized(): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'status' => '401',
                    'title' => 'InvalidApplicationToken',
                    'detail' => 'A valid application token is required to access this API.',
                ]
            ]
        ], 401);
    }
}
