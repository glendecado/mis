<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class User extends Component
{
    public $email;
    public $password;
    public function login(){
        dd([$this->email, $this->password]);
    }

    #[Layout('layouts.app')] 
    public function render()
    {
        return view('livewire.user');
    }
}
