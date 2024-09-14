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
    public $password;


    //to open the modal for update
    #[On('modal-update')]
    public function openModal($id)
    {
        //getting the users that has been dispatched  -- <button @click="$dispatch('modal-update', {id:{{$user->id}}})"> --in view-users.php
        $this->user = User::find($id);

        //dispatch the modal named update in update-users.php
        $this->dispatch('open-modal', 'update');
    }

    public function updateUser()
    {
        //if global variable remains empty then just keep the existing value
        $this->user->name = $this->name ?? $this->user->name;
        $this->user->email = $this->email ?? $this->user->email;

        if (!empty($this->password)) {
            $this->user->password = $this->password;
        }

        //Save the updated user information in the database
        $this->user->save();

        //dispatch user-update in Mis/ViewUser.php --#[On('user-update')] 
        //so that the frontend will notify that user was updated 
        $this->dispatch('user-update');

        //dispatch to js sweet alert
        $this->dispatch('success', name: 'User had been updated successfully.');


        //dispatch the modal named update to close in update-users.php
        $this->dispatch('close-modal', 'update');
    }

 
}
