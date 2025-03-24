<div class="y gap-2" 
     x-data="{ 
        category: @entangle('category_'), 
        openSuggest: false, 
        otherCategory: '', 
        selectedCategories: []
     }">
    
    <div class="flex flex-col space-y-2">
        @foreach ($this->viewCategory() as $item)
        <label class="flex items-center space-x-2">
            <input type="checkbox" 
                   :disabled="openSuggest" 
                   value="{{ $item->id }}" 
                   x-model="selectedCategories" 
                   @change="category = selectedCategories" 
                   class="input">
            <span>{{ $item->name }}</span>
        </label>
        @endforeach

        <!-- "Others" Checkbox -->
        <label class="flex items-center space-x-2">
            <input type="checkbox" 
                   x-model="openSuggest" 
                   @change="if(openSuggest) { selectedCategories = []; category = otherCategory; }" 
                   class="input">
            <span>Others</span>
        </label>
    </div>

    <!-- Label and Input Field for "Others" -->
    <div class="mt-2" x-show="openSuggest">
        <label class="block font-semibold text-gray-700">Specify Other Category:</label>
        <input type="text" class="input w-full" placeholder="Type category..." 
               x-model="otherCategory" 
               @input="category = otherCategory" 
               wire:model.live="category" 
               required>
    </div>
</div>
