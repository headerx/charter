<?php

namespace App\Providers;

use App\Actions\Tenancy\UpdateTeamLogo;
use App\Tenancy;
use Illuminate\Support\ServiceProvider;

class TenancyProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Tenancy::updateTeamLogoUsing(UpdateTeamLogo::class);
    }
}
