<?php

use App\Mail\UpdateAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use function Livewire\Volt\{mount, state, title, usesFileUploads};

title('Profile');

usesFileUploads();

state(['id']);
state('photo');

state(['fName', 'lName', 'img', 'email', 'password', 'site', 'officeOrBuilding', 'role']);

mount(function () {
    try {
        $this->user = (object) User::where('id', $this->id)->with('faculty')->first()->makeVisible('password');
        // Process full name
        $fullName = $this->user->name;
        $cleanName = preg_replace('/^(Prof\.|Dr\.|Mr\.|Ms\.|Mrs\.)\s+/i', '', $fullName);
        $cleanName = preg_replace('/\s+(Jr\.|Sr\.|II|III|IV|V)$/i', '', $cleanName);
        $nameParts = explode(' ', $cleanName);

        $last = count($nameParts) - 1;
        $first = array_slice($nameParts, 0, $last, ' ');

        $this->fName = implode(' ', $first);
        $this->lName = $nameParts[$last];
        $this->id = $this->user->id;
        $this->img = $this->user->img;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
        $this->password = $this->user->password ?? Auth::user()->password;

        if ($this->user->role == 'Faculty') {
            $this->site = $this->user->faculty->site;
            $this->officeOrBuilding = $this->user->faculty->officeOrBuilding;
        }
    } catch (Throwable $e) {
        return $this->redirect('/', navigate: true);
    }
});

$updateProfile = function ($type) {
    $updateUser = User::where('id', $this->id)->with('faculty')->first();

    if ($type === 'profile') {
        $validated = $this->validate([
            'fName' => 'required|string|max:255',
            'lName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'password' => 'required|string|min:8',
            'site' => 'required|string|max:255',
            'officeOrBuilding' => 'required|string|max:255',
        ], [
            'fName.required' => 'First name is required.',
            'lName.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $updateUser->name = $this->fName . ' ' . $this->lName;
        $updateUser->email = $this->email;
        $updateUser->password = $this->password;

        if ($updateUser->faculty) {
            $updateUser->faculty->site = $this->site;
            $updateUser->faculty->officeOrBuilding = $this->officeOrBuilding;
            $updateUser->faculty->save();
        }

        $updateUser->save();

        $this->dispatch('success', 'Profile updated successfully');
    }

    if ($type === 'img') {
        $this->validate([
            'photo' => 'required|image|max:2048', // Max 2MB
        ], [
            'photo.required' => 'Please select a photo.',
            'photo.image' => 'The file must be an image.',
            'photo.max' => 'The image may not be greater than 2MB.',
        ]);

        $img = $this->img;
        $imageName = $this->photo->store('profile_images', 'public');
        $updateUser->img = $imageName;

        if (Storage::disk('public')->exists($img) && $img != 'profile_images/default/default.png') {
            Storage::disk('public')->delete($img);
        }

        $updateUser->save();
        $this->img = $imageName;
        $this->dispatch('success', 'Profile image updated');
        $this->redirect('/profile/' . $updateUser->id, navigate: true);
    }

    // Update session info
    if ($this->id == session('user')['id']) {
        session()->put('user.img', $this->img);
        session()->put('user.name', $this->lName . ' ' . $this->fName);
        session()->put('user.email', $this->email);
        session()->put('user.password', $this->password);
        session()->put('user.site', $this->site);
        session()->put('user.officeOrBuilding', $this->officeOrBuilding);
    }

    Mail::to($updateUser->email)->send(new UpdateAccount($updateUser));
};


?>
<div class="min-h-screen bg-gray-50 p-2 md:p-6">
    <!-- Back Button -->
    <a href="/{{ session('page') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 transition-colors mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        <span>Back</span>
    </a>

    <!-- Main Profile Container -->
    <div x-data="{
        update: true,
        fName: @entangle('fName'),
        lName: @entangle('lName'),
        img: @entangle('img'),
        email: @entangle('email'),
        password: @entangle('password'),
        site: @entangle('site'),
        officeOrBuilding: @entangle('officeOrBuilding'),
        role: @entangle('role')
    }" class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-blue p-2 mb:p-6 flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="relative group">
                    <img src="{{ asset('storage/'. $this->img) }}" alt="Profile" class="h-20 w-20 rounded-full border-4 border-white/80 object-cover shadow-md">
                    <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div class="">
                    <h1 class="text-2xl font-bold text-white" x-text="fName + ' ' + lName"></h1>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-400 text-white" x-text="role"></span>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-2 mb:p-6">
            <!-- Profile Picture Section -->
            <div class="lg:col-span-1 bg-gray-50 rounded-lg p-6 shadow-inner">
                <div class="flex flex-col items-center">
                    @if($photo)
                    <!-- Loading state during preview -->
                    <div class="relative w-40 h-40">
                        <div wire:loading wire:target="photo" class="absolute inset-0 flex items-center justify-center rounded-full border-4 border-white bg-gray-200">
                            <svg class="animate-spin h-10 w-10 text-blue-600 ml-14 mt-14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <!-- Preview image when loaded -->
                        <div wire:loading.remove wire:target="photo">
                            <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="rounded-full w-40 h-40 object-cover border-4 border-white shadow-md">
                        </div>
                    </div>

                    <div class="flex gap-2 w-full items-center justify-center mt-2">
                        <!-- Loading state during save -->
                        <div wire:loading wire:target="updateProfile('img')" class="flex items-center justify-center px-4 py-2 bg-blue-600 rounded-md text-white">

                            Saving...
                        </div>

                        <!-- Buttons when not loading -->
                        <div wire:loading.remove wire:target="updateProfile('img')" class="flex gap-2 mt-2">
                            <button class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-gray-700 transition-colors">
                                <label for="photo" class="cursor-pointer">Change</label>
                                <input id="photo" type="file" wire:model="photo" class="hidden">
                                @error('photo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </button>
                            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-white transition-colors" @click="$wire.updateProfile('img');">
                                Save
                            </button>
                        </div>
                    </div>
                    @else
                    <!-- Default state -->
                    <div class="relative w-40 h-40">
                        <!-- Loading state during image load -->
                        <div wire:loading wire:target="photo" class="absolute inset-0 flex items-center justify-center rounded-full border-4 border-white bg-gray-200">
                            <svg class="animate-spin h-10 w-10 text-blue-600 ml-14 mt-14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <!-- Profile image when loaded -->
                        <div wire:loading.remove wire:target="photo">
                            <img src="{{ asset('storage/'. $this->img) }}" alt="Profile" class="rounded-full w-40 h-40 object-cover border-4 border-white shadow-md">
                        </div>
                    </div>

                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-white transition-colors mt-2">
                        <label for="photo" class="cursor-pointer">Update Photo</label>
                        <input id="photo" type="file" wire:model="photo" class="hidden">
                        @error('photo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </button>
                    @endif

                </div>
            </div>

            <!-- Profile Information Section -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm p-2 md:p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">Personal Information</h2>

                    <div class="space-y-4">
                        <!-- Name Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input :disabled="update" type="text" x-model="fName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('fname') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input :disabled="update" type="text" x-model="lName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('lName') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input :disabled="update" type="email" x-model="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Faculty Fields -->
                        <div x-show="role == 'Faculty'" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Site</label>
                                <select :disabled="update" x-model="site" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="New Site">New Site</option>
                                    <option value="Old Site">Old Site</option>
                                </select>
                                @error('site') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Office/Building</label>
                                <input :disabled="update" type="text" x-model="officeOrBuilding" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('officeOrBuilding') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                        </div>

                        <!-- Password Field -->
                        <div x-data="{ showPassword: false }" class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input :disabled="update" x-model="password" :type="showPassword ? 'text' : 'password'" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-10">
                                @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                                    <template x-if="showPassword">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg"
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
                                    <template x-if="!showPassword">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor" class="size-6 text-blue-950">
                                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                <path fill-rule="evenodd"
                                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                        <button x-show="update" @click="update = false" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                            Edit Profile
                        </button>
                        <button x-show="!update" @click.prevent="
        if (confirm('Are you sure you want to update')) {
            $wire.updateProfile('profile'); update = true;
        }"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors">
                            Save Changes
                        </button>
                        <button x-show="!update" @click="update = true; $wire.$refresh()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-alerts />
</div>