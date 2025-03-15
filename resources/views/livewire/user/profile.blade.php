<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cach;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{mount, state, title, usesFileUploads};

title('Profile');

usesFileUploads();

state(['id']);
state('photo');

state(['fName', 'lName', 'img', 'email', 'password', 'college', 'building', 'room', 'role']);

mount(function () {

    $this->user = (object) User::where('id', $this->id)->with('faculty')->first()->makeVisible('password');


    //get full name
    $fullName = $this->user->name;

    // Remove titles and suffixes (e.g., Prof., Jr., Sr., Dr., etc.)
    $cleanName = preg_replace('/^(Prof\.|Dr\.|Mr\.|Ms\.|Mrs\.)\s+/i', '', $fullName);
    $cleanName = preg_replace('/\s+(Jr\.|Sr\.|II|III|IV|V)$/i', '', $cleanName);

    // Split the name into parts
    $nameParts = explode(' ', $cleanName);

    $last = count($nameParts) - 1;
    $first = array_slice($nameParts, 0, $last, ' ');

    $this->fName = implode(' ', $first);
    $this->lName = $nameParts[$last];
    $this->id = $this->user->id; // Accessing as an object
    $this->img = $this->user->img; // Accessing as an object
    $this->email = $this->user->email; // Accessing as an object
    $this->role = $this->user->role; // Accessing as an object
    $this->password = $this->user->password ?? Auth::user()->password; // Accessing as an object

    if ($this->user->role == 'Faculty') {
        $this->college = $this->user->faculty->college; // Accessing nested properties
        $this->building = $this->user->faculty->building; // Accessing nested properties
        $this->room = $this->user->faculty->room; // Accessing nested properties
    }
});

$updateProfile = function ($type) {
    $updateUser = User::where('id', $this->id)->with('faculty')->first();

    switch ($type) {
        case  'profile':
            $updateUser->name = $this->fName . ' ' . $this->lName;
            $updateUser->email = $this->email;
            $updateUser->password = $this->password;

            if ($updateUser->faculty) {
                $updateUser->faculty->college = $this->college;
                $updateUser->faculty->building = $this->building;
                $updateUser->faculty->room = $this->room;

                // Save the faculty changes
                $updateUser->faculty->save();
            }

            $updateUser->save();

            $this->dispatch('success', 'udpated successfully');

            break;
        case 'img':
            //current image

            $img = $this->img;

            $imageName = $this->photo->store('profile_images', 'public');
            $updateUser->img = $imageName;



            if (Storage::disk('public')->exists($img) && $img != 'profile_images/default/default.png') {
                Storage::disk('public')->delete($img);
            }

            $updateUser->save();
            $this->img = $imageName;
            $this->dispatch('success', 'image save');
            $this->redirect('/edit-profile/' . $updateUser->id, navigate: true);
            break;
    }

    Cache::flush();

    if ($this->id == session('user')['id']) {
        session()->put('user.img', $this->img);
        session()->put('user.name', $this->lName . ' ' . $this->fName);
        session()->put('user.email', $this->email);
        session()->put('user.password', $this->password);
        session()->put('user.college', $this->college);
        session()->put('user.building', $this->building);
        session()->put('user.room', $this->room);
    }
}


?>

<div
    x-data="{
    update : true,
    fName: @entangle('fName'),
    lName: @entangle('lName'),
    img: @entangle('img'),
    email: @entangle('email'),
    password: @entangle('password'),
    college: @entangle('college'),
    building: @entangle('building'),
    room: @entangle('room'),
    role: @entangle('role')
}"

class="h-full w-full grid md:grid-cols-2 grid-cols-1  md:grid-rows-[30%,70%] grid-rows-3  gap-2">

    <div class="col-span-2 p-2 border rounded-md w-full flex flex-row items-center justify-between relative">
        <div class="flex items-center gap-3">
            <img src="{{asset('storage/'. $this->img)}}" alt="" class="rounded-full object-cover ml-3" style="width: 100px; height: 100px;">
            <span x-text="fName+' '+lName" class="text-lg font-semibold"></span>
        </div>


        <div class="text-md text-white rounded-md p-2" style="margin-right: 20px; background-color: #2e5e91;">
            <span x-text="role"></span>
        </div>
    </div>


    <div class="border rounded-md md:row-start-2 col-span-2 md:col-span-1 p-4 overflow-scroll">

    <div class="y gap-4">
        <p>Personal Information</p>

        <!-- First Name & Last Name in One Line -->
        <div class="w-full flex gap-4">
            <div class="w-full">
                <label class="block">First Name:</label>
                <input :disabled="update" type="text" class="input w-full" x-model="fName" @click="fName = ''">
            </div>
            <div class="w-full">
                <label class="block">Last Name:</label>
                <input :disabled="update" type="text" class="input w-full" x-model="lName">
            </div>
        </div>

        <!-- Email Address -->
        <div class="w-full">
            <label class="block">Email Address:</label>
            <input :disabled="update" type="text" class="input w-full" x-model="email">
        </div>

        <!-- College, Building, and Room in One Line for Faculty -->
        <div x-show="role == 'Faculty'" class="w-full flex gap-4">
            <div class="w-full">
                <label class="block">College:</label>
                <input :disabled="update" type="text" class="input w-full" x-model="college">
            </div>
            <div class="w-full">
                <label class="block">Building:</label>
                <input :disabled="update" type="text" class="input w-full" x-model="building">
            </div>
            <div class="w-full">
                <label class="block">Room:</label>
                <input :disabled="update" type="text" class="input w-full" x-model="room">
            </div>
        </div>

        <!-- Password -->
        <div class="w-full">
            <label class="block">Password:</label>
            <input :disabled="update" type="password" class="input w-full" x-model="password">
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-4 flex justify-end gap-2">
        <button class="button float-end mt-2 p-2 rounded-md" style="color: white; background-color: #2e5e91; font-size: 14px;" x-show="update == true" @click="update = false">Update Info</button>
        <button class="button float-end mt-2 p-2 rounded-md" style="color: white; background-color: #2e5e91; font-size: 14px;" x-show="update == false" @click="$wire.updateProfile('profile'); update= true">Save Changes</button>
        <button class="float-end mt-2 p-2 rounded-md" style="color: white; color: #2e5e91; font-size: 14px; margin-right: 10px; border: 1px solid #2e5e91;" x-show="update == false" @click="update= true">Cancel</button>
    </div>

</div>


    <div
        wire:loading.hidden
        class="border rounded-md row-start-2 md:row-start-2 col-span-2 md:col-span-1 p-2 flex items-center justify-center relative flex-col gap-2">
        <span class="absolute top-2 left-2">User Profile</span>



        @if($photo)
        <img
            src="{{ $photo->temporaryUrl()}}" alt=""
            class="rounded-full w-[150px] h-[150px] object-cover">
        <div class="flex gap-2">
            <div class="p-2 rounded-md button mt-4" style="color: white; background-color: #2e5e91; font-size: 14px;">
                <label for="photo">Choose</label>
                <input id="photo" type="file" wire:model="photo" class="hidden" placeholder="update">
            </div>
            <button class="p-2 rounded-md button mt-4" style="color: white; background-color: #2e5e91; font-size: 14px;" @click="$wire.updateProfile('img');">Save</button>
        </div>

        @else
        <div wire:target="photo">
            <img wire:loading.remove
                src="{{asset('storage/'. $this->img)}}" alt=""
                class="rounded-full w-[150px] h-[150px]">
        </div>

        @endif


        @if(!$photo)
        <div class="p-2 rounded-md button mt-4" style="color: white; background-color: #2e5e91; font-size: 14px;">
            <label for="photo" class="cursor-pointer">Update Profile</label>
            <input id="photo" type="file" wire:model="photo" class="hidden" placeholder="update">
        </div>
        @endif



    </div>

    <x-alerts />
</div>