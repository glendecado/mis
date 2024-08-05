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
        //check if user id is equals to the id of mis staff if true then redirect to your own profile
        if ($this->user->id == DB::table('users')->where('role','Mis Staff')->value('id')) {
            return redirect()->to("/profile/" . Auth::id());
        }
    }

    public function render()
    {
        // Render the view for the profile component
        return view('livewire.user.profile');
    }
}
