<?php

use App\Models\Account;

/*
    Functions to be used in the application
    These functions are not part of any class and can be used globally.
    They are defined in this file for convenience.
    You can add more functions as needed.
    Just make sure to follow the naming convention and avoid conflicts with existing functions.
*/

/**
 * Get the current server root path
 *
 * @return string
 */
if (! function_exists('server_root')) {
    function server_root()
    {
        return config('blacktek.server_root');
    }
}

/**
 * Get the current authenticated user's account
 *
 * @return Account
 */
if (! function_exists('account')) {
    function account(): Account
    {
        return auth()->user()->account;
    }
}

/**
 * Get the amount of experience needed for a specific level
 *
 * @param  int  $level  The level to calculate experience for
 * @return int The amount of experience needed for the level
 */
if (! function_exists('experience_for_level')) {
    function experience_for_level($level)
    {
        $level = $level - 1;

        return (50 * $level * $level * $level - 150 * $level * $level + 400 * $level) / 3;
    }
}
