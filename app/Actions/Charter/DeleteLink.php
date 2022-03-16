<?php

namespace App\Actions\Charter;

use App\Aggregates\LinkAggregate;
use App\Contracts\DeletesLink;
use Illuminate\Support\Facades\Validator;

class DeleteLink implements DeletesLink
{
    /**
     * Delete the given model.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  string $uuid
     * @return void
     */
    public function delete($user, $uuid)
    {
        Validator::make(['uuid' => $uuid], [
            'uuid' => 'required|exists:links,uuid',
        ])->validate();

        $linkAggregate = LinkAggregate::retrieve($uuid);


        $linkAggregate->deleteLink(
            userUuid: $user->uuid,
            teamUuid: $user->currentTeam->uuid,
        )->persist();
    }

    public function redirectTo(){
        return route('dashboard');
    }
}
