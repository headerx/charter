<?php

namespace App\Http\Livewire;

use App\Contracts\CreatesLink;
use App\Models\LinkMenu;
use App\Models\LinkTarget;
use App\Models\LinkType;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\InteractsWithBanner;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class CreateLinkForm extends Component
{
    use RedirectsActions;
    use InteractsWithBanner;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    public $creatingNewLink = false;

    protected $listeners = ['creatingNewLink' => 'showForm'];

    public function mount()
    {
        $this->state = [
            'role' => array_keys(config('roles'))[0],
            'type' => LinkType::ExternalLink->value,
            'target' => LinkTarget::Self->value,
            'url' => '',
            'title' => '',
            'label' => '',
            'view' => LinkMenu::NavigationMenu->value,
        ];
    }

    public function showForm($icon = null)
    {
        if($icon){
            $this->state['icon'] = $icon;
        }
        $this->creatingNewLink = true;
    }

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

        $this->creatingNewLink = false;

        $this->banner('Link created successfully.', 'success');
        $this->emit('refresh-navigation-menu');
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
