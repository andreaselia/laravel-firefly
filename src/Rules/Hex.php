<?php

namespace Firefly\Rules;

use Illuminate\Contracts\Validation\Rule;

class Hex implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        $hash_count = substr_count($value, '#');
        $value = ltrim($value, '#');

        return $hash_count == 1 && ctype_xdigit($value) && (strlen($value) == 6 || strlen($value) == 3);
    }

    public function message(): string
    {
        return 'The :attribute must be a valid hex code.';
    }
}
