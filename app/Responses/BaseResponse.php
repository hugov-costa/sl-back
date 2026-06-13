<?php

namespace App\Responses;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class BaseResponse
{
    public function destroy(): JsonResponse
    {
        return response()->json([
            'data' => 'Resource successfully deleted.',
        ], 200);
    }

    public function error(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $statusCode);
    }

    public function index(Collection $data): JsonResponse
    {
        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function notFound(): JsonResponse
    {
        return response()->json([
            'detail' => 'Resource not found.',
            'status' => 404,
            'title' => 'Not Found',
            'type' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/404',
        ], 404);
    }

    public function show(Model $data): JsonResponse
    {
        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function store(): JsonResponse
    {
        return response()->json([
            'message' => 'Resource successfully created.',
        ], 201);
    }

    public function unexpectedError(string $error): JsonResponse
    {
        return response()->json([
            'detail' => $error,
            'status' => 500,
            'title' => 'Internal Server Error',
            'type' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/500',
        ], 500);
    }

    public function update(): JsonResponse
    {
        return response()->json([
            'message' => 'Resource successfully updated.',
        ], 200);
    }
}
