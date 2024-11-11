<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cach;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{mount, state, title, usesFileUploads};

title('Edit profile');

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
            $imageName = $this->photo->store('profile_images', 'public');
            $updateUser->img = $imageName;
            $updateUser->save();
            $this->dispatch('success', 'image save');
            $this->redirect('/edit-profile/'.$updateUser->id, navigate: true);
            break;

         
    }
    
    Cache::flush();

    session()->put('user.img', $this->img);
    session()->put('user.name', $this->lName. ' '. $this->fName);
    session()->put('user.email', $this->email);
    session()->put('user.password', $this->password);
    session()->put('user.college', $this->college);
    session()->put('user.building', $this->building);
    session()->put('user.room', $this->room);

   
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

    <div class="col-span-2 border rounded-md w-full flex gap-3 items-center relative">

        <img src="{{asset('storage/'. $this->img)}}" alt=""
            class="rounded-full w-[150px] h-[150px] ml-3">
        <span x-text="fName+' '+lName"></span>


    </div>

    <div class="border rounded-md md:row-start-2 col-span-2 md:col-span-1 p-2">

        <div class="flex gap-9 mb-4">Role: <span x-text="role"></span></div>

        <div class="y gap-2">

            <div class="w-full">
                <label for="" class="w-[20%]">First Name:</label>
                <input :disabled="update" type="text" class="input w-[80%] float-right" x-model="fName" @clic="fName = ''">
            </div>

            <div class="w-full">
                <label for="" class="w-[20%]">Last Name:</label>
                <input :disabled="update" type="text" class="input w-[80%] float-right" x-model="lName">
            </div>

            <div class="w-full">
                <label for="" class="w-[20%] text-sm">Email Address:</label>
                <input :disabled="update" type="text" class="input w-[80%] float-right" x-model="email">
            </div>

            <div x-show="role == 'Faculty'" class="w-full">
                <label for="" class="w-[20%]">College:</label>
                <input :disabled="update" type="text" class="input w-[80%] float-right" x-model="college">
            </div>

            <div x-show="role == 'Faculty'" class="w-full">
                <label for="" class="w-[20%]">Building:</label>
                <input :disabled="update" type="text" class="input w-[80%] float-right" x-model="building">
            </div>

            <div x-show="role == 'Faculty'" class="w-full">
                <label for="" class="w-[20%]">Room:</label>
                <input :disabled="update" type="text" class="input w-[80%] float-right" x-model="room">
            </div>

            <div class="w-full">
                <label for="" class="w-[20%]">Password:</label>
                <input :disabled="update" type="password" class="input w-[80%] float-right" x-model="password">
            </div>

        </div>
        <button class="button" x-show="update == true" @click="update = false">Update Profile</button>
        <button class="button" x-show="update == false" @click="$wire.updateProfile('profile'); update= true">Save</button>

    </div>

    <div

        class="border rounded-md row-start-2 md:row-start-2 col-span-2 md:col-span-1 p-2 flex items-center justify-center relative flex-col gap-2">
        <span class="absolute top-2 left-2">User Profile</span>



        @if($photo)
        <img
            src="{{ $photo->temporaryUrl()}}" alt=""
            class="rounded-full w-[150px] h-[150px] ml-3">

        <button class="button" @click="$wire.updateProfile('img');">save</button>
        @else
        <div wire:target="photo">
            <img wire:loading.remove 
                src="{{asset('storage/'. $this->img)}}" alt=""
                class="rounded-full w-[150px] h-[150px] ml-3">
        </div>

        @endif



        <div class="button">
            <label for="photo">Update Profile</label>
            <input id="photo" type="file" wire:model="photo" class="hidden" placeholder="update">
        </div>




    </div>

    <x-alerts />
</div>