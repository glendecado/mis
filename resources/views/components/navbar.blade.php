<header class="bg-blue-500 h-[60%] flex justify-between items-center px-3 flex-wrap">
    {{-- top --}}

    <h1 class="text-blue-50 text-lg">MIS SERVICE REQUEST PORTAL</h1>
    <input type="text" class="rounded-full w-[250px] px-2 outline-none h-[30px]">

</header>

{{-- navbar --}}
<nav class="bg-yellow h-[40%]">
    <div class=" h-[100%] justify-between flex">

        {{-- burger menu --}}
        {{-- mobile --}}
        <div class="x md:hidden " x-data="{ open: false }">

            <div @click="open = !open">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-9">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>

            {{-- mobile --}}
            <div x-show="open" x-cloak class="z-[100]">
                <div class="absolute top-[105px] bg-yellow  shadow-md basis-full w-screen left-0">
                    <a wire:navigate.hover href="/dashboard"
                        class="p-2 navbar-link flex-center {{ request()->routeIs(patterns: 'dashboard') ? 'navbar-link-active' : '' }}">
                        Home
                    </a>
                    <a wire:navigate.hover href="/profile/{{session('user')['id']}}"
                        class="p-2 navbar-link flex-center {{ request()->routeIs(patterns: 'profile') ? 'navbar-link-active' : '' }}">
                        Profile
                    </a>

                    @if (Auth::user()->role == 'Mis Staff')
                    <a wire:navigate.hover href="/admin-panel?tab=requests"
                        class="p-2 navbar-link flex-center  {{ request()->routeIs(patterns: 'admin-panel') ? 'navbar-link-active' : '' }}">
                        Admin Panel
                    </a>
                    @else
                    <a wire:navigate.hover href="/request?status=all"
                        class="p-2 navbar-link flex-center  {{ request()->routeIs(patterns: 'request') ? 'navbar-link-active' : '' }}">
                        Request
                    </a>
                    @endif



                </div>
            </div>

        </div>



        {{-- web --}}
        <div class="md:flex hidden">

            <a wire:navigate.hover href="/dashboard"
                class="w-32 navbar-link flex-center {{ request()->routeIs('dashboard') ? 'navbar-link-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span class="ml-1">Home</span>
            </a>


            <a wire:navigate.hover href="/profile/{{ Auth::id() }}"
                class="w-32 navbar-link flex-center {{ request()->routeIs('profile') || request()->routeIs('update')  ? 'navbar-link-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span class="ml-1"> Profile</span>
            </a>


            @if (Auth::user()->role == 'Mis Staff')
            <a wire:navigate.hover href="/admin-panel?tab=requests&status=all"
                class="w-32 navbar-link flex-center  {{ request()->routeIs('admin-panel') ? 'navbar-link-active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                </svg>
                <span class="ml-1">Admin</span>
            </a>
            @else
            <a wire:navigate.hover href="/request?status=all"
                class="w-32 navbar-link flex-center  
                    {{ request()->route()->uri() == 'request' ||  
                     request()->route()->uri() == 'request/{id}' ?'navbar-link-active' : '' }}">
                Request
            </a>
            @endif

        </div>

        <div class="x">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>

            <div class="">
                <livewire:user.logout />
            </div>


        </div>

    </div>
</nav>