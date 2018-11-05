<?php

namespace Firefly\Rules;

use Illuminate\Contracts\Validation\Rule;

class Hex implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $hash_count = substr_count($value, '#');
        $value = ltrim($value, '#');

        return $hash_count == 1 && ctype_xdigit($value) && (strlen($value) == 6 || strlen($value) == 3);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid hex code.';
    }
}
