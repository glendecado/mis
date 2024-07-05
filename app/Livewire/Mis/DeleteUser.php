<?php

namespace App\Livewire\Mis;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteUser extends Component
{

    #[On('user-delete')]
    public function DeleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        $this->dispatch('success', name: 'User had been added successfully.');
        $this->dispatch('reset-validation');
    }

}
