<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateJsonApiAccept
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedMediaType = config('jsonapi.media_type');
        $acceptHeader = $request->header('Accept');
        $allowedExtensions = config('jsonapi.extensions', []);

        if (!$acceptHeader) {
            return $this->addVaryHeader($next($request));
        }

        $mediaTypes = array_map('trim', explode(',', $acceptHeader));

        $hasJsonApi = false;
        $hasValidJsonApi = false;

        foreach ($mediaTypes as $mediaType) {

            if (!str_starts_with($mediaType, $allowedMediaType)) {
                continue;
            }

            $hasJsonApi = true;

            [$type, $params] = $this->parseMediaType($mediaType);

            if ($this->hasInvalidParams($params)) {
                continue;
            }

            if (isset($params['ext'])) {
                $exts = explode(' ', trim($params['ext'], '"'));

                $supported = array_intersect($exts, $allowedExtensions);

                if (empty($supported)) {
                    continue;
                }
            }

            $hasValidJsonApi = true;
            break;
        }

        if ($hasJsonApi && !$hasValidJsonApi) {
            return response()->json([
                'errors' => [[
                    'status' => Response::HTTP_NOT_ACCEPTABLE,
                    'title' => __('api.406.title'),
                    'detail' => __('api.406.detail')
                ]]
            ], Response::HTTP_NOT_ACCEPTABLE, [
                'Content-Type' => $allowedMediaType,
                'Vary' => 'Accept',
            ]);
        }

        return $this->addVaryHeader($next($request));
    }

    private function parseMediaType(string $mediaType): array
    {
        $parts = array_map('trim', explode(';', $mediaType));
        $type = array_shift($parts);

        $params = [];

        foreach ($parts as $param) {
            if ($param === '') continue;

            [$key, $value] = array_pad(explode('=', $param, 2), 2, null);

            if ($key !== null) {
                $params[strtolower($key)] = $value;
            }
        }

        return [$type, $params];
    }

    private function hasInvalidParams(array $params): bool
    {
        foreach ($params as $key => $value) {
            if (!in_array($key, ['ext', 'profile'])) {
                return true;
            }
        }

        return false;
    }

    private function addVaryHeader(Response $response): Response
    {
        $response->headers->set('Vary', 'Accept');
        return $response;
    }
}
