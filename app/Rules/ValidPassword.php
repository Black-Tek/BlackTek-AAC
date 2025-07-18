<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class ValidPassword implements ValidationRule
{
    public function validate(string $attribute, mixed $value, $fail): void
    {
        if (! preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $value)) {
            $fail('The :attribute must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
        }
    }
}
