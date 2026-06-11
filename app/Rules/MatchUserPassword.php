<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Translation\PotentiallyTranslatedString;

class MatchUserPassword implements ValidationRule
{
    protected ?User $user;

    public function __construct(mixed $email)
    {
        $this->user = User::where('email', $email)->first();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isValidPassword = $this->user && is_string($value) && is_string($this->user->password) && Hash::check($value, $this->user->password);

        if (! $isValidPassword) {
            $fail(__('auth.failed'));
        }
    }
}
