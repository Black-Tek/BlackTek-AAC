<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidTown implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validationService = app('player.validation');

        if (! $validationService->isValidTown($value)) {
            $fail($validationService->getTownErrorMessage($value));
        }
    }
}
