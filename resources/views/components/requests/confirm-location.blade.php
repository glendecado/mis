<div>
    <div class="y mb-2" x-data="{
        cl: false,
        college: @entangle('college'),
        building: @entangle('building'),
        room: @entangle('room')
    }">
        <fieldset class="border p-2 rounded-md flex justify-between">
            <legend>Location</legend>
            <div>College: <span x-text="college" class="font-bold"></span></div>
            <div>Building: <span x-text="building" class="font-bold"></span></div>
            <div>Room: <span x-text="room" class="font-bold"></span></div>
            <button @click="$dispatch('open-modal','edit-loc')">Edit</button>
        </fieldset>
    </div>

    <x-modal name="edit-loc">
    <div class="y mb-2" x-data="{
        college: @entangle('college'),
        building: @entangle('building'),
        room: @entangle('room')
    }">
        <div class="md:x y gap-2 mb-2">
            <div>
                <label :class="{ 'text-gray-500': cl }" for="college" class="label">College</label>
                <input x-model="college" type="text" class="input w-full uppercase" />
            </div>
            <div>
                <label wire:model="building" :class="{ 'text-gray-500': cl }" for="building" class="label">Building</label>
                <input x-model="building" type="text" class="input w-full uppercase" />
            </div>
            <div>
                <label wire:model="room" :class="{ 'text-gray-500': cl }" for="room" class="label">Room</label>
                <input x-model="room" type="text" class="input w-full uppercase" />
            </div>
        </div>

        <!-- Disable button if any of the fields are empty -->
        <button 
            class="button" 
            :disabled="!college || !building || !room" 
            @click="$wire.confirmLocation(); $dispatch('close-modal', 'edit-loc')">
            Submit
        </button>
    </div>
</x-modal>

</div>
