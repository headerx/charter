<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Lab404\Impersonate\Services\ImpersonateManager;

class ImpersonatedTeam
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
        if ($request->user() && $request->user()->isImpersonated()) {
            $impersonator = app(ImpersonateManager::class)->getImpersonator();
            $user = request()->user();
            $request->session()->put('previous_team_uuid', $user->currentTeam->uuid);
            $request->session()->put('previous_team_name', $user->currentTeam->name);

            if (! $user->switchTeam($impersonator->currentTeam)) {
                abort(403);
            }
        }

        return $next($request);
    }
}
