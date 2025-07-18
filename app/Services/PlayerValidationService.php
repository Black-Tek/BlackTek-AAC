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
        $vocations = [];

        foreach ($availableVocations as $vocation) {
            if (in_array($vocation->name, $allowedVocations)) {
                $vocations[$vocation->id] = [
                    'id' => $vocation->id,
                    'name' => $vocation->name,
                ];
            }
        }

        return $vocations;
    }

    /**
     * Get available towns for new players
     */
    public function getAvailableTowns(): array
    {
        $availableTowns = Town::getAvailableTowns();
        $allowedTowns = config('blacktek.characters.new.towns');
        $towns = [];

        foreach ($allowedTowns as $townId => $townName) {
            if (array_key_exists($townId, $availableTowns)) {
                $towns[$townId] = [
                    'id' => $townId,
                    'name' => $townName,
                ];
            }
        }

        return $towns;
    }

    /**
     * Get available sexes for new players
     */
    public function getAvailableSexes(): array
    {
        return config('blacktek.characters.new.sex');
    }

    /**
     * Validate if a vocation is available for new players
     */
    public function isValidVocation(int $vocationId): bool
    {
        $vocations = app('vocations')->getVocations();
        $allowedVocations = config('blacktek.characters.new.vocations');

        if (! isset($vocations[$vocationId])) {
            return false;
        }

        $vocationName = $vocations[$vocationId]->name;

        return in_array($vocationName, $allowedVocations);
    }

    /**
     * Validate if a town is available for new players
     */
    public function isValidTown(int $townId): bool
    {
        $availableTowns = Town::getAvailableTowns();
        $allowedTowns = config('blacktek.characters.new.towns');

        if (! array_key_exists($townId, $availableTowns)) {
            return false;
        }

        $townName = $availableTowns[$townId];

        return in_array($townName, $allowedTowns);
    }

    /**
     * Validate if a sex is available for new players
     */
    public function isValidSex(int $sex): bool
    {
        $allowedSexes = array_keys(config('blacktek.characters.new.sex'));

        return in_array($sex, $allowedSexes);
    }

    /**
     * Get validation error message for vocation
     */
    public function getVocationErrorMessage(int $vocationId): string
    {
        $vocations = app('vocations')->getVocations();

        if (! isset($vocations[$vocationId])) {
            return __('The selected vocation is invalid.');
        }

        return __('The selected vocation is not available for new characters.');
    }

    /**
     * Get validation error message for town
     */
    public function getTownErrorMessage(int $townId): string
    {
        $availableTowns = Town::getAvailableTowns();

        if (! array_key_exists($townId, $availableTowns)) {
            return __('The selected town does not exist.');
        }

        return __('The selected town is not available for new characters.');
    }

    /**
     * Get validation error message for sex
     */
    public function getSexErrorMessage(): string
    {
        return __('The selected sex is invalid.');
    }
}
