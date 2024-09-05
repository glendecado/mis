<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Validate;

class LogIn extends Component
{

    public $email;
    public $password;

    public $emailError;
    public $passwordError;

    public function login()
    {
        $this->resetErrorBag(); // Reset any previous error messages
        $this->emailError = null;
        $this->passwordError = null;

        $user = User::where('email', $this->email)->first();
        if(empty($user)){
            $this->emailError = 'Email field is required';
        }
        elseif (!$user) {
            $this->emailError = 'User not found';
        } elseif (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->passwordError = 'Incorrect password';
        } else {
            // Authentication successful
            return redirect()->intended('/');
        }

     
    }

    public function render()
    {
        return view('livewire.user.log-in');
    }
}
