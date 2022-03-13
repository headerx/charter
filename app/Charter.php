<?php

namespace App;

use App\Contracts\UpdatesTeamLogo;
use App\Models\Team;
use Illuminate\Http\Request;

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

    public static function ensureTeamForUser(Request $request)
    {
        if (! $request->user()) {
            return;
        }
        if ($request->user() && $team = Team::where('uuid', $request->user()->currentTeam->uuid)->first()) {
            session()->put('current_team_uuid', $team->uuid);
        }
    }

    public static function ensureTeamForDomain(Request $request)
    {
        $host = $request->getHost();

        if ($team = Team::where('name', $host)->first()) {
            session()->put('current_team_uuid', $team->uuid);
        }
    }
}
