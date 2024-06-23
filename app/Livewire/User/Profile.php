<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
 
    public $id;
    public $img;
    public $name;
    public $email;
    public $password;


    public function updateProfile()
    {
        $user = User::find(Auth::user()->id);
        $user->img = $this->img;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = $this->password;

        $user->save();

        session()->flash('message', 'Profile updated successfully');
    }


    public function render()
    {
        return view('livewire.user.profile');
    }
}
