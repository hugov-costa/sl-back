<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class UserResponse extends BaseResponse
{
    public function forbiddenExclusion(): JsonResponse
    {
        return response()->json([
            'detail' => 'You cannot delete your own user.',
            'status' => 403,
            'title' => 'Forbidden',
            'type' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Status/403',
        ], 403);
    }
}
