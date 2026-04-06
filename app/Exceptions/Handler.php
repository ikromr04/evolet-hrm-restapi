<?php

namespace App\Exceptions;

use App\Traits\ApiResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponses;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $handlers = [
        ValidationException::class => 'handleValidation',
        AuthenticationException::class => 'handleAuthentication',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        $className = get_class($exception);

        if (array_key_exists($className, $this->handlers)) {
            $method = $this->handlers[$className];

            return $this->$method($exception);
        }

        $index = strrpos($className, '\\');

        return $this->error([[
            'status' => 200,
            'title' => $exception->getMessage(),
            'detail' => substr($className, $index + 1),
        ]]);
    }

    private function handleValidation(ValidationException $exception)
    {
        $errors = [];
        foreach ($exception->errors() as $field => $messages)
            foreach ($messages as $message) {
                $errors[] = [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'title' => __('api.422.title'),
                    'detail' => $message,
                    'source' => ['pointer' => '/' . str_replace('.', '/', $field)],
                ];
            }

        return $this->error($errors);
    }

    private function handleAuthentication(AuthenticationException $exception)
    {
        return $this->error([[
            'status' => Response::HTTP_UNAUTHORIZED,
            'title' => __('api.401.title'),
            'detail' => __('api.401.detail'),
        ]]);
    }
}
