<?php

namespace App\Contracts;

interface UpdatesTeamDomain
{
    /**
     * Validate and update the given team's domain.
     *
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function update($team, array $input);
}
