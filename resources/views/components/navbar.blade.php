@php
$route = Request::route()->getName() ?? '/';
@endphp


<nav class="bg-blue-950 text-white flex flex-row gap-2 overflow-auto">
    <a href="/" wire:navigate class="flex items-center justify-center h-[56px] px-[20px] hover:bg-yellow-400 hover:text-blue-950 {{$route == '/' ? 'bg-yellow-400 text-blue-950' : '' }}">
        Home
    </a>

    <a href="{{route('profile')}}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:bg-yellow-400 hover:text-blue-950 {{$route == 'profile' ? 'bg-yellow-400 text-blue-950' : '' }}">
        Profile
    </a>

    <div class="h-fit w-fit">
        <a href="{{route('request')}}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:bg-yellow-400 hover:text-blue-950 {{$route == 'request' ? 'bg-yellow-400 text-blue-950' : '' }}">
            Request
            <span class="relative left-0 bottom-2 text-md text-red-900">0</span>
        </a>

    </div>

    @if (Auth::user()->role == 'Mis Staff')
    <a href="{{route('manage-user')}}" wire:navigate class="flex items-center justify-center h-[56px] px-[20px]  hover:bg-yellow-400 hover:text-blue-950 {{$route == 'manage-user' ? 'bg-yellow-400 text-blue-950' : '' }}">
        Users
    </a>
    @endif

    @livewire('user.logout')
</nav>