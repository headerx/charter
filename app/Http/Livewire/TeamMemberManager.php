<?php

namespace App\Http\Livewire;

use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager as JetstreamTeamMemberManager;
use Laravel\Jetstream\Jetstream;

class TeamMemberManager extends JetstreamTeamMemberManager
{
    /**
     * Remove a team member from the team.
     *
     * @param  \Laravel\Jetstream\Contracts\RemovesTeamMembers  $remover
     * @return void
     */
    public function removeTeamMember(RemovesTeamMembers $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            $user = is_numeric($this->teamMemberIdBeingRemoved) ?
            Jetstream::findUserByIdOrFail($this->teamMemberIdBeingRemoved) :
            Jetstream::newUserModel()->where('uuid', $this->teamMemberIdBeingRemoved)->firstOrFail(),
        );

        $this->confirmingTeamMemberRemoval = false;

        $this->teamMemberIdBeingRemoved = null;

        $this->team = $this->team->fresh();
    }

    /**
     * Cancel a pending team member invitation.
     *
     * @param  int  $invitationId
     * @return void
     */
    public function cancelTeamInvitation($invitationId)
    {
        if (! empty($invitationId)) {
            $model = Jetstream::teamInvitationModel();

            $model::whereKey($invitationId)->orWhere('uuid', $invitationId)->delete();
        }

        $this->team = $this->team->fresh();
    }
}
