<?php

namespace App\Responses;

use App\Helpers\AccessTokenHelper;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthResponse extends BaseResponse
{
    public function alreadyLoggedIn(): JsonResponse
    {
        return response()->json([
            'detail' => 'User already logged in.',
            'status' => 409,
            'title' => 'Conflict',
            'type' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/409',
        ], 409);
    }

    public function logout(): JsonResponse
    {
        return response()->json([
            'message' => 'Successfully logged out.',
        ], 200)->cookie(
            AccessTokenHelper::destroyHttpOnlySecureCookie()
        );
    }

    public function success(string $token, User $user): JsonResponse
    {
        return response()->json([
            'message' => 'Token successfully issued.',
            'user' => $user,
        ], 200)->cookie(
            AccessTokenHelper::issueHttpOnlySecureCookie($token)
        );
    }

    public function unauthorized(): JsonResponse
    {
        return response()->json([
            'detail' => 'Unauthorized access.',
            'status' => 401,
            'title' => 'Unauthorized',
            'type' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/401',
        ], 401);
    }

    public function userIsAuthenticated(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'User is authenticated.',
            'user' => $user,
        ], 200);
    }

    public function userNotFoundAfterAuthentication(): JsonResponse
    {
        return response()->json([
            'detail' => 'User not found after authentication.',
            'status' => 404,
            'title' => 'Not Found',
            'type' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/404',
        ], 404);
    }
}
