<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait ApiResponse
 *
 * Provides standardized JSON:API (v1.1) compliant responses
 *
 * @see https://jsonapi.org/format/
 */
trait ApiResponse
{
    /**
     * Return an unauthorized JSON:API response.
     */
    protected function unauthorized(?string $message = null): JsonResponse
    {
        return $this->error([[
            'status' => Response::HTTP_UNAUTHORIZED,
            'title' => __('api.401.title'),
            'detail' => $message ?: __('api.401.message'),
        ]]);
    }

    /**
     * Return a successful JSON:API response.
     */
    protected function success(
        mixed $data,
        int $status = Response::HTTP_OK,
        ?array $links = null,
    ): JsonResponse {
        $response = [
            'data' => $data
        ];

        if ($links) {
            $response['links'] = $links;
        }

        return response()->json($response, $status);
    }

    /**
     * Return a JSON:API compliant error response.
     */
    public function error(array $errors): JsonResponse
    {
        $status = (int) ($errors[0]['status'] ?? 500);

        return response()->json([
            'errors'  => array_map(fn($error) => [
                'status' => (string) $error['status'],
                'title'  => $error['title'],
                'detail' => $error['detail'] ?? null
            ], $errors),
        ], $status);
    }
}
