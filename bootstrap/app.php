<?php

use App\Http\Responses\BasicResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Src\V1\Infrastructure\Middlewares\B3PropagationMiddleware;
use Src\V1\Infrastructure\Middlewares\BearerTokenMiddleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => BearerTokenMiddleware::class,
        ]);
        $middleware->group('api', [
            B3PropagationMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (MethodNotAllowedHttpException $e) {
            return new BasicResponse(404, [], 'Not Found');
        });
    })->create();
