<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeamMiddleware
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
        if ($request->has('team_id') && $request->user()) {
            $team = \App\Models\Team::whereUuid($request->input('team_id'))->firstOrFail();

            if (! $request->user()->switchTeam($team)) {
                abort(403);
            }
        }

        return $next($request);
    }
}
