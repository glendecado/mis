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
            $this->redirect('/profile/' . $updateUser->id, navigate: true);
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
<div class="w-full h-dvh">
    <div>
        <a href="/">
            <div class="border w-fit p-2 mb-2 rounded-md px-4 bg-blue text-white">
                <x-icons.arrow direction="left" />
            </div>
        </a>

    </div>
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


            <div class="text-md text-black rounded-md p-1" style="margin-right: 20px; background-color: yellow;">
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
                <div class="w-full relative" x-data="{ show: true }">
                    <label class="block">Password:</label>
                    <input :disabled="update" class="input w-full" x-model="password" :type="show ? 'password' : 'text'">

                    <div class="absolute right-2 bottom-2 cursor-pointer">
                        <template x-if="show">
                            <div>
                                <svg @click="show = !password" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor" class="size-6 text-blue-950">
                                    <path
                                        d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z" />
                                    <path
                                        d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.53 15.713l-4.243-4.244a3.75 3.75 0 0 0 4.244 4.243Z" />
                                    <path
                                        d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 0 0-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 0 1 6.75 12Z" />
                                </svg>
                            </div>
                        </template>
                        <template x-if="!show">
                            <div>
                                <svg @click="show = !show" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor" class="size-6 text-blue-950">
                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </template>
                    </div>

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

            class="border rounded-md row-start-2 md:row-start-2 col-span-2 md:col-span-1 p-2 flex items-center justify-center relative flex-col gap-2">
            <span class="absolute top-2 left-2">User Profile</span>



            @if($photo)
            <img
                wire:loading.class="hidden"
                src="{{ $photo->temporaryUrl()}}" alt=""
                class="rounded-full w-[150px] h-[150px] object-cover">
            <div class="flex gap-2">
                <div wire:loading.class="hidden" class="p-2 rounded-md button mt-4 cursor-pointer" style="color: white; background-color: #2e5e91; font-size: 14px;">
                    <label for="photo">Choose</label>
                    <input id="photo" type="file" wire:model="photo" class="hidden" placeholder="update">
                </div>
                <button wire:loading.class="hidden" class="p-2 rounded-md button mt-4" style="color: white; background-color: #2e5e91; font-size: 14px;" @click="$wire.updateProfile('img');">Save</button>
            </div>

            @else
            <div wire:target="photo">
                <img wire:loading.class="hidden"
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
</div>