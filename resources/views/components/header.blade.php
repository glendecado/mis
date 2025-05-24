<header class="h-full p-2 flex items-center justify-between bg-[#578FCA]">

    {{--Logo--}}
    <div class="header-container-logo" @click="Livewire.navigate('/request?status=all')">
        <x-logo />
        <span class="ml-2 md:block hidden">SERVICE CONNECT IT: REQUEST AND SUPPORT SYSTEM</span>
    </div>

    {{--Profile--}}
    <div class="x gap-2 items-center cursor-pointer select-none">

        <livewire:notif wire:key="notif" />

        <div class="flex h-[50px] px-2 items-center gap-4 justify-between text-white border border-gray-100 rounded-md" x-data="{ open: false }" @click="open = !open">
            <div class="flex items-center gap-2">

                <div class="flex flex-col justify-center w-full items-center">
                    <div class="md:block hidden w-32 text-center truncate text-sm">
                        {{ session('user')['email'] }}
                    </div>

                    <div class="md:block hidden text-xs">
                        {{ strtoupper(session('user')['role']) }}
                    </div>
                </div>

                <img src="{{ asset('storage/' . session('user')['img']) }}" alt=""
                    class="rounded-full size-10 object-cover aspect-square">
            </div>


            {{-- Arrow Down (default) --}}
            <div x-cloak x-show="!open">
                <x-icons.arrow direction="down" />
            </div>

            {{-- Arrow Up (on click) --}}
            <div x-cloak x-show="open" x-cloak>

            {{--arrow--}}
            <div x-cloak x-show="open == false">
                <x-icons.arrow direction="down" />
            </div>

            {{--open dropdown--}}
            <div x-cloak x-show="open == true" x-cloak @click.outside="open = false">


                <x-icons.arrow direction="up" />
            </div>

            {{-- Dropdown (displayed when `open` is true) --}}
            <div x-show="open" x-cloak @click.outside="open = false" class="dropdown w-56 right-1 top-16 absolute md:right-7">
                <div class="dropdown-open-items p-4" @click="Livewire.navigate('/profile/{{ session('user')['id'] }}')">
                    <x-icons.profile class="size-6 absolute left-5" />
                    <span>Profile</span>
                </div>

                <livewire:user.logout />
            </div>
        </div>
    </div>
</header>
