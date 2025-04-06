<?php

use function Livewire\Volt\{layout, state, title};
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

title('Login');

layout('components.layouts.guest');
state(['email', 'password', 'emailError', 'passwordError']);

$login = function () {
    $this->resetErrorBag();

    // Validation checks
    if (empty($this->email)) {
        $this->emailError = 'Email field is required';
        return;
    }

    $user = User::where('email', $this->email)->first();

    if (!$user) {
        $this->emailError = 'User not found';
        return;
    }

    // Check account status
    if ($user->status !== 'active') {
        $this->emailError = 'Your account is inactive. Contact support.';
        return;
    }

    // Check password
    try{
        if (!Hash::check($this->password, $user->password)) {
            $this->passwordError = 'Incorrect password';
            return;
        }
    }
    catch(Throwable $e){

        if ($this->password !== $user->password) {
            $this->passwordError = 'Incorrect password';
            return;
        }
    }

    if($user->isOnline()){
        $this->passwordError = 'Account already login';
        return;
    }

    // Check existing session
    

    // Login and session setup
    Auth::login($user);

    $sessionData = [
        'id' => $user->id,
        'img' => $user->img,
        'name' => $user->name,
        'role' => $user->role,
        'email' => $user->email,
    ];

    if ($user->role === 'Faculty' && $user->faculty) {
        $sessionData['college'] = $user->faculty->college;
        $sessionData['building'] = $user->faculty->building;
        $sessionData['room'] = $user->faculty->room;
    }

    Session::put('user', $sessionData);



    return redirect('/dashboard');
};

?>

<div class="w-full h-screen flex flex-col items-center justify-center bg-blue-50 px-4">


    <div class="w-full flex justify-center m-4"> <!-- Changed justify-end to justify-center -->
        <div
            class="relative w-full sm:w-96 px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 rounded-md sm:px-10 bg-[#2e5e91]">
            <div class="flex items-center gap-2 justify-center mb-2">
                <img src="{{ asset('storage/profile_images/default/ISAT-U-logo.png') }}" alt="ISAT-U Logo" class="size-10">
                <p class="text-white font-medium text-xl font-geist">MIS Service Request Portal</p>
            </div>

            <hr>

            <div class="text-center">
                <!-- <h1 class="font-geist text-3xl font-semibold text-blue-50">Sign in</h1> -->
                <p class="mt-4 text-blue-50">Sign in to access your account</p>
            </div>
            <div class="mt-[24px]">
                <form wire:submit.prevent="login" method="post">
                    <div class="">
                        <label for="email" class="block text-sm text-white font-thin">Email Address</label>
                        <input wire:model.lazy="email" type="text" id="email"
                            class="rounded-md block w-full px-2 py-3 bg-blue-100 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-500
                        {{ $emailError ? 'border border-red-500' : '' }}" />
                        @if ($emailError)
                        <div class="text-red-500 text-xs mt-1">{{ $emailError }}</div>
                        @endif
                    </div>

                    <div class="relative mt-[10px]" x-data="{ password: true }">
                        <label for="password" class="block text-sm text-white font-thin mb-">Password</label>
                        <input :type="password ? 'password' : 'text'" wire:model.lazy="password" autocomplete="off"
                            id="floating_standard"
                            class="rounded-md peer block w-full appearance-none px-2 py-3 bg-blue-100 text-sm text-gray-900 focus:outline-none focus:ring-0 {{ $passwordError ? 'border border-red-500' : '' }}"
                            placeholder=" " />
                        <div class="absolute right-2 bottom-2 cursor-pointer">
                            <template x-if="password">
                                <div>
                                    <svg @click="password = !password" xmlns="http://www.w3.org/2000/svg"
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
                            <template x-if="!password">
                                <div>
                                    <svg @click="password = !password" xmlns="http://www.w3.org/2000/svg"
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
                    @if ($passwordError)
                    <div class="text-red-500 text-xs mt-1">{{ $passwordError }}</div>
                    @endif
                    <div class="float-right w-24 group mt-4">
                        <button type="submit"
                            class="text-blue-500 font-geist w-full rounded-md bg-blue-50 px-3 py-2 focus:bg-yellow-500 focus:outline-none hover:bg-yellow hover:text-black transition-all duration-300 hover:-translate-x-1 hover:-translate-y-1 hover:shadow-md hover:shadow-blue-950/50">
                            Sign in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>