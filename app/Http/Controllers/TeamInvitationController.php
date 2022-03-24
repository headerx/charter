<?php

namespace App\Http\Controllers;

use App\Contracts\UpdatesCurrentTeam;
use Illuminate\Http\Request;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Http\Controllers\TeamInvitationController as JetstreamTeamInvitationController;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\TeamInvitation;

class TeamInvitationController extends JetstreamTeamInvitationController
{
       /**
     * Accept a team invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Jetstream\TeamInvitation  $invitation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Request $request, TeamInvitation $invitation)
    {
        app(AddsTeamMembers::class)->add(
            $invitation->team->owner,
            $invitation->team,
            $invitation->email,
            $invitation->role
        );

        $user = Jetstream::findUserByEmailOrFail($invitation->email);

        app(UpdatesCurrentTeam::class)->update($user, [ 'team_uuid' => $invitation->team->uuid ]);

        $invitation->delete();

        return redirect(config('fortify.home'))->banner(
            __('Great! You have accepted the invitation to join the :team team.', ['team' => $invitation->team->name]),
        );
    }
}
