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
