<?php

namespace App\Providers;

use App\Actions\Charter\UpdateTeamDomain;
use App\Actions\Tenancy\UpdateTeamLogo;
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
        Charter::updateTeamLogosUsing(UpdateTeamLogo::class);
        Charter::updateTeamDomainsUsing(UpdateTeamDomain::class);
    }
}
