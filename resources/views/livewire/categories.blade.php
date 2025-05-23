<?php

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

use function Livewire\Volt\{mount, state};

state('cacheKey');

state(['category_' => []])->modelable();

mount(function () {
    if (request()->route()->getName() == 'category') {
        session(['page' => 'category']);
    }
    $this->cacheKey = 'categories_';
});

$viewCategories = function () {

    return Cache::rememberForever($this->cacheKey . '4', function () {
        return Category::get();
    });
};



?>

<div class="y gap-2"
    x-data="{ 
        category: @entangle('category_'), 
        openSuggest: false, 
        otherCategory: '', 
        selectedCategories: [],
        maxSelection: 3,
        otherCategoryMaxLength: 50,

        submitHandler() {
            this.selectedCategories = []; 
            this.openSuggest = false; 
            this.otherCategory = ''; 
            this.category = [];
        }
     }"
    @reset-category.window="submitHandler()">

    <div class="flex flex-col space-y-2">
        @foreach ($this->viewCategories() as $item)
        <label class="flex items-center space-x-2">
            <input type="checkbox"
                :value="{{ $item->id }}"
                x-model="selectedCategories"
                @change="category = [...selectedCategories.map(Number), ...(openSuggest && otherCategory ? [otherCategory] : [])]"
                :disabled="(selectedCategories.length + (openSuggest ? 1 : 0)) >= maxSelection && !selectedCategories.includes('{{ $item->id }}')"
                class="input">
            <span>{{ $item->name }}</span>
        </label>
        @endforeach

        <!-- "Others" Checkbox -->
        <label class="flex items-center space-x-2">
            <input type="checkbox"
                x-model="openSuggest"
                @change="category = [...selectedCategories.map(Number), ...(openSuggest && otherCategory ? [otherCategory] : [])]"
                :disabled="(selectedCategories.length + (openSuggest ? 1 : 0)) >= maxSelection && !openSuggest"
                class="input">
            <span>Others</span>
        </label>
    </div>

    <!-- Label and Input Field for "Others" -->
    <div class="mt-2" x-show="openSuggest">
        <label class="block font-medium mb-1 text-gray-700">Specific Other Category</label>
        <input type="text" class="input w-full" placeholder="Enter category..."
            x-model="otherCategory"
            @input="otherCategory = otherCategory.trimStart().replace(/^\s+/, '');
                    if (otherCategory.length > otherCategoryMaxLength) {
                        otherCategory = otherCategory.substring(0, otherCategoryMaxLength);
                    }
                    category = [...selectedCategories.map(Number), ...(openSuggest && otherCategory ? [otherCategory] : [])]"
            :maxlength="otherCategoryMaxLength"
            required>
        <p class="text-sm text-gray-500" x-text="`${otherCategory.length}/${otherCategoryMaxLength} characters`"></p>
    </div>


</div>