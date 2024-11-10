<?php

use App\Models\User;

use function Livewire\Volt\{computed, layout, mount, state, title};

title('Profile');

// Define state variables
state(['id']);

state('tab')->url();

mount(function () {
    $this->tab = 'details';
});

$user = function () {
    $user = User::find($this->id);

    if ($user->id == session('user')['id']) {
        return (object) session('user');
    } else {
        return (object) $user->toArray();
    }
}

?>
{{-- parent --}}
<div class="flex p-4  h-[80vh] gap-1 flex-col md:flex-row basis-full">
    {{-- first tab --}}
    {{-- sm --}} {{-- normal --}} {{-- md --}}
    <div class="border w-[100%] md:w-[320px] sm:w-[100%]  bg-blue-100 rounded-md h-[50%] md:h-full">
        {{-- profile image and name cart --}}

        {{-- image card --}}
        <div class=" flex items-center mt-10 flex-col">
            <img src="{{ asset('storage/' . session('user')['img']) }}" alt=""
                class="rounded-full w-[200px] h-[200px]">
            <span class="mt-2 text-lg text-slate-600">{{$this->user()->name}}</span>
        </div>

    </div>

    <div class="flex-1 w-full bg-blue-100 rounded-md p-4 overflow-hidden" x-data="{ tab: @entangle('tab') }" x-cloak>

        <ul class="flex  text-lg">

            <li @click="tab = 'details'" :class="tab === 'details' ? 'bg-blue-300 text-white' : ''"
                class="p-2 cursor-pointer rounded-t-lg">Details</li>
            <li @click="tab = 'history'" :class="tab === 'history' ? 'bg-blue-300 text-white' : ''"
                class="p-2 cursor-pointer rounded-t-lg ">History</li>
        </ul>

        {{-- Tab content --}}
        <div class="bg-blue-300 w-full h-[89%] md:h-[93%] rounded-md relative bottom-2 overflow-hidden text-white">


            <div x-show="tab === 'details'">
                <!-- Content for Details tab -->
                @include('components.user.details')
            </div>

            <div x-show="tab === 'history'">
                <!-- Content for History tab -->
                @include('components.user.history')
            </div>

        </div>

    </div>



</div>