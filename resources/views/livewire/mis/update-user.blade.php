@php
//class design for input
$input = 'rounded bg-slate-200 border border-slate-900 m-2 p-2 placeholder-black';
@endphp
<div>
    <x-modal name="update">

        {{--check if user exist--}}
        @if (isset($user))
        <form wire:submit.prevent="updateUser" class="flex flex-col">
            <label for="name">name</label>
            <input type="text" name="name" id="" placeholder="{{$user->name}}" class="{{$input}}" wire:model="name">
            <label for="email">email</label>
            <input type="text" name="email" id="" placeholder="{{$user->email}}" class="{{$input}}" wire:model="email">
            <label for="role">role</label>
            <input type="text" placeholder="{{$user->role}}" disabled class="{{$input}}">
            </select>
            <label for="password">password</label>
            @php
            $passwordDots = str_repeat('•', strlen($user->password));
            @endphp

            <div x-data="{ show: false }">
                <div class="relative">
                    <input
                        :type="show ? 'text' : 'password'"
                        name="password"
                        id=""
                        class="{{$input}} w-full"
                        wire:model="password"
                        :placeholder="show ? '{{$user->password}}' : '{{ $passwordDots }}'">

                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <!-- Hide/show icons -->
                        <svg :class="{'hidden': show, 'block': !show }" class="h-5 w-5 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h.01M19.071 19.071A9.453 9.453 0 0112 21a9.453 9.453 0 01-7.071-2.929m0-14.142A9.453 9.453 0 0112 3a9.453 9.453 0 017.071 2.929M9.878 9.878a3 3 0 104.244 4.244M15 12h.01"></path>
                        </svg>
                        <svg :class="{'block': show, 'hidden': !show }" class="h-5 w-5 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.056 10.056 0 0112 19.5c-5.246 0-9.5-4.254-9.5-9.5S6.754.5 12 .5s9.5 4.254 9.5 9.5a10.056 10.056 0 01-.375 2.825M19.071 19.071A9.453 9.453 0 0112 21a9.453 9.453 0 01-7.071-2.929m0-14.142A9.453 9.453 0 0112 3a9.453 9.453 0 017.071 2.929M9.878 9.878a3 3 0 104.244 4.244M15 12h.01"></path>
                        </svg>
                    </button>
                </div>

                <button type="submit">Confirm</button>
            </div>

        </form>
        @endif


    </x-modal>
</div>