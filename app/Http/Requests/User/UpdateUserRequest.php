<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Rules\MatchUserPassword;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * @property-read User $user
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * User email address to update to.
             *
             * @example user@email.com
             */
            'email' => [
                'email',
                'max:255',
                'string',
            ],

            /**
             * Full user name. Letters and spaces only.
             *
             * @example Maria Oliveira
             */
            'name' => [
                'max:255',
                'min:3',
                'nullable',
                'regex:/^[\pL ]+$/u',
                'string',
            ],

            /**
             * Current password required when changing email (used for verification).
             *
             * @example Passw0rd!
             */
            'password' => [
                'required_with:email',
                'string',
                new MatchUserPassword($this->email),
            ],

            /**
             * New email to replace current one.
             *
             * @example new.email@email.com
             */
            'updated_email' => [
                'different:email',
                'email',
                'max:255',
                'nullable',
                'string',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],

            /**
             * New password (confirmed). Password must be at least 8 characters, contain at least one uppercase letter, one lowercase letter, one digit, and one special character.
             *
             * @example NewPassw0rd!
             */
            'updated_password' => [
                'confirmed',
                'different:password',
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
