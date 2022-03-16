<?php

namespace App\Http\Livewire;

use App\Contracts\UpdatesLink;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateLinkForm extends Component
{
    /**
     * The team instance.
     *
     * @var mixed
     */
    public $link;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];


    public function updateLink(UpdatesLink $updater)
    {
        $this->resetErrorBag();

        $updater->update($this->user, $this->state);

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.update-link-form');
    }
}
