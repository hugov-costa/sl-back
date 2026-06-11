<?php

namespace App\Helpers;

class EmailHelper
{
    /**
     * @return array<int, string>
     */
    public static function rules(): array
    {
        return [
            'email',
            'max:255',
            'required',
            'string',
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function applyUpdatedEmail(array $data): array
    {
        if (isset($data['updated_email'])) {
            $data['email'] = $data['updated_email'];
            unset($data['updated_email']);
        }

        return $data;
    }
}
