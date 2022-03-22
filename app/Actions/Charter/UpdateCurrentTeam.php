<?php

namespace App\Actions\Charter;

use App\Aggregates\UserAggregate;
use App\Contracts\UpdatesCurrentTeam;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Jetstream\Jetstream;

class UpdateCurrentTeam implements UpdatesCurrentTeam
{
    public function update($user, array $input)
    {
        Validator::make($input, [
            'team_uuid' => ['required', 'string', 'exists:teams,uuid'],
        ])->validateWithBag('updateCurrentTeam');

        $userAggregate = UserAggregate::retrieve($user->uuid);

        if (! $userAggregate->switchUserTeam(
            teamUuid: $input['team_uuid'],
            previousTeamUuid: $user->currentTeam->uuid,
        )->persist()) {
            throw new UnauthorizedException('You are not authorized to switch teams.');
        }
    }
}

