<?php

namespace App\Livewire\Mis;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class UpdateUser extends Component
{
    public $user;
    public $name;
    public $email;
    public $role;
    public $password;


   
    #[On('modal-update')]
    public function openModal($id)
    {
        $this->user = User::find($id);
        $this->dispatch('open-modal', 'update');
        
    }

    public function updateUser(){
        $this->user->name = $this->name ?? $this->user->name;
        $this->user->email = $this->email ?? $this->user->email;
        $this->user->role = $this->role ?? $this->user->role;
        

        if(!empty($this->password)){
            $this->user->password = $this->password;
        }
        
        $this->user->save();
        $this->dispatch('user-update');
    }

    public function render()
    {
        return view('livewire.mis.update-user');
    }
}
