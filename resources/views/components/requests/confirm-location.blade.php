<div>
    <div class="y mb-2" x-data="{
        cl: false,
        college: @entangle('college'),
        building: @entangle('building'),
        room: @entangle('room')
    }">
        <div class="flex flex-row justify-between items-center mb-2">
            <h1>Location</h1>
            <button @click="$dispatch('open-modal','edit-loc')">
                    <x-icons.edit class="size-6"/>

            </button>
        </div>
        <div class="border py-2 px-4 rounded-md flex justify-between">
            <div>College: <span x-text="college" class="font-bold"></span></div>
            <div>Building: <span x-text="building" class="font-bold"></span></div>
            <div>Room: <span x-text="room" class="font-bold"></span></div>
        </div>
    </div>

</div>
