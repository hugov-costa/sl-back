<?php

namespace App\Helpers;

class DateHelper
{
    public static function normalizeDateInput(mixed $val): string|int|float|\DateTimeInterface|null
    {
        if ($val instanceof \DateTimeInterface) {
            return $val;
        }

        if (is_string($val) || is_int($val) || is_float($val)) {
            return $val;
        }

        return null;
    }
}
