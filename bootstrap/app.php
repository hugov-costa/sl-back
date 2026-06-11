<?php

use App\Http\Middleware\AuthenticateFromCookie;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            AuthenticateFromCookie::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (MethodNotAllowedHttpException $e) {
            return response()->json([
                'detail' => 'The HTTP method used is not allowed for this route.',
                'status' => 405,
                'title' => 'Method Not Allowed',
                'type' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/405',
            ], 405);
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return response()->json([
                    'detail' => 'The requested resource was not found.',
                    'status' => 404,
                    'title' => 'Not Found',
                    'type' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/404',
                ], 404);
            }

            return response()->json([
                'detail' => 'The requested route was not found.',
                'status' => 404,
                'title' => 'Not Found',
                'type' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/404',
            ], 404);
        });
    })->create();
