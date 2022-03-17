<?php

namespace App;

use App\Contracts\CreatesLink;
use App\Contracts\DeletesLink;
use App\Contracts\UpdatesLink;
use App\Contracts\UpdatesTeamDomains;
use App\Contracts\UpdatesTeamLogo;
use App\Models\Membership;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class Charter
{
    /**
     * Register a class / callback that should be used to create a link.
     *
     * @param  string  $callback
     * @return void
     */
    public static function createLinksUsing(string $callback)
    {
        app()->singleton(CreatesLink::class, $callback);
    }

    /**
     * Register a class / callback that should be used to delete a link.
     *
     * @param  string  $callback
     * @return void
     */
    public static function deleteLinksUsing(string $callback)
    {
        app()->singleton(DeletesLink::class, $callback);
    }

    /**
     * Register a class / callback that should be used to update team logo.
     *
     * @param  string  $callback
     * @return void
     */
    public static function updateTeamLogosUsing(string $callback)
    {
        app()->singleton(UpdatesTeamLogo::class, $callback);
    }

    /**
     * Register a class / callback that should be used to update links.
     *
     * @param  string  $callback
     * @return void
     */
    public static function updateLinksUsing(string $callback)
    {
        app()->singleton(UpdatesLink::class, $callback);
    }

    /**
     * Register a class / callback that should be used to update team logo.
     *
     * @param  string  $callback
     * @return void
     */
    public static function updateTeamDomainsUsing(string $callback)
    {
        app()->singleton(UpdatesTeamDomains::class, $callback);
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
        if (! $request->user() || ! $request->user()->currentTeam) {
            return;
        }

        $team = Team::where('uuid', $request->user()->currentTeam->uuid)->first();

        if (isset($team->uuid)) {
            session()->put('current_team_uuid', $team->uuid);
            session()->put('team', $team);
        }
    }

    public static function ensureTeamForDomain(Request $request)
    {
        $host = $request->getHost();

        if ($team = Team::where('domain', $host)->first()) {
            session()->put('current_team_uuid', $team->uuid);
            session()->put('team', $team);
        }
    }

    public static function membershipInstance(Team $team, User $user) : Membership
    {
        return new Membership([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
    }
}
