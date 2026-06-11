<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * User email address.
             *
             * @example user@email.com
             */
            'email' => [
                'email',
                'max:255',
                'required',
                'string',
                Rule::unique('users'),
            ],

            /**
             * Full user name. Letters and spaces only.
             *
             * @example João Silva
             */
            'name' => [
                'max:255',
                'min:3',
                'regex:/^[\pL ]+$/u',
                'required',
                'string',
            ],

            /**
             * User password (confirmed). Password must be at least 8 characters, contain at least one uppercase letter, one lowercase letter, one digit, and one special character.
             *
             * @example Passw0rd!
             */
            'password' => [
                'confirmed',
                'required',
                'string',
                Password::min(8)
                    ->max(255)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }
}
