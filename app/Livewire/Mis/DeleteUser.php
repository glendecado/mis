<?php

namespace App\Livewire\Mis;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class DeleteUser extends Component
{
    // This Livewire event listener will trigger the DeleteUser method when a 'user-delete' event is dispatched
    #[On('user-delete')]
    public function DeleteUser($id)
    {
        // Find the user by their ID from the User model
        $user = User::find($id);

        //link of the user's image
        $img = 'public/' . $user->img;

        //defult image path of a user
        $defaultImage = 'public/profile_images/default/default.png';



        // Delete the user from the database
        $user->delete();

        // Update table
        $this->dispatch('user-update');

        // Dispatch a success event with a message indicating the user was deleted successfully
        $this->dispatch('success', name: 'User had been added successfully.');


        
        //deleting image of user
        // Check if the file exists and is not the default image before attempting to delete
        if ($img !== $defaultImage && Storage::exists($img)) {
            Storage::delete($img);
        }


    }
}
