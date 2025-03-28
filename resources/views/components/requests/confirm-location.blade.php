<div>
    <div class="y mb-2" x-data="{
        cl: false,
        college: @entangle('college'),
        building: @entangle('building'),
        room: @entangle('room')
    }">
        <fieldset class="border p-4 rounded-md flex justify-between items-center">
            <legend>Location</legend>
            <div>College: <span x-text="college" class="font-bold"></span></div>
            <div>Building: <span x-text="building" class="font-bold"></span></div>
            <div>Room: <span x-text="room" class="font-bold"></span></div>
            <button @click="$dispatch('open-modal','edit-loc')">
                <x-icons.edit class="size-6"/>

            </button>
        </fieldset>
    </div>

</div>
