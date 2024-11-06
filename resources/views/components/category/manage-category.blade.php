<div x-data="{ selectedCategoryId: null }" class="m-3 rounded-lg overflow-auto border h-[80vh] bg-blue-200">
    <div class="bg-blue-500 p-2 text-white">
        Category
    </div>

    <div class="p-2">
        @foreach($this->viewCategory() as $category)
        <div 
            class="bg-blue-400 rounded-md p-2 mt-6 text-white cursor-pointer"
            @click="selectedCategoryId = selectedCategoryId === {{ $category->id }} ? null : {{ $category->id }}"
        >
            {{$category->name}}
        </div>

        <div x-show="selectedCategoryId === {{ $category->id }}" class="bg-blue-500 mb-2 relative top-0 -translate-y-2 z-10 p-2">

            {{-- TaskList --}}
            <livewire:task-list :category="$category->id" />
        </div>
        @endforeach
    </div>
</div>
