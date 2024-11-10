<div class="w-full flex flex-col md:flex-row absolute bottom-0 top-0 p-4 gap-2 overflow-auto">

    {{-- first row --}}
    <div class="basis-80 flex-1  flex flex-col gap-2">
        {{-- user details --}}
        <div class="border basis-1/2 rounded-md flex flex-col justify-center p-2 h-fit gap-4">
            <span>User Details</span>

            @if(session('user')['id'] == $this->user()->id || session('user')['role'] == 'Mis Staff')
            <span class="text-right mr-2 cursor-pointer" @click="Livewire.navigate('/edit-profile/{{$this->user()->id}}')">Edit profile</span>
            @endif

            <span>Role: {{ $this->user()->role }}</span>
            <span>Email Address: {{ $this->user()->email }}</span>
        </div>

        {{-- user details --}}
        <div class="border basis-full rounded-md p-2"><span>Links</span></div>
    </div>

    {{-- 2nd row --}}
    <div class="flex flex-col basis-full gap-2">
        <div class="border basis-full p-2 rounded-md">
            login details
        </div>
        <div class="border p-2 rounded-md basis-3/5">
            privacy and policy
        </div>
    </div>
</div>