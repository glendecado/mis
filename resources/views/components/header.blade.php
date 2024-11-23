<header class="header">

    {{--Logo--}}
    <div class="header-container-logo"
        @click="Livewire.navigate('/request?status=all')">
        <x-logo />
        <span class="hidden md:block">MIS Service Request Portal</span>
    </div>


    {{--profile--}}
    <div class="x gap-2 items-center">
        <x-icons.bell class="size-10 p-2 text-white border rounded-full" />
        <div class="header-container-profile " x-data="{open : false}" @click="open = !open">

            <span class="">{{session('user')['role']}}</span>

            <img src="{{ asset('storage/' . session('user')['img']) }}" alt=""
                class="rounded-full size-10">

            {{--arrow--}}
            <div x-show="open == false">
                <x-icons.arrow direction="down" />
            </div>

            {{--open arrow--}}
            <div x-show="open == true" x-cloak>

                <x-icons.arrow direction="up" />

                <div class="header-open-items-container">

                    <div class="header-open-items" @click="Livewire.navigate('/profile/{{session('user')['id']}}')">
                        <span>Profile</span>
                    </div>


                    <livewire:user.logout />


                </div>
            </div>

        </div>
    </div>


</header>