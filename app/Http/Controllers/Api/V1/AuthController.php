<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use LaravelJsonApi\Core\Responses\DataResponse;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        /** @var User|null $user */
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'errors' => [
                    [
                        'status' => '401',
                        'title' => 'InvalidCredentials',
                        'detail' => 'Email or password is incorrect.',
                    ]
                ],
            ], 401);
        }

        // Issue Sanctum token (personal access token)
        $token = $user->createToken('frontend')->plainTextToken;

        return response()->json([
            'data' => [
                'type' => 'token',
                'id' => (string)$user->id,
                'attributes' => [
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var User|null $user */
        $user = $request->user();

        $token = $user?->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return response()->json([
            'data' => [
                'type' => 'logout',
                'id' => $user ? (string)$user->id : null,
                'attributes' => [
                    'message' => 'Logged out.',
                ],
            ],
        ]);
    }

    public function me(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return DataResponse::make($user)->withServer('v1');
    }
}
