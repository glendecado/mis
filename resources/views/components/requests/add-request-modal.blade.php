<x-modal name="add-request-modal">

    <h1 class="text-[#2e5e91] text-[28px] text-center font-medium">Service Request Form</h1>

    <div class="y p-4 mt-7"
        x-data="
        {
    category : @entangle('category_'),
    concerns : @entangle('concerns'),
    message: ''

        }">
        @include('components.requests.confirm-location')


        <fieldset class="border rounded-md p-4">
            <legend>Category</legend>
            <div class="y">
                <livewire:categories wire:model="category_" />
                @error('category_')
                <span class="text-red-500"> {{$message}}</span>
                @enderror
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



        <button
            wire:loading.attr="disabled"
            wire:click.prevent="addRequest"
            class="button mt-4 text-white bg-[#2e5e91]">
            Submit
        </button>

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
                <label for="college" class="label">College</label>
                <input x-model="college" type="text" class="input w-full uppercase" />
            </div>
            <div>
                <label wire:model="building" for="building" class="label">Building</label>
                <input x-model="building" type="text" class="input w-full uppercase" />
            </div>
            <div>
                <label wire:model="room" for="room" class="label">Room</label>
                <input x-model="room" type="text" class="input w-full uppercase" />
            </div>
        </div>

        <!-- Disable button if any of the fields are empty -->
        <button
            class="button mt-4 text-white bg-[#2e5e91]"
            :disabled="!college || !building || !room"
            @click="$wire.confirmLocation(); $dispatch('close-modal', 'edit-loc')">
            Update Location
        </button>
    </div>
</x-modal>