<?php

declare (strict_types = 1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaSpaces implements Rule
{
    public function passes($attribute, $value): bool
    {
        return (bool) preg_match('/(^[A-Za-z0-9 -]+$)+/', $value);
    }

    public function message(): string
    {
        return 'Field :attribute may only contains letters, digits and spaces';
    }
}
