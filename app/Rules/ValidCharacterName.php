<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class ValidCharacterName implements ValidationRule
{
    public function validate(string $attribute, mixed $value, $fail): void
    {
        if (strlen($value) < 4) {
            $fail('The name must be at least 4 characters.');
        }

        if (strlen($value) > 29) {
            $fail('The name must be at most 29 characters.');
        }

        if (! ctype_upper($value[0])) {
            $fail('The first letter of a name has to be a capital letter.');
        }

        if (! preg_match('/^[a-zA-Z ]+$/', $value)) {
            $fail('This name contains invalid letters. Please use only A-Z, a-z, and space.');
        }

        if (preg_match('/\s{2,}/', $value)) {
            $fail('This name contains more than one space between words. Please use only one space between words.');
        }

        if (! preg_match('/[aeiou]/i', $value)) {
            $fail('This name contains a word without vowels. Please choose another name.');
        }

        $words = explode(' ', $value);
        foreach ($words as $word) {
            if (strlen($word) > 14) {
                $fail('This name contains a word that is too long. Please use no more than 14 letters for each word.');
            }

            if (strlen($word) < 2) {
                $fail('This name contains a word that is too short. Please use at least 2 letters for each word.');
            }

            if (in_array(strtolower($word), config('blacktek.characters.new.blocked_words'))) {
                $fail('This name cannot be used because it contains a forbidden word or combination of letters. Please choose another name!.');
            }

            if (! preg_match('/[aeiou]/i', $word)) {
                $fail('This name contains a word without vowels. Please choose another name.');
            }
        }

        if (in_array(strtolower($value), config('blacktek.characters.new.blocked_words'))) {
            $fail('This name cannot be used because it contains a forbidden word or combination of letters. Please choose another name!.');
        }
    }
}
