<?php

namespace App\Livewire\Mis;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class UpdateUser extends Component
{
    public $user;

    #[On('modal-update')]
    public function open_modal($id)
    {
        $this->user = User::find($id);
        $this->dispatch('open-modal', 'update');
    }

    public function render()
    {
        return view('livewire.mis.update-user');
    }
}
