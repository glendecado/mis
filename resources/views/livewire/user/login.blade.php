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

<div class="grid grid-cols-1 md:grid-cols-2 grid-rows-[25%,auto] md:grid-rows-1  w-full items-start md:items-center justify-center  h-svh ">

    <div class="w-full flex justify-end">
        <div
            class="relative w-full md:w-96 bg-blue-500 px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 rounded-xl sm:px-10 h-[450px] ">
            <div class="text-center">
                <h1 class="font-geist text-3xl font-semibold text-blue-50">Sign in</h1>
                <p class=" mt-2 text-blue-50">Sign in below to access your account</p>
            </div>
            <div class="my-[50px]">
                <form wire:submit.prevent="login" method="post">

                    <div class="relative z-0">
                        <input wire:model.lazy="email" type="text" id="floating_standard"
                            class="rounded-full peer block w-full appearance-none px-5 py-3 bg-blue-100  text-sm text-gray-900  focus:outline-none focus:ring-0 {{ $emailError ? 'border border-red-500' : '' }}"
                            placeholder=" " />
                        <label for="floating_standard"
                            class="absolute top-2 z-10 origin-[0] -translate-y-[35px] scale-75 transform  duration-300 peer-placeholder-shown:translate-y-0 text-lg peer-focus:start-0 peer-focus:-translate-y-[35px] peer-focus:scale-75 peer-focus:text-yellow rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 ml-2 text-gray-500">Email
                            Address</label>

                        @if ($emailError)
                        <div class="mt-1 text-xs text-red-600 absolute">❌ {{ $emailError }}</div>
                        @endif
                    </div>

                    <div class="relative mt-9" x-data="{ password: true }">
                        <input :type="password ? 'password' : 'text'" wire:model.lazy="password" autocomplete="off"
                            id="floating_standard"
                            class="rounded-full peer block w-full appearance-none px-5 py-3 bg-blue-100  text-sm text-gray-900  focus:outline-none focus:ring-0 {{ $passwordError ? 'border border-red-500' : '' }}"
                            placeholder=" " />
                        <label for="floating_standard"
                            class="absolute top-2 z-10 origin-[0] -translate-y-[35px] scale-75 transform  duration-300 peer-placeholder-shown:translate-y-0 text-lg peer-focus:start-0 peer-focus:-translate-y-[35px] peer-focus:scale-75 peer-focus:text-yellow rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 ml-2 text-gray-500">Password</label>
                        <div class="absolute right-2 bottom-2 cursor-pointer">
                            <template x-if="password">
                                <div>
                                    <svg @click="password = ! password" xmlns="http://www.w3.org/2000/svg"
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
                                    <svg @click="password = ! password" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="currentColor" class="size-6 text-blue-950">
                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </template>
                        </div>


                        @if ($passwordError)
                        <div class="mt-1 text-xs text-red-600 absolute">❌ {{ $passwordError }}</div>
                        @endif
                    </div>




                    <div class="my-[50px] float-right w-24">
                        <button type="submit"
                            class="font-geist w-full rounded-full bg-blue-200 px-3 py-4 text-white focus:bg-gray-600 focus:outline-none hover:bg-yellow hover:text-black transition duration-300">Sign
                            in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row-start-1 md:col-start-2 self-center p-4 md:p-0 md:ml-5 ml-0 w-full md:w-96 text-blue-900">

        <h1 class="text-[50px] md:text-[80px]">MIS/EDP</h1>
        <h3>A product of students from ISAT- U, for their requirements within the
            Bachelor of Science in Information Technology</h3>
    </div>
</div>