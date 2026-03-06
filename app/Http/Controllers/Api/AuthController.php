<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    /**
     * Check if the user is authenticated
     */
    public function check(): UserResource
    {
        $user = Auth::user()->makeHidden([
            'email_verified_at',
            'created_at',
            'updated_at'
        ]);

        return new UserResource($user);
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

        $token = Auth::user()->createToken('api:default');

        return $this->success(
            data: [
                'type' => 'tokens',
                'id' => (string) $token->accessToken->id,
                'attributes' => [
                    'token' => $token->plainTextToken,
                    'userId' => (string) $token->accessToken->tokenable_id
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
    public function logout(): Response
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
