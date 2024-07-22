@php
$route = Request::route()->getName() ?? '/';
@endphp


<nav class="bg-blue-950 text-white flex flex-row gap-2">
    <a href="/" wire:navigate class="flex items-center justify-center h-[50px] px-[20px] hover:bg-yellow-400 hover:text-blue-950 {{$route == '/' ? 'bg-yellow-400 text-blue-950' : '' }}">
        Home
    </a>

    <a href="{{route('profile')}}" wire:navigate class="flex items-center justify-center h-[50px] px-[20px]  hover:bg-yellow-400 hover:text-blue-950 {{$route == 'profile' ? 'bg-yellow-400 text-blue-950' : '' }}">
        Profile
    </a>

    <a href="{{route('request')}}" wire:navigate class="flex items-center justify-center h-[50px] px-[20px]  hover:bg-yellow-400 hover:text-blue-950 {{$route == 'request' ? 'bg-yellow-400 text-blue-950' : '' }}">
        Request
    </a>

    @if (Auth::user()->role == 'Mis Staff')
    <a href="{{route('manage-user')}}" wire:navigate class="flex items-center justify-center h-[50px] px-[20px]  hover:bg-yellow-400 hover:text-blue-950 {{$route == 'manage-user' ? 'bg-yellow-400 text-blue-950' : '' }}">
        Users
    </a>
    @endif

    @livewire('user.logout')
</nav>