<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    /**
     * Check if the user is authenticated
     */
    public function me(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    /**
     * Authenticate a user and issue a personal access token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->credentials())) {
            return $this->error([[
                'status' => Response::HTTP_UNAUTHORIZED,
                'title' => __('api.unauthorized.title'),
                'detail' => __('api.unauthorized.detail')
            ]]);
        }

        $token = $request->user()->createToken('api');

        return $this->success(
            data: [
                'type' => 'tokens',
                'id' => (string) $token->accessToken->id,
                'attributes' => [
                    'token' => $token->plainTextToken,
                ]
            ],
            links: [
                'self' => $request->url()
            ]
        );
    }

    /**
     * Log out the authenticated user.
     */
    public function logout(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }

    /**
     * Log out the user from all devices (revoke all tokens).
     */
    public function logoutAll(Request $request): Response
    {
        $request->user()->tokens()->delete();

        return response()->noContent();
    }
}
