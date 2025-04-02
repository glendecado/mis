<x-modal name="add-request-modal" class="max-w-lg p-6">
    <h1 class="text-[#2e5e91] text-[28px] text-center font-medium mb-4">Service Request Form</h1>

    <div class="space-y-5" x-data="{ category : @entangle('category_'), concerns : @entangle('concerns'), message: '' }">
        @include('components.requests.confirm-location')

        <fieldset class="border border-gray-300 rounded-lg p-4 shadow-sm">
            <legend class="text-sm font-medium text-gray-700 px-2">Category</legend>
            <div class="space-y-3">
                <livewire:categories wire:model="category_" />
                @error('category_')
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
                <textarea x-model="concerns" class="input w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-[#2e5e91]" placeholder="Describe your concerns..."></textarea>
                @error('concerns')
                    <span class="text-red-500 text-sm">{{$message}}</span>
                @enderror
            </div>
        </fieldset>

        <button wire:loading.attr="disabled" wire:click.prevent="addRequest" class="w-full bg-[#2e5e91] text-white py-2 px-4 rounded-lg hover:bg-[#1e4b72] transition disabled:opacity-50">
            Submit Request
        </button>
    </div>
</x-modal>

<x-modal name="edit-loc" class="max-w-lg p-6">
    <div class="space-y-4" x-data="{ college: @entangle('college'), building: @entangle('building'), room: @entangle('room') }">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="college" class="block text-sm font-medium text-gray-700">College</label>
                <input x-model="college" type="text" class="input w-full p-2 border border-gray-300 rounded-md uppercase focus:ring focus:ring-[#2e5e91]" />
            </div>
            <div>
                <label for="building" class="block text-sm font-medium text-gray-700">Building</label>
                <input x-model="building" type="text" class="input w-full p-2 border border-gray-300 rounded-md uppercase focus:ring focus:ring-[#2e5e91]" />
            </div>
            <div>
                <label for="room" class="block text-sm font-medium text-gray-700">Room</label>
                <input x-model="room" type="text" class="input w-full p-2 border border-gray-300 rounded-md uppercase focus:ring focus:ring-[#2e5e91]" />
            </div>
        </div>

        <button class="w-full bg-[#2e5e91] text-white py-2 px-4 rounded-lg hover:bg-[#1e4b72] transition disabled:opacity-50" :disabled="!college || !building || !room" @click="$wire.confirmLocation(); $dispatch('close-modal', 'edit-loc')">
            Update Location
        </button>
    </div>
</x-modal>
