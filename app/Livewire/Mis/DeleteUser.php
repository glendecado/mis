<?php

namespace App\Livewire\Mis;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteUser extends Component
{
    // This Livewire event listener will trigger the DeleteUser method when a 'user-delete' event is dispatched
    #[On('user-delete')]
    public function DeleteUser($id)
    {
        // Find the user by their ID from the User model
        $user = User::find($id);

        // Check if the user exists before attempting to delete
        if ($user) {
            // Delete the user from the database
            $user->delete();

            // Update table
            $this->dispatch('user-update');

            // Dispatch a success event with a message indicating the user was deleted successfully
            $this->dispatch('success', name: 'User had been added successfully.');

        } else {
            // Handle the case where the user was not found (optional, not implemented here)
        }
    }
}
