<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidateCpfCnpj implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            $fail('The :attribute must be a string.');

            return;
        }

        $sanitized = (string) preg_replace('/[^0-9]/', '', $value);

        if (! $this->isValidCpfOrCnpj($sanitized)) {
            $fail('The :attribute must be a valid CPF or CNPJ.');
        }
    }

    /**
     * Check if all digits in the document are the same (invalid CPF/CNPJ).
     */
    private function isRepeatedSequence(string $document): bool
    {
        return count(array_unique(str_split($document))) === 1;
    }

    /**
     * Validate CPF using check digit algorithm.
     */
    private function isValidCpf(string $cpf): bool
    {
        if (strlen($cpf) !== 11 || ! ctype_digit($cpf)) {
            return false;
        }

        if ($this->isRepeatedSequence($cpf)) {
            return false;
        }

        $sum = 0;
        $multiplier = 10;

        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $cpf[$i] * $multiplier;
            $multiplier--;
        }

        $remainder = $sum % 11;
        $firstCheckDigit = $remainder < 2 ? 0 : 11 - $remainder;

        if ((int) $cpf[9] !== $firstCheckDigit) {
            return false;
        }

        $sum = 0;
        $multiplier = 11;

        for ($i = 0; $i < 10; $i++) {
            $sum += (int) $cpf[$i] * $multiplier;
            $multiplier--;
        }

        $remainder = $sum % 11;
        $secondCheckDigit = $remainder < 2 ? 0 : 11 - $remainder;

        return (int) $cpf[10] === $secondCheckDigit;
    }

    /**
     * Validate CPF or CNPJ based on length.
     */
    private function isValidCpfOrCnpj(string $document): bool
    {
        if (strlen($document) === 11) {
            return $this->isValidCpf($document);
        } elseif (strlen($document) === 14) {
            return $this->isValidCnpj($document);
        }

        return false;
    }

    /**
     * Validate CNPJ using check digit algorithm.
     */
    private function isValidCnpj(string $cnpj): bool
    {
        if (strlen($cnpj) !== 14 || ! ctype_digit($cnpj)) {
            return false;
        }

        if ($this->isRepeatedSequence($cnpj)) {
            return false;
        }

        $weights = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        for ($i = 0; $i < 12; $i++) {
            $sum += (int) $cnpj[$i] * $weights[$i];
        }

        $remainder = $sum % 11;
        $firstCheckDigit = $remainder < 2 ? 0 : 11 - $remainder;

        if ((int) $cnpj[12] !== $firstCheckDigit) {
            return false;
        }

        $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;

        for ($i = 0; $i < 12; $i++) {
            $sum += (int) $cnpj[$i] * $weights[$i];
        }

        $sum += $firstCheckDigit * $weights[12];
        $remainder = $sum % 11;
        $secondCheckDigit = $remainder < 2 ? 0 : 11 - $remainder;

        return (int) $cnpj[13] === $secondCheckDigit;
    }
}
