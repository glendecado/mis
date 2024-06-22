<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class User extends Component
{
    public $email;
    public $password;

    public function login(){
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Authentication successful
            return redirect()->intended('/');
        } else {
            // Authentication failed
            session()->flash('login-error', 'Invalid credentials');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
    #[Layout('layouts.app')] 
    public function render()
    {
        return view('livewire.user');
    }
}
