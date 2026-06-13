<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Cookie;

class AccessTokenHelper
{
    public static function destroyHttpOnlySecureCookie(): Cookie
    {
        /** @var string|null */
        $domain = config('session.domain');

        /** @var bool|null */
        $secure = config('session.secure', true);

        /** @var string|null */
        $sameSite = config('session.same_site', 'lax');

        return cookie(
            'access_token',
            '',
            -1,
            '/',
            $domain,
            $secure,
            true,
            false,
            $sameSite
        );
    }

    public static function issueHttpOnlySecureCookie(
        string $token,
        ?int $minutes = null
    ): Cookie {
        $minutes = $minutes ?? config('sanctum.expiration', 60 * 24 * 30);

        if (! is_scalar($minutes) && $minutes !== null) {
            $minutes = 60 * 24 * 30;
        }

        $minutes = intval($minutes);

        /** @var string|null */
        $domain = config('session.domain');

        /** @var bool|null */
        $secure = config('session.secure', true);

        /** @var string|null */
        $sameSite = config('session.same_site', 'lax');

        return cookie(
            'access_token',
            $token,
            $minutes,
            '/',
            $domain,
            $secure,
            true,
            false,
            $sameSite
        );
    }
}
