<?php

namespace App\Livewire;

use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class User extends Component
{
    #[Url()]
    public $id;
    public $img;
    public $name;
    public $email;
    public $password;


    public function mount()
    {
        $this->id = Auth::user()->id ?? 'guest';
    }
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

    public function updateProfile()
    {
        $user = ModelsUser::find(Auth::user()->id);
        $user->img = $this->img;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = $this->password;

        $user->save();

        session()->flash('message', 'Profile updated successfully');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.user');
    }
}
