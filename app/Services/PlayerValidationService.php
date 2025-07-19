<?php

namespace App\Services;

use App\Models\Town;

class PlayerValidationService
{
    /**
     * Get available vocations for new players
     */
    public function getAvailableVocations(): array
    {
        $availableVocations = app('vocations')->getVocations();
        $allowedVocations = config('blacktek.characters.new.vocations');

        return collect($availableVocations)
            ->filter(fn ($vocation) => in_array($vocation->name, $allowedVocations))
            ->map(fn ($vocation) => ['id' => $vocation->id, 'name' => $vocation->name])
            ->toArray();
    }

    /**
     * Get available towns for new players
     */
    public function getAvailableTowns(): array
    {
        $availableTowns = Town::get();
        $allowedTowns = config('blacktek.characters.new.towns');

        return collect($availableTowns)
            ->filter(fn ($town) => in_array($town->name, $allowedTowns))
            ->map(fn ($town) => ['id' => $town->id, 'name' => $town->name])
            ->toArray();
    }

    /**
     * Get available sexes for new players
     */
    public function getAvailableSexes(): array
    {
        $allowedSexes = config('blacktek.characters.new.sex');

        return collect($allowedSexes)
            ->map(fn ($name, $id) => ['id' => (int) $id, 'name' => $name])
            ->toArray();
    }

    /**
     * Validate if a vocation is available for new players
     */
    public function isValidVocation(int $vocationId): bool
    {
        $vocations = app('vocations')->getVocations();
        $allowedVocations = config('blacktek.characters.new.vocations');

        return isset($vocations[$vocationId]) &&
            in_array($vocations[$vocationId]->name, $allowedVocations);
    }

    /**
     * Validate if a town is available for new players
     */
    public function isValidTown(int $townId): bool
    {
        return array_key_exists($townId, config('blacktek.characters.new.towns'));
    }

    /**
     * Validate if a sex is available for new players
     */
    public function isValidSex(int $sex): bool
    {
        return array_key_exists($sex, config('blacktek.characters.new.sex'));
    }

    /**
     * Get validation error message for vocation
     */
    public function getVocationErrorMessage(int $vocationId): string
    {
        $vocations = app('vocations')->getVocations();

        return isset($vocations[$vocationId])
            ? __('The selected vocation is not available for new characters.')
            : __('The selected vocation is invalid.');
    }

    /**
     * Get validation error message for town
     */
    public function getTownErrorMessage(int $townId): string
    {
        return __('The selected town is not available for new characters.');
    }

    /**
     * Validate character name
     */
    public function isValidCharacterName(string $name): array
    {
        $errors = [];

        // Length validations
        if (strlen($name) < 4) {
            $errors[] = 'The name must be at least 4 characters.';
        }

        if (strlen($name) > 29) {
            $errors[] = 'The name must be at most 29 characters.';
        }

        // First letter must be uppercase
        if (! empty($name) && ! ctype_upper($name[0])) {
            $errors[] = 'The first letter of a name has to be a capital letter.';
        }

        // Only letters and spaces allowed
        if (! preg_match('/^[a-zA-Z ]+$/', $name)) {
            $errors[] = 'This name contains invalid letters. Please use only A-Z, a-z, and space.';
        }

        // No multiple consecutive spaces
        if (preg_match('/\s{2,}/', $name)) {
            $errors[] = 'This name contains more than one space between words. Please use only one space between words.';
        }

        // Must contain at least one vowel
        if (! preg_match('/[aeiou]/i', $name)) {
            $errors[] = 'This name contains a word without vowels. Please choose another name.';
        }

        // Word-specific validations
        $words = explode(' ', $name);
        foreach ($words as $word) {
            if (strlen($word) > 14) {
                $errors[] = 'This name contains a word that is too long. Please use no more than 14 letters for each word.';
                break;
            }

            if (strlen($word) < 2) {
                $errors[] = 'This name contains a word that is too short. Please use at least 2 letters for each word.';
                break;
            }

            if (! preg_match('/[aeiou]/i', $word)) {
                $errors[] = 'This name contains a word without vowels. Please choose another name.';
                break;
            }

            if (in_array(strtolower($word), config('blacktek.characters.new.blocked_words'))) {
                $errors[] = 'This name cannot be used because it contains a forbidden word or combination of letters. Please choose another name!';
                break;
            }
        }

        // Check full name against blocked words
        if (in_array(strtolower($name), config('blacktek.characters.new.blocked_words'))) {
            $errors[] = 'This name cannot be used because it contains a forbidden word or combination of letters. Please choose another name!';
        }

        return $errors;
    }
}
