<?php

namespace App\Rules;

use App\Services\PlayerValidationService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPlayerData implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validationService = app(PlayerValidationService::class);

        switch ($attribute) {
            case 'name':
                $errors = $validationService->isValidCharacterName($value);
                if (! empty($errors)) {
                    $fail($errors[0]); // Return the first error
                }
                break;

            case 'sex':
                if (! $validationService->isValidSex($value)) {
                    $fail(__('The selected sex is invalid.'));
                }
                break;

            case 'vocation':
                if (! $validationService->isValidVocation($value)) {
                    $fail($validationService->getVocationErrorMessage($value));
                }
                break;

            case 'town_id':
                if (! $validationService->isValidTown($value)) {
                    $fail($validationService->getTownErrorMessage($value));
                }
                break;
        }
    }
}
