<?php

namespace App\Http\Middleware;

use App\Contracts\UpdatesCurrentTeam;
use Closure;
use Illuminate\Http\Request;

class EnsureHasTeam
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && ! $request->user()->isMemberOfATeam()) {
            return redirect()->route('create-first-team');
        }

        $this->ensureOneOfTheTeamsIsCurrent($request);

        return $next($request);
    }

    protected function ensureOneOfTheTeamsIsCurrent(Request $request): void
    {
        $updater = app(UpdatesCurrentTeam::class);

        if (! is_null($request->user()->current_team_id)) {
            return;
        }

        $firstTeamUuid = $request->user()->allTeams()->first()->uuid;
        $updater->update($request->user(), ['team_uuid' => $firstTeamUuid]);
    }
}
