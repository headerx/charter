<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\InteractsWithBanner;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class DeleteModal extends Component
{
    use InteractsWithBanner;
    use RedirectsActions;

    public $modalHeading = '';
    public $modalMessage = '';
    public $showDeleteModal = false;
    public $model;
    public $deleter;

    protected $listeners = ['showDeleteModal'];

    public function showDeleteModal($deleter, $modelType, $modelUuid, $modalHeading = 'Delete', $modalMessage = 'Are you sure you want to delete this?')
    {
        $this->deleter = $deleter;
        $this->showDeleteModal = true;
        $this->model = $modelType::whereUuid($modelUuid)->first();
        $this->modalHeading = $modalHeading;
        $this->modalMessage = $modalMessage;
    }

    public function destroy()
    {
        $this->resetErrorBag();
        $deleter = app()->make($this->deleter);
        $deleter->delete($this->user, $this->model->uuid);
        $this->showModal = false;
        $this->banner('Link created successfully.', 'success');
        $this->emit('refresh-navigation-menu');

        return $this->redirectPath($deleter);
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
        return view('livewire.delete-modal');
    }
}
