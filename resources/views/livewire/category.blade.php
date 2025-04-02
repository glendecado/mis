<?php

use App\Models\Category;
use function Livewire\Volt\{mount, state, title};

title('Categories');

state('tab')->url();
state('cacheKey');
state(['category_' => []])->modelable();

mount(function () {
    if (request()->route()->getName() == 'category') {
        session(['page' => 'category']);
    }


});

$viewCategory = function () {
    return Category::with('taskList')->get();
};

$addCategory = function ($categoryName) {
    $categoryName = trim($categoryName);
    
    if (empty($categoryName)) {
        $this->dispatch('error', 'Category name cannot be empty');
        return;
    }

    $formattedName = ucfirst(strtolower($categoryName));
    
    if (Category::where('name', $formattedName)->exists()) {
        $this->dispatch('danger', 'Category already exists');
        return;
    }

    Category::create(['name' => $formattedName]);
    $this->dispatch('success', 'Category created successfully');
    $this->redirect('/category', navigate: true);
};

?>

<div class="max-w-3xl mx-auto p-4">
    <div class="space-y-3">
        <!-- Category List -->
        @foreach($this->viewCategory() as $category)
        <div x-data="{ isOpen: false }" class="transition-all duration-200">
            <!-- Category Header -->
            <div
                @click="isOpen = !isOpen"
                class="flex items-center justify-between p-3 bg-blue text-white cursor-pointer select-none rounded-lg hover:bg-blue-800 transition-colors"
                :class="{ 'rounded-b-none': isOpen }"
            >
                <span class="font-medium text-lg">{{ $category->name }}</span>
                
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5 transition-transform duration-200" 
                    viewBox="0 0 20 20" 
                    fill="currentColor"
                    :class="{ 'rotate-180': isOpen }"
                >
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>

            <!-- Category Content -->
            <div 
                x-show="isOpen"
                class="p-4 bg-white border border-t-0 border-blue-600 rounded-b-lg"
            >
                <livewire:task-list :category="$category->id" wire:key="task-list-{{ $category->id }}" />
            </div>
        </div>
        @endforeach

        <!-- Add Category Form -->
        <div x-data="{ input: '' }" class="mt-6 flex gap-2">
            <div class="flex-1">
                <input 
                    type="text" 
                    x-model="input" 
                    @keyup.enter="$wire.addCategory(input)"
                    placeholder="New category name..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                >
            </div>
            
            <button 
                type="button" 
                @click="$wire.addCategory(input)"
                :disabled="!input.trim()"
                class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors"
            >
                Add
            </button>
        </div>
    </div>
</div>