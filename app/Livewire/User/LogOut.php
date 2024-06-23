<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LogOut extends Component
{
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function render()
    {
        return view('livewire.user.log-out');
    }
}
