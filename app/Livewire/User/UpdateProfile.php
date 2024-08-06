<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfile extends Component
{
    use WithFileUploads; // Trait to handle file uploads

    public $img; // Property to store the uploaded image
    public $user;

    // Validation rules for the uploaded image
    protected $rules = [
        'img' => 'required|image|max:1024', // Image is required and should be a maximum of 1MB
    ];


    public function mount(){
        $this->user = User::find(Auth::id());
    }


    // Method to handle profile image update
    public function updateProfileImage()
    {

        $this->validate(); // Validate the image based on the rules


        $img = 'public/' . $this->user->img; // Current image path

        $defaultImage = 'public/profile_images/default/default.png'; // Path to the default image

        // Store the new image and get the path
        $imageName = $this->img->store('profile_images', 'public');

        $this->user->img = $imageName; // Update the user's image path

        $this->user->save(); // Save the user with the new image path

        // Check if the old image exists and is not the default image before deleting it
        if ($img !== $defaultImage && Storage::exists($img)) {
            Storage::delete($img); // Delete the old image
        }

        $this->dispatch('success', name: 'Profile updated successfully.');

        return redirect('/profile/'.Auth::id());

    }

   
    public function render()
    {
        return view('livewire.user.update-profile');
    }
}
