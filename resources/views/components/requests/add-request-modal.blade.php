
<x-modal name="add-request-modal">



    <div class="y"
        x-data="
        {
    category : @entangle('category'),
    concerns : @entangle('concerns'),
    message: ''

        }">
        @include('components.requests.confirm-location')


        <fieldset class="border p-2 rounded-md">
            <legend>Request Form</legend>
            <div class="y">
                <livewire:category wire:model="category" />
                <textarea
                    name="" id=""
                    x-model="concerns"
                    class="input mt-2"
                    placeholder="Concerns..."></textarea>

                @error('concerns')
                <span class="text-red-500"> {{$message}}</span>
                @enderror
            </div>
        </fieldset>



        <button @click="$wire.addRequest()" class="button mt-2">submit</button>
    </div>


</x-modal>

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
