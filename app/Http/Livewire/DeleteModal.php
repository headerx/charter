<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteModal extends Component
{
    public $modalHeading = '';
    public $modalMessage = '';
    public $showModal = false;
    public $model;
    public $deleter;

    protected $listeners = ['showDeleteModal'];

    public function showDeleteModal($deleter, $modelType, $modelUuid, $modalHeading = 'Delete', $modalMessage = 'Are you sure you want to delete this?')
    {
        $this->deleter = $deleter;
        $this->showModal = true;
        $this->model = $modelType::whereUuid($modelUuid)->first();
        $this->modalHeading = $modalHeading;
        $this->modalMessage = $modalMessage;
    }

    public function destroy()
    {
        app()->make($this->deleter)->delete($this->user, $this->model->uuid);
        $this->emit('refreshComponent');
        $this->emit('successAlert', 'Deleted successfully');
        $this->showModal = false;
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
