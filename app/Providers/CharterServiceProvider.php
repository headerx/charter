<?php

namespace App\Providers;

use App\Actions\Charter\CreateLink;
use App\Actions\Charter\DeleteLink;
use App\Actions\Charter\UpdateCurrentTeam;
use App\Actions\Charter\UpdateLink;
use App\Actions\Charter\UpdateTeamDomain;
use App\Actions\Charter\UpdateTeamLogo;
use App\Actions\Charter\UpdateUserType;
use App\Charter;
use Illuminate\Support\ServiceProvider;

class CharterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Charter::updateUserTypesUsing(UpdateUserType::class);
        Charter::updateCurrentTeamsUsing(UpdateCurrentTeam::class);
        Charter::updateTeamLogosUsing(UpdateTeamLogo::class);
        Charter::updateTeamDomainsUsing(UpdateTeamDomain::class);
        Charter::createLinksUsing(CreateLink::class);
        Charter::updateLinksUsing(UpdateLink::class);
        Charter::deleteLinksUsing(DeleteLink::class);
    }
}
