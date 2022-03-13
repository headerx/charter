<?php

namespace App;

use App\Contracts\UpdatesTeamLogo;

class Tenancy
{
    /**
     * Register a class / callback that should be used to update user profile information.
     *
     * @param  string  $callback
     * @return void
     */
    public static function updateTeamLogoUsing(string $callback)
    {
        app()->singleton(UpdatesTeamLogo::class, $callback);
    }
}
