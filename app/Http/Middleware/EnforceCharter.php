<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;

class EnforceCharter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        if ($request->user() && $team = Team::where('uuid', $request->user()->currentTeam->uuid)->first()) {
            session()->put('current_team_uuid', $team->uuid);
        } elseif ($team = Team::where('name', $host)->first()) {
            session()->put('current_team_uuid', $team->uuid);
        }

        return $next($request);
    }
}
