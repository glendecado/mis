<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Throwable;

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
/*         
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
        } */

        //remove try catch if password is already hashed
        try{
            if (empty($this->email)) {
                $this->emailError = 'Email field is required';
            } elseif (empty($user->email)) {
                $this->emailError = 'User not found';
            } elseif ($this->password == $user->password || Hash::check($this->password, $user->password)) {
                Auth::login($user);
                return redirect()->intended('/');
            } else {
                $this->passwordError = 'Incorrect password';
            }
        }
        catch(Throwable $e){
            $this->passwordError = 'Incorrect password';
        }

     
    }

    public function render()
    {
        return view('livewire.user.log-in');
    }
}
