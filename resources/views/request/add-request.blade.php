{{--button to open modal--}}

<button type="button" @click="$dispatch('open-modal',  'add-request-modal')">Add request </button>

{{--modal--}}
<x-modal name="add-request-modal">

    <div>
        <form wire:submit.prevent="addRequest">
            <div>
                <label for="category">Category</label>
                <input type="text" id="category" wire:model="category">
                @error('category') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="concerns">Concern</label>
                <textarea id="concerns" wire:model="concerns"></textarea>
                @error('concerns') <span class="error">{{ $message }}</span> @enderror
            </div>

            <button @click="$dispatch('update-request')" type="submit">Submit</button>
        </form>
    </div>

</x-modal>