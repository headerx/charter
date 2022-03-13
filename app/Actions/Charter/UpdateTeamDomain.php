<?php

namespace App\Actions\Charter;

use App\Aggregates\TeamAggregate;
use App\Contracts\UpdatesTeamDomains;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Validator;

class UpdateTeamDomain implements UpdatesTeamDomains
{
    /**
     * Validate and update the given team's domain.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function update($user, $team, array $input)
    {
        Gate::forUser($user)->authorize('update', $team);

        Validator::make($input, [
            'domain' => ['required', 'string',Rule::unique('teams')->ignore($team->uuid, 'uuid'), 'max:255'],
        ])->validateWithBag('updateTeamDomain');

        TeamAggregate::retrieve(
            uuid: $team->uuid
        )->updateTeamDomain(
            domain: $input['domain']
        )->persist();
    }
}
