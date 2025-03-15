<?php

use function Livewire\Volt\{layout, state, title};
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

title('Login');

layout('components.layouts.guest');
state(['email', 'password', 'emailError', 'passwordError']);

$login = function () {
    $this->resetErrorBag(); // Reset any previous error messages
    $this->emailError = null;
    $this->passwordError = null;

    $user = User::where('email', $this->email)->first();

    //remove try catch if password is already hashed
    try {
        if (empty($this->email)) {
            $this->emailError = 'Email field is required';
        } elseif (empty($user->email)) {
            $this->emailError = 'User not found';
        } elseif ($this->password == $user->password || Hash::check($this->password, $user->password)) {
            Auth::login($user);

            if ($user->role == 'Faculty') {
                Session::put('user', [
                    'id' => $user->id,
                    'img' => $user->img,
                    'name' => $user->name,
                    'role' => $user->role,
                    'email' => $user->email,
                    'college' => $user->faculty->college,
                    'building' => $user->faculty->building,
                    'room' => $user->faculty->room
                ]);
            } else {
                Session::put('user', [
                    'id' => $user->id,
                    'img' => $user->img,
                    'name' => $user->name,
                    'role' => $user->role,
                    'email' => $user->email,
                ]);
            }

            return redirect('/dashboard');
        } else {
            $this->passwordError = 'Incorrect password';
        }
    } catch (Throwable $e) {
        $this->passwordError = 'Incorrect password';
    }
};

?>

<div class="w-full flex items-center justify-center h-screen bg-blue-50">
    <div class="w-full flex justify-center m-4">
        <div class="relative w-full md:w-96 px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 rounded-md sm:px-10" 
            style="background-color: #2e5e91;">
            
            <div class="flex items-center gap-2 justify-center mb-2">
                <img src="{{ asset('storage/profile_images/default/ISAT-U-logo.png') }}" 
                    alt="ISAT-U Logo" class="size-10">
                <p class="text-white font-medium text-xl font-geist">MIS Service Request Portal</p>
            </div>

            <hr>

            <div class="text-center">
                <p class="m-4 text-blue-50">Sign in to access your account</p>
            </div>

            <div class="mt-10">
                <form wire:submit.prevent="login" method="post">
                    
                    <!-- Email Field -->
                    <div class="mb-2">
                        <label for="email" class="text-sm text-white font-thin">Email Address</label>
                        <input wire:model.lazy="email" type="text" id="email"
                            class="w-full px-3 py-2 rounded-md bg-blue-100 text-gray-900 
                            focus:outline-none focus:ring-2 focus:ring-yellow 
                            {{ $emailError ? 'border border-red-500' : '' }}" />
                        @if ($emailError)
                            <div class="text-red-500 text-xs mt-1">{{ $emailError }}</div>
                        @endif
                    </div>

                    <!-- Password Field -->
                    <div class="mb-2 relative" x-data="{ showPassword: false }">
                        <label for="password" class="text-sm text-white font-thin">Password</label>
                        <input :type="showPassword ? 'text' : 'password'" wire:model.lazy="password"
                            id="password" autocomplete="off"
                            class="w-full px-3 py-2 rounded-md bg-blue-100 text-gray-900 
                            focus:outline-none focus:ring-2 focus:ring-yellow 
                            {{ $passwordError ? 'border border-red-500' : '' }}" />
                        
                        <!-- Toggle Password Visibility -->
                        <div class="absolute right-3 top-9 cursor-pointer">
                            <svg @click="showPassword = !showPassword" 
                                xmlns="http://www.w3.org/2000/svg" 
                                viewBox="0 0 24 24" 
                                fill="currentColor" class="w-5 h-5 text-blue-950">
                                <path x-show="!showPassword" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path x-show="showPassword" d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z" />
                            </svg>
                        </div>

                        @if ($passwordError)
                            <div class="text-red-500 text-xs mt-1">{{ $passwordError }}</div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="float-right w-24 group" style="margin-top: 24px;">
                        <button type="submit"
                            class="text-blue-500 font-geist w-full rounded-md bg-blue-50 px-3 py-2 focus:bg-yellow focus:outline-none hover:bg-yellow hover:text-black transition-all duration-300 hover:-translate-x-1 hover:-translate-y-1 hover:shadow-md hover:shadow-blue-950/50">
                            Sign in
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
