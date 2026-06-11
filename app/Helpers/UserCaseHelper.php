<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class UserCaseHelper
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function formatData(array $data): array
    {
        $data['name'] = is_string($data['name']) ? Str::title($data['name']) : $data['name'];
        $data['email'] = is_string($data['email']) ? Str::lower($data['email']) : $data['email'];

        return $data;
    }
}
