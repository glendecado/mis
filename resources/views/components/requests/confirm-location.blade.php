<div class="y mb-2"
    x-data="{ cl: false, 

college : @entangle('college'),
building : @entangle('building'),
room : @entangle('room') 

}">
    <div class="md:x y gap-2 mb-2">
        <div>
            <label :class="{ 'text-gray-500': cl }" for="college" class="label">College</label>
            <input

                x-model="college"
                type="text"
                class="input w-full"
                :disabled="!cl" />
        </div>
        <div>
            <label wire:model="building" :class="{ 'text-gray-500': cl }" for="building" class="label">Building</label>
            <input

                x-model="building"
                type="text"
                class="input w-full"
                :disabled="!cl" />
        </div>
        <div>
            <label wire:model="room" :class="{ 'text-gray-500': cl }" for="room" class="label">Room</label>
            <input

                x-model="room"
                type="text"
                class="input w-full"
                :disabled="!cl" />
        </div>
    </div>


    <button x-show="!cl" class="button" x-on:click="cl = !cl">Confirm Location</button>

    <button x-show="cl" class="button" x-on:click="cl = !cl" @click="$wire.confirmLocation()">Submit</button>
</div>