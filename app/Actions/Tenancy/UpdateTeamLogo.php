<?php

namespace App\Actions\Tenancy;

use App\Aggregates\TeamAggregate;
use App\Aggregates\UserAggregate;
use App\Contracts\UpdatesTeamLogo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateTeamLogo implements UpdatesTeamLogo
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function update($team, array $input)
    {
        Validator::make($input, [
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            DB::transaction(function () use ($team, $input) {
                $team->updateProfilePhoto($input['photo']);
            });
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
