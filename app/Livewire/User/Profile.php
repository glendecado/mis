<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Profile extends Component
{
    public User $user;

    // Lifecycle hook that runs when the component is initialized
    public function mount()
    {
        if(Auth::user()->role != 'Mis Staff'){
            if($this->user->role == 'Mis Staff'){
                abort(404);
            }
        }
    }

    public function render()
    {
        // Render the view for the profile component
        return view('livewire.user.profile');
    }
}
