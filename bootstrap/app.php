<?php

use App\Http\Middleware\ValidateJsonApiAccept;
use App\Http\Middleware\ValidateJsonApiMediaType;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function (Application $app): void {
            Route::middleware(['api', 'media_type', 'accept'])
                ->prefix('api/v1')
                ->group(base_path('routes/api_v1.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'media_type' => ValidateJsonApiMediaType::class,
            'accept' => ValidateJsonApiAccept::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            foreach ($exception->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $errors[] = [
                        'status' => 422,
                        'title' => __('api.unprocessable_content.title'),
                        'detail' => $message,
                        'source' => ['pointer' => '/' . str_replace('.', '/', $field)]
                    ];
                }
            }

            return response()->json([
                'jsonapi' => ['version' => config('jsonapi.version')],
                'errors' => $errors
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            return response()->json([
                'jsonapi' => ['version' => config('jsonapi.version')],
                'errors' => [[
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'title' => __('api.unauthenticated.title'),
                    'detail' => __('api.unauthenticated.detail'),
                ]]
            ], Response::HTTP_UNAUTHORIZED);
        });
    })->create();
