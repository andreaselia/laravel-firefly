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
        $value = preg_replace('/#+/', '#', $value);
        $value = ltrim($value, '#');

        return ctype_xdigit($value) && (strlen($value) == 6 || strlen($value) == 3);
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
