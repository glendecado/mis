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

        <button type="submit">Submit</button>
    </form>
</div>