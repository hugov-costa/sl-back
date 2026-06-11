<?php

namespace App\Helpers;

use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordHelper
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function applyUpdatedPassword(array $data): array
    {
        if (isset($data['updated_password']) && isset($data['updated_password_confirmation'])) {
            $data['password'] = $data['updated_password'];
            unset($data['updated_password']);
            unset($data['updated_password_confirmation']);
        }

        return $data;
    }
}
