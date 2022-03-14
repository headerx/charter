<?php

namespace App\Http\Livewire;

use App\Contracts\CreatesLink;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class CreateLinkForm extends Component
{
    use RedirectsActions;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Create a new team.
     *
     * @param  \Laravel\Jetstream\Contracts\CreatesTeams  $creator
     * @return void
     */
    public function createLink(CreatesLink $creator)
    {
        $this->resetErrorBag();

        $creator->create(Auth::user(), $this->team, $this->state);

        return $this->redirectPath($creator);
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getTeamProperty()
    {
        return Auth::user()->currentTeam;
    }

    public function render()
    {
        return view('livewire.create-link-form');
    }
}
