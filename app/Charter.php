<?php

namespace App;

use App\Contracts\UpdatesTeamLogo;
use App\Models\Team;

class Charter
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

    public static function currentTeam()
    {
        if (! session()->has('current_team_uuid')) {
            return false;
        }

        $currentTeamUuid = session()->get('current_team_uuid');

        return Team::whereUuid($currentTeamUuid)->first();
    }
}
