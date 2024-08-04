<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfile extends Component
{
    use WithFileUploads;

    public $img;

    protected $rules = [
        'img' => 'required|image|max:1024', // 1MB Max
    ];

    public function updateProfileImage()
    {
        $this->validate();

        $user = User::find(Auth::id());
        $img = 'public/' . $user->img;
        // Check if the file exists before attempting to delete
        if (Storage::exists($img)) {
            Storage::delete($img);

            session()->flash('message', 'File deleted successfully.');
        } else {
            session()->flash('error', 'File not found.');
        }

        if ($this->img) {
            $imageName = $this->img->store('profile_images', 'public');
            $user->img = $imageName;
            $user->save();

            session()->flash('message', 'Profile image updated successfully.');
        }
    }

    #[On('remove-img')]
    public function removeImg(){
        $this->img = '';
    }
    public function render()
    {
        return view('livewire.user.update-profile');
    }
}
