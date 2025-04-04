<?php

use App\Models\Category;
use function Livewire\Volt\{mount, state, title};

title('Task Categories');

state('tab')->url();
state('cacheKey');
state(['category_' => []])->modelable();

mount(function () {
    if (request()->route()->getName() == 'category') {
        session(['page' => 'category']);
    }

    // Scroll to top when component mounts
    $this->dispatch('scroll-to-top');
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

<div  class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- Enhanced scroll-to-top listener with smooth transitions -->
    <div x-data="{
        scrollToTop() {
            // First make page transparent
            document.body.style.opacity = '0';
            // Scroll instantly to top (no animation yet)
            window.scrollTo({ top: 0 });
            // After scroll completes, fade in content
            setTimeout(() => {
                document.body.style.opacity = '1';
                document.body.style.transition = 'opacity 300ms ease-in-out';
            }, 50);
        }
    }"
        @scroll-to-top.window="scrollToTop()"
        class="contents"></div>

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 transition-opacity duration-500 "
            x-data="{ shown: false }"
            x-init="setTimeout(() => shown = true, 150)"
            x-show="shown"
            x-transition:enter="transition-opacity duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">Categories</h1>

        <!-- Add Category Form - Floating Button Trigger -->
        <div  x-data="{ showForm: false }" class="relative">
            <button
                @click="showForm = true"
                class="px-5 py-3 bg-blue text-white font-medium rounded-full shadow-lg hover:shadow-xl transition-all flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>New Category</span>
            </button>

            <!-- Floating Form -->
            <div

                x-show="showForm"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                @click.away="showForm = false"
                class="absolute right-0 mt-2 w-72 z-10">
                <div class="bg-white p-4 rounded-xl shadow-xl border border-gray-100" >
                    <div x-data="{ input: '' }" class="space-y-3">
                        <h3 class="font-medium text-gray-700">Create New Category</h3>
                        <input
                            type="text"
                            x-model="input"
                            @keyup.enter="$wire.addCategory(input); showForm = false"
                            placeholder="Category name..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                            autofocus>
                        <div class="flex justify-end space-x-2">
                            <button
                                @click="showForm = false"
                                class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                                Cancel
                            </button>
                            <button
                                @click="$wire.addCategory(input); showForm = false"
                                :disabled="!input.trim()"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:bg-gray-300 disabled:cursor-not-allowed transition">
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Grid with staggered animations -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($this->viewCategory() as $category)
        <div
            x-data="{ isOpen: false, shown : '' }"
            class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all h-fit"
            :class="{ 
                'ring-2 ring-blue-400': isOpen, 
                'translate-y-4': !shown,
                'relative': !isOpen
            }"
            x-init="
                shown = false;
                setTimeout(() => {
                    shown = true;
                    $el.style.transform = 'translateY(0)';
                    $el.style.opacity = '1';
                }, {{ $loop->index * 75 + 200 }});
            "
            style="opacity: 0; transform: translateY(20px); transition: all 0.4s ease-out;"
            @keydown.escape.window="isOpen = false">
            <!-- Category Header -->
            <div

                @click="isOpen = !isOpen"
                class="p-5 cursor-pointer flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-white">
                        {{ strtoupper(substr($category->name, 0, 1)) }}
                    </div>
                    <h3 class="font-semibold text-gray-800">{{ $category->name }}</h3>
                </div>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-gray-500 transition-transform duration-300"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    :class="{ 'hidden': isOpen }">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>

            <!-- Close button for absolute positioned card -->
            <button
                @click="isOpen = false"
                class="absolute top-2 right-2 p-1 rounded-full hover:bg-gray-100 transition"
                x-show="isOpen">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Category Content -->
            <div
                x-show="isOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="border-t border-gray-100 px-5 py-4 bg-gray-50">
                <livewire:task-list :category="$category->id" wire:key="task-list-{{ $category->id }}" />


            </div>
        </div>
        @endforeach
    </div>
</div>