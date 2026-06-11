<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateFromCookie
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (! $request->bearerToken() && $request->cookie('access_token')) {
            $token = $request->cookie('access_token');

            if (is_string($token)) {
                $request->headers->set('Authorization', "Bearer {$token}");
            }
        }

        return $next($request);
    }
}
