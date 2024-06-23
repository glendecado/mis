<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public function login()
    {
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Authentication successful
            return redirect()->intended('/');
        } else {
            // Authentication failed
            session()->flash('login-error', 'Invalid credentials');
        }
    }
    public function render()
    {
        return view('livewire.user.log-in');
    }
}
