<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ValidateTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * New password token string used to validate the request. Required.
             *
             * @example abcdef123456
             */
            'token' => [
                'min:12',
                'max:1000',
                'required',
                'string',
            ],
        ];
    }
}
