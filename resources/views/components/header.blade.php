<header class="bg-blue h-full flex px-8 items-center justify-between">

    <div class="text-white flex items-center gap-1 cursor-pointer" 
    @click="Livewire.navigate('/request?status=all')">
    <x-logo/>
    <span>MIS Service Request Portal</span>
    </div>

    <div class="border flex h-[7svh] px-4 gap-5 items-center text-white rounded-md hover:bg-blue-500/50" x-data="{open : false}" @click="open = !open">
        <span>{{session('user')['role']}}</span>
        <img src="{{ asset('storage/' . session('user')['img']) }}" alt=""
            class="rounded-full size-10">

        <div x-show="open == false">
            <x-icons.arrow type="down" />
        </div>

        <div x-show="open == true"  x-cloak>
            <x-icons.arrow type="up" />
            <div class="bg-azure/80 drop-shadow-lg rounded-md h-fit w-52 top-20  absolute right-8 z-[100] text-blue-950 items-center flex flex-col">

                <div class="w-full hover:bg-blue hover:text-white flex-center p-2 cursor-pointer" @click="Livewire.navigate('/profile/{{session('user')['id']}}')">
                    <span>Profile</span>
                </div>


                    <livewire:user.logout />
             

            </div>
        </div>

    </div>

</header>