<header class="header">

    {{--Logo--}}
    <div class="header-container-logo"
        @click="Livewire.navigate('/request?status=all')">
        <x-logo />
        <span class="hidden md:block">MIS Service Request Portal</span>
    </div>


    {{--profile--}}
    <div class="x gap-2 items-center cursor-pointer select-none">

        <x-notif />

        <div class="header-container-profile " x-data="{open : false}" @click="open = !open">

            <span class="md:block hidden">{{session('user')['role']}}</span>

            <img src="{{ asset('storage/' . session('user')['img']) }}" alt=""
                class="rounded-full size-10">

            {{--arrow--}}
            <div x-show="open == false">
                <x-icons.arrow direction="down" />
            </div>

            {{--open dropdown--}}
            <div x-show="open == true" x-cloak @click.outside="open = false">

                <x-icons.arrow direction="up" />

                <div class="dropdown w-56 right-7 top-16 absolute">

                    <div class="dropdown-open-items p-4" @click="Livewire.navigate('/profile/{{session('user')['id']}}')">
                        <x-icons.profile class="size-6 absolute left-5" />
                        <span>Profile</span>
                    </div>


                    <livewire:user.logout />


                </div>
            </div>

        </div>
    </div>

</header>