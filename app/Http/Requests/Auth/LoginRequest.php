<?php

namespace App\Http\Requests\Auth;

use App\Helpers\EmailHelper;
use App\Models\User;
use App\Responses\AuthResponse;
use App\Rules\MatchUserPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * @property-read User $user
 */
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        $token = $this->cookie('access_token');

        if (! $token) {
            return true;
        }

        if (! is_string($token)) {
            return true;
        }

        $tokenModel = PersonalAccessToken::findToken($token);

        if ($tokenModel && $tokenModel->tokenable instanceof User) {
            $response = new AuthResponse;
            throw new HttpResponseException($response->alreadyLoggedIn());
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * User email address to authenticate with.
             *
             * @example user@email.com
             */
            'email' => EmailHelper::rules(),

            /**
             * User password for authentication.
             *
             * @example Passw0rd!
             */
            'password' => [
                'max:255',
                'required',
                'string',
                new MatchUserPassword($this->email),
            ],
        ];
    }
}
